<?php

namespace Tests\Feature;

use App\Models\FamilyDocument;
use App\Models\FamilyFolder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class FamilyDocumentTest extends TestCase
{
    use RefreshDatabase;

    public function test_family_can_create_folder_upload_download_and_delete_document(): void
    {
        Storage::fake('local');
        $user = User::factory()->create(['account_type' => 'Family']);
        $this->actingAs($user)->post(route('account.family.folders.store'), ['folder_name' => 'Assessments'])
            ->assertRedirect(route('account.family.documents'));
        $folder = FamilyFolder::sole();
        $this->assertSame($user->id, $folder->user_id);
        $this->assertSame('Assessments', $folder->name);

        $this->post(route('account.family.documents.store'), [
            'document' => UploadedFile::fake()->create('Learning report.pdf', 120, 'application/pdf'),
            'family_folder_id' => $folder->id,
            'child_name' => 'Tariq',
            'user_id' => 99999,
            'path' => 'untrusted-path',
        ])->assertRedirect(route('account.family.documents'))->assertSessionHas('status', 'Document uploaded.');
        $document = FamilyDocument::sole();
        $this->assertSame($user->id, $document->user_id);
        $this->assertSame($folder->id, $document->family_folder_id);
        $this->assertSame('Tariq', $document->child_name);
        Storage::disk('local')->assertExists($document->path);
        $this->get(route('account.family.documents'))->assertOk()->assertSee('Learning report.pdf')
            ->assertSee('Tariq')->assertViewHas('usedBytes', 122880)->assertViewHas('fileCount', 1);
        $this->get(route('account.family.documents.download', $document))->assertDownload('Learning report.pdf')
            ->assertHeader('X-Content-Type-Options', 'nosniff');

        $this->delete(route('account.family.documents.destroy', $document))->assertRedirect(route('account.family.documents'));
        $this->assertModelMissing($document);
        Storage::disk('local')->assertMissing($document->path);
    }

    public function test_guests_cannot_access_document_endpoints(): void
    {
        $this->get(route('account.family.documents'))->assertRedirect(route('login'));
        $this->post(route('account.family.documents.store'))->assertRedirect(route('login'));
        $this->post(route('account.family.folders.store'))->assertRedirect(route('login'));
        $this->get(route('account.family.documents.download', 1))->assertRedirect(route('login'));
        $this->delete(route('account.family.documents.destroy', 1))->assertRedirect(route('login'));
    }

    public static function otherRoles(): array
    {
        return [
            'individual' => ['Individual', false],
            'provider' => ['Provider', false],
            'institution' => ['Institution', false],
            'partner' => ['Partner / Other', false],
            'admin' => ['Family', true],
        ];
    }

    #[DataProvider('otherRoles')]
    public function test_only_non_admin_family_accounts_can_access_documents(string $type, bool $admin): void
    {
        $user = User::factory()->create(['account_type' => $type, 'is_admin' => $admin]);

        $this->actingAs($user)->get(route('account.family.documents'))->assertForbidden();
        $this->post(route('account.family.documents.store'))->assertForbidden();
        $this->post(route('account.family.folders.store'))->assertForbidden();
        $this->get(route('account.family.documents.download', 1))->assertForbidden();
        $this->delete(route('account.family.documents.destroy', 1))->assertForbidden();
        $this->assertDatabaseCount('family_documents', 0);
        $this->assertDatabaseCount('family_folders', 0);
    }

    public function test_families_cannot_list_download_delete_or_upload_to_another_familys_records(): void
    {
        Storage::fake('local');
        $owner = User::factory()->create(['account_type' => 'Family']);
        $other = User::factory()->create(['account_type' => 'Family']);
        $folder = FamilyFolder::create(['user_id' => $owner->id, 'name' => 'Private assessments']);
        $this->actingAs($owner)->post(route('account.family.documents.store'), [
            'document' => UploadedFile::fake()->create('Confidential.pdf', 100, 'application/pdf'),
            'family_folder_id' => $folder->id,
        ])->assertSessionHasNoErrors();
        $document = FamilyDocument::sole();

        $this->actingAs($other)->get(route('account.family.documents'))->assertDontSee('Confidential.pdf')
            ->assertDontSee('Private assessments')->assertViewHas('usedBytes', 0);
        $this->get(route('account.family.documents', ['q' => 'Confidential']))->assertDontSee('Confidential.pdf');
        $this->get(route('account.family.documents.download', $document))->assertNotFound();
        $this->delete(route('account.family.documents.destroy', $document))->assertNotFound();
        $this->getJson(route('account.family.documents', ['folder' => $folder->id]))->assertUnprocessable()->assertJsonValidationErrors('folder');
        $this->post(route('account.family.documents.store'), [
            'document' => UploadedFile::fake()->create('Attempt.pdf', 10, 'application/pdf'),
            'family_folder_id' => $folder->id,
        ])->assertSessionHasErrorsIn('upload', 'family_folder_id');
        $this->assertModelExists($document);
        Storage::disk('local')->assertExists($document->path);
        $this->assertDatabaseCount('family_documents', 1);
    }

    public function test_upload_rejects_missing_executable_disguised_and_oversize_files(): void
    {
        Storage::fake('local');
        $user = User::factory()->create(['account_type' => 'Family']);
        $this->actingAs($user)->post(route('account.family.documents.store'))
            ->assertSessionHasErrorsIn('upload', ['document' => 'The document field is required.']);
        $disguisedFile = tmpfile();
        fwrite($disguisedFile, '<?php echo "unsafe";');
        foreach ([
            UploadedFile::fake()->create('script.php', 1, 'application/x-httpd-php'),
            new UploadedFile(stream_get_meta_data($disguisedFile)['uri'], 'disguised.pdf', 'application/pdf', null, true),
            UploadedFile::fake()->create('large.pdf', 11000, 'application/pdf'),
        ] as $file) {
            $this->post(route('account.family.documents.store'), ['document' => $file])
                ->assertSessionHasErrorsIn('upload', 'document');
        }
        $this->assertDatabaseCount('family_documents', 0);
        $this->assertSame([], Storage::disk('local')->allFiles());
    }

    public function test_duplicate_folder_names_are_rejected_for_same_family_only(): void
    {
        $first = User::factory()->create(['account_type' => 'Family']);
        $second = User::factory()->create(['account_type' => 'Family']);
        FamilyFolder::create(['user_id' => $first->id, 'name' => 'Reports']);

        $this->actingAs($first)->post(route('account.family.folders.store'), ['folder_name' => 'Reports'])
            ->assertSessionHasErrorsIn('folder', 'folder_name');
        $this->actingAs($second)->post(route('account.family.folders.store'), ['folder_name' => 'Reports'])
            ->assertSessionHasNoErrors()->assertRedirect(route('account.family.documents'));
        $this->assertDatabaseCount('family_folders', 2);
    }

    public function test_filters_search_sort_and_storage_summary_use_the_familys_records(): void
    {
        Storage::fake('local');
        $user = User::factory()->create(['account_type' => 'Family']);
        $folder = FamilyFolder::create(['user_id' => $user->id, 'name' => 'Reports']);
        $this->actingAs($user)->post(route('account.family.documents.store'), [
            'document' => UploadedFile::fake()->create('Zebra report.pdf', 100, 'application/pdf'),
            'child_name' => 'Zoe', 'family_folder_id' => $folder->id,
        ])->assertSessionHasNoErrors();
        $this->post(route('account.family.documents.store'), [
            'document' => UploadedFile::fake()->create('Art.jpg', 200, 'image/jpeg'),
        ])->assertSessionHasNoErrors();

        $this->get(route('account.family.documents', ['q' => 'Zoe']))->assertSee('Zebra report.pdf')->assertDontSee('Art.jpg');
        $this->get(route('account.family.documents', ['folder' => $folder->id]))->assertSee('Zebra report.pdf')->assertDontSee('Art.jpg');
        $this->get(route('account.family.documents', ['type' => 'jpg']))->assertSee('Art.jpg')->assertDontSee('Zebra report.pdf');
        $this->get(route('account.family.documents', ['sort' => 'name']))->assertSeeInOrder(['Art.jpg', 'Zebra report.pdf'])
            ->assertViewHas('usedBytes', 307200)->assertViewHas('imageBytes', 204800)->assertViewHas('documentBytes', 102400);
        $this->get(route('account.family.documents', ['q' => 'absent']))->assertSee('No matching documents');
        $this->getJson(route('account.family.documents', ['sort' => 'name; DROP TABLE users']))
            ->assertUnprocessable()->assertJsonValidationErrors('sort');
    }

    public function test_empty_state_is_real_and_family_navigation_links_to_documents(): void
    {
        $user = User::factory()->create(['account_type' => 'Family']);

        $this->actingAs($user)->get(route('account.family.documents'))->assertOk()
            ->assertSee('Upload your first document')->assertViewHas('usedBytes', 0)->assertViewHas('fileCount', 0);
        $this->get(route('dashboard'))->assertSee(route('account.family.documents'));
        $this->get(route('families'))->assertSee(route('account.family.documents'));
    }

    public function test_user_provided_file_folder_and_child_names_are_escaped(): void
    {
        Storage::fake('local');
        $user = User::factory()->create(['account_type' => 'Family']);
        $unsafe = '<script>alert(1)</script>';
        $folder = FamilyFolder::create(['user_id' => $user->id, 'name' => $unsafe]);
        $this->actingAs($user)->post(route('account.family.documents.store'), [
            'document' => UploadedFile::fake()->create('report.pdf', 10, 'application/pdf'),
            'child_name' => $unsafe, 'family_folder_id' => $folder->id,
        ])->assertSessionHasNoErrors();
        FamilyDocument::sole()->update(['name' => $unsafe.'.pdf']);

        $this->get(route('account.family.documents'))->assertSee(e($unsafe), false)->assertDontSee($unsafe, false);
    }
}
