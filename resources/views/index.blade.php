   @include ('components._header')

    <main>
        @if ($posts -> count())
            @foreach ($posts as $post)
                <x-post-card
                    :post="$post"
                    class="{{ $loop -> iteration < 3 ? 'col-span-3' : 'col-span-2'}}"/>
            @if(!auth()->user()==null)
                @if($post->author == auth()->user()|| auth()-> user()->is_admin)
                    <button>
                        <a class="btn btn-primary" href="{{route('user.post.edit', $post->id)}}">Edit</a>
                    </button>
                @endif
                @endif
            @endforeach
        @else
            <p class="text-center">No posts yet</p>
        @endif
    </main>
