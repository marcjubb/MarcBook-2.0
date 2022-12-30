<x-guest-layout>
<x-layout xmlns:livewire="http://www.w3.org/1999/html">
    @livewireStyles
    @include ('components._header')
    <article>


        <header>

            @if(!$post->image == null)
            <img src="{{ asset($post->image->image_path)}}" alt="" class="rounded-xl">
            @endif


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


        <h2>ajax Comments</h2>


       <livewire:comment-live :post="$post" />


        @livewireScripts

    </article>



</x-layout>
    </x-guest-layout>
