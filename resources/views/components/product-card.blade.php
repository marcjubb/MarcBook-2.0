@props(['product'])

<article>
    <header>
        <h4>
        <div class="mt-4",>
            <a href="/products/{{$product -> slug}}">
                {{$product -> title}}
            </a>
        </div>
        </h4>
    </header>

    <div class="text-sm mt-4 space-y-4">
        {!! $product -> body!!}
    </div>
</article>
