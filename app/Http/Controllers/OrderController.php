<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderStatusNotification;
use App\Services\OrderService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    /**
     * Display list of buyer's orders.
     */
    public function index(): View
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display order details.
     */
    public function show(Order $order): View
    {
        // Ensure buyer can only see their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product', 'items.seller']);

        $hasUnreviewedItems = false;
        if ($order->status === 'completed') {
            $reviewedCount = \App\Models\Review::where('order_id', $order->id)->count();
            if ($reviewedCount < $order->items->count()) {
                $hasUnreviewedItems = true;
            }
        }

        return view('orders.show', compact('order', 'hasUnreviewedItems'));
    }

    /**
     * Cancel an order (only if pending).
     */
    public function cancel(Order $order): RedirectResponse
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        try {
            $this->orderService->updateOrderStatus($order->id, 'cancelled');
            
            // Notify sellers
            $sellerIds = $order->items->pluck('product.seller_id')->unique();
            $sellers = User::whereIn('id', $sellerIds)->get();
            foreach ($sellers as $seller) {
                $seller->notify(new OrderStatusNotification($order));
            }

            return redirect()->route('orders.show', $order)
                ->with('success', 'Pesanan berhasil dibatalkan.');
        } catch (Exception $e) {
            return redirect()->route('orders.show', $order)
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Mark order as completed by buyer.
     */
    public function complete(Order $order): RedirectResponse
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        try {
            $this->orderService->updateOrderStatus($order->id, 'completed');
            
            // Notify sellers
            $sellerIds = $order->items->pluck('product.seller_id')->unique();
            $sellers = User::whereIn('id', $sellerIds)->get();
            foreach ($sellers as $seller) {
                $seller->notify(new OrderStatusNotification($order));
            }

            return redirect()->route('reviews.create', $order)
                ->with('success', 'Terima kasih telah mengonfirmasi penerimaan pesanan. Silakan berikan penilaian Anda.');
        } catch (Exception $e) {
            return redirect()->route('orders.show', $order)
                ->with('error', $e->getMessage());
        }
    }
}
