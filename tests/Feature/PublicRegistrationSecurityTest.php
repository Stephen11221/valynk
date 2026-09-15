<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicRegistrationSecurityTest extends TestCase
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

    public function test_public_registration_never_accepts_an_admin_type(): void
    {
        $this->get(route('register'))->assertDontSee('data-account-type="Admin"', false);

        $this->post(route('register.store'), $this->adminSignupFields())
            ->assertSessionHasErrors('account_type');
        $this->assertDatabaseMissing('users', ['email' => 'new-admin@example.test']);

        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $this->actingAs($admin)
            ->post(route('register.store'), $this->adminSignupFields())
            ->assertSessionHasErrors('account_type');
        $this->assertDatabaseMissing('users', ['email' => 'new-admin@example.test']);
    }
}
