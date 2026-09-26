<?php

namespace Tests\Feature;

use App\Models\SitePage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SolutionDetailsTest extends TestCase
{
    use RefreshDatabase;

    public function test_each_default_solution_has_its_own_popup(): void
    {
        $response = $this->get(route('solutions'))->assertOk();

        $response->assertSee('id="solution-performance-confidence"', false)
            ->assertSee('Positive Mindset &amp; Self-Belief', false)
            ->assertSee('id="solution-academic-learning"', false)
            ->assertSee('Subject Mastery')
            ->assertSee('id="solution-specialised-support"', false)
            ->assertSee('Professional Assessment');
        $this->assertSame(8, substr_count($response->getContent(), 'aria-haspopup="dialog"'));
    }

    public function test_admin_can_save_details_and_public_page_reads_them(): void
    {
        $this->signInAdmin();
        $page = SitePage::query()->create(['slug' => 'solutions', 'title' => 'Solutions', 'content' => ['heading' => 'Keep this heading'], 'is_published' => true]);
        $payload = $this->payload();
        $payload['title'] = 'Confidence for every child';
        $payload['areas'][0]['title'] = 'Personal goals';
        $payload['areas'][0]['points'] = "Find your strengths\nBuild healthy habits";
        $payload['benefits'] = "More confidence\nBetter focus";
        $payload['image_url'] = 'https://example.com/hero.jpg';

        $this->put(route('admin.solutions.update', 'performance-confidence'), $payload)
            ->assertSessionHasNoErrors()->assertRedirect(route('admin.solutions.index'));

        $saved = $page->fresh()->content;
        $this->assertSame('Keep this heading', $saved['heading']);
        $this->assertSame(['More confidence', 'Better focus'], $saved['solutions']['performance-confidence']['benefits']);
        $this->assertSame('https://example.com/hero.jpg', $saved['solutions']['performance-confidence']['image_url']);
        $this->get(route('solutions'))->assertOk()->assertSee('Confidence for every child')->assertSee('Personal goals')->assertSee('Find your strengths')->assertSee('Academic, Learning &amp; Excellence', false);
        $this->get(route('admin.solutions.edit', 'performance-confidence'))->assertSee('Confidence for every child');
    }

    public function test_admin_can_add_a_solution_then_hide_it_as_a_draft(): void
    {
        $this->signInAdmin();
        $payload = $this->payload();
        $payload['title'] = 'Creative Writing';
        $this->get(route('admin.solutions.create'))->assertOk();

        $this->post(route('admin.solutions.store'), $payload)->assertSessionHasNoErrors()->assertRedirect();
        $this->get(route('solutions'))->assertOk()->assertSee('id="solution-creative-writing"', false);

        $payload['is_published'] = 0;
        $this->put(route('admin.solutions.update', 'creative-writing'), $payload)->assertSessionHasNoErrors();
        $this->get(route('solutions'))->assertDontSee('Creative Writing');
        $this->get(route('admin.solutions.index'))->assertSee('Creative Writing')->assertSee('Draft');
        $this->assertFalse(SitePage::query()->where('slug', 'solutions')->firstOrFail()->content['solutions']['creative-writing']['is_published']);
    }

    public function test_guests_and_non_admins_cannot_manage_solutions(): void
    {
        $this->get(route('admin.solutions.index'))->assertRedirect(route('login'));
        $this->post(route('admin.solutions.store'), $this->payload())->assertRedirect(route('login'));
        $this->actingAs(User::factory()->create());
        $this->get(route('admin.solutions.edit', 'performance-confidence'))->assertForbidden();
        $this->post(route('admin.solutions.store'), $this->payload())->assertForbidden();
        $this->put(route('admin.solutions.update', 'performance-confidence'), $this->payload())->assertForbidden();
        $this->assertDatabaseCount('site_pages', 0);
    }

    public function test_invalid_links_and_malformed_support_areas_are_rejected_without_saving(): void
    {
        $this->signInAdmin();
        $payload = $this->payload();
        $payload['image_url'] = 'javascript:alert(1)';
        $payload['cta_route'] = 'admin.dashboard';
        $payload['areas'][0]['image_url'] = 'data:text/html,bad';
        $payload['areas'][0]['title'] = '';

        $this->put(route('admin.solutions.update', 'performance-confidence'), $payload)
            ->assertSessionHasErrors(['image_url', 'cta_route', 'areas.0.image_url', 'areas.0.title']);
        $this->assertDatabaseCount('site_pages', 0);
    }

    public function test_highlight_limit_and_duplicate_title_are_validated(): void
    {
        $this->signInAdmin();
        $payload = $this->payload();
        $payload['highlights'] = "One\nTwo\nThree\nFour\nFive";
        $this->put(route('admin.solutions.update', 'performance-confidence'), $payload)->assertSessionHasErrors('highlights');
        $payload = $this->payload();
        $payload['title'] = 'Academic Learning';
        $this->post(route('admin.solutions.store'), $payload)->assertSessionHasErrors('title');
        $this->assertDatabaseCount('site_pages', 0);
    }

    public function test_unknown_solution_is_not_created_by_update(): void
    {
        $this->signInAdmin();
        $this->get(route('admin.solutions.edit', 'unknown'))->assertNotFound();
        $this->put(route('admin.solutions.update', 'unknown'), $this->payload())->assertNotFound();
        $this->assertDatabaseCount('site_pages', 0);
    }

    public function test_popup_escapes_admin_text(): void
    {
        $this->signInAdmin();
        $payload = $this->payload();
        $payload['title'] = '<script>alert("title")</script>';
        $payload['areas'][0]['points'] = '<img src=x onerror=alert(1)>';
        $this->put(route('admin.solutions.update', 'performance-confidence'), $payload)->assertSessionHasNoErrors();

        $this->get(route('solutions'))->assertOk()->assertSee($payload['title'])->assertDontSee($payload['title'], false)
            ->assertSee($payload['areas'][0]['points'])->assertDontSee($payload['areas'][0]['points'], false);
    }

    public function test_editing_page_copy_preserves_saved_solution_details(): void
    {
        $this->signInAdmin();
        $this->put(route('admin.solutions.update', 'performance-confidence'), $this->payload())->assertSessionHasNoErrors();
        $page = SitePage::query()->where('slug', 'solutions')->firstOrFail();
        $details = $page->content['solutions'];

        $this->put(route('admin.content.update', $page), [
            'title' => 'Solutions page', 'heading' => 'New headline', 'intro' => 'New intro', 'is_published' => 1,
        ])->assertSessionHasNoErrors();

        $this->assertSame($details, $page->fresh()->content['solutions']);
        $this->get(route('solutions'))->assertOk()->assertSee('New headline')->assertSee('Find your strengths');
    }

    private function signInAdmin(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $this->actingAs($admin);
    }

    /** @return array<string, mixed> */
    private function payload(): array
    {
        return [
            'title' => 'Personal Development', 'description' => 'Build confidence and healthy habits.',
            'tone' => 'pink', 'photo' => 0, 'tagline' => 'Ready for tomorrow', 'age_range' => 'Ages 5–25',
            'support_intro' => 'Support for every stage.', 'highlights' => "Confidence\nHealthy habits",
            'benefits' => "Greater resilience\nBetter focus", 'cta_label' => 'Get Connected', 'cta_route' => 'contact',
            'is_published' => 1, 'areas' => [['title' => 'Mindset', 'points' => "Find your strengths\nSet personal goals"]],
        ];
    }
}
