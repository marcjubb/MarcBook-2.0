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
                <a href="/products/{{$product -> slug}}">
                    {{$product -> title}}
                </a>
            </div>
        </header>

        <div class="text-sm mt-4 space-y-4">
            {!! $product -> body!!}
        </div>

        <div class="ml-3">
            <a href="/author/{{$product -> author -> username}}">
                <h5 class="font-bold">{{$product -> author -> name}}</h5>
            </a>
        </div>




    </article>



</x-layout>
    </x-guest-layout>
