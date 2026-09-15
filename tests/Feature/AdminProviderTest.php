<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminProviderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $this->actingAs($admin);
    }

    public function test_page_counts_real_provider_accounts_and_handles_missing_profiles(): void
    {
        $approved = User::factory()->create(['name' => 'Approved Tutor', 'account_type' => 'Provider']);
        $approved->providerProfile()->create([
            'service' => 'Tutoring', 'category' => 'Academic Support',
            'status' => 'Approved', 'verification' => 'Verified',
        ]);
        User::factory()->create(['name' => 'New Provider', 'account_type' => 'Provider']);
        User::factory()->create(['name' => 'Regular Account', 'account_type' => 'Family']);

        $this->get(route('admin.providers'))
            ->assertOk()
            ->assertSee('Approved Tutor')
            ->assertSee('New Provider')
            ->assertSee('Not Verified')
            ->assertDontSee('Regular Account')
            ->assertDontSee('MindWell Center')
            ->assertDontSee('This Month: 1 – 27 May 2025')
            ->assertDontSee('KES 3,842,500')
            ->assertViewHas('stats', fn (array $stats): bool => $stats === [
                'total' => 2, 'approved' => 1, 'pending' => 1, 'rejected' => 0, 'verified' => 1,
            ]);
    }

    public function test_search_and_filters_use_database_fields(): void
    {
        $tutor = User::factory()->create(['name' => 'Bright Tutor', 'account_type' => 'Provider']);
        $tutor->providerProfile()->create([
            'service' => 'Math Tutoring', 'category' => 'Academic Support',
            'status' => 'Approved', 'verification' => 'Verified',
        ]);
        $coach = User::factory()->create(['name' => 'Wellness Coach', 'account_type' => 'Provider']);
        $coach->providerProfile()->create([
            'service' => 'Life Coaching', 'category' => 'Wellness',
            'status' => 'Rejected', 'verification' => 'Not Verified',
        ]);
        User::factory()->create(['name' => 'New Provider', 'account_type' => 'Provider']);

        $this->get(route('admin.providers', [
            'search' => 'Math', 'category' => 'Academic Support',
            'status' => 'Approved', 'verification' => 'Verified',
        ]))->assertOk()->assertViewHas('providers', fn ($providers): bool => $providers->pluck('name')->all() === ['Bright Tutor']);

        $this->get(route('admin.providers', ['status' => 'Pending']))
            ->assertOk()->assertViewHas('providers', fn ($providers): bool => $providers->pluck('name')->all() === ['New Provider']);
    }

    public function test_admin_can_add_and_review_a_provider(): void
    {
        $this->get(route('admin.providers.create'))->assertOk()->assertSee('Add New Provider');

        $this->post(route('admin.providers.store'), [
            'name' => 'New Academy', 'email' => 'academy@example.com', 'phone' => '0712345678',
            'location' => 'Nairobi', 'service' => 'Career Coaching', 'category' => 'Career Guidance',
            'status' => 'Pending', 'verification' => 'Under Review',
            'password' => 'secure-provider-password',
            'password_confirmation' => 'secure-provider-password',
            'is_admin' => '1',
        ])->assertRedirect(route('admin.providers'));

        $provider = User::query()->where('email', 'academy@example.com')->firstOrFail();
        $this->assertSame('Provider', $provider->account_type);
        $this->assertFalse($provider->is_admin);
        $this->assertTrue(Hash::check('secure-provider-password', $provider->password));
        $this->assertSame('Career Coaching', $provider->providerProfile->service);

        $this->get(route('admin.providers.edit', $provider))->assertOk()->assertSee('Career Coaching');
        $this->put(route('admin.providers.update', $provider), [
            'name' => 'New Academy', 'email' => 'academy@example.com',
            'service' => 'Career Coaching', 'category' => 'Career Guidance',
            'status' => 'Approved', 'verification' => 'Verified',
        ])->assertRedirect(route('admin.providers'));
        $this->assertSame('Approved', $provider->fresh()->providerProfile->status);
        $this->assertSame('Verified', $provider->fresh()->providerProfile->verification);
        $this->assertTrue(Hash::check('secure-provider-password', $provider->fresh()->password));
    }

    public function test_csv_export_respects_filters(): void
    {
        User::factory()->create(['name' => 'Pending School', 'account_type' => 'Provider']);
        $approved = User::factory()->create(['name' => 'Approved Center', 'account_type' => 'Provider']);
        $approved->providerProfile()->create([
            'service' => 'Therapy', 'category' => 'Wellness',
            'status' => 'Approved', 'verification' => 'Verified',
        ]);
        $unsafe = User::factory()->create(['name' => '=HYPERLINK("bad")', 'account_type' => 'Provider']);
        $unsafe->providerProfile()->create([
            'service' => 'Coaching', 'category' => 'Wellness',
            'status' => 'Approved', 'verification' => 'Verified',
        ]);

        $response = $this->get(route('admin.providers.export', ['status' => 'Approved']));
        $response->assertOk()->assertDownload('providers.csv');
        $csv = $response->streamedContent();
        $this->assertStringContainsString('Approved Center', $csv);
        $this->assertStringContainsString("'=HYPERLINK", $csv);
        $this->assertStringNotContainsString('Pending School', $csv);
    }

    public function test_non_admin_cannot_add_provider(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('admin.providers.store'), [
                'name' => 'Unauthorized', 'email' => 'unauthorized@example.com',
            ])->assertForbidden();
        $this->assertDatabaseMissing('users', ['email' => 'unauthorized@example.com']);
    }
}
