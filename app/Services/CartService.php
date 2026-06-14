<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Exception;

class CartService
{
    /**
     * Add an item to the cart.
     * Enforces single-seller constraint per cart.
     */
    public function addItem(int $userId, int $productId, int $quantity = 1): CartItem
    {
        $product = Product::findOrFail($productId);

        if ($product->stock < $quantity) {
            throw new Exception('Stok produk tidak mencukupi.');
        }

        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        // Check seller consistency
        $existingItem = $cart->items()->with('product')->first();
        if ($existingItem && $existingItem->product->seller_id !== $product->seller_id) {
            throw new Exception('Keranjang hanya boleh berisi produk dari satu penjual. Kosongkan keranjang terlebih dahulu untuk menambahkan produk dari penjual lain.');
        }

        // Add or update cart item
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            if ($newQuantity > $product->stock) {
                throw new Exception('Stok produk tidak mencukupi untuk jumlah yang diminta.');
            }
            $cartItem->update([
                'quantity' => $newQuantity,
                'price_snapshot' => $product->price,
            ]);
        } else {
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price_snapshot' => $product->price,
            ]);
        }

        return $cartItem;
    }

    /**
     * Update the quantity of a cart item.
     */
    public function updateQuantity(int $userId, int $cartItemId, int $quantity): CartItem
    {
        $cart = Cart::where('user_id', $userId)->firstOrFail();
        $cartItem = CartItem::where('id', $cartItemId)
            ->where('cart_id', $cart->id)
            ->with('product')
            ->firstOrFail();

        if ($quantity < 1) {
            throw new Exception('Jumlah minimum adalah 1.');
        }

        if ($quantity > $cartItem->product->stock) {
            throw new Exception('Stok produk tidak mencukupi. Stok tersedia: ' . $cartItem->product->stock);
        }

        $cartItem->update(['quantity' => $quantity]);

        return $cartItem;
    }

    /**
     * Remove an item from the cart.
     */
    public function removeItem(int $userId, int $cartItemId): void
    {
        $cart = Cart::where('user_id', $userId)->firstOrFail();
        CartItem::where('id', $cartItemId)
            ->where('cart_id', $cart->id)
            ->delete();

        // If cart is empty, delete the cart too
        if ($cart->items()->count() === 0) {
            $cart->delete();
        }
    }

    /**
     * Get the user's cart with items and product relations.
     */
    public function getCart(int $userId): ?Cart
    {
        return Cart::where('user_id', $userId)
            ->with(['items.product.category', 'items.product.seller'])
            ->first();
    }

    /**
     * Clear all items from the user's cart.
     */
    public function clearCart(int $userId): void
    {
        $cart = Cart::where('user_id', $userId)->first();
        if ($cart) {
            $cart->items()->delete();
            $cart->delete();
        }
    }
}
