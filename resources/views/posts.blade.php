
<x-layout>
    @include ('components._header')

    <p class="pt-4">
        Categories:
        @foreach ($posts as $post)
        @foreach($post -> categories as $category)
            <a href="/category/{{$category -> slug}}">
                {{$category -> title}}
            </a>
        @endforeach
        @endforeach
    </p>


    <h1>Posts</h1>
        <main class="max-w-6xl mx-auto mt-6 lg:mt-20 space-y-6">
        @if ($posts -> count())

        @foreach ($posts as $post)

            <x-post-card
                :post="$post"
                class="{{'col-span-3'}}"/>
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

            <h1>Comments</h1>
            @if ($comments -> count())

                @foreach ($comments as $comment)
                    <h3>Commented on {{$comment -> post -> title}}</h3>
                    <x-comment-card
                        :comment="$comment"/>
                    @if(!auth()->user()==null)
                    @if($comment->author == auth()->user()|| auth()-> user()->is_admin)
                        <button>
                            <a class="btn btn-primary" href="{{route('user.comment.edit', $comment->id)}}">Edit</a>
                        </button>
                    @endif
                    @endif
                @endforeach
            @else
                <p class="text-center">No comments yet</p>
            @endif

    </main>

</x-layout>

