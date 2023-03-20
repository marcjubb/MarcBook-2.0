<x-guest-layout>
    <x-layout>
        @include ('components._header')
        @if(!$author->image == null)
            <section class="p-strip u-image-position">
                <img src="{{ asset($author->image->image_path)}}" width="250" height="500" alt="">
            </section>
        @elseif(Auth::user()->username === $author->username)
            <form action="{{route('user.upload')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group m-3 p-3">
                    <label for="body">Chose a Profile Picture</label>
                    <label>
                        <input class="form-control" name="image" type="file">
                    </label>
                </div>
                <button type="submit" value="submit">Upload Profile picture</button>
            </form>
        @endif
        <h1>{{$author -> name}}'s Page</h1>


        <h1>Posts</h1>
        <main class="max-w-6xl mx-auto mt-6 lg:mt-20 space-y-6">
            @if ($products -> count())

                @foreach ($products as $product)

                    <x-product-card
                        :product="$product"
                        class="{{'col-span-3'}}"/>
                    @if(!auth()->user()==null)
                        @if(auth()-> user()->is_admin)

                            <button>
                                <a class="btn btn-primary" href="{{route('user.product.edit', $product->id)}}">Edit</a>
                            </button>
                        @endif
                    @endif

                @endforeach

            @else
                <p class="text-center">No Products yet</p>
            @endif

        </main>

    </x-layout>

</x-guest-layout>
