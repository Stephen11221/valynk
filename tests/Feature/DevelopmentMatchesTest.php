<?php

namespace Tests\Feature;

use App\Models\DevelopmentAssessment;
use App\Models\DevelopmentChild;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DevelopmentMatchesTest extends TestCase
{
    use RefreshDatabase;

    public function test_matches_show_relevant_verified_providers_and_age_appropriate_programmes(): void
    {
        $assessment = $this->assessmentForParent();
        foreach ([['Relevant Provider', 'Mindset and confidence coaching', 'Approved', 'Verified'], ['Pending Provider', 'Confidence coaching', 'Pending', 'Verified'], ['Unverified Provider', 'Confidence coaching', 'Approved', 'Pending'], ['Unrelated Provider', 'Dental services', 'Approved', 'Verified']] as [$name, $service, $status, $verification]) {
            User::factory()->create(['name' => $name, 'account_type' => 'Provider'])->providerProfile()->create(['service' => $service, 'category' => 'Support', 'status' => $status, 'verification' => $verification]);
        }
        $this->get(route('development.matches', $assessment))->assertOk()->assertSee('Relevant Provider')->assertSee('Genius Activator')
            ->assertDontSee('Pending Provider')->assertDontSee('Unverified Provider')->assertDontSee('Unrelated Provider')
            ->assertDontSee('Performance Accelerator Program')->assertSee(route('development.programme', [$assessment, 'gap']));
        $this->get(route('development.programme', [$assessment, 'gap']))->assertOk()->assertSee('Genius Activator')->assertSee('14,900');
        $this->get(route('development.programme', [$assessment, 'pap']))->assertNotFound();
        $this->get(route('development.programme', [$assessment, 'unknown']))->assertNotFound();
    }

    public function test_no_providers_or_programmes_produces_an_honest_empty_state(): void
    {
        $assessment = $this->assessmentForParent(25);
        $this->get(route('development.matches', $assessment))->assertOk()->assertSee('No relevant verified provider suggestions yet')->assertSee('No catalogue programmes currently cover this age group');
    }

    public function test_report_matches_and_programmes_require_parent_ownership_and_consent(): void
    {
        $assessment = $this->assessmentForParent();
        $assessment->update(['consented_at' => null]);
        $this->get(route('development.matches', $assessment))->assertNotFound();
        $this->get(route('development.programme', [$assessment, 'gap']))->assertNotFound();
        $assessment->update(['consented_at' => now()]);
        $this->actingAs(User::factory()->create());
        $this->get(route('development.matches', $assessment))->assertNotFound();
        $this->get(route('development.programme', [$assessment, 'gap']))->assertNotFound();
        auth()->logout();
        $this->get(route('development.matches', $assessment))->assertRedirect(route('login'));
    }

    private function assessmentForParent(int $age = 10): DevelopmentAssessment
    {
        $parent = User::factory()->create(['account_type' => 'Family']);
        $this->actingAs($parent);
        $child = DevelopmentChild::create(['user_id' => $parent->id, 'name' => 'Learner', 'age' => $age, 'grade' => 'Grade 5', 'solution' => 'performance-confidence']);

        return $child->assessments()->create(['answers' => [], 'step' => 5, 'consented_at' => now()]);
    }
}
