<x-guest-layout>
   @include ('components._header')
    <h1>Category name: {{$category -> name}}</h1>
    <main>
        @if ($products -> count())
            @foreach ($products as $product)
                <x-product-card
                    :product="$product"
                    class="{{ $loop -> iteration < 3 ? 'col-span-3' : 'col-span-2'}}"/>
            @if(!auth()->user()==null)
                @if($product->author == auth()->user()|| auth()-> user()->is_admin)
                    <button>
                        <a class="btn btn-primary" href="{{route('user.product.edit', $product->id)}}">Edit</a>
                    </button>
                @endif
                @endif
            @endforeach
        @else
            <p class="text-center">No products yet</p>
        @endif
    </main>
    </x-guest-layout>
