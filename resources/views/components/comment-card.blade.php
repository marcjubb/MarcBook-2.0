@props(['comment'])

<article>

    <div class="text-sm mt-4 space-y-4">
        {!! $comment -> body!!}
    </div>

    <div class="ml-3">
        <a href="/author/{{$comment -> author -> username}}">
            <h5 class="font-bold">{{$comment -> author -> name}}</h5>
        </a>
    </div>
</article>
