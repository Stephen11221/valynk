<?php

namespace Tests\Feature;

use App\Models\DevelopmentChild;
use App\Models\SitePage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class GetConnectedTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_connected_uses_the_selected_solution_and_popup_links_to_it(): void
    {
        $this->get(route('get-connected', ['solution' => 'academic-learning']))->assertOk()
            ->assertSee('Academic, Learning &amp; Excellence', false)->assertSee('Create Your Account')
            ->assertSee('value="academic-learning"', false)->assertSee('PWD Status');
        $this->get(route('solutions'))->assertOk()->assertSee(route('get-connected', ['solution' => 'academic-learning']));
        $this->get(route('get-connected', ['solution' => 'missing']))->assertNotFound();
    }

    public function test_draft_solutions_cannot_be_used_for_registration(): void
    {
        $details = config('solutions.academic-learning');
        $details['is_published'] = false;
        SitePage::query()->create(['slug' => 'solutions', 'title' => 'Solutions', 'content' => ['solutions' => ['academic-learning' => $details]], 'is_published' => true]);
        $this->get(route('get-connected', ['solution' => 'academic-learning']))->assertNotFound();
        $this->post(route('development.register.store'), $this->payload())->assertSessionHasErrors('solution');
        $this->assertDatabaseCount('users', 0);
    }

    public function test_registration_saves_family_child_and_encrypted_support_details_then_begins_assessment(): void
    {
        $response = $this->post(route('development.register.store'), $this->payload());
        $child = DevelopmentChild::sole();
        $parent = User::sole();

        $response->assertSessionHasNoErrors()->assertRedirect(route('development.assessment', [$child, 1]));
        $this->assertAuthenticatedAs($parent);
        $this->assertSame('Family', $parent->account_type);
        $this->assertTrue(Hash::check('A-secure-test-password', $parent->password));
        $this->assertSame($parent->id, $child->user_id);
        $this->assertSame('academic-learning', $child->solution);
        $this->assertSame('yes', $child->pwd_status);
        $this->assertSame('Hearing support', $child->pwd_details);
        $this->assertSame('Enjoys reading and music.', $child->support_notes);
        $raw = DB::table('development_children')->first();
        $this->assertNotSame('yes', $raw->pwd_status);
        $this->assertStringNotContainsString('Hearing support', $raw->pwd_details);
        $this->assertStringNotContainsString('Enjoys reading', $raw->support_notes);
        $this->assertArrayNotHasKey('pwd_details', $child->toArray());
    }

    public function test_authenticated_parent_adds_child_without_creating_another_account(): void
    {
        $parent = User::factory()->create();
        $this->actingAs($parent);
        $this->get(route('get-connected'))->assertOk()->assertSee('Add Your Child')->assertDontSee('name="password"', false);
        $payload = $this->payload();
        $payload['pwd_status'] = 'no';
        $response = $this->post(route('development.child.store'), $payload);
        $child = DevelopmentChild::sole();

        $response->assertSessionHasNoErrors()->assertRedirect(route('development.assessment', [$child, 1]));
        $this->assertDatabaseCount('users', 1);
        $this->assertSame($parent->id, $child->user_id);
        $this->assertNull($child->pwd_details);
    }

    public function test_invalid_details_do_not_create_a_partial_account(): void
    {
        $payload = $this->payload();
        $payload['pwd_status'] = 'unknown';
        $payload['support_notes'] = str_repeat('x', 501);
        $payload['password_confirmation'] = 'does-not-match';
        $payload['terms'] = 0;
        $this->post(route('development.register.store'), $payload)
            ->assertSessionHasErrors(['pwd_status', 'support_notes', 'password', 'terms']);
        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('development_children', 0);
    }

    public function test_pwd_status_is_required_but_disclosure_is_optional(): void
    {
        $payload = $this->payload();
        unset($payload['pwd_status']);
        $this->post(route('development.register.store'), $payload)->assertSessionHasErrors('pwd_status');
        $payload['pwd_status'] = 'prefer_not_to_say';
        $this->post(route('development.register.store'), $payload)->assertSessionHasNoErrors();
        $this->assertSame('prefer_not_to_say', DevelopmentChild::sole()->pwd_status);
        $this->assertNull(DevelopmentChild::sole()->pwd_details);
    }

    public function test_login_returns_to_the_selected_connection_flow(): void
    {
        $this->get(route('development.login', ['solution' => 'academic-learning']))->assertOk()
            ->assertSessionHas('url.intended', route('get-connected', ['solution' => 'academic-learning']));
    }

    public function test_registration_saves_quick_answers_encrypted_and_account_location(): void
    {
        $payload = $this->payload();
        $payload['connection_form'] = 1;
        $payload['quick_questions'] = $this->quickAnswers();
        $payload['location'] = 'Nairobi';
        $payload['country_code'] = '+254';
        $payload['phone'] = '0700000000';

        $response = $this->post(route('development.register.store'), $payload);
        $child = DevelopmentChild::sole();
        $assessment = $child->assessments()->sole();
        $response->assertSessionHasNoErrors()->assertRedirect(route('development.assessment', [$child, 1]));
        $this->assertSame($payload['quick_questions'], $assessment->answers['connection']);
        $this->assertSame(1, $assessment->step);
        $this->assertNull($assessment->consented_at);
        $this->assertSame('Nairobi', User::sole()->location);
        $this->assertSame('+254700000000', User::sole()->phone);
        $this->assertStringNotContainsString('Build confidence', DB::table('development_assessments')->value('answers'));

        $this->post(route('development.assessment.save', [$child, 1]), [
            'reasons' => ['Academic Performance'],
            'performance' => 'Average',
            'goals' => ['Build confidence and self-belief'],
        ])->assertSessionHasNoErrors()->assertRedirect(route('development.assessment', [$child, 2]));
        $this->assertSame($payload['quick_questions'], $assessment->fresh()->answers['connection']);
    }

    public function test_signed_in_parent_saves_quick_answers_for_their_new_child(): void
    {
        $parent = User::factory()->create();
        $payload = $this->payload();
        $payload['connection_form'] = 1;
        $payload['quick_questions'] = $this->quickAnswers();
        $this->actingAs($parent)->post(route('development.child.store'), $payload)->assertSessionHasNoErrors();

        $child = DevelopmentChild::sole();
        $this->assertSame($parent->id, $child->user_id);
        $this->assertSame($payload['quick_questions'], $child->assessments()->sole()->answers['connection']);
        $this->assertDatabaseCount('users', 1);
    }

    public function test_new_account_confirmation_offers_dashboard_and_assessment_once(): void
    {
        $response = $this->post(route('development.register.store'), $this->payload());
        $child = DevelopmentChild::sole();
        $response->assertSessionHasNoErrors()->assertSessionHas('account_created_child', $child->id);
        $url = route('development.assessment', [$child, 1]);

        $this->get($url)->assertOk()
            ->assertSee('Your Account is Ready!')
            ->assertSee('Academic, Learning &amp; Excellence', false)
            ->assertSee('Go to Dashboard')
            ->assertSee('href="'.route('dashboard').'"', false)
            ->assertSee('data-account-ready-continue', false);
        $this->get($url)->assertOk()->assertDontSee('id="account-ready"', false);
        $this->get(route('dashboard'))->assertOk();
    }

    /** @param array<string, mixed>|null $invalidAnswers */
    #[DataProvider('invalidQuickAnswers')]
    public function test_invalid_quick_answers_do_not_create_accounts(?array $invalidAnswers): void
    {
        $payload = $this->payload();
        $payload['connection_form'] = 1;
        if ($invalidAnswers !== null) {
            $payload['quick_questions'] = array_replace($this->quickAnswers(), $invalidAnswers);
        }
        $this->post(route('development.register.store'), $payload)->assertSessionHasErrors();
        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('development_children', 0);
        $this->assertDatabaseCount('development_assessments', 0);
    }

    /** @return array<string, array{array<string, mixed>|null}> */
    public static function invalidQuickAnswers(): array
    {
        return [
            'too few reasons' => [['reasons' => ['Build confidence and self-belief', 'Improve focus and study habits']]],
            'duplicate reasons' => [['reasons' => ['Build confidence and self-belief', 'Build confidence and self-belief', 'Improve focus and study habits']]],
            'unknown reason' => [['reasons' => ['Not a supported reason', 'Improve focus and study habits', 'Set goals and stay motivated']]],
            'unknown level' => [['current_level' => 'Unknown']],
            'unknown timeline' => [['timeline' => 'Unknown']],
            'unknown relationship' => [['relationship' => 'Unknown']],
            'missing answers' => [null],
            'missing level' => [['current_level' => null]],
        ];
    }

    /** @return array<string, mixed> */
    private function quickAnswers(): array
    {
        return [
            'reasons' => ['Build confidence and self-belief', 'Improve focus and study habits', 'Set goals and stay motivated'],
            'current_level' => 'Low',
            'timeline' => 'In 1–3 months',
            'relationship' => 'Guardian',
        ];
    }

    /** @return array<string, mixed> */
    private function payload(): array
    {
        return [
            'name' => 'Test Guardian', 'email' => 'guardian@example.test', 'phone' => '+254700000000',
            'password' => 'A-secure-test-password', 'password_confirmation' => 'A-secure-test-password', 'terms' => 1,
            'child_name' => 'Test Learner', 'age' => 10, 'grade' => 'Grade 5', 'school' => 'Example School',
            'solution' => 'academic-learning', 'pwd_status' => 'yes', 'pwd_details' => 'Hearing support',
            'support_notes' => 'Enjoys reading and music.',
        ];
    }
}
