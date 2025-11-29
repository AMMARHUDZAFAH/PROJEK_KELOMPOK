<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed categories first
        $this->call(CategorySeeder::class);

        // Seed admin user
        $this->call(AdminUserSeeder::class);

        // Seed products before orders so OrderSeeder can attach items
        $this->call(ProductSeeder::class);

        // Create carts for users
        $this->call(CartSeeder::class);

        // Seed sample orders (now products exist)
        $this->call(OrderSeeder::class);
    }
}
