@auth
    <div>
        <form wire:submit.prevent="store" action="#" method="POST">
            @csrf
            <div class="flex">
                <div>
                    <textarea wire:model.defer="body" name="body" id="body" rows="3" placeholder="Comment"></textarea>

                    @error('comment')
                    <p>{{ $message }}</p>
                    @enderror

                    <button type="submit">
                        <svg wire:loading wire:target="store">

                        </svg>
                        <span>Post Comment</span>
                    </button>

                </div>
            </div>
        </form>

        @foreach ($post->comments as $comment)
            <x-post-comment :comment="$comment"/>
            @if(!auth()->user()==null)
                @if($comment->author == auth()->user()|| auth()-> user()->is_admin)
                    <button>
                        <a class="btn btn-primary" href="{{route('user.comment.edit', $comment->id)}}">Edit</a>
                    </button>
                @endif
            @endif
        @endforeach

    </div>

@else
    <p class="font-semibold">
        <a href="/register" class="hover:underline">Register</a> or
        <a href="/login" class="hover:underline">log in</a> to leave a comment.
    </p>
    @foreach ($post->comments as $comment)
        <x-post-comment :comment="$comment"/>
        @if(!auth()->user()==null)
            @if($comment->author == auth()->user()|| auth()-> user()->is_admin)
                <button>
                    <a class="btn btn-primary" href="{{route('user.comment.edit', $comment->id)}}">Edit</a>
                </button>
            @endif
        @endif
    @endforeach
@endauth

