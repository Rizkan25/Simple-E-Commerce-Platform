<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected OrderService $orderService
    ) {}

    /**
     * Display checkout page.
     */
    public function index(): View|RedirectResponse
    {
        $cart = $this->cartService->getCart(auth()->id());

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja kosong.');
        }

        $total = $cart->items->sum(fn($item) => $item->price_snapshot * $item->quantity);
        $user = auth()->user();

        return view('checkout.index', compact('cart', 'total', 'user'));
    }

    /**
     * Process checkout and create order.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|in:dummy_bank,cod',
        ]);

        try {
            $order = $this->orderService->createOrderFromCart(
                auth()->id(),
                $request->shipping_address,
                $request->payment_method
            );

            // Optionally save shipping address to user profile
            auth()->user()->update(['shipping_address' => $request->shipping_address]);

            return redirect()->route('orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat! Nomor pesanan: ' . $order->order_number);
        } catch (Exception $e) {
            return redirect()->route('cart.index')
                ->with('error', $e->getMessage());
        }
    }
}
