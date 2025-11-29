<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->info('⚠️ Perlu ada users dan products terlebih dahulu.');
            return;
        }

        $statuses = ['pending', 'paid', 'processing', 'shipped', 'completed'];

        // Create 15 sample orders
        foreach ($users->take(3) as $user) {
            for ($i = 0; $i < 5; $i++) {
                $randomProducts = $products->random(rand(2, 4));
                $total = 0;

                $order = Order::create([
                    'user_id'    => $user->id,
                    'total_price' => 0, // Will update after items
                    'status'     => $statuses[array_rand($statuses)],
                    'address'    => fake()->address(),
                    'phone'      => fake()->phoneNumber(),
                ]);

                foreach ($randomProducts as $product) {
                    $quantity = rand(1, 3);
                    $price = $product->price;
                    $total += $price * $quantity;

                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $product->id,
                        'quantity'   => $quantity,
                        'price'      => $price,
                    ]);
                }

                // Update order total
                $order->update(['total_price' => $total]);

                $this->command->info("✅ Created order #{$order->id} for {$user->name} - Status: {$order->status}");
            }
        }

        $this->command->info("✨ OrderSeeder completed!");
    }
}
