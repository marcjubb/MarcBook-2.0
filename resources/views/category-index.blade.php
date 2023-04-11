<x-guest-layout>
    @include ('components._header')
    <main class="container mx-auto px-4">
        <div class="mb-4">
            <label for="category-select">Category:</label>
            <select id="category-select" name="category">
                <option value="{{ route('category', ['category' => 'all']) }}"{{ !request('category') || request('category') == 'all' ? ' selected' : '' }}>All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ route('category', ['category' => $category->slug]) }}"{{ request('category') == $category->slug ? ' selected' : '' }}>{{ $category->name }}</option>
                @endforeach
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
                    <a class="p-pagination__link" href="?page=1{{ $category ? '&category='.$category->slug : '' }}" aria-label="Page 1">1</a>
                </li>
                <li class="p-pagination__item">
                    <a class="p-pagination__link" href="?page=2{{ $category ? '&category='.$category->slug : '' }}" aria-label="Page 2">2</a>
                </li>
                <li class="p-pagination__item">
                    <a class="p-pagination__link" href="?page=3{{ $category ? '&category='.$category->slug : '' }}" aria-label="Page 3">3</a>
                </li>
                <li class="p-pagination__item">
                    <a class="p-pagination__link" href="?page=4{{ $category ? '&category='.$category->slug : '' }}" aria-label="Page 4">4</a>
                </li>
                <li class="p-pagination__item">
                    <a class="p-pagination__link" href="?page=5{{ $category ? '&category='.$category->slug : '' }}" aria-label="Page 5">5</a>
                </li>
                <li class="p-pagination__item">
                    <a class="p-pagination__link--next" href="?page=next{{ $category ? '&category='.$category->slug : '' }}" title="Next page"><i class="p-icon--chevron-down">Next page</i></a>
                </li>
            </ol>
        </nav>
    </main>
</x-guest-layout>
<script>
    // Retrieve the selected index from localStorage, if available
    const selectedIndex = localStorage.getItem('category-select-index');
    if (selectedIndex !== null) {
        document.getElementById('category-select').selectedIndex = selectedIndex;
    }

    // Add an event listener to the select element to store the selected index in localStorage
    const selectElement = document.getElementById('category-select');
    selectElement.addEventListener('change', () => {
        localStorage.setItem('category-select-index', selectElement.selectedIndex);
        window.location = selectElement.options[selectElement.selectedIndex].value;
    });
</script>
