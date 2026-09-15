<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSignupTest extends TestCase
{
    use RefreshDatabase;

    private function adminSignupFields(): array
    {
        return [
            'name' => 'New Administrator',
            'email' => 'new-admin@example.test',
            'phone' => '712345678',
            'account_type' => 'Admin',
            'password' => 'strong-new-password',
            'password_confirmation' => 'strong-new-password',
            'terms' => '1',
        ];
    }

    public function test_admin_option_is_visible_but_requires_an_existing_admin_session(): void
    {
        $this->get(route('register'))->assertSee('data-account-type="Admin"', false);

        $this->post(route('register.store'), $this->adminSignupFields())
            ->assertSessionHasErrors('account_type');
        $this->assertDatabaseMissing('users', ['email' => 'new-admin@example.test']);

        $regularUser = User::factory()->create();
        $this->actingAs($regularUser)
            ->post(route('register.store'), $this->adminSignupFields())
            ->assertSessionHasErrors('account_type');
        $this->assertDatabaseMissing('users', ['email' => 'new-admin@example.test']);
    }

    public function test_existing_admin_can_register_another_admin_who_can_log_in(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $this->actingAs($admin)
            ->post(route('register.store'), $this->adminSignupFields())
            ->assertRedirect(route('admin.users'));

        $created = User::where('email', 'new-admin@example.test')->firstOrFail();
        $this->assertSame('Admin', $created->account_type);
        $this->assertTrue($created->is_admin);

        $this->post(route('logout'))->assertRedirect(route('login'));
        $this->post(route('login.authenticate'), [
            'email' => 'new-admin@example.test',
            'password' => 'strong-new-password',
        ])->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($created);
    }
}
