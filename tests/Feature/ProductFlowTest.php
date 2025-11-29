<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_product_and_public_can_see_it()
    {
        // create admin user directly to avoid factory fields mismatch with migrations
        $admin = \App\Models\User::create([
            'name' => 'Admin Test',
            'email' => 'admintest@example.com',
            'password' => bcrypt('secret'),
            'role' => 'admin',
        ]);

        // create a category
        $category = \App\Models\Category::create(['name' => 'Default']);

        // act as admin and post a product
        $this->actingAs($admin)
            ->post(route('admin.products.store'), [
                'name' => 'Test Product X',
                'description' => 'Desc',
                'price' => 99.99,
                'stock' => 10,
                'category_id' => $category->id,
            ])
            ->assertRedirect(route('admin.products.index'));

        // public index should show the product
        $this->get(route('products.index'))
            ->assertStatus(200)
            ->assertSee('Test Product X');
    }
}
