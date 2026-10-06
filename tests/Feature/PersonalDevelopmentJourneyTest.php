<?php

namespace Tests\Feature;

use App\Models\DevelopmentAssessment;
use App\Models\DevelopmentChild;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PersonalDevelopmentJourneyTest extends TestCase
{
    use RefreshDatabase;

    public function test_details_and_six_questions_save_restore_and_continue_to_consent(): void
    {
        $child = $this->childForParent();
        $this->get(route('development.journey', $child))->assertRedirect(route('development.child.details', $child));
        $this->get(route('development.child.details', $child))->assertOk()->assertSee('Child’s Details');
        $this->post(route('development.child.details.save', $child), ['child_name' => 'Learner', 'age' => 10, 'grade' => 'Grade 5', 'school' => 'Local School', 'pwd_status' => 'yes', 'pwd_details' => 'Reading support'])->assertSessionHasNoErrors()->assertRedirect(route('development.mindset', [$child, 1]));
        $this->assertSame('Reading support', $child->fresh()->pwd_details);
        foreach (config('development.mindset_questions') as $number => $question) {
            $answer = array_keys($question['options'])[1];
            $this->get(route('development.mindset', [$child, $number]))->assertOk()->assertSee($question['label'])->assertSee('Question '.$number.' of 6');
            $this->post(route('development.mindset.save', [$child, $number]), ['answer' => $answer])->assertSessionHasNoErrors()->assertRedirect($number === 6 ? route('development.assessment.complete', $child) : route('development.mindset', [$child, $number + 1]));
            $this->assertSame($answer, DevelopmentAssessment::sole()->answers['personal_development'][$question['key']]);
        }
        $assessment = DevelopmentAssessment::sole();
        $this->assertSame(5, $assessment->step);
        $this->get(route('development.assessment.complete', $child))->assertOk()
            ->assertSee('Assessment Complete!')->assertSee('6 of 6 completed')
            ->assertSee(route('development.mindset', [$child, 6]))
            ->assertSee(route('development.assessment', [$child, 5]));
        $this->get(route('development.journey', $child))->assertRedirect(route('development.assessment.complete', $child));
        $this->assertStringNotContainsString('Somewhat confident', DB::table('development_assessments')->value('answers'));
        $this->get(route('development.mindset', [$child, 1]))->assertOk()->assertSee('value="Somewhat confident" required checked', false);
        $this->get(route('development.assessment', [$child, 5]))->assertOk()->assertSee('Somewhat confident');
        $this->get(route('development.report', $assessment))->assertNotFound();
        $this->post(route('development.assessment.save', [$child, 5]), ['guardian' => 1, 'consent' => 1, 'sharing' => 1])->assertSessionHasNoErrors();
        $this->get(route('development.report', $assessment))->assertOk()->assertSee('Somewhat confident');
        $this->get(route('development.assessment.complete', $child))->assertOk()->assertSee(route('development.report', $assessment));
        $this->post(route('development.mindset.save', [$child, 1]), ['answer' => 'Very confident'])->assertSessionHasNoErrors();
        $this->assertNull($assessment->fresh()->consented_at);
    }

    public function test_invalid_details_answers_and_skipped_questions_are_rejected(): void
    {
        $child = $this->childForParent();
        $this->post(route('development.child.details.save', $child), ['child_name' => '', 'age' => 2, 'grade' => '', 'pwd_status' => 'invalid'])->assertSessionHasErrors(['child_name', 'age', 'grade', 'pwd_status']);
        $this->assertDatabaseCount('development_assessments', 0);
        $this->get(route('development.mindset', [$child, 1]))->assertRedirect(route('development.child.details', $child));
        $this->post(route('development.mindset.save', [$child, 1]), ['answer' => 'Very confident'])->assertStatus(422);
        $child->assessments()->create(['answers' => ['details_confirmed' => true], 'step' => 1]);
        $this->post(route('development.mindset.save', [$child, 1]), [])->assertSessionHasErrors('answer');
        $this->post(route('development.mindset.save', [$child, 1]), ['answer' => 'Invalid answer'])->assertSessionHasErrors('answer');
        $this->get(route('development.mindset', [$child, 3]))->assertRedirect(route('development.mindset', [$child, 1]));
        $this->post(route('development.mindset.save', [$child, 3]), ['answer' => 'Very easily'])->assertStatus(422);
        $this->get(route('development.mindset', [$child, 7]))->assertNotFound();
        $this->assertArrayNotHasKey('personal_development', DevelopmentAssessment::sole()->answers);
    }

    public function test_guests_and_other_parents_cannot_access_or_change_the_journey(): void
    {
        $child = $this->childForParent();
        $this->actingAs(User::factory()->create());
        foreach (['development.child.details', 'development.journey', 'development.assessment.complete'] as $route) {
            $this->get(route($route, $child))->assertNotFound();
        }
        $this->post(route('development.child.details.save', $child), [])->assertNotFound();
        $this->get(route('development.mindset', [$child, 1]))->assertNotFound();
        $this->post(route('development.mindset.save', [$child, 1]), [])->assertNotFound();
        auth()->logout();
        $this->get(route('development.child.details', $child))->assertRedirect(route('login'));
        $this->get(route('development.assessment.complete', $child))->assertRedirect(route('login'));
        $this->post(route('development.mindset.save', [$child, 1]), [])->assertRedirect(route('login'));
    }

    public function test_dashboard_resume_returns_to_the_first_unanswered_question(): void
    {
        $child = $this->childForParent();
        $child->assessments()->create(['answers' => ['details_confirmed' => true, 'personal_development' => ['confidence' => 'Very confident']], 'step' => 1]);
        $this->get(route('development.journey', $child))->assertRedirect(route('development.mindset', [$child, 2]));
    }

    public function test_editing_details_clears_inapplicable_disability_details_and_preserves_answers(): void
    {
        $child = $this->childForParent();
        $child->update(['pwd_status' => 'yes', 'pwd_details' => 'Old details']);
        $assessment = $child->assessments()->create(['answers' => ['details_confirmed' => true, 'personal_development' => ['confidence' => 'Very confident']], 'step' => 5, 'consented_at' => now()]);
        $this->post(route('development.child.details.save', $child), ['child_name' => 'Updated Learner', 'age' => 11, 'grade' => 'Grade 6', 'pwd_status' => 'no', 'pwd_details' => 'Should be removed'])->assertSessionHasNoErrors();
        $this->assertNull($child->fresh()->pwd_details);
        $this->assertSame('Very confident', $assessment->fresh()->answers['personal_development']['confidence']);
        $this->assertNull($assessment->fresh()->consented_at);
    }

    public function test_existing_assessments_resume_their_original_flow(): void
    {
        $child = $this->childForParent();
        $child->assessments()->create(['answers' => ['reasons' => ['Academic Performance']], 'step' => 2]);
        $this->get(route('development.journey', $child))->assertRedirect(route('development.assessment', [$child, 2]));
    }

    public function test_incomplete_assessments_cannot_show_the_completion_page(): void
    {
        $child = $this->childForParent();
        $this->get(route('development.assessment.complete', $child))->assertRedirect(route('development.child.details', $child));
        $assessment = $child->assessments()->create(['answers' => ['details_confirmed' => true, 'personal_development' => ['confidence' => 'Very confident']], 'step' => 1]);
        $this->get(route('development.assessment.complete', $child))->assertRedirect(route('development.mindset', [$child, 2]));
        $answers = $assessment->answers;
        $answers['personal_development']['confidence'] = 'Invalid saved answer';
        $assessment->update(['answers' => $answers]);
        $this->get(route('development.assessment.complete', $child))->assertRedirect(route('development.mindset', [$child, 1]));
    }

    private function childForParent(): DevelopmentChild
    {
        $parent = User::factory()->create(['account_type' => 'Family']);
        $this->actingAs($parent);

        return DevelopmentChild::create(['user_id' => $parent->id, 'name' => 'Learner', 'age' => 10, 'grade' => 'Grade 5']);
    }
}
