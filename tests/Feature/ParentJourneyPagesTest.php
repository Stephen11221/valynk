<?php

namespace Tests\Feature;

use App\Models\DevelopmentAssessment;
use App\Models\DevelopmentChild;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ParentJourneyPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_parent_reference_screens_are_accessible_without_creating_records(): void
    {
        $this->get(route('development.screens'))->assertOk()->assertSee('Every step towards a brighter future.');
        foreach (['ready', 'child', 'question-1', 'question-2', 'question-3', 'question-4', 'question-5', 'question-6', 'complete', 'report', 'subscription', 'matches', 'selection', 'programme', 'participant', 'intake', 'review', 'confirmation', 'dashboard', 'tracking'] as $screen) {
            $this->get(route('development.screens.show', $screen))->assertOk()->assertSee('Sample journey');
        }
        $this->get(route('development.screens.show', 'intake'))->assertSee('19,900')->assertSee('2,985')->assertSee('16,915');
        $this->assertSame(0, User::count());
        $this->assertSame(0, DevelopmentChild::count());
        $this->assertSame(0, DevelopmentAssessment::count());
    }

    public function test_sample_forms_retain_answers_programme_and_payment_choices_in_the_session_only(): void
    {
        $this->post(route('development.screens.save', 'child'), ['child_name' => 'Sample Learner', 'age' => 10, 'grade' => 'Grade 5', 'school' => 'Sample School', 'pwd_status' => 'no'])
            ->assertRedirect(route('development.screens.show', ['screen' => 'question-1', 'programme' => 'gap']));
        $this->post(route('development.screens.save', 'question-1'), ['answer' => 'Not very confident'])->assertSessionHas('parent_journey_preview.answers.confidence', 'Not very confident');
        $this->get(route('development.screens.show', 'report'))->assertSee('Sample Learner')->assertSee('My child often doubts themselves');
        $this->post(route('development.screens.save', 'selection'), ['programme' => 'pap'])->assertSessionHas('parent_journey_preview.programme', 'pap');
        $this->post(route('development.screens.save', 'participant'), ['participant_confirmed' => 1, 'contact_phone' => '0700000000'])->assertSessionHas('parent_journey_preview.participant_confirmed');
        $this->post(route('development.screens.save', 'intake'), ['intake' => 'alternative', 'payment_option' => 'full', 'payment_method' => 'Card'])->assertSessionHas('parent_journey_preview.payment_option', 'full');
        $this->get(route('development.screens.show', 'review'))->assertSee('Request another intake')->assertSee('25,415')->assertSee('Card');
        $this->post(route('development.screens.save', 'review'), ['enquiry_consent' => 1])->assertRedirect(route('development.screens.show', ['screen' => 'confirmation', 'programme' => 'pap']));
        $this->get(route('development.screens.show', 'confirmation'))->assertSee('KES 0')->assertSee('No booking, payment, email or WhatsApp message has been sent.');
        $this->assertSame(0, DevelopmentAssessment::count());
    }

    public function test_sample_validation_rejects_unknown_pages_programmes_answers_and_payment_methods(): void
    {
        $this->get(route('development.screens.show', 'unknown'))->assertNotFound();
        $this->post(route('development.screens.save', 'confirmation'))->assertNotFound();
        $this->get(route('development.screens.show', ['screen' => 'programme', 'programme' => '../secret']))->assertSessionHasErrors('programme');
        $this->post(route('development.screens.save', 'question-1'), ['answer' => 'Invented'])->assertSessionHasErrors('answer');
        $this->post(route('development.screens.save', 'selection'), ['programme' => 'bad'])->assertSessionHasErrors('programme');
        $this->post(route('development.screens.save', 'intake'), ['intake' => 'forged', 'payment_option' => 'free', 'payment_method' => 'bad'])->assertSessionHasErrors(['intake', 'payment_option', 'payment_method']);
    }

    public function test_live_enquiry_saves_validated_preferences_and_preserves_assessment_answers_and_consent(): void
    {
        $assessment = $this->assessmentForParent();
        $consent = $assessment->consented_at->toIso8601String();
        $this->get(route('development.enquiry', [$assessment, 'selection']))->assertSee('Genius Activator')->assertDontSee('Performance Accelerator Program');
        $this->post(route('development.enquiry.save', [$assessment, 'selection']), ['programme' => 'gap'])->assertRedirect(route('development.enquiry', [$assessment, 'programme']));
        $this->get(route('development.enquiry', [$assessment, 'programme']))->assertSee('14,900')->assertDontSee('15%');
        $this->post(route('development.enquiry.save', [$assessment, 'participant']), ['participant_confirmed' => 1, 'contact_phone' => '0700000000', 'participant_notes' => 'Private practical needs'])->assertRedirect(route('development.enquiry', [$assessment, 'intake']));
        $this->post(route('development.enquiry.save', [$assessment, 'intake']), ['intake' => 'listed', 'payment_option' => 'commitment', 'payment_method' => 'M-PESA', 'amount' => 1, 'status' => 'Paid'])->assertRedirect(route('development.enquiry', [$assessment, 'review']));
        $this->get(route('development.enquiry', [$assessment, 'review']))->assertSee('5,000')->assertSee('Save Programme Enquiry');
        $this->post(route('development.enquiry.save', [$assessment, 'review']), ['enquiry_consent' => 1])->assertRedirect(route('development.enquiry', [$assessment, 'confirmation']));
        $this->get(route('development.enquiry', [$assessment, 'confirmation']))->assertSee('Programme Enquiry Saved!')->assertSee('No booking has been confirmed')->assertDontSee('Sample amount paid');
        $assessment->refresh();
        $this->assertSame('Somewhat confident', data_get($assessment->answers, 'personal_development.confidence'));
        $this->assertSame('gap', data_get($assessment->answers, 'programme_enquiry.programme'));
        $this->assertSame('commitment', data_get($assessment->answers, 'programme_enquiry.payment_option'));
        $this->assertNotNull(data_get($assessment->answers, 'programme_enquiry.requested_at'));
        $this->assertArrayNotHasKey('amount', $assessment->answers['programme_enquiry']);
        $this->assertArrayNotHasKey('status', $assessment->answers['programme_enquiry']);
        $this->assertSame($consent, $assessment->consented_at->toIso8601String());
        $this->assertStringNotContainsString('Private practical needs', DB::table('development_assessments')->value('answers'));
        $this->get(route('dashboard'))->assertSee('Saved Programme Enquiry');
        $this->get(route('development.bookings'))->assertSee('Real Learner')->assertSee('Review Enquiry');
        $this->get(route('account.section', 'progress'))->assertSee('View Saved Programme Enquiry');
    }

    public function test_live_enquiry_requires_the_right_parent_consent_age_and_completed_steps(): void
    {
        $assessment = $this->assessmentForParent();
        $this->get(route('development.enquiry', [$assessment, 'review']))->assertRedirect(route('development.enquiry', [$assessment, 'selection']));
        $this->post(route('development.enquiry.save', [$assessment, 'review']), ['enquiry_consent' => 1])->assertStatus(422);
        $this->post(route('development.enquiry.save', [$assessment, 'selection']), ['programme' => 'pap'])->assertSessionHasErrors('programme');
        $this->post(route('development.enquiry.save', [$assessment, 'selection']), ['programme' => 'gap'])->assertRedirect();
        $this->get(route('development.enquiry', [$assessment, 'confirmation']))->assertRedirect(route('development.enquiry', [$assessment, 'participant']));
        $this->post(route('development.enquiry.save', [$assessment, 'participant']), ['contact_phone' => '0700000000'])->assertSessionHasErrors('participant_confirmed');
        $assessment->refresh();
        $this->assertNull(data_get($assessment->answers, 'programme_enquiry.participant_confirmed'));
        $assessment->update(['consented_at' => null]);
        $this->get(route('development.enquiry', [$assessment, 'selection']))->assertNotFound();
        $this->post(route('development.enquiry.save', [$assessment, 'selection']), ['programme' => 'gap'])->assertNotFound();
        $assessment->update(['consented_at' => now()]);
        $this->actingAs(User::factory()->create(['account_type' => 'Family']));
        $this->get(route('development.enquiry', [$assessment, 'selection']))->assertNotFound();
        $this->post(route('development.enquiry.save', [$assessment, 'selection']), ['programme' => 'gap'])->assertNotFound();
        auth()->logout();
        $this->get(route('development.enquiry', [$assessment, 'selection']))->assertRedirect(route('login'));
    }

    public function test_changing_programme_resets_later_selections(): void
    {
        $assessment = $this->assessmentForParent();
        $answers = $assessment->answers;
        $answers['programme_enquiry'] = ['programme' => 'gap', 'participant_confirmed' => 1, 'intake' => 'listed', 'requested_at' => now()->toIso8601String()];
        $assessment->update(['answers' => $answers]);
        $this->post(route('development.enquiry.save', [$assessment, 'selection']), ['programme' => 'club'])->assertRedirect();
        $this->assertSame(['programme' => 'club'], $assessment->fresh()->answers['programme_enquiry']);
        $assessment->child->update(['age' => 25]);
        $this->get(route('development.enquiry', [$assessment, 'review']))->assertRedirect(route('development.enquiry', [$assessment, 'selection']));
        $this->post(route('development.enquiry.save', [$assessment, 'review']), ['enquiry_consent' => 1])->assertStatus(422);
    }

    private function assessmentForParent(): DevelopmentAssessment
    {
        $parent = User::factory()->create(['account_type' => 'Family']);
        $this->actingAs($parent);
        $child = DevelopmentChild::create(['user_id' => $parent->id, 'name' => 'Real Learner', 'age' => 10, 'grade' => 'Grade 5', 'school' => 'Local School']);

        return $child->assessments()->create(['answers' => ['personal_development' => ['confidence' => 'Somewhat confident']], 'step' => 5, 'consented_at' => now()]);
    }
}
