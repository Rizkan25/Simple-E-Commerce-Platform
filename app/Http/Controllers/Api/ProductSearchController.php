<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $query = $request->get('query');
        
        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }

        $products = \App\Models\Product::where('name', 'like', '%' . $query . '%')
            ->select('id', 'name', 'slug', 'price')
            ->take(15)
            ->get();

        return response()->json($products);
    }
}
