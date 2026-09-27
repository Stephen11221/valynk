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
            ->assertSee(route('admin.pages.edit', 'solutions'))
            ->assertSee(route('admin.solutions.create'));
        $this->get(route('admin.content.edit', $page))->assertOk()->assertSee('Edit Solutions Landing Page');
        $this->put(route('admin.content.update', $page), [
            'title' => 'Updated solutions', 'heading' => 'Find support', 'intro' => 'Explore support areas', 'is_published' => '1',
        ])->assertRedirect(route('admin.solutions.index'));
        $this->assertDatabaseHas('site_pages', ['id' => $page->id, 'title' => 'Updated solutions']);
    }

    public function test_every_public_page_has_an_individual_editor_and_saves_without_seeding(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $this->actingAs($admin);
        $index = $this->get(route('admin.content'))->assertOk();
        foreach (array_keys(config('site-pages')) as $slug) {
            if ($slug !== 'solutions') {
                $index->assertSee(route('admin.pages.edit', $slug));
            }
            $this->get(route('admin.pages.edit', $slug))->assertOk();
        }
        $this->assertDatabaseCount('site_pages', 0);
        foreach (array_keys(config('site-pages')) as $slug) {
            $heading = 'Updated '.$slug.' headline';
            $this->put(route('admin.pages.update', $slug), [
                'title' => 'Page '.$slug, 'heading' => $heading, 'intro' => 'A new introduction for '.$slug,
                'meta_description' => 'Search description for '.$slug, 'is_published' => 1,
            ])->assertSessionHasNoErrors()->assertRedirect();
            $this->get(route($slug))->assertOk()->assertSee($heading)->assertSee('A new introduction for '.$slug);
            $this->get(route('admin.pages.edit', $slug))->assertOk()->assertSee($heading);
        }
        $this->assertDatabaseCount('site_pages', count(config('site-pages')));
    }

    public function test_page_editors_reject_invalid_unknown_and_unauthorised_requests(): void
    {
        $this->get(route('admin.pages.edit', 'about'))->assertRedirect(route('login'));
        $this->actingAs(User::factory()->create());
        $this->put(route('admin.pages.update', 'about'), [])->assertForbidden();
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $this->actingAs($admin);
        $this->get(route('admin.pages.edit', 'unknown'))->assertNotFound();
        $this->put(route('admin.pages.update', 'unknown'), [])->assertNotFound();
        $this->put(route('admin.pages.update', 'about'), [])->assertSessionHasErrors(['title', 'heading', 'intro']);
        $this->assertDatabaseCount('site_pages', 0);
    }

    public function test_admin_layout_still_renders_when_page_config_is_missing_from_cache(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $this->actingAs($admin);
        config(['site-pages' => null]);

        $this->get(route('admin.solutions.index'))->assertOk()->assertSee('Solutions');
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
