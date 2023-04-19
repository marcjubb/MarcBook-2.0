<x-guest-layout>
    @extends('layouts.app')
    @include ('components._header')
    @component('layouts.app')

        @slot('header')

            <div class="container">
                <h1>All Orders</h1>

                <table class="table">
                    <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Order Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    @if ($orders)
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->product->title }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>{{ $order->product->price }}</td>
                                <td>{{ $order->quantity * $order->product->price }}</td>
                                <td>{{ $order->order_status }}</td>
                                <td>
                                    @if ($order->order_status === 'Processing')
                                        <form method="POST" action="{{ route('orders.ship', ['order' => $order->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="button"><i class="fa fa-user"></i>Ship</button>
                                        </form>

                                    @elseif ($order->order_status === 'Shipped')
                                        <form method="POST" action="{{ route('orders.complete', ['order' => $order->id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="button"><i class="fa fa-user"></i>Complete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>

                        @endforeach
                    @else
                        <tr>
                            <td colspan="8">No orders found.</td>
                        </tr>
                    @endif

                    </tbody>
                </table>
            </div>

        @endslot
    @endcomponent
</x-guest-layout>
