<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminEmail = env('SEED_ADMIN_EMAIL', 'admin@example.com');
        $adminPassword = env('SEED_ADMIN_PASSWORD', 'password');

        $user = User::firstOrCreate([
            'email' => $adminEmail,
        ], [
            'name' => 'Admin',
            'password' => Hash::make($adminPassword),
        ]);

        if (method_exists($user, 'assignRole')) {
            $user->assignRole('admin');
        }
    }
}
