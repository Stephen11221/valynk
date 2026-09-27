<?php

namespace Tests\Feature;

use App\Models\DevelopmentAssessment;
use App\Models\DevelopmentChild;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AssessmentPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_answers_are_saved_encrypted_and_restored_when_returning_to_a_step(): void
    {
        $child = $this->childForParent();
        $this->get(route('development.assessment', [$child, 1]))->assertOk()->assertSee('Take a Brief Assessment')->assertSee('Learner');
        $this->post(route('development.assessment.save', [$child, 1]), [
            'reasons' => ['Academic Performance', 'Other'], 'reasons_other' => 'Support with a school transition',
            'performance' => 'Average', 'goals' => ['Build confidence and self-belief', 'Other'], 'goals_other' => 'Speak at assembly',
        ])->assertSessionHasNoErrors()->assertRedirect(route('development.assessment', [$child, 2]));

        $assessment = DevelopmentAssessment::sole();
        $this->assertSame(['Academic Performance', 'Other'], $assessment->answers['reasons']);
        $this->assertSame('Speak at assembly', $assessment->answers['goals_other']);
        $this->assertSame(2, $assessment->step);
        $this->assertStringNotContainsString('Speak at assembly', DB::table('development_assessments')->value('answers'));
        $this->get(route('development.assessment', [$child, 1]))->assertOk()->assertSee('Speak at assembly')->assertSee('Support with a school transition');
    }

    public function test_other_details_and_goal_limit_are_enforced_without_saving_invalid_answers(): void
    {
        $child = $this->childForParent();
        $this->post(route('development.assessment.save', [$child, 1]), [
            'reasons' => ['Other'], 'performance' => 'Average',
            'goals' => ['Improve grades and learning habits', 'Build confidence and self-belief', 'Develop key skills', 'Explore career interests'],
        ])->assertSessionHasErrors(['reasons_other', 'goals']);
        $this->assertDatabaseCount('development_assessments', 0);
    }

    public function test_editing_an_earlier_step_preserves_later_answers_and_clears_old_other_details_and_consent(): void
    {
        $child = $this->childForParent();
        $assessment = $child->assessments()->create([
            'answers' => ['reasons' => ['Other'], 'reasons_other' => 'Old explanation', 'goals' => ['Other'], 'goals_other' => 'Old goal', 'learning' => ['Hands-on']],
            'step' => 5, 'consented_at' => now(),
        ]);
        $this->post(route('development.assessment.save', [$child, 1]), [
            'reasons' => ['Confidence & Self-Esteem'], 'performance' => 'Doing well', 'goals' => ['Build confidence and self-belief'],
        ])->assertSessionHasNoErrors()->assertRedirect(route('development.assessment', [$child, 2]));

        $assessment->refresh();
        $this->assertSame(5, $assessment->step);
        $this->assertSame(['Hands-on'], $assessment->answers['learning']);
        $this->assertNull($assessment->answers['reasons_other']);
        $this->assertNull($assessment->answers['goals_other']);
        $this->assertNull($assessment->consented_at);
        $this->assertDatabaseCount('development_assessments', 1);
        $this->get(route('development.report', $assessment))->assertNotFound();
    }

    public function test_support_preferences_restore_and_update_the_existing_learning_details(): void
    {
        $child = $this->childForParent();
        $assessment = $child->assessments()->create([
            'answers' => ['learning' => ['Hands-on'], 'differences' => 'Yes', 'difference_details' => 'Reading support'],
            'step' => 3,
        ]);
        $this->get(route('development.assessment', [$child, 3]))->assertOk()->assertSee('Almost there!')->assertSee('Reading support');
        $payload = [
            'support' => ['Academic Support', 'Other'], 'support_other' => 'School transition',
            'heard' => 'Other', 'heard_other' => 'Community event', 'expectations' => 'Practical learning support',
            'updates' => 'No', 'differences' => 'Not sure', 'difference_details' => 'Awaiting an assessment',
        ];
        $this->post(route('development.assessment.save', [$child, 3]), array_replace($payload, ['updates' => 'invalid']))->assertSessionHasErrors('updates');
        $this->assertSame(3, $assessment->fresh()->step);
        $this->post(route('development.assessment.save', [$child, 3]), $payload)->assertSessionHasNoErrors()->assertRedirect(route('development.assessment', [$child, 4]));
        $assessment->refresh();
        $this->assertSame(['Hands-on'], $assessment->answers['learning']);
        foreach ($payload as $key => $value) {
            $this->assertSame($value, $assessment->answers[$key]);
        }
        $this->assertStringNotContainsString('Practical learning support', DB::table('development_assessments')->value('answers'));
        $this->get(route('development.assessment', [$child, 3]))->assertOk()->assertSee('Awaiting an assessment')->assertSee('Community event');
        $this->get(route('development.assessment', [$child, 2]))->assertOk()->assertSee('Awaiting an assessment');
    }

    public function test_duplicate_submissions_update_the_same_assessment(): void
    {
        $child = $this->childForParent();
        $payload = ['reasons' => ['Academic Performance'], 'performance' => 'Average', 'goals' => ['Develop key skills']];
        $this->post(route('development.assessment.save', [$child, 1]), $payload)->assertSessionHasNoErrors();
        $payload['performance'] = 'Doing well';
        $this->post(route('development.assessment.save', [$child, 1]), $payload)->assertSessionHasNoErrors();

        $this->assertDatabaseCount('development_assessments', 1);
        $this->assertSame('Doing well', DevelopmentAssessment::sole()->answers['performance']);
    }

    public function test_another_parent_cannot_read_or_save_child_answers(): void
    {
        $child = $this->childForParent();
        $this->actingAs(User::factory()->create());
        $this->get(route('development.assessment', [$child, 1]))->assertNotFound();
        $this->post(route('development.assessment.save', [$child, 1]), [
            'reasons' => ['Academic Performance'], 'performance' => 'Average', 'goals' => ['Develop key skills'],
        ])->assertNotFound();
        $this->assertDatabaseCount('development_assessments', 0);
    }

    private function childForParent(): DevelopmentChild
    {
        $parent = User::factory()->create();
        $this->actingAs($parent);

        return DevelopmentChild::create(['user_id' => $parent->id, 'name' => 'Learner', 'age' => 10, 'grade' => 'Grade 5']);
    }
}
