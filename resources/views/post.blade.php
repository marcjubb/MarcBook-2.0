<x-layout>

    @include ('components._header')
    <article>
        <header>
            <div class="mt-4">
                <a href="/posts/{{$post -> slug}}">
                    {{$post -> title}}
                </a>
            </div>
        </header>

        <div class="text-sm mt-4 space-y-4">
            {!! $post -> body!!}
        </div>

        <div class="ml-3">
            <a href="/author/{{$post -> author -> username}}">
                <h5 class="font-bold">{{$post -> author -> name}}</h5>
            </a>
        </div>

        <h2>Comments</h2>

        <section class="col-span-8 col-start-5 mt-10 space-y-6">
            @include ('components.add_comment')
            @foreach ($post->comments as $comment)
                <x-post-comment :comment="$comment"/>

                <button>
                    <a class="btn btn-primary" href="{{route('user.comment.edit', $comment->id)}}">Edit</a>
                </button>
            @endforeach

        </section>

    </article>



</x-layout>
