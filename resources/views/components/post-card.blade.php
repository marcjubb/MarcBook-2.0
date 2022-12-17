@props(['post'])

<article>
    <header>
        <div class="mt-4",>
            <a href="/posts/{{$post -> slug}}">
                {{$post -> title}}
            </a>
        </div>
    </header>

    <div class="text-sm mt-4 space-y-4">
        {!! $post -> body!!}
    </div>

    <div class="ml-3">
        <a href="/author/{{ $post->author->username }}">
            {{ $post->author->name }}</a>
    </div>
</article>
