@extends('layouts.app')

@component('layouts.app')

    @slot('header')
        <h1>Product Summary</h1>
    @endslot

    <div class="row">
        <div class="col-md-4">
            <img src="{{ $product->image }}" alt="{{ $product->title }}" class="img-fluid">
        </div>
        <div class="col-md-8">
            <h2>{{ $product->title }}</h2>
            <p>{{ $product->description }}</p>
            <h4>Price: {{ $product->price }}</h4>
            <form action="{{ route('basket.view') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1" max="10" required>
                <br>
                <button type="submit" class="btn btn-primary">Add to Cart</button>
                <a href="{{ route('home') }}" class="btn btn-secondary">Continue Shopping</a>
            </form>
        </div>
    </div>

@endcomponent
