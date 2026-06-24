<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display seller's products.
     */
    public function index(\Illuminate\Http\Request $request): View
    {
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $query = Product::where('seller_id', auth()->id())->with('category');

        if ($sortBy === 'category') {
            $query->join('categories', 'products.category_id', '=', 'categories.id')
                  ->select('products.*')
                  ->orderBy('categories.name', $sortOrder);
        } else {
            $allowedColumns = ['name', 'price', 'stock', 'created_at'];
            if (in_array($sortBy, $allowedColumns)) {
                $query->orderBy($sortBy, $sortOrder);
            } else {
                $query->orderBy('created_at', 'desc');
            }
        }

        $products = $query->paginate(10)->appends($request->query());

        return view('seller.products.index', compact('products', 'sortBy', 'sortOrder'));
    }

    /**
     * Show create product form.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('seller.products.create', compact('categories'));
    }

    /**
     * Store a new product.
     */
    public function store(ProductStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['seller_id'] = auth()->id();
        $data['is_cod_enabled'] = $request->has('is_cod_enabled');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . bin2hex(random_bytes(8)) . '.' . $file->getClientOriginalExtension();
            $data['image'] = $file->storeAs('products', $filename, 'public');
        }

        Product::create($data);

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Show edit product form.
     */
    public function edit(Product $product): View
    {
        $this->authorize('update', $product);
        $categories = Category::all();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    /**
     * Update an existing product.
     */
    public function update(ProductUpdateRequest $request, Product $product): RedirectResponse
    {
        $this->authorize('update', $product);

        $data = $request->validated();
        $data['is_cod_enabled'] = $request->has('is_cod_enabled');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $file = $request->file('image');
            $filename = time() . '_' . bin2hex(random_bytes(8)) . '.' . $file->getClientOriginalExtension();
            $data['image'] = $file->storeAs('products', $filename, 'public');
        }

        $product->update($data);

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Delete a product.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('delete', $product);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
