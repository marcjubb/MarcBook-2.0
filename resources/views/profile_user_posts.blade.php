<x-guest-layout>
<x-layout>
    @include ('components._header')
    <h1>Your Posts & Comments</h1>
    <p class="pt-4">
        Categories:
        @foreach ($products as $product)
            @foreach($product -> categories as $category)
                <a href="/category/{{$category -> slug}}">
                    {{$category -> title}}
                </a>
            @endforeach
        @endforeach
    </p>
    <h1>Posts</h1>
    <main class="max-w-6xl mx-auto mt-6 lg:mt-20 space-y-6">
        @if ($products -> count())

            @foreach ($products as $product)

                <x-product-card
                    :product="$product"
                    class="{{'col-span-3' }}"/>

                <button>
                <a class="btn btn-primary" href="{{route('user.product.edit', $product->id)}}">Edit</a>
                </button>

            @endforeach
        @else
            <p class="text-center">No products yet</p>
        @endif

        <h1>Comments</h1>
        @if ($comments -> count())

            @foreach ($comments as $comment)
                <h3>Commented on {{$comment -> product -> title}}</h3>
                <x-comment-card
                    :comment="$comment"/>

                    <button>
                        <a class="btn btn-primary" href="{{route('user.comment.edit', $comment->id)}}">Edit</a>
                    </button>

            @endforeach
        @else
            <p class="text-center">No comments yet</p>
        @endif

    </main>

</x-layout>

    </x-guest-layout>
