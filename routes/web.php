<?php
use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;

use App\Http\GNews;
use App\Http\Twitter;
use App\Models\Category;
use App\Models\Post;
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

app()-> singleton('App\Http\Facebook', function ($app){
    return new Facebook("key");
});
app()-> singleton('App\Http\GNews', function ($app){
    return new GNews("57c5c660c0d558f175431aed521c4b42");
});




Route::get('/api', [PostController::class, 'gnewsTest']);
//Webpage Browsing routes
Route::get('/', [PostController::class, 'index']) ->name('home');
Route::get('/home', [PostController::class, 'index']) ->name('homer');
Route::get('/posts/{post:slug}', [PostController::class, 'show']);
Route::post('/posts/{post:slug}/comments', [PostCommentsController::class, 'store']);
Route::get('/author/{author:username}', function (User $author){
    return view('posts', [
        'author'=> $author,
        'posts'=> $author -> posts,
        'comments' => $author -> comments
    ]);

});
Route::get('/category/{category:slug}', function (Category $category){
    return view('category-index', [
        'category'=> $category,
        'posts'=> $category -> posts]);

});



Route::get('/clearnotifications',[PostCommentsController::class, 'clear_notifications'])
    ->name('clear.notifications');
/*Route::get('/clearnotification',[PostCommentsController::class, 'clear_notification'])
    ->name('clear.notification');*/
Route::get('/sendnotification',[PostCommentsController::class, 'send_notification'])
    ->name('send.notification');




Route::get('/user/post/create',[PostController::class, 'create'])->name('user.post.create')->middleware('auth');
Route::post('/user/post/submit',[PostController::class, 'store'])->name('user.post.publish_post')->middleware('auth');

Route::get('/user/post/edit/{post:id}',[PostController::class, 'edit_post'])->middleware('auth')
    ->name('user.post.edit');
Route::post('/user/post/update/{post:id}',[PostController::class, 'update_post'])->middleware('auth')
    ->name('user.post.update_post');

Route::get('/user/comment/edit/{comment:id}',[PostCommentsController::class, 'edit_comment'])->middleware('auth')
    ->name('user.comment.edit');
Route::post('/user/comment/update/{comment:id}',[PostCommentsController::class, 'update_comment'])->middleware('auth')
    ->name('user.comment.update_comment');


Route::middleware('auth')->group(function () {

    //User panel routes
    Route::get('/user/{author:username}', function (User $author){
        return view('profile_user_posts', [
            'posts'=> $author -> posts,
            'comments' => $author -> comments
        ]);
    })->name('user_posts_comments');


});
require __DIR__.'/auth.php';
