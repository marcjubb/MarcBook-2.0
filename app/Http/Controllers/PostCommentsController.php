<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Notifications\CommentNotify;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;

class PostCommentsController extends Controller
{
    public function store(Post $post)
    {

        request()->validate([
            'body' => 'required'
        ]);

        $post->comments()->create([
            'user_id' => request()->user()->id,
            'body' => request('body')
        ]);





        return back();
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
    public function clear_notifications()
    {
        auth()->user()->notifications()->delete();
        return redirect()->route('home');
    }
   /* public function clear_notification( $notification)
    {
        $notification->delete();
        return redirect()->route('home');
    }*/
    public function send_notification()
    {
        $comment = Comment::query()->where('id', '=', 1)->first();
        auth()->user()->notify(new CommentNotify($comment));
        return redirect()->route('home');
    }

}
