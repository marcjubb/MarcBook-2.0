<x-guest-layout>
@extends('layouts.app')
@include ('components._header')
@component('layouts.app')

    @slot('header')
        <h1>Your Basket</h1>


    @if (Auth::check())

        @if ($user->basketItems->count() > 0)

            <table class="table">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($user->basketItems as $item)
                    @if ($item->order_status ==="basket")
                    <tr>
                        <td>{{ $item->product->title }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->product->price }}</td>
                        <td>{{ $item->quantity * $item->product->price }}</td>
                        <td>
                                <form method="POST" action="{{ route('basket.buy', ['order' => $item->id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="button"><i class="fa fa-user"></i>Buy</button>
                                </form>
                        </td>

                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>

            <div class="text-right">
                <p>Total: {{ $user->basketItems->sum(function ($item) {
                    return $item->quantity * $item->product->price;
                }) }}</p>
                <a href="{{ route('home') }}" class="btn btn-primary">Checkout</a>
            </div>

        @else

            <p>Your basket is empty.</p>

        @endif

    @else

        <h1>Page Not Found</h1>
        <p>The page you requested could not be found.</p>

    @endif
    @endslot
@endcomponent
    </x-guest-layout>
