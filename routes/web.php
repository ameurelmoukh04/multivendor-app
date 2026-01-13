<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\VendorController as AdminVendorController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboardController;
use App\Http\Controllers\Vendor\ProductController as VendorProductController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\User\ReviewController as UserReviewController;
use Illuminate\Support\Facades\Route;

// Home route - Products page for everyone
Route::get('/', [UserProductController::class, 'index'])->name('home');

// Breeze dashboard route
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isVendor()) {
        return redirect()->route('vendor.dashboard');
    } else {
        // For regular users, redirect to products
        return redirect()->route('products.index');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Public product routes (accessible without auth)
Route::get('/products', [UserProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [UserProductController::class, 'show'])->name('products.show');

// Profile routes (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', AdminCategoryController::class);
    Route::get('/vendors', [AdminVendorController::class, 'index'])->name('vendors.index');
    Route::get('/vendors/{id}', [AdminVendorController::class, 'show'])->name('vendors.show');
    Route::post('/vendors/{id}/status', [AdminVendorController::class, 'updateStatus'])->name('vendors.updateStatus');
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/{id}', [AdminProductController::class, 'show'])->name('products.show');
    Route::post('/products/{id}/approve', [AdminProductController::class, 'approve'])->name('products.approve');
    Route::post('/products/{id}/reject', [AdminProductController::class, 'reject'])->name('products.reject');
});

// Vendor routes
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', VendorProductController::class);
});


// User routes
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/orders', [UserOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [UserOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [UserOrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/{id}/confirm-receipt', [UserOrderController::class, 'confirmReceipt'])->name('orders.confirmReceipt');
    Route::post('/reviews/{orderItemId}', [UserReviewController::class, 'store'])->name('reviews.store');
});

use App\Http\Controllers\Admin\ProductApprovalController;

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/products/pending', [ProductApprovalController::class, 'index'])->name('admin.products.pending');
    Route::post('/products/{id}/approve', [ProductApprovalController::class, 'approve'])->name('admin.products.approve');
});
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [
        \App\Http\Controllers\Admin\AdminDashboardController::class,
        'index'
    ])->name('admin.dashboard');
});

