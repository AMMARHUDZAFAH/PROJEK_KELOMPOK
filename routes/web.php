<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;

// Public route
Route::get('/', fn() => view('welcome'));

// Public product browsing
Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

// Cart routes (authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [\App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{cartItem}', [\App\Http\Controllers\CartController::class, 'updateQuantity'])->name('cart.update');
    Route::post('/cart/remove/{cartItem}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');

    // Checkout and orders
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/process', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');

    // Profile routes
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

// User dashboard
Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':user'])->group(function () {
    Route::get('/user/dashboard', fn() => view('user.dashboard'))->name('user.dashboard');
});

// Admin routes (names prefixed with `admin.`)
Route::name('admin.')->prefix('admin')->middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');

    // Categories management
    Route::resource('categories', CategoryController::class);

    // Products management (admin)
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);

    // Orders management (admin)
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'adminIndex'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'adminShow'])->name('orders.show');
    Route::post('/orders/{order}/status', [\App\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Users management (Admin namespace)
    Route::resource('users', UserController::class);
    // Restore soft-deleted user
    Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    // Force delete (permanent) user
    Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.forceDelete');
});


