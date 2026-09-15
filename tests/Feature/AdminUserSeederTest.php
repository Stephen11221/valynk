<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeding_promotes_an_existing_account_and_allows_admin_login(): void
    {
        config()->set('admin_seed', [
            'name' => 'Admin User',
            'email' => 'seeded-admin@example.test',
            'password' => 'secure-admin-password',
        ]);

        User::factory()->create([
            'email' => 'seeded-admin@example.test',
            'password' => 'old-password',
        ]);

        $this->seed(AdminUserSeeder::class);

        $admin = User::where('email', 'seeded-admin@example.test')->firstOrFail();
        $this->assertSame(1, User::where('email', 'seeded-admin@example.test')->count());
        $this->assertTrue($admin->is_admin);
        $this->assertSame('Admin', $admin->account_type);
        $this->assertTrue(Hash::check('secure-admin-password', $admin->password));

        $this->post(route('login.authenticate'), [
            'email' => $admin->email,
            'password' => 'secure-admin-password',
        ])->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_seeding_fails_clearly_without_a_configured_password(): void
    {
        config()->set('admin_seed.password', null);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('ADMIN_PASSWORD is required');

        $this->seed(AdminUserSeeder::class);
    }
}
