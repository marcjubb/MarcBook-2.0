<footer class="footer">
    <div class="footer-container">
        <h2>Recommended products</h2>
        <div class="product-grid-container">
            @foreach ($recommended_products as $recommended_product)
                <div class="recommended-product">
                    <a href="{{ route('product.show', $recommended_product['product']) }}">
                        @if(!$product->image === null)
                            <a href="{{ route('product.show', $recommended_product['product']->slug) }}">
                                <img src="{{ $recommended_product['product']->image_url }}" alt=""
                                     class="rounded-t-lg object-cover">
                            </a>
                        @else
                            <img src="https://via.placeholder.com/150"  class="rounded-t-lg object-cover">
                        @endif
                        <p class="product-name">{{ $recommended_product['product']->name }}</p>
                        <p class="product-price">${{ $recommended_product['product']->price }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</footer>
