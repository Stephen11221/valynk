<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * The public login page renders its primary account controls.
     */
    public function test_the_login_page_loads(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('Welcome Back!');
        $response->assertSee('Email Login');
        $response->assertSee('Secure & Protected');
        $response->assertSee(route('register'));
    }

    /**
     * Invalid login submissions return to the login form with an error.
     */
    public function test_invalid_login_submission_is_handled(): void
    {
        $response = $this->post(route('login'), [
            'email' => 'unknown@example.com',
            'password' => 'incorrect-password',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
    }

    /**
     * The public registration page renders account type and detail controls.
     */
    public function test_the_registration_page_loads(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertSee('Create Your VALYNK Account');
        $response->assertSee('Individual / Family');
        $response->assertSee('Provider');
        $response->assertSee('Institution');
        $response->assertSee('Partner / Other');
        $response->assertSee('Create Account');
    }

    /**
     * A valid registration creates an account and returns to login.
     */
    public function test_registration_submission_creates_account(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '712345678',
            'account_type' => 'Individual / Family',
            'password' => 'secure-password',
            'password_confirmation' => 'secure-password',
            'location' => 'Nairobi',
            'terms' => '1',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'email' => 'jane@example.com',
            'account_type' => 'Individual / Family',
        ]);
        $this->assertInstanceOf(User::class, User::where('email', 'jane@example.com')->first());
    }
}
