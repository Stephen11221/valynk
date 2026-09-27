<?php

namespace Tests\Feature;

use App\Models\SitePage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_edit_page_and_publish_changes(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $this->actingAs($admin);

        $page = SitePage::query()->create([
            'slug' => 'about',
            'title' => 'Old title',
            'meta_description' => 'Old description',
            'content' => ['eyebrow' => 'Old label', 'heading' => 'Old heading', 'intro' => 'Old introduction'],
            'is_published' => false,
        ]);

        $this->get(route('admin.content'))->assertOk()->assertSee('Old title');
        $this->get(route('admin.content.edit', $page))->assertOk()->assertSee('Old heading');
        $this->put(route('admin.content.update', $page), [
            'title' => 'New title',
            'meta_description' => 'New description',
            'eyebrow' => 'New label',
            'heading' => 'New heading',
            'intro' => 'New introduction',
            'is_published' => '1',
        ])->assertRedirect(route('admin.content'));

        $this->get(route('about'))->assertOk()->assertSee('New heading')->assertSee('New introduction');
        $this->assertDatabaseHas('site_pages', ['id' => $page->id, 'title' => 'New title', 'is_published' => true]);
    }

    public function test_solutions_are_managed_separately_from_general_content(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $this->actingAs($admin);
        $page = SitePage::query()->create(['slug' => 'solutions', 'title' => 'Solution landing content', 'is_published' => true]);

        $this->get(route('admin.content'))->assertOk()
            ->assertDontSee('Solution landing content')
            ->assertDontSee(route('admin.transactions'))
            ->assertDontSee(route('admin.payments'))
            ->assertSee(route('admin.solutions.index'));
        $this->get(route('admin.solutions.index'))->assertOk()
            ->assertSee(route('admin.content.edit', $page))
            ->assertSee(route('admin.solutions.create'));
        $this->get(route('admin.content.edit', $page))->assertOk()->assertSee('Edit Solutions Landing Page');
        $this->put(route('admin.content.update', $page), [
            'title' => 'Updated solutions', 'heading' => 'Find support', 'intro' => 'Explore support areas', 'is_published' => '1',
        ])->assertRedirect(route('admin.solutions.index'));
        $this->assertDatabaseHas('site_pages', ['id' => $page->id, 'title' => 'Updated solutions']);
    }

    public function test_regular_user_cannot_change_page(): void
    {
        $page = SitePage::query()->create(['slug' => 'about', 'title' => 'Original', 'is_published' => true]);
        $this->actingAs(User::factory()->create())
            ->put(route('admin.content.update', $page), [
                'title' => 'Changed', 'heading' => 'Changed', 'intro' => 'Changed', 'is_published' => '1',
            ])->assertForbidden();
        $this->assertDatabaseHas('site_pages', ['id' => $page->id, 'title' => 'Original']);
    }

    public function test_a_draft_page_is_hidden_from_the_public(): void
    {
        SitePage::query()->create(['slug' => 'about', 'title' => 'Draft', 'is_published' => false]);

        $this->get(route('about'))->assertNotFound();
    }
}
