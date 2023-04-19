<x-guest-layout>
    @extends('layouts.app')
    @include ('components._header')
    @component('layouts.app')

        @slot('header')
        <div class="container mx-auto my-8">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-semibold">All Products</h1>
                <a href="{{ route('user.product.create') }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Add Product</a>
            </div>
            <table class="table-auto w-full">
                <thead>
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Title</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td class="border px-4 py-2">{{ $product->id }}</td>
                        <td class="border px-4 py-2">{{ $product->title }}</td>
                        <td class="border px-4 py-2">{{ $product->description }}</td>
                        <td class="border px-4 py-2">${{ $product->price }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('user.product.edit', $product->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</a>
                            <form action="{{ route('user.product.destroy', $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endslot
    @endcomponent
</x-guest-layout>
