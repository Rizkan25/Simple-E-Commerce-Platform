<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $seller;
    protected User $buyer;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seller = User::factory()->seller()->create();
        $this->buyer = User::factory()->buyer()->create();
        $this->category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
        ]);
    }

    public function test_seller_can_access_product_create_page(): void
    {
        $response = $this->actingAs($this->seller)
            ->get(route('seller.products.create'));

        $response->assertStatus(200);
    }

    public function test_buyer_cannot_access_product_create_page(): void
    {
        $response = $this->actingAs($this->buyer)
            ->get(route('seller.products.create'));

        $response->assertStatus(403);
    }

    public function test_seller_can_create_product(): void
    {
        $response = $this->actingAs($this->seller)
            ->post(route('seller.products.store'), [
                'name' => 'Test Product',
                'category_id' => $this->category->id,
                'description' => 'A test product description',
                'price' => 100000,
                'stock' => 10,
            ]);

        $response->assertRedirect(route('seller.products.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'seller_id' => $this->seller->id,
            'category_id' => $this->category->id,
            'price' => 100000,
            'stock' => 10,
        ]);
    }

    public function test_buyer_cannot_create_product(): void
    {
        $response = $this->actingAs($this->buyer)
            ->post(route('seller.products.store'), [
                'name' => 'Test Product',
                'category_id' => $this->category->id,
                'price' => 100000,
                'stock' => 10,
            ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('products', ['name' => 'Test Product']);
    }

    public function test_seller_can_update_own_product(): void
    {
        $product = Product::create([
            'name' => 'Original Product',
            'seller_id' => $this->seller->id,
            'category_id' => $this->category->id,
            'price' => 50000,
            'stock' => 5,
        ]);

        $response = $this->actingAs($this->seller)
            ->put(route('seller.products.update', $product), [
                'name' => 'Updated Product',
                'category_id' => $this->category->id,
                'description' => 'Updated description',
                'price' => 75000,
                'stock' => 8,
            ]);

        $response->assertRedirect(route('seller.products.index'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'price' => 75000,
            'stock' => 8,
        ]);
    }

    public function test_seller_cannot_update_other_sellers_product(): void
    {
        $otherSeller = User::factory()->seller()->create();
        $product = Product::create([
            'name' => 'Other Seller Product',
            'seller_id' => $otherSeller->id,
            'category_id' => $this->category->id,
            'price' => 50000,
            'stock' => 5,
        ]);

        $response = $this->actingAs($this->seller)
            ->put(route('seller.products.update', $product), [
                'name' => 'Hacked Product',
                'category_id' => $this->category->id,
                'price' => 1,
                'stock' => 999,
            ]);

        $response->assertStatus(403);
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Other Seller Product']);
    }

    public function test_seller_can_delete_own_product(): void
    {
        $product = Product::create([
            'name' => 'Product To Delete',
            'seller_id' => $this->seller->id,
            'category_id' => $this->category->id,
            'price' => 50000,
            'stock' => 5,
        ]);

        $response = $this->actingAs($this->seller)
            ->delete(route('seller.products.destroy', $product));

        $response->assertRedirect(route('seller.products.index'));
        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }
}
