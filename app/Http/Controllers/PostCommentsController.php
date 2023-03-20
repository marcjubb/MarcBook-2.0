<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use App\Notifications\CommentNotify;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;

class PostCommentsController extends Controller
{
    public function store(Product $post)
    {
        request()->validate([
            'body' => 'required'
        ]);

        return back();
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
