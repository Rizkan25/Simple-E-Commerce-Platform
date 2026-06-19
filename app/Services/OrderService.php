<?php

namespace App\Services;

use App\Jobs\SendOrderConfirmation;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function __construct(
        protected StockService $stockService
    ) {}

    /**
     * Create orders from the user's cart using database transaction and pessimistic locking.
     */
    public function createOrderFromCart(int $userId, string $shippingAddress, string $paymentMethod): array
    {
        return DB::transaction(function () use ($userId, $shippingAddress, $paymentMethod) {
            $cart = Cart::where('user_id', $userId)
                ->with('items.product')
                ->firstOrFail();

            if ($cart->items->isEmpty()) {
                throw new Exception('Keranjang belanja kosong.');
            }

            // Filter cart items if payment method is COD
            $itemsToProcess = $cart->items;
            if ($paymentMethod === 'cod') {
                $itemsToProcess = $cart->items->filter(function($item) {
                    return $item->product->is_cod_enabled;
                });
                if ($itemsToProcess->isEmpty()) {
                    throw new Exception('Tidak ada produk yang mendukung COD di keranjang Anda.');
                }
            }

            // Get product IDs and lock them for update (pessimistic locking)
            $productIds = $itemsToProcess->pluck('product_id')->toArray();
            $products = Product::whereIn('id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // Group items by seller_id
            $itemsBySeller = [];
            foreach ($itemsToProcess as $item) {
                $sellerId = $products[$item->product_id]->seller_id;
                if (!isset($itemsBySeller[$sellerId])) {
                    $itemsBySeller[$sellerId] = [];
                }
                $itemsBySeller[$sellerId][] = $item;
            }

            // Get current commission percentage
            $commissionSetting = \App\Models\PlatformSetting::where('key', 'commission_percentage')->first();
            $commissionPercentage = $commissionSetting ? (float) $commissionSetting->value : 0;

            $createdOrders = [];

            foreach ($itemsBySeller as $sellerId => $sellerItems) {
                // Calculate total for this seller's order
                $sellerTotalAmount = 0;
                foreach ($sellerItems as $item) {
                    $product = $products[$item->product_id];
                    $sellerTotalAmount += $product->effective_price * $item->quantity;
                }

                // Create order for this seller
                $order = Order::create([
                    'user_id' => $userId,
                    'order_number' => 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
                    'status' => 'pending',
                    'total_amount' => $sellerTotalAmount,
                    'shipping_address' => $shippingAddress,
                    'payment_method' => $paymentMethod,
                ]);

                // Create order items with live prices and deduct stock
                foreach ($sellerItems as $item) {
                    $product = $products[$item->product_id];

                    $itemTotal = $product->effective_price * $item->quantity;
                    $platformFee = $itemTotal * ($commissionPercentage / 100);
                    $sellerEarnings = $itemTotal - $platformFee;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'seller_id' => $product->seller_id,
                        'quantity' => $item->quantity,
                        'price_at_order' => $product->effective_price,
                        'platform_fee' => $platformFee,
                        'seller_earnings' => $sellerEarnings,
                    ]);

                    // Deduct stock
                    $product->decrement('stock', $item->quantity);
                }

                // Notify this seller
                $seller = User::find($sellerId);
                if ($seller) {
                    $seller->notify(new NewOrderNotification($order));
                }

                // Dispatch email confirmation job for this order
                SendOrderConfirmation::dispatch($order);

                $createdOrders[] = $order;
            }

            // Clear processed cart items from cart
            \App\Models\CartItem::whereIn('id', $itemsToProcess->pluck('id'))->delete();
            if ($cart->items()->count() === 0) {
                $cart->delete();
            }

            return $createdOrders;
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

        $originalStatus = $order->status;
        $order->update(['status' => $status]);

        // Process seller deposits if the order is completed
        if ($status === 'completed' && $originalStatus !== 'completed') {
            DB::transaction(function () use ($order) {
                // Group items by seller to avoid multiple deposits to the same seller if they have multiple items
                $sellerEarnings = [];
                foreach ($order->items as $item) {
                    if (!isset($sellerEarnings[$item->seller_id])) {
                        $sellerEarnings[$item->seller_id] = 0;
                    }
                    // Fallback to full price if seller_earnings is 0 (for backward compatibility with old orders)
                    $earnings = $item->seller_earnings > 0 ? $item->seller_earnings : ($item->price_at_order * $item->quantity);
                    $sellerEarnings[$item->seller_id] += $earnings;
                }

                foreach ($sellerEarnings as $sellerId => $amount) {
                    $seller = \App\Models\User::find($sellerId);
                    if ($seller) {
                        $seller->deposit($amount, ['description' => 'Pembayaran pesanan: ' . $order->order_number]);
                    }
                }
            });
        }

        return $order;
    }
}
