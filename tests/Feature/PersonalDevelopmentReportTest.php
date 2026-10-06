<?php

namespace Tests\Feature;

use App\Models\DevelopmentAssessment;
use App\Models\DevelopmentChild;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonalDevelopmentReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_report_uses_saved_answers_and_real_child_details(): void
    {
        $assessment = $this->assessmentForParent(1);
        $response = $this->get(route('development.report', $assessment))->assertOk()->assertViewIs('development.personal-report')
            ->assertSee('Learner')->assertSee('Local School')->assertSee('Grade 5')->assertSee('Download Report (PDF)')
            ->assertSee(route('development.providers'))->assertSee(route('development.assessment.complete', $assessment->child))
            ->assertSee('My child is confident sometimes, but can be unsure in new situations.');
        $response->assertViewHas('report', fn (array $report): bool => count($report['strengths']) === 3 && count($report['development']) === 3 && count($report['recommendations']) === 3);
    }

    public function test_positive_answers_do_not_invent_development_concerns(): void
    {
        $assessment = $this->assessmentForParent(0);
        $this->get(route('development.report', $assessment))->assertOk()
            ->assertSee('Your responses show positive habits across the areas assessed.')
            ->assertDontSee('They need frequent reminders to stay on track.')
            ->assertViewHas('report', fn (array $report): bool => count($report['strengths']) === 3 && $report['development'] === []);
    }

    public function test_uncertain_and_support_answers_are_not_described_as_strengths(): void
    {
        $assessment = $this->assessmentForParent(3);
        $this->get(route('development.report', $assessment))->assertOk()
            ->assertSee('Your answers highlight areas where additional support may help.')
            ->assertSee('I’m not sure')
            ->assertViewHas('report', fn (array $report): bool => $report['strengths'] === [] && count($report['development']) === 3);
    }

    public function test_report_requires_consent_and_is_private_to_the_parent(): void
    {
        $assessment = $this->assessmentForParent(1);
        $assessment->update(['consented_at' => null]);
        $this->get(route('development.report', $assessment))->assertNotFound();
        $assessment->update(['consented_at' => now()]);
        $this->actingAs(User::factory()->create())->get(route('development.report', $assessment))->assertNotFound();
        auth()->logout();
        $this->get(route('development.report', $assessment))->assertRedirect(route('login'));
    }

    private function assessmentForParent(int $optionIndex): DevelopmentAssessment
    {
        $parent = User::factory()->create(['account_type' => 'Family']);
        $this->actingAs($parent);
        $child = DevelopmentChild::create(['user_id' => $parent->id, 'name' => 'Learner', 'age' => 10, 'grade' => 'Grade 5', 'school' => 'Local School', 'pwd_status' => 'no']);
        $answers = [];
        foreach (config('development.mindset_questions') as $question) {
            $answers[$question['key']] = array_keys($question['options'])[$optionIndex];
        }

        return $child->assessments()->create(['answers' => ['details_confirmed' => true, 'personal_development' => $answers], 'step' => 5, 'consented_at' => now()]);
    }
}
