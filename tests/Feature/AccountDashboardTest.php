<?php

namespace Tests\Feature;

use App\Models\DevelopmentChild;
use App\Models\DevelopmentConnection;
use App\Models\SitePage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AccountDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_every_account_type_has_a_dashboard_with_its_own_details(): void
    {
        $dashboards = [
            'Individual' => ['account.individual-dashboard', 'Your Individual Dashboard', 'solutions'],
            'Family' => ['account.family-dashboard', 'Your Family Dashboard', 'families'],
            'Provider' => ['account.provider-dashboard', 'Your Provider Dashboard', 'providers'],
            'Institution' => ['account.institution-dashboard', 'Your Institution Dashboard', 'institutions'],
            'Partner / Other' => ['account.dashboard', 'Your Partner Dashboard', 'about'],
        ];

        foreach ($dashboards as $type => [$view, $heading, $actionRoute]) {
            $user = User::factory()->create([
                'name' => "{$type} Member",
                'account_type' => $type,
                'phone' => '0712345678',
                'location' => 'Nairobi',
            ]);
            $response = $this->actingAs($user)->get(route('dashboard'))
                ->assertOk()
                ->assertViewIs($view)
                ->assertSee($heading)
                ->assertSee($user->name)
                ->assertSee($user->email)
                ->assertSee('0712345678')
                ->assertSee('Nairobi')
                ->assertSee(route($actionRoute));
            if ($type !== 'Provider') {
                $response->assertDontSee('Approval status');
            }
        }
    }

    public function test_family_dashboard_shows_saved_progress_and_only_owned_records(): void
    {
        $parent = User::factory()->create(['account_type' => 'Family']);
        $otherParent = User::factory()->create(['account_type' => 'Family']);
        $provider = User::factory()->create(['name' => 'Trusted Provider', 'account_type' => 'Provider']);
        $profile = $provider->providerProfile()->create(['service' => 'Learning support', 'category' => 'Education']);
        $child = DevelopmentChild::create(['user_id' => $parent->id, 'name' => 'Own Learner', 'age' => 10, 'grade' => 'Grade 5', 'solution' => 'academic-learning', 'support_notes' => 'Enjoys learning science.']);
        $otherChild = DevelopmentChild::create(['user_id' => $otherParent->id, 'name' => 'Private Learner', 'age' => 12, 'grade' => 'Grade 7', 'support_notes' => 'Private family note.']);
        $assessment = $child->assessments()->create(['answers' => [], 'step' => 3]);
        DevelopmentConnection::create(['user_id' => $parent->id, 'provider_profile_id' => $profile->id, 'development_child_id' => $child->id, 'status' => 'Requested']);
        DevelopmentConnection::create(['user_id' => $parent->id, 'provider_profile_id' => $profile->id, 'development_child_id' => $otherChild->id, 'status' => 'Private request']);

        $this->actingAs($parent)->get(route('dashboard'))->assertOk()
            ->assertViewIs('account.family-dashboard')
            ->assertSee('Own Learner')->assertSee('Enjoys learning science.')
            ->assertSee('Academic, Learning &amp; Excellence', false)
            ->assertSee('Trusted Provider')->assertSee('Requested')
            ->assertSee('50%')->assertSee(route('development.journey', $child))
            ->assertDontSee('Private Learner')->assertDontSee('Private family note.')->assertDontSee('Private request')
            ->assertDontSee(route('development.report', $assessment));

        $assessment->update(['step' => 5, 'consented_at' => now()]);
        $this->get(route('dashboard'))->assertOk()->assertSee('100%')
            ->assertSee(route('development.report', $assessment));
        foreach (['assessments', 'progress', 'messages'] as $section) {
            $this->get(route('account.section', $section))->assertOk()
                ->assertDontSee('Private Learner')->assertDontSee('Private family note.')->assertDontSee('Private request');
        }
    }

    public function test_new_family_dashboard_has_actions_without_fake_bookings_or_payments(): void
    {
        $parent = User::factory()->create(['account_type' => 'Family']);
        $this->actingAs($parent)->get(route('dashboard'))->assertOk()
            ->assertSee('Add Your Child')->assertSee(route('development.child'))
            ->assertSee('0%')->assertSee('No payments recorded')
            ->assertSee('No scheduled programme sessions yet.')
            ->assertSee(route('development.providers'))->assertSee(route('account.family.documents'));
    }

    public function test_family_dashboard_sections_and_linked_pages_share_navigation(): void
    {
        $parent = User::factory()->create(['account_type' => 'Family']);
        $this->actingAs($parent);
        foreach (['assessments', 'payments', 'progress', 'messages', 'programmes', 'settings', 'help'] as $page) {
            $response = $this->get(route('account.section', $page))->assertOk()->assertViewIs('account.sections');
            $response->assertSee('id="family-sidebar"', false)->assertSee(route('dashboard'))->assertSee($parent->name);
            $this->assertSame(1, substr_count($response->getContent(), 'id="family-sidebar"'));
        }
        foreach (['development.home', 'development.child', 'development.providers', 'development.bookings', 'account.profile.edit', 'account.family.documents'] as $route) {
            $this->get(route($route))->assertOk()->assertSee('id="family-sidebar"', false)
                ->assertSee('family-dashboard.css')->assertSee(route('account.section', 'settings'));
        }
        $this->get('/dashboard/unknown')->assertNotFound();
    }

    public function test_dashboard_sections_require_login_and_keep_admin_and_other_roles_separate(): void
    {
        $this->get(route('account.section', 'payments'))->assertRedirect(route('login'));
        $individual = User::factory()->create(['account_type' => 'Individual']);
        $this->actingAs($individual)->get(route('account.section', 'payments'))->assertForbidden();
        $admin = User::factory()->create(['account_type' => 'Family']);
        $admin->forceFill(['is_admin' => true])->save();
        $this->actingAs($admin)->get(route('account.section', 'payments'))->assertRedirect(route('admin.dashboard'));
    }

    public function test_programmes_page_omits_unpublished_solutions_and_unpublished_catalogue(): void
    {
        $parent = User::factory()->create(['account_type' => 'Family']);
        $draft = config('solutions.academic-learning');
        $draft['is_published'] = false;
        $page = SitePage::create(['slug' => 'solutions', 'title' => 'Solutions', 'is_published' => true, 'content' => ['solutions' => ['academic-learning' => $draft]]]);
        $this->actingAs($parent)->get(route('account.section', 'programmes'))->assertOk()
            ->assertDontSee('Academic, Learning &amp; Excellence', false)->assertSee('Performance, Confidence &amp; Personal Development', false);
        $page->update(['is_published' => false]);
        $this->get(route('account.section', 'programmes'))->assertOk()->assertSee('No published solutions are available yet.');
    }

    public function test_login_sends_regular_accounts_to_dashboard_and_admin_to_admin(): void
    {
        $user = User::factory()->create(['account_type' => 'Family', 'password' => 'secure-password']);
        $this->post(route('login.authenticate'), [
            'email' => $user->email, 'password' => 'secure-password',
        ])->assertRedirect(route('dashboard'));

        $admin = User::factory()->create(['password' => 'secure-password']);
        $admin->forceFill(['is_admin' => true])->save();
        $this->actingAs($admin)->get(route('dashboard'))->assertRedirect(route('admin.dashboard'));
    }

    public function test_regular_account_does_not_return_to_admin_url_after_login(): void
    {
        $user = User::factory()->create(['account_type' => 'Individual', 'password' => 'secure-password']);

        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
        $this->post(route('login.authenticate'), [
            'email' => $user->email, 'password' => 'secure-password',
        ])->assertRedirect(route('dashboard'));
    }

    public function test_dashboard_and_profile_require_login(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));
        $this->get(route('account.profile.edit'))->assertRedirect(route('login'));
        $this->put(route('account.profile.update'), [])->assertRedirect(route('login'));
    }

    public function test_user_can_update_own_contact_details_without_changing_type_or_admin_access(): void
    {
        $user = User::factory()->create(['account_type' => 'Individual', 'phone' => null, 'location' => null]);

        $this->actingAs($user)->put(route('account.profile.update'), [
            'name' => 'Updated Member',
            'email' => $user->email,
            'phone' => '0799999999',
            'location' => 'Mombasa',
            'account_type' => 'Provider',
            'is_admin' => '1',
        ])->assertRedirect(route('dashboard'));

        $user->refresh();
        $this->assertSame('Updated Member', $user->name);
        $this->assertSame('0799999999', $user->phone);
        $this->assertSame('Mombasa', $user->location);
        $this->assertSame('Individual', $user->account_type);
        $this->assertFalse($user->is_admin);
    }

    public function test_email_or_password_change_requires_current_password(): void
    {
        $user = User::factory()->create([
            'account_type' => 'Family', 'password' => 'correct-old-password',
            'email_verified_at' => now(),
        ]);
        $payload = [
            'name' => $user->name,
            'email' => 'changed@example.com',
            'password' => 'new-secure-password',
            'password_confirmation' => 'new-secure-password',
        ];

        $this->actingAs($user)->put(route('account.profile.update'), $payload)
            ->assertSessionHasErrors('current_password');
        $this->put(route('account.profile.update'), $payload + ['current_password' => 'wrong'])
            ->assertSessionHasErrors('current_password');
        $this->assertSame($user->email, $user->fresh()->email);

        $this->put(route('account.profile.update'), $payload + ['current_password' => 'correct-old-password'])
            ->assertRedirect(route('dashboard'));
        $this->assertSame('changed@example.com', $user->fresh()->email);
        $this->assertNull($user->fresh()->email_verified_at);
        $this->assertTrue(Hash::check('new-secure-password', $user->fresh()->password));
    }

    public function test_provider_can_edit_service_without_self_approving(): void
    {
        $provider = User::factory()->create(['account_type' => 'Provider']);
        $payload = [
            'name' => $provider->name,
            'email' => $provider->email,
            'service' => 'Math Tutoring',
            'category' => 'Academic Support',
            'status' => 'Approved',
            'verification' => 'Verified',
        ];

        $this->actingAs($provider)->get(route('dashboard'))
            ->assertOk()->assertViewIs('account.provider-dashboard')->assertSee('Pending')->assertSee('Not Verified');
        $this->put(route('account.profile.update'), $payload)->assertRedirect(route('dashboard'));
        $profile = $provider->fresh()->providerProfile;
        $this->assertSame('Math Tutoring', $profile->service);
        $this->assertSame('Pending', $profile->status);
        $this->assertSame('Not Verified', $profile->verification);
        $this->get(route('dashboard'))->assertSee('Math Tutoring')->assertSee('Academic Support');

        $profile->update(['status' => 'Approved', 'verification' => 'Verified']);
        $this->put(route('account.profile.update'), array_replace($payload, ['service' => 'Science Tutoring']))
            ->assertRedirect(route('dashboard'));
        $this->assertSame('Science Tutoring', $profile->fresh()->service);
        $this->assertSame('Approved', $profile->fresh()->status);
        $this->assertSame('Verified', $profile->fresh()->verification);
    }
}
