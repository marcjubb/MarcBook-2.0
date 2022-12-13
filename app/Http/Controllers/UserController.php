<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function show(Post $post)
    {
        return view('post', [
            'post' => $post
        ]);
    }

    public function edit_post($post_id)
    {
        $post = Post::query()->where('id', '=', $post_id)->first();

        $categories = Category::all();
        return view('edit_post', compact('post','categories'));
    }
    public function edit_comment($comment_id)
    {
        $comment = Comment::query()->where('id', '=', $comment_id)->first();
        return view('edit_comment', compact('comment'));
    }
    public function update_comment(Request $request, $id)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        $comment = Comment::query()->where('id', '=', $id)->first();
        $comment->body = $request->body;
        $comment->save();

        return redirect()->route('home')->with('success', 'Project Updated Successfully!');

    }
    public function update_post(Request $request, $id)
    {

        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required'
        ]);

        $post = Post::query()->where('id', '=', $id)->first();
        if ($request->user()->cannot('update', $post)) {
            abort(403);
        }
        $post->title = $request->title;
        $post->body = $request->body;
        $post->category_id = $request->category_id;
        $post->save();

        return redirect()->route('home')->with('success', 'Project Updated Successfully!');

    }


}

