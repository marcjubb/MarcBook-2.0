<x-guest-layout>
   @include ('components._header')
    <main class="container mx-auto px-4">
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
            <div class="grid grid-cols-3 gap-4">
                @foreach ($products as $product)
                    <div class="bg-white rounded-lg shadow-lg flex">
                        @if(!$product->image == null)
                            <img src="{{ asset($product->image->image_path)}}" alt="" class="rounded-l-lg object-cover h-48 w-48">
                        @endif
                        <div class="p-4 flex flex-col justify-between">
                            <div>
                                <h3 class="text-xl font-bold mb-2">{{ $product->title }}</h3>
                                <p class="text-gray-700 text-base">{{ $product->description }}</p>
                                <p class="text-gray-900 text-lg font-bold mt-4">${{ $product->price }}</p>
                            </div>
                            <div>
                                <a href="{{ route('product.show', $product->slug) }}" class="block bg-gray-900 text-white text-center py-2 px-4 rounded-lg mt-4 hover:bg-gray-800 focus:bg-gray-800 focus:outline-none">View Product</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
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
