<x-guest-layout>
   @include ('components._header')
    <main>
        @if(!auth()->user()==null)
        <h1>Notifications: </h1>
        @if (auth()->user()->notifications -> count())
            @foreach (auth()->user()->notifications as $notification)
                   <h3>You have recieved a comment: {{ $notification->data['body']}}</h3>
                <h4>This was commented on product:</h4>
                    @php
                $id = $notification->data['comment_id'];
                $product = \App\Models\Comment::query()->where('id','=',$id )->first()->product;
                @endphp
                    <a href="/products/{{$product -> slug }}">
                        <h3 class="font-bold">
                            {{$product->title}}</h3>
                    </a>
            @endforeach
                <button>
                    <a class="btn btn-primary" href="{{route('clear.notifications')}}">Clear Notifications</a>
                </button>

            @endif

        @endif
        <h1>Category Selection:</h1>
        @if ($categories -> count())
            @foreach ($categories as $category)
                <a href="/category/{{$category -> slug }}">
                    <h3 class="font-bold col-span-3 mt-4">{{$category -> name}}</h3>
                </a>
            @endforeach
        @else
            <p class="text-center">No Categories</p>
        @endif
        <h1>All products :</h1>
        @if ($products -> count())
            @foreach ($products as $product)
                <x-product-card
                    :product="$product"
                    class="col-span-3"/>
                @if(!auth()->user()==null)
                    @if(Auth::user()->id === $product->author->id|| auth()-> user()->is_admin)

                        <button>
                            <a class="btn btn-primary" href="{{route('user.product.edit', $product->id)}}">Edit</a>
                        </button>
                    @endif
                @endif

            @endforeach

        @else
            <p class="text-center">No products yet on current page</p>
        @endif
            <nav class="p-pagination" aria-label="Pagination">
                <ol class="p-pagination__items">
                    <li class="p-pagination__item">
                        <a class="p-pagination__link--previous" href="#previous" title="Previous page"><i class="p-icon--chevron-down">Previous page</i></a>
                    </li>
                    <li class="p-pagination__item">
                        <a class="p-pagination__link" href="?page=1" aria-label="Page 1">1</a>
                    </li>
                    <li class="p-pagination__item">
                        <a class="p-pagination__link" href="?page=2" aria-label="Page 2">2</a>
                    </li>
                    <li class="p-pagination__item">
                        <a class="p-pagination__link"  href="?page=3"  aria-label="Page 3">3</a>
                    </li>
                    <li class="p-pagination__item">
                        <a class="p-pagination__link" href="?page=4"  aria-label="Page 4">4</a>
                    </li>
                    <li class="p-pagination__item">
                        <a class="p-pagination__link" href="?page=5"  aria-label="Page 5">5</a>
                    </li>
                    <li class="p-pagination__item">
                        <a class="p-pagination__link--next" href="?page=next" title="Next page"><i class="p-icon--chevron-down">Next page</i></a>
                    </li>
                </ol>
            </nav>
    </main>
    </x-guest-layout>
