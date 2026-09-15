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
        $password = config('admin_seed.password');

        if (! is_string($password) || $password === '') {
            throw new \RuntimeException('ADMIN_PASSWORD is required to seed the administrator account. Set it in .env before running db:seed.');
        }

        if (strlen($password) < 10) {
            throw new \RuntimeException('ADMIN_PASSWORD must contain at least 10 characters.');
        }

        $admin = User::updateOrCreate(
            ['email' => config('admin_seed.email')],
            [
                'name' => config('admin_seed.name'),
                'account_type' => 'Admin',
                'email_verified_at' => now(),
                'password' => Hash::make($password),
            ],
        );

        $admin->forceFill(['is_admin' => true])->save();
    }
}
