<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;


// 1. Splash Screen aur Store (Aam User)
Route::get('/welcome', function () { return view('welcome'); });
Route::get('/', [ShopController::class, 'index'])->name('shop.home');

// 2. Admin ke Routes (Products add karna)
Route::get('/admin/add-product', [AdminController::class, 'addProduct'])->name('admin.add_product');
Route::post('/admin/store-product', [AdminController::class, 'storeProduct'])->name('admin.store_product');
Route::get('/admin/orders', [App\Http\Controllers\AdminController::class, 'viewOrders'])->name('admin.orders');
Route::post('/admin/orders/{id}/status', [App\Http\Controllers\AdminController::class, 'updateOrderStatus'])->name('admin.order.status');
Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('user.orders');

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

// Admin: Manage, Edit aur Delete Products
Route::get('/admin/products', [App\Http\Controllers\AdminController::class, 'manageProducts'])->name('admin.manage_products');
Route::get('/admin/products/edit/{id}', [App\Http\Controllers\AdminController::class, 'editProduct'])->name('admin.edit_product');
Route::post('/admin/products/update/{id}', [App\Http\Controllers\AdminController::class, 'updateProduct'])->name('admin.update_product');
Route::post('/admin/products/delete/{id}', [App\Http\Controllers\AdminController::class, 'deleteProduct'])->name('admin.delete_product');

require __DIR__.'/auth.php';