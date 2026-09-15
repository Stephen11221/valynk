<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class LoginSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_and_regular_user_cannot_open_admin_pages(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));

        $user = User::factory()->create(['password' => 'correct-password']);
        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
        $this->get(route('admin.content'))->assertForbidden();
        $this->get(route('admin.users.create'))->assertForbidden();
        $this->post(route('admin.users.store'), [
            'name' => 'Unauthorized', 'email' => 'unauthorized@example.com',
            'account_type' => 'Individual', 'password' => 'a-secure-password',
            'password_confirmation' => 'a-secure-password',
        ])->assertForbidden();
        $this->assertDatabaseMissing('users', ['email' => 'unauthorized@example.com']);
    }

    public function test_login_checks_password_and_redirects_admin(): void
    {
        $admin = User::factory()->create(['password' => 'correct-password']);
        $admin->forceFill(['is_admin' => true])->save();

        $this->post(route('login.authenticate'), [
            'email' => $admin->email,
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');
        $this->assertGuest();

        $this->post(route('login.authenticate'), [
            'email' => $admin->email,
            'password' => 'correct-password',
        ])->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_logout_invalidates_the_session(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->post(route('logout'))->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_login_is_rate_limited(): void
    {
        $user = User::factory()->create();
        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post(route('login.authenticate'), ['email' => $user->email, 'password' => 'wrong']);
        }
        $this->post(route('login.authenticate'), ['email' => $user->email, 'password' => 'wrong'])
            ->assertStatus(429);
    }

    public function test_password_reset_changes_the_credentials(): void
    {
        $user = User::factory()->create(['password' => 'old-password']);
        $token = Password::createToken($user);

        $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'a-new-secure-password',
            'password_confirmation' => 'a-new-secure-password',
        ])->assertRedirect(route('login'));

        $this->assertTrue(Hash::check('a-new-secure-password', $user->fresh()->password));
        $this->assertFalse(Hash::check('old-password', $user->fresh()->password));
    }
}
