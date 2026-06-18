<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public product catalog
Route::get('/products', [ShopController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ShopController::class, 'show'])->name('products.show');
Route::get('/api/products/search', \App\Http\Controllers\Api\ProductSearchController::class)->name('api.products.search');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::patch('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/notifications/{id}/click', [\App\Http\Controllers\NotificationController::class, 'click'])->name('notifications.click');
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::delete('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
});

// Buyer routes
Route::middleware(['auth', 'role:buyer'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/items/{item}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/items/{item}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::patch('/orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');

    Route::get('/orders/{order}/review', [\App\Http\Controllers\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/orders/{order}/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
});


// Seller routes
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', SellerProductController::class)->except(['show']);

    Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/status', [SellerOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::get('/withdrawals', [\App\Http\Controllers\Seller\WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::post('/withdrawals', [\App\Http\Controllers\Seller\WithdrawalController::class, 'store'])->name('withdrawals.store');
});

// Keep old dashboard route as redirect
Route::get('/dashboard', function () {
    if (auth()->user()->hasRole('Super Admin')) {
        return redirect('/admin');
    }
    if (auth()->user()->isSeller()) {
        return redirect()->route('seller.dashboard');
    }
    return redirect()->route('products.index');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
