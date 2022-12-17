<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\Comment;
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

        sleep(1);
        Comment::create([
            'post_id' => $this->post->id,
            'user_id' => request()->user()->id,
            'body' => $this->body,
        ]);

        $this->comment = '';

        $this->post = Post::find($this->post->id);

        $this->successMessage =  'Comment was posted!';

    }
    public function render()
    {
        return view('livewire.comment-live');
    }
}
