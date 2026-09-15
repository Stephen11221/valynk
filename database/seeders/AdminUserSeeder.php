<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the default administrator account.
     */
    public function run(): void
    {
        $password = env('ADMIN_PASSWORD');

        if (! $password) {
            return;
        }

        if (strlen($password) < 10) {
            throw new \RuntimeException('ADMIN_PASSWORD must contain at least 10 characters.');
        }

        $admin = User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@valynk.co.ke')],
            [
                'name' => env('ADMIN_NAME', 'Admin User'),
                'email_verified_at' => now(),
                'password' => Hash::make($password),
            ],
        );

        $admin->forceFill(['is_admin' => true])->save();
    }
}
