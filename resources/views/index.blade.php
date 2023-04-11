<x-guest-layout>
    @include ('components._header')
    <main class="container mx-auto px-4">
        <div class="mb-4">
            <label for="category-select">Category:</label>
            <select id="category-select" onchange="window.location.href = '{{ route('home') }}' + '?category=' + this.value + '&sort={{ request('sort') }}'">
                <option value="all" {{ request('category') == 'all' || !request('category') ? 'selected' : '' }}>All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="sort-select">Sort By:</label>
            <select id="sort-select" onchange="window.location.href = '{{ route('home') }}' + '?category={{ request('category') }}&sort=' + this.value">
                <option value="default" {{ !request('sort') ? 'selected' : '' }}>Default</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Price: High to Low</option>
            </select>
        </div>





        <div class="product-grid">
            @if ($products->count())
                @foreach ($products as $product)
                    <div class="product">
                        @if(!$product->image == null)
                            <a href="{{ route('product.show', $product->slug) }}">
                                <img src="{{ asset($product->image->image_path)}}" alt="" class="rounded-t-lg object-cover h-48 w-full">
                            </a>
                        @endif
                        <div class="product-details">
                            <a href="{{ route('product.show', $product->slug) }}" class="hover:text-gray-800 focus:text-gray-800">
                                <h3 class="text-xl font-bold mb-2">{{ $product->title }}</h3>
                            </a>
                            <p class="text-gray-700 text-base">{{ $product->body }}</p>
                            <p class="price">${{ $product->price }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center">No products yet on current page</p>
            @endif
        </div>

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
<script>
    function applyFilters() {
        var categorySelect = document.getElementById('category-select');
        var sortSelect = document.getElementById('sort-select');
        var url = "{{ route('home') }}";
        var params = {};

        if (categorySelect.value) {
            params.category = categorySelect.value;
        }
        if (sortSelect.value) {
            params.sort = sortSelect.value;
        }
        if (Object.keys(params).length > 0) {
            url += '?' + new URLSearchParams(params).toString();
        }

        window.location.href = url;
    }
</script>
