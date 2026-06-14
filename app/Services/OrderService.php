<?php

namespace App\Services;

use App\Jobs\SendOrderConfirmation;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function __construct(
        protected StockService $stockService
    ) {}

    /**
     * Create an order from the user's cart using database transaction and pessimistic locking.
     */
    public function createOrderFromCart(int $userId, string $shippingAddress, string $paymentMethod): Order
    {
        return DB::transaction(function () use ($userId, $shippingAddress, $paymentMethod) {
            $cart = Cart::where('user_id', $userId)
                ->with('items.product')
                ->firstOrFail();

            if ($cart->items->isEmpty()) {
                throw new Exception('Keranjang belanja kosong.');
            }

            // Get product IDs and lock them for update (pessimistic locking)
            $productIds = $cart->items->pluck('product_id')->toArray();
            $products = Product::whereIn('id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // Validate stock with live product data
            $totalAmount = 0;
            foreach ($cart->items as $item) {
                $product = $products[$item->product_id];
                if ($product->stock < $item->quantity) {
                    throw new Exception(
                        "Stok produk \"{$product->name}\" tidak mencukupi. " .
                        "Stok tersedia: {$product->stock}, diminta: {$item->quantity}."
                    );
                }
                $totalAmount += $product->price * $item->quantity;
            }

            // Create order
            $order = Order::create([
                'user_id' => $userId,
                'order_number' => 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'shipping_address' => $shippingAddress,
                'payment_method' => $paymentMethod,
            ]);

            // Create order items with live prices and deduct stock
            foreach ($cart->items as $item) {
                $product = $products[$item->product_id];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'seller_id' => $product->seller_id,
                    'quantity' => $item->quantity,
                    'price_at_order' => $product->price,
                ]);

                // Deduct stock
                $product->decrement('stock', $item->quantity);
            }

            // Clear cart
            $cart->items()->delete();
            $cart->delete();

            // Dispatch email confirmation job
            SendOrderConfirmation::dispatch($order);

            return $order;
        });
    }

    /**
     * Get order details with all relations.
     */
    public function getOrderDetails(int $orderId): Order
    {
        return Order::with(['items.product', 'items.seller', 'user'])
            ->findOrFail($orderId);
    }

    /**
     * Update order status with authorization.
     */
    public function updateOrderStatus(int $orderId, string $status, ?int $sellerId = null): Order
    {
        $order = Order::findOrFail($orderId);

        // If seller is updating, verify they own the order's items
        if ($sellerId) {
            $hasItems = $order->items()->where('seller_id', $sellerId)->exists();
            if (!$hasItems) {
                throw new Exception('Anda tidak memiliki akses ke pesanan ini.');
            }
        }

        $allowedTransitions = [
            'pending' => ['paid', 'cancelled'],
            'paid' => ['shipped', 'cancelled'],
            'shipped' => ['completed'],
            'completed' => [],
            'cancelled' => [],
        ];

        if (!in_array($status, $allowedTransitions[$order->status] ?? [])) {
            throw new Exception("Tidak dapat mengubah status dari \"{$order->status}\" ke \"{$status}\".");
        }

        $order->update(['status' => $status]);

        return $order;
    }
}
