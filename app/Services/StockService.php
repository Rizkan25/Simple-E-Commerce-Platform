<?php

namespace App\Services;

use App\Models\Product;
use Exception;
use Illuminate\Support\Collection;

class StockService
{
    /**
     * Validate that stock is sufficient for all cart items.
     * Expects a collection of items with product_id and quantity.
     *
     * @param Collection $cartItems Collection of cart items with loaded product relation
     * @throws Exception if stock is insufficient
     */
    public function validateStock(Collection $cartItems): bool
    {
        foreach ($cartItems as $item) {
            $product = $item->product;
            if ($product->stock < $item->quantity) {
                throw new Exception(
                    "Stok produk \"{$product->name}\" tidak mencukupi. " .
                    "Stok tersedia: {$product->stock}, diminta: {$item->quantity}."
                );
            }
        }

        return true;
    }

    /**
     * Deduct stock for all items. Must be called within a DB transaction.
     *
     * @param Collection $items Collection with product_id and quantity
     */
    public function deductStock(Collection $items): void
    {
        foreach ($items as $item) {
            $product = Product::find($item->product_id);
            $product->decrement('stock', $item->quantity);
        }
    }
}
