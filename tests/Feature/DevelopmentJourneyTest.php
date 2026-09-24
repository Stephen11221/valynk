<?php

namespace Tests\Feature;

use App\Models\DevelopmentAssessment;
use App\Models\DevelopmentChild;
use App\Models\DevelopmentConnection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DevelopmentJourneyTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_reference_pages_render_and_pdf_downloads(): void
    {
        $this->get(route('development.landing'))->assertOk()->assertSee('Personal Development');
        $this->get(route('development.register'))->assertOk();
        $this->get(route('development.sample'))->assertOk()->assertSee('Amina Wanjiku');
        $this->get(route('development.sample.pdf'))->assertDownload('VALYNK_Sample_Full_Report.pdf');
        foreach (['dashboard', 'providers', 'provider', 'programme', 'payment', 'confirmation', 'success', 'tracking'] as $page) {
            $this->get(route('development.preview', $page))->assertOk()->assertSee('Sample journey');
        }
        $this->get(route('development.preview', ['page' => 'payment', 'programme' => 'pap', 'mode' => 'online']))->assertOk()->assertSee('14,900')->assertSee('11,900');
        $this->get(route('development.preview', ['page' => 'confirmation', 'programme' => 'pap', 'mode' => 'online', 'amount' => 'full']))->assertOk()->assertSee('KES 0');
        $this->get(route('development.preview', 'unknown'))->assertNotFound();
        $this->get(route('development.preview', ['page' => 'programme', 'programme' => 'unknown']))->assertNotFound();
    }

    public function test_registration_creates_real_family_and_child(): void
    {
        $this->post(route('development.register.store'), ['name' => 'Test Parent', 'email' => 'parent@example.test', 'phone' => '0700000000', 'password' => 'a-secure-test-password', 'password_confirmation' => 'a-secure-test-password', 'terms' => 1, 'child_name' => 'Test Child', 'age' => 10, 'grade' => 'Grade 5'])->assertRedirect(route('development.home'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['account_type' => 'Family', 'email' => 'parent@example.test']);
        $this->assertDatabaseHas('development_children', ['name' => 'Test Child']);
    }

    public function test_assessment_saves_validates_consents_and_encrypts_answers(): void
    {
        $user = User::factory()->create();
        $child = DevelopmentChild::create(['user_id' => $user->id, 'name' => 'Learner', 'age' => 10, 'grade' => '5']);
        $this->actingAs($user);
        $this->get(route('development.assessment', [$child, 5]))->assertRedirect(route('development.assessment', [$child, 1]));
        $this->post(route('development.assessment.save', [$child, 5]), ['guardian' => 1, 'consent' => 1, 'sharing' => 1])->assertStatus(422);
        $this->post(route('development.assessment.save', [$child, 1]), ['reasons' => ['bad'], 'performance' => 'Average', 'goals' => ['Other']])->assertSessionHasErrors('reasons.0');
        foreach (config('development.questions') as $step => $questions) {
            $data = [];
            foreach ($questions as $key => [$label,$type,$options]) {
                $data[$key] = in_array($type, ['multi', 'goals']) ? [$options[0]] : ($type === 'text' ? 'Private parent observation' : $options[0]);
            }
            $this->get(route('development.assessment', [$child, $step]))->assertOk();
            $this->post(route('development.assessment.save', [$child, $step]), $data)->assertRedirect(route('development.assessment', [$child, $step + 1]));
        }
        $a = DevelopmentAssessment::sole();
        $this->get(route('development.report', $a))->assertNotFound();
        $this->get(route('development.assessment', [$child, 5]))->assertOk()->assertSee('Parental Consent');
        $this->post(route('development.assessment.save', [$child, 5]), [])->assertSessionHasErrors(['guardian', 'consent', 'sharing']);
        $this->post(route('development.assessment.save', [$child, 5]), ['guardian' => 1, 'consent' => 1, 'sharing' => 1])->assertRedirect(route('development.report', $a));
        $this->get(route('development.report', $a))->assertOk()->assertSee('Learner')->assertSee('Academic Support')->assertDontSee('78%');
        $this->assertStringNotContainsString('Private parent observation', DB::table('development_assessments')->value('answers'));
        $this->get(route('development.home'))->assertOk()->assertSee('Learner');
        $this->get(route('development.plans'))->assertOk();
        $this->get(route('development.checkout', ['plan' => 'Family', 'method' => 'Card']))->assertOk()->assertSee('Payments are not available yet');
        $this->get(route('development.checkout', ['plan' => 'invalid', 'method' => 'Card']))->assertSessionHasErrors('plan');
    }

    public function test_children_and_reports_are_private(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $child = DevelopmentChild::create(['user_id' => $owner->id, 'name' => 'Private Child', 'age' => 12, 'grade' => '7']);
        $a = $child->assessments()->create(['answers' => [], 'step' => 5, 'consented_at' => now()]);
        $this->get(route('development.home'))->assertRedirect(route('login'));
        $this->actingAs($other)->get(route('development.assessment', [$child, 1]))->assertNotFound();
        $this->post(route('development.assessment.save', [$child, 1]), [])->assertNotFound();
        $this->get(route('development.report', $a))->assertNotFound();
    }

    public function test_directory_and_connection_requests_use_approved_providers_and_owned_children(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $child = DevelopmentChild::create(['user_id' => $user->id, 'name' => 'Owned Learner', 'age' => 10, 'grade' => '5']);
        $foreign = DevelopmentChild::create(['user_id' => $other->id, 'name' => 'Other Child', 'age' => 10, 'grade' => '5']);
        $provider = User::factory()->create(['account_type' => 'Provider', 'name' => 'Verified Learning', 'location' => 'Nairobi']);
        $profile = $provider->providerProfile()->create(['status' => 'Approved', 'verification' => 'Verified', 'category' => 'Academic Support', 'service' => 'Learning coaching']);
        $pending = User::factory()->create(['account_type' => 'Provider', 'name' => 'Pending Provider']);
        $hidden = $pending->providerProfile()->create(['status' => 'Pending', 'verification' => 'Not Verified']);
        $this->actingAs($user)->get(route('development.providers'))->assertOk()->assertSee('Verified Learning')->assertDontSee('Pending Provider');
        $this->get(route('development.provider', $hidden))->assertNotFound();
        $this->get(route('development.providers', ['q' => 'missing']))->assertOk()->assertDontSee('Verified Learning');
        $this->get(route('development.provider', $profile))->assertOk();
        $this->post(route('development.connect', $profile), ['child_id' => $foreign->id, 'consent' => 1])->assertNotFound();
        $this->post(route('development.connect', $profile), ['child_id' => $child->id])->assertSessionHasErrors('consent');
        for ($i = 0; $i < 2; $i++) {
            $this->post(route('development.connect', $profile), ['child_id' => $child->id, 'consent' => 1, 'status' => 'Confirmed'])->assertRedirect(route('development.bookings'));
        }
        $this->assertSame(1, DevelopmentConnection::count());
        $this->assertSame('Requested', DevelopmentConnection::sole()->status);
        $this->get(route('development.bookings'))->assertOk()->assertSee('Owned Learner');
        $this->actingAs($other)->get(route('development.bookings'))->assertOk()->assertDontSee('Owned Learner');
    }
}
