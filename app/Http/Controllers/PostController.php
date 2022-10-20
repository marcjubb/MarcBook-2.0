<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function show(Post $post)
    {
        return view('post', [
            'post' => $post
        ]);
    }



    public function index()
    {
        return view('posts', [
            'posts' => Post::query()->latest()->filter(
                request(['search', 'author'])
            )->paginate(10)->withQueryString()
        ]);
    }


}

