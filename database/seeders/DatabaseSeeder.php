<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Check if the admin already exists to prevent duplicate entry errors
        if (!User::where('email', 'admin@test.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@test.com',
                'password' => Hash::make('password'), // <-- Replace 'password' with your secure password if you want
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
        }
    }
}