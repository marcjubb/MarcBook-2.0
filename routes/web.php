<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Webpage Browsing routes
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('product.show');

// User Product routes
Route::middleware(['auth'])->group(function () {
    Route::get('/user/product/create', [ProductController::class, 'create'])->name('user.product.create');
    Route::post('/user/product/submit', [ProductController::class, 'store'])->name('user.product.publish_product');
    Route::post('/user/product/delete/{product:id}', [ProductController::class, 'delete'])->name('user.product.destroy');
    Route::get('/user/product/edit/{product:id}', [ProductController::class, 'edit_product'])->name('user.product.edit');
    Route::post('/user/product/update/{product:id}', [ProductController::class, 'update_product'])->name('user.product.update_product');
});

// Order routes
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [ProductController::class, 'orders'])->name('orders');
    Route::put('/ship/{order:id}', [ProductController::class, 'ship'])->name('orders.ship');
    Route::put('/complete/{order:id}', [ProductController::class, 'complete'])->name('orders.complete');
});

// Admin routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [ProductController::class, 'adminPanel'])->name('admin-panel');
});

// Bought route
Route::get('/bought/{product}', [ProductController::class, 'bought'])->name('bought');

// Basket routes
Route::get('/basket', [ProductController::class, 'basket'])->name('basket.view');
Route::put('/basket/add/{id}', [BasketController::class, 'add'])->name('basket.add');
Route::put('/basket/buy/{order:id}', [BasketController::class, 'buy'])->name('basket.buy');
Route::put('/basket/remove/{order:id}', [BasketController::class, 'remove'])->name('basket.remove');

// Wishlist routes
Route::put('/wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::get('/wishlist', [WishlistController::class, 'wishlist'])->name('wishlist.view');
Route::put('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::put('/wishlist/basket/{id}', [WishlistController::class, 'addBasket'])->name('wishlist.basket');

// Profile route
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});

require __DIR__.'/auth.php';
