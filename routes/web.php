<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\OrderController;

// Home Page
Route::get('/', [ProductController::class, 'index'])->name('home');

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::view('register', 'auth.register')->name('register');
    Route::post('register', 'register');
    Route::view('login', 'auth.login')->name('login');
    Route::post('login', 'login');
    Route::get('logout', 'logout')->name('logout');
});

// Dashboard Routes (Requires Authentication)
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/product', [AuthController::class, 'product'])->name('product');

    // Product Management
    Route::controller(ProductController::class)->prefix('products')->group(function () {
        Route::post('/store', 'store')->name('products.store');
        Route::get('/view', 'product_view')->name('products.view');
        Route::get('/{id}/edit', 'edit')->name('products.edit');
        Route::put('/{id}', 'update')->name('products.update');
        Route::delete('/{id}', 'destroy')->name('products.destroy');
    });

    // Order Management
    Route::controller(AuthController::class)->group(function () {
        Route::get('/pending-orders', 'pendingOrders')->name('pending.orders');
        Route::get('/delivered-orders', 'deliveredOrders')->name('delivered.orders');
        Route::post('/orders/{order}/mark-delivered', 'markAsDelivered')->name('orders.markDelivered');
    });
});

// Product Routes (Public Access)
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{category}', [ProductController::class, 'productsByCategory'])->name('category.products');
Route::get('/search', [ProductController::class, 'search'])->name('search');

// Cart Routes
Route::controller(CartController::class)->prefix('cart')->group(function () {
    Route::post('/add', 'addToCart')->name('cart.add');
    Route::get('/count', 'getCartCount')->name('cart.count');
    Route::post('/update', 'updateCart')->name('cart.update');
    Route::post('/remove', 'removeFromCart')->name('cart.remove');
    Route::get('/', fn() => view('template.cart'))->name('cart.view');
});

// Likes Routes
Route::controller(LikeController::class)->prefix('likes')->group(function () {
    Route::post('/add', 'addLike')->name('likes.add');
    Route::post('/remove', 'removeLike')->name('likes.remove');
    Route::get('/count', 'getLikeCount')->name('likes.count');
    Route::get('/', 'showLikes')->name('products.likes');
});

// Order Routes
Route::controller(OrderController::class)->group(function () {
    Route::get('/checkout', 'checkout')->name('checkout');
    Route::post('/place-order', 'placeOrder')->name('place.order');
});
