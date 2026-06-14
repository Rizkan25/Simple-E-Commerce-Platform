<?php

namespace App\Http\Controllers;

use App\Models\Order;
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

        return view('orders.show', compact('order'));
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
            return redirect()->route('orders.show', $order)
                ->with('success', 'Pesanan berhasil dibatalkan.');
        } catch (Exception $e) {
            return redirect()->route('orders.show', $order)
                ->with('error', $e->getMessage());
        }
    }
}
