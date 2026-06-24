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

        $total = $cart->items->sum(fn($item) => $item->product->effective_price * $item->quantity);
        $user = auth()->user();
        $hasNonCodItems = $cart->items->contains(fn($i) => !$i->product->is_cod_enabled);

        $platformBank = [
            'name' => \App\Models\PlatformSetting::where('key', 'platform_bank_name')->value('value') ?? 'BCA',
            'account' => \App\Models\PlatformSetting::where('key', 'platform_bank_account')->value('value') ?? '1234567890',
            'owner' => \App\Models\PlatformSetting::where('key', 'platform_bank_owner')->value('value') ?? 'PT Solusi Marketplace Digital',
        ];

        return view('checkout.index', compact('cart', 'total', 'user', 'hasNonCodItems', 'platformBank'));
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
            $orders = $this->orderService->createOrderFromCart(
                auth()->id(),
                $request->shipping_address,
                $request->payment_method
            );

            // Optionally save shipping address to user profile
            auth()->user()->update(['shipping_address' => $request->shipping_address]);

            return redirect()->route('orders.index')
                ->with('success', 'Pesanan berhasil dibuat! Anda telah membuat ' . count($orders) . ' pesanan terpisah untuk setiap toko.');
        } catch (Exception $e) {
            return redirect()->route('cart.index')
                ->with('error', $e->getMessage());
        }
    }
}
