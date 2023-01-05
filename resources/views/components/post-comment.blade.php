@props(['comment'])

    <article class="flex space-x-2">
        <div class="flex-shrink-2">

            @if(!$comment->author->image == null)
                <img src="{{ asset($comment->author->image->image_path)}}" width="50" height="50" alt="" >
            @else
                <img src="https://i.pravatar.cc/60?u={{ $comment->user_id }}"  width="50" height="50" alt="">
            @endif
             </div>
        <div>
            <header class="mb-6">
                <h3 class="font-bold">{{ $comment->author->name }}</h3>
                <p class="text-xs">
                    Posted
                    <time>{{ $comment->created_at->format('F j, Y, g:i a') }}</time>
                </p>
            </header>
            <p>
                {{ $comment->body }}
            </p>
        </div>
    </article>

