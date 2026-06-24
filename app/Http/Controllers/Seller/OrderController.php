<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusUpdated;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\OrderService;
use App\Notifications\OrderStatusNotification;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    /**
     * Display orders containing seller's products.
     */
    public function index(): View
    {
        $sellerId = auth()->id();

        $orderIds = OrderItem::where('seller_id', $sellerId)
            ->distinct()
            ->pluck('order_id');

        $orders = Order::whereIn('id', $orderIds)
            ->with(['items' => function ($query) use ($sellerId) {
                $query->where('seller_id', $sellerId)->with('product');
            }, 'user'])
            ->latest()
            ->paginate(10);

        return view('seller.orders.index', compact('orders'));
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:paid,shipped',
        ]);

        try {
            $this->orderService->updateOrderStatus(
                $order->id,
                $request->status,
                auth()->id()
            );

            // Send notification email and system notification to buyer
            $order = $order->fresh();
            Mail::to($order->user->email)->send(new OrderStatusUpdated($order));
            $order->user->notify(new OrderStatusNotification($order));

            return redirect()->route('seller.orders.index')
                ->with('success', 'Status pesanan berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->route('seller.orders.index')
                ->with('error', $e->getMessage());
        }
    }
}
