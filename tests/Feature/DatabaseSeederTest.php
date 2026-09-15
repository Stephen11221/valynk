<?php

namespace Tests\Feature;

use App\Models\SitePage;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeding_again_preserves_existing_users_and_page_edits(): void
    {
        $existingUser = User::factory()->create(['email' => 'test@example.com']);

        $this->seed(DatabaseSeeder::class);
        $page = SitePage::query()->where('slug', 'about')->firstOrFail();
        $page->update(['title' => 'Edited About', 'content' => ['heading' => 'Edited heading']]);

        $this->seed(DatabaseSeeder::class);

        $this->assertSame(1, User::query()->where('email', 'test@example.com')->count());
        $this->assertSame($existingUser->id, User::query()->where('email', 'test@example.com')->firstOrFail()->id);
        $this->assertSame('Edited About', $page->fresh()->title);
        $this->assertSame('Edited heading', $page->fresh()->content['heading']);
    }
}
