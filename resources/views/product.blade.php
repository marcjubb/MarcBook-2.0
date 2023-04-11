<x-guest-layout>
<x-layout xmlns:livewire="http://www.w3.org/1999/html">

    @livewireStyles
    @include ('components._header')
    <article>

        <header>
            @if(!$product->image == null)
                <img src="{{ asset($product->image->image_path)}}" alt="" class="rounded-xl">
            @endif

            <div class="mt-4">
                <h1 class="text-3xl font-bold">{{$product->title}}</h1>
            </div>
        </header>

        <div class="text-sm mt-4 space-y-4">
            {!! $product->body !!}
        </div>
        <h4>£{!! $product->price !!}</h4>
        <div class="flex items-center mt-8 space-x-4">

            <form action="{{ route('basket.add', $product->id) }}" method="GET">
                @csrf
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
                    Add to Basket
                </button>
            </form>


            <form action="{{ route('bought', $product->id) }}" method="GET">
                @csrf
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                    Buy It Now
                </button>
            </form>

            <form action="{{ route('wishlist.add', $product->id) }}" method="GET">
                @csrf
                <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded">
                    Add to Watchlist
                </button>
            </form>
        </div>


    </article>

</x-layout>
    </x-guest-layout>
