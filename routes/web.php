<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

// 1. Splash Screen aur Store (Aam User)
Route::get('/welcome', function () { return view('welcome'); });
Route::get('/', [ShopController::class, 'index'])->name('shop.home');

// 2. Admin ke Routes (Products add karna)
Route::get('/admin/add-product', [AdminController::class, 'addProduct'])->name('admin.add_product');
Route::post('/admin/store-product', [AdminController::class, 'storeProduct'])->name('admin.store_product');

// 3. Breeze Default Routes (Login ke baad dashboard aur profile)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Cart ke Routes (Aam user wale routes ke sath inko bhi rakh dein)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');


Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place_order');

require __DIR__.'/auth.php';