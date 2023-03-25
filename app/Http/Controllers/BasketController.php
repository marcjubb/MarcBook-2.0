<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class BasketController extends Controller
{
    public function add(Product $product): RedirectResponse
    {
        // Add the product to the user's basket
        auth()->user()->basket()->attach($product);

        // Redirect back to the product page
        return back()->with('success', 'Product added to basket');
    }
}
