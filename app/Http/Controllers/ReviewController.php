<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    /**
     * Show the form for creating a new review for an order.
     */
    public function create(Order $order): View|RedirectResponse
    {
        // Ensure buyer owns the order and it is completed
        if ($order->user_id !== auth()->id() || $order->status !== 'completed') {
            abort(403);
        }

        // Check if all items are already reviewed
        $reviewedProductIds = Review::where('order_id', $order->id)->pluck('product_id')->toArray();
        $itemsToReview = $order->items()->whereNotIn('product_id', $reviewedProductIds)->with('product')->get();

        if ($itemsToReview->isEmpty()) {
            return redirect()->route('orders.show', $order)
                ->with('info', 'Anda sudah memberikan penilaian untuk semua produk di pesanan ini.');
        }

        return view('reviews.create', compact('order', 'itemsToReview'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Order $order): RedirectResponse
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'completed') {
            abort(403);
        }

        $request->validate([
            'reviews' => 'required|array',
            'reviews.*.product_id' => 'required|exists:products,id',
            'reviews.*.rating' => 'required|integer|min:1|max:5',
            'reviews.*.comment' => 'nullable|string|max:1000',
        ]);

        foreach ($request->reviews as $reviewData) {
            Review::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'order_id' => $order->id,
                    'product_id' => $reviewData['product_id'],
                ],
                [
                    'rating' => $reviewData['rating'],
                    'comment' => $reviewData['comment'] ?? null,
                ]
            );
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Terima kasih atas penilaian Anda!');
    }
}
