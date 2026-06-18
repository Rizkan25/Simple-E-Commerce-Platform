<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    /**
     * Display product catalog with search and category filter.
     */
    public function index(Request $request): View
    {
        $query = Product::with(['category', 'seller'])
            ->where('stock', '>', 0);

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Get all products instead of paginating
        $products = $query->get();

        // Apply recommendation sorting if no active filters
        if (!$request->filled('search') && !$request->filled('category')) {
            $products = $products->sortByDesc(function ($product) {
                // Weight = number of views + a random factor (0 to 15) to keep it dynamic
                return $product->views + rand(0, 15);
            })->values();
        }
        $categories = Category::whereHas('products', function ($query) {
            $query->where('stock', '>', 0);
        })->get();

        return view('shop.index', compact('products', 'categories'));
    }

    /**
     * Display a single product detail.
     */
    public function show(Product $product): View
    {
        $product->increment('views');
        $product->load(['category', 'seller', 'reviews.user']);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->limit(4)
            ->get();

        return view('shop.show', compact('product', 'relatedProducts'));
    }
}
