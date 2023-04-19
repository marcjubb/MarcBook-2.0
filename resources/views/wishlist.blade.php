<x-guest-layout>

@extends('layouts.app')
@include ('components._header')
@component('layouts.app')

    @slot('header')
    <h1>Your Wishlist</h1>

    @if (Auth::check())

        @if ($user->wishlistItems->count() > 0)

            <table class="table">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($user->wishlistItems as $item)
                    <tr>
                        <td>{{ $item->product->title }}</td>
                        <td>{{ $item->product->price }}</td>

                        <td>
                                <form method="POST" action="{{ route('basket.add', ['id' => $item->product->id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="button"><i class="fa fa-user"></i>Add to Basket</button>
                                </form>
                        </td>


                        <td>
                            <form action="{{ route('wishlist.remove', $item->product->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger">Remove From Wishlist</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        @else

            <p>Your wishlist is empty.</p>

        @endif

    @else

        <h1>Page Not Found</h1>
        <p>The page you requested could not be found.</p>

    @endif
    @endslot
@endcomponent
    </x-guest-layout>
