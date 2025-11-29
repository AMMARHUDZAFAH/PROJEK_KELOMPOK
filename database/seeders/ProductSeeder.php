<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada kategori. Jalankan CategorySeeder terlebih dahulu.');
            return;
        }

        $products = [
            [
                'name' => 'Laptop Gaming ASUS ROG',
                'description' => 'Laptop gaming dengan spesifikasi tinggi, RTX 4070, Intel i9-13th gen',
                'price' => 25000000,
                'stock' => 5,
                'category_id' => $categories->where('name', 'Elektronik')->first()->id ?? $categories->first()->id,
                'image' => 'products/laptop.jpg',
            ],
            [
                'name' => 'Smartphone Samsung Galaxy S24',
                'description' => 'Flagship smartphone dengan kamera 200MP dan AI processing',
                'price' => 12000000,
                'stock' => 8,
                'category_id' => $categories->where('name', 'Elektronik')->first()->id ?? $categories->first()->id,
                'image' => 'products/phone.jpg',
            ],
            [
                'name' => 'Monitor UltraWide LG 34"',
                'description' => 'Monitor ultrawide 34 inch dengan refresh rate 144Hz',
                'price' => 5500000,
                'stock' => 3,
                'category_id' => $categories->where('name', 'Elektronik')->first()->id ?? $categories->first()->id,
                'image' => 'products/monitor.jpg',
            ],
            [
                'name' => 'Keyboard Mekanik RGB',
                'description' => 'Keyboard gaming mekanik dengan switch custom, RGB backlit',
                'price' => 1200000,
                'stock' => 15,
                'category_id' => $categories->where('name', 'Aksesoris')->first()->id ?? $categories->first()->id,
                'image' => 'products/keyboard.jpg',
            ],
            [
                'name' => 'Mouse Gaming Corsair',
                'description' => 'Mouse gaming dengan DPI tinggi dan sensor presisi',
                'price' => 850000,
                'stock' => 12,
                'category_id' => $categories->where('name', 'Aksesoris')->first()->id ?? $categories->first()->id,
                'image' => 'products/mouse.jpg',
            ],
            [
                'name' => 'Headphone Wireless Sony WH-1000XM5',
                'description' => 'Headphone wireless dengan noise cancellation terbaik',
                'price' => 4200000,
                'stock' => 7,
                'category_id' => $categories->where('name', 'Aksesoris')->first()->id ?? $categories->first()->id,
                'image' => 'products/headphones.jpg',
            ],
            [
                'name' => 'Power Bank 65W Anker',
                'description' => 'Power bank 65W dengan fast charging dan kapasitas 30000mAh',
                'price' => 750000,
                'stock' => 20,
                'category_id' => $categories->where('name', 'Perlengkapan')->first()->id ?? $categories->first()->id,
                'image' => 'products/powerbank.jpg',
            ],
            [
                'name' => 'USB-C Hub 7 in 1',
                'description' => 'Hub USB-C dengan 7 port untuk konektivitas maksimal',
                'price' => 450000,
                'stock' => 25,
                'category_id' => $categories->where('name', 'Perlengkapan')->first()->id ?? $categories->first()->id,
                'image' => 'products/hub.jpg',
            ],
            [
                'name' => 'Webcam Logitech 4K',
                'description' => 'Webcam 4K dengan auto-focus dan micophone noise cancellation',
                'price' => 1800000,
                'stock' => 6,
                'category_id' => $categories->where('name', 'Perlengkapan')->first()->id ?? $categories->first()->id,
                'image' => 'products/webcam.jpg',
            ],
            [
                'name' => 'Tripod Profesional Manfrotto',
                'description' => 'Tripod profesional untuk fotografi dan videografi',
                'price' => 2500000,
                'stock' => 4,
                'category_id' => $categories->where('name', 'Perlengkapan')->first()->id ?? $categories->first()->id,
                'image' => 'products/tripod.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']],
                $product
            );
            $this->command->info("✅ Created/Updated: {$product['name']}");
        }

        $this->command->info("✨ ProductSeeder completed!");
    }
}
