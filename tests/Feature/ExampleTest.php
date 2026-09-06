<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
