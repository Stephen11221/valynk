<?php

namespace Tests\Feature;

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
