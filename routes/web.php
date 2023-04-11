<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\WishlistController;
use App\Http\GNews;
use App\Http\Twitter;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Facebook;
use App\Http\Controllers;

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
//t@t2.com
//test123123
app()-> singleton('App\Http\Facebook', function ($app){
    return new Facebook("key");
});


app()-> singleton('App\Http\GNews', function ($app){
    return new GNews("57c5c660c0d558f175431aed521c4b42");
});
Route::get('/api', [ProductController::class, 'gnewsTest']);


Route::get('/r', [ProductController::class, 'getRecommendations']) ->name('home');


//Webpage Browsing routes
Route::get('/', [ProductController::class, 'index']) ->name('home');
Route::get('/home', [ProductController::class, 'index']) ->name('homer');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('product.show');
Route::post('/products/{product:slug}/comments', [PostCommentsController::class, 'store']);
Route::get('/author/{author:username}', function (User $author){
    return view('products', [
        'author'=> $author,
    ]);

});
Route::get('/category/{category:slug}', function (Category $category){

    return view('category-index', [
        'category'=> $category,
        'products'=> $category -> products()->get(),
        'categories'=> Category::all()]);

})->name("category");


Route::get('/clearnotifications',[PostCommentsController::class, 'clear_notifications'])
    ->name('clear.notifications');
/*Route::get('/clearnotification',[PostCommentsController::class, 'clear_notification'])
    ->name('clear.notification');*/
Route::get('/sendnotification',[PostCommentsController::class, 'send_notification'])
    ->name('send.notification');



Route::get('/user/product/create',[ProductController::class, 'create'])->name('user.product.create');
Route::post('/user/product/submit',[ProductController::class, 'store'])->name('user.product.publish_product');
Route::post('/user/uploadpp',[ProductController::class, 'uploadPP'])->name('user.uploadpp');

Route::get('/user/product/edit/{product:id}',[ProductController::class, 'edit_product'])->middleware('auth')
    ->name('user.product.edit');
Route::post('/user/product/update/{product:id}',[ProductController::class, 'update_product'])->middleware('auth')
    ->name('user.product.update_product');

Route::get('/user/comment/edit/{comment:id}',[PostCommentsController::class, 'edit_comment'])->middleware('auth')
    ->name('user.comment.edit');
Route::post('/user/comment/update/{comment:id}',[PostCommentsController::class, 'update_comment'])->middleware('auth')
    ->name('user.comment.update_comment');



Route::post('/user/product/update/{product:id}',[ProductController::class, 'update_product'])->middleware('auth')
    ->name('user.product.update_product');


Route::get('/bought/{product}', [ProductController::class, 'bought']) ->name('bought');


Route::get('/basket', [ProductController::class, 'basket']) ->name('basket.view');
Route::get('/basket/add/{id}', [BasketController::class, 'add'])->name('basket.add');


Route::get('/wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::get('/wishlist', [WishlistController::class, 'wishlist']) ->name('wishlist.view');


Route::get('/basket/addeee', [Controllers\BasketController::class, 'add']) ->name('buy');

Route::middleware('auth')->group(function () {

    //User panel routes
    Route::get('/user/{author:username}', function (User $author){
        return view('profile_user_posts', [
            'products'=> $author -> products(),
            'comments' => $author -> comments
        ]);
    })->name('user_product_comments');


});
require __DIR__.'/auth.php';
