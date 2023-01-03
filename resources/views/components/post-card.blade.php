@props(['post'])

<article>
    <header>
        <h4>
        <div class="mt-4",>
            <a href="/posts/{{$post -> slug}}">
                {{$post -> title}}
            </a>
        </div>
        </h4>
    </header>

    <div class="text-sm mt-4 space-y-4">
        {!! $post -> body!!}
    </div>
    <h6>
    <div class="ml-3">
        <a href="/author/{{ $post->author->username }}">
            {{ $post->author->name }}</a>
    </div>
    </h6>
</article>
