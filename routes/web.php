<?php
use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Models\Post;
use App\Models\User;
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

//Webpage Browsing routes
Route::get('/', [PostController::class, 'index']) ->name('home');
Route::get('/home', [PostController::class, 'index']) ->name('homer');
Route::get('/posts/{post:slug}', [PostController::class, 'show']);
Route::post('/posts/{post:slug}/comments', [PostCommentsController::class, 'store']);
Route::get('/author/{author:username}', function (User $author){
    return view('posts', [
        'posts'=> $author -> posts,
        'comments' => $author -> comments
    ]);

});





//Admin panel Routes
Route::get('/admin/posts/create', [PostController::class, 'create']);
Route::get('/admin/posts/edit', [PostController::class, 'edit']);



Route::get('/user/post/edit/{post:id}',[App\Http\Controllers\UserController::class, 'edit_post'])->name('user.post.edit');
Route::post('/user/post/update/{post:id}',[App\Http\Controllers\UserController::class, 'update_post'])->name('user.post.update_post');

Route::get('/user/comment/edit/{comment:id}',[App\Http\Controllers\UserController::class, 'edit_comment'])->name('user.comment.edit');
Route::post('/user/comment/update/{comment:id}',[App\Http\Controllers\UserController::class, 'update_comment'])->name('user.comment.update_comment');

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
