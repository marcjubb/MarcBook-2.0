<x-guest-layout>
    @include ('components._header')
    <main class="container mx-auto px-4">
        <div class="select-container">
            <label for="category-select">Category:</label>
            <select id="category-select" onchange="window.location.href = '{{ route('home') }}' + '?search={{ request('search') }}&category=' + this.value + '&sort={{ request('sort') }}'">
                <option value="all" {{ request('category') === 'all' || !request('category') ? 'selected' : '' }}>All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="select-container">
            <label for="sort-select">Sort By:</label>
            <select id="sort-select" onchange="window.location.href = '{{ route('home') }}' + '?search={{ request('search') }}&category={{ request('category') }}&sort=' + this.value">
                <option value="default" {{ !request('sort') ? 'selected' : '' }}>Default</option>
                <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="desc" {{ request('sort') === 'desc' ? 'selected' : '' }}>Price: High to Low</option>
            </select>
        </div>





        <div class="product-grid">
            @if ($products->count())
                @foreach ($products as $product)
                    <div class="product">
                        @if(!$product->image == null)
                            <a href="{{ route('product.show', $product->slug) }}">
                                <img src="{{ asset($product->image->image_path)}}" alt="" class="rounded-t-lg object-cover">
                            </a>
                        @else
                            <img src="https://via.placeholder.com/150" alt="" class="rounded-t-lg object-cover">
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

        <div class="pagination-container">
            {{ $products->links('custom-pagination') }}
        </div>

    </main>

    @if(Auth::user())
    @include ('components._recommendations')
        @endif
</x-guest-layout>
<script>
    function applyFilters() {
        var categorySelect = document.getElementById('category-select');
        var sortSelect = document.getElementById('sort-select');
        var searchValue = document.querySelector('input[name="search"]').value;
        var url = "{{ route('home') }}";
        var params = {};

        if (categorySelect.value) {
            params.category = categorySelect.value;
        }
        if (sortSelect.value) {
            params.sort = sortSelect.value;
        }
        if (searchValue) {
            params.search = searchValue;
        }
        if (Object.keys(params).length > 0) {
            url += '?' + new URLSearchParams(params).toString();
        }

        window.location.href = url;
    }

</script>
