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

//Admin panel Routes
//Route::get('/admin/posts/create', [PostController::class, 'create']);
Route::get('/admin/posts/edit', [PostController::class, 'edit']);


Route::get('/user/post/create',[PostController::class, 'create'])->name('user.post.create');
Route::post('/user/post/submit',[PostController::class, 'store'])->name('user.post.publish_post');

Route::get('/user/post/edit/{post:id}',[PostController::class, 'edit_post'])
    ->name('user.post.edit');
Route::post('/user/post/update/{post:id}',[PostController::class, 'update_post'])
    ->name('user.post.update_post');

Route::get('/user/comment/edit/{comment:id}',[PostCommentsController::class, 'edit_comment'])
    ->name('user.comment.edit');
Route::post('/user/comment/update/{comment:id}',[PostCommentsController::class, 'update_comment'])
    ->name('user.comment.update_comment');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    //User panel routes
    Route::get('/user/{author:username}', function (User $author){
        return view('profile_user_posts', [
            'posts'=> $author -> posts,
            'comments' => $author -> comments
        ]);
    })->name('user_posts_comments');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
