<x-guest-layout>
    @extends('layouts.app')
    @include ('components._header')
    @component('layouts.app')

        @slot('header')
    <div class="container">
        <h1>Your Orders</h1>

        <table class="table">
            <thead>
            <tr>
                <th>Order ID</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @if ($orders->count() > 0)
                @foreach ($orders as $order)
                    @if ($order->order_status === 'Processing' || $order->order_status === 'Shipped' || $order->order_status === 'Complete')
                        <tr>
                            <td>{{ $order->product->title }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->product->price }}</td>
                            <td>{{ $order->quantity * $order->product->price }}</td>
                            <td>{{ $order->order_status }}</td>
                        </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td colspan="7">No orders found.</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>


        @endslot
    @endcomponent
</x-guest-layout>
