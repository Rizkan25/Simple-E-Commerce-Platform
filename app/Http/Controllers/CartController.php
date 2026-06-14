<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    /**
     * Display the cart page.
     */
    public function index(): View
    {
        $cart = $this->cartService->getCart(auth()->id());

        return view('cart.index', compact('cart'));
    }

    /**
     * Add a product to cart.
     */
    public function add(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        try {
            $cartItem = $this->cartService->addItem(
                auth()->id(),
                $request->product_id,
                $request->quantity ?? 1
            );

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang.',
                'cartItem' => $cartItem->load('product'),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Update quantity of a cart item.
     */
    public function updateQuantity(Request $request, int $item): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $cartItem = $this->cartService->updateQuantity(
                auth()->id(),
                $item,
                $request->quantity
            );

            $cart = $this->cartService->getCart(auth()->id());
            $total = $cart ? $cart->items->sum(fn($i) => $i->price_snapshot * $i->quantity) : 0;

            return response()->json([
                'success' => true,
                'message' => 'Jumlah berhasil diperbarui.',
                'cartItem' => $cartItem->load('product'),
                'subtotal' => $cartItem->price_snapshot * $cartItem->quantity,
                'total' => $total,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(int $item): JsonResponse
    {
        try {
            $this->cartService->removeItem(auth()->id(), $item);

            $cart = $this->cartService->getCart(auth()->id());
            $total = $cart ? $cart->items->sum(fn($i) => $i->price_snapshot * $i->quantity) : 0;

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus dari keranjang.',
                'total' => $total,
                'itemCount' => $cart ? $cart->items->count() : 0,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
