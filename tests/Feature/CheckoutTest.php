<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected User $buyer;
    protected User $seller;
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

    private function createCartWithProduct(int $productStock, int $cartQuantity): Product
    {
        $product = Product::create([
            'name' => 'Test Product',
            'seller_id' => $this->seller->id,
            'category_id' => $this->category->id,
            'price' => 100000,
            'stock' => $productStock,
        ]);

        $cart = Cart::create([
            'user_id' => $this->buyer->id,
            'seller_id' => $this->seller->id,
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $cartQuantity,
            'price_snapshot' => $product->price,
        ]);

        return $product;
    }

    public function test_checkout_succeeds_with_sufficient_stock(): void
    {
        $product = $this->createCartWithProduct(productStock: 10, cartQuantity: 2);

        $response = $this->actingAs($this->buyer)
            ->post(route('checkout.store'), [
                'shipping_address' => 'Jl. Test No. 123',
                'payment_method' => 'dummy_bank',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Order was created
        $this->assertDatabaseHas('orders', [
            'user_id' => $this->buyer->id,
            'total_amount' => 200000, // 100000 * 2
            'status' => 'pending',
            'payment_method' => 'dummy_bank',
        ]);

        // Stock was deducted
        $product->refresh();
        $this->assertEquals(8, $product->stock); // 10 - 2

        // Cart was cleared
        $this->assertDatabaseMissing('carts', ['user_id' => $this->buyer->id]);
    }

    public function test_checkout_fails_with_insufficient_stock(): void
    {
        $product = $this->createCartWithProduct(productStock: 1, cartQuantity: 5);

        $response = $this->actingAs($this->buyer)
            ->post(route('checkout.store'), [
                'shipping_address' => 'Jl. Test No. 123',
                'payment_method' => 'dummy_bank',
            ]);

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error');

        // Order was NOT created (transaction rollback)
        $this->assertDatabaseMissing('orders', [
            'user_id' => $this->buyer->id,
        ]);

        // Stock was NOT deducted (transaction rollback)
        $product->refresh();
        $this->assertEquals(1, $product->stock);
    }

    public function test_checkout_requires_shipping_address(): void
    {
        $this->createCartWithProduct(productStock: 10, cartQuantity: 1);

        $response = $this->actingAs($this->buyer)
            ->post(route('checkout.store'), [
                'payment_method' => 'dummy_bank',
                // missing shipping_address
            ]);

        $response->assertSessionHasErrors('shipping_address');
    }

    public function test_checkout_requires_valid_payment_method(): void
    {
        $this->createCartWithProduct(productStock: 10, cartQuantity: 1);

        $response = $this->actingAs($this->buyer)
            ->post(route('checkout.store'), [
                'shipping_address' => 'Jl. Test No. 123',
                'payment_method' => 'bitcoin', // invalid
            ]);

        $response->assertSessionHasErrors('payment_method');
    }

    public function test_seller_cannot_access_checkout(): void
    {
        $response = $this->actingAs($this->seller)
            ->get(route('checkout.index'));

        $response->assertStatus(403);
    }

    public function test_checkout_with_empty_cart_redirects(): void
    {
        $response = $this->actingAs($this->buyer)
            ->get(route('checkout.index'));

        $response->assertRedirect(route('cart.index'));
    }
}
