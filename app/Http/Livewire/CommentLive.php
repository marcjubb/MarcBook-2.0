<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\Comment;
use App\Notifications\CommentNotify;
use Livewire\Component;

class CommentLive extends Component
{
    public $post;
    public $body;
    protected $rules = [
        'body' => 'required|min:4',
        'post' => 'required',
    ];
    public function mount(Post $post)
    {
        $this->post = $post;
    }
    public function store(Post $post)
    {
        $this->validate();

        sleep(0.5);
        $comment = Comment::create([
            'post_id' => $this->post->id,
            'user_id' => request()->user()->id,
            'body' => $this->body,
        ]);
        $userToNotify = $this->post->author;
        $userToNotify->notify(new CommentNotify($comment));
        $this->comment = '';

        $this->post = Post::find($this->post->id);

        $this->successMessage =  'Comment was posted!';

    }
    public function render()
    {
        return view('livewire.comment-live');
    }
}
