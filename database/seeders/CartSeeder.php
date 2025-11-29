<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cart;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        // Create carts for all users who don't have one
        User::where('role', 'user')->doesntHave('cart')->each(function ($user) {
            Cart::create(['user_id' => $user->id]);
        });

        if ($this->command) {
            $this->command->info('✅ Carts created for all users!');
        }
    }
}
