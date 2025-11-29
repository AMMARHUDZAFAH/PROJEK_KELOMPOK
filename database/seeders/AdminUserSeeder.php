<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => bcrypt('password'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'user@example.com'],
            ['name' => 'User', 'password' => bcrypt('password'), 'role' => 'user']
        );

        // Create additional test users
        for ($i = 1; $i <= 3; $i++) {
            User::updateOrCreate(
                ['email' => "user$i@example.com"],
                ['name' => "User $i", 'password' => bcrypt('password'), 'role' => 'user']
            );
        }

        if ($this->command) {
            $this->command->info("Created admin@example.com / password and user@example.com / password and more test users");
        }
    }
}
