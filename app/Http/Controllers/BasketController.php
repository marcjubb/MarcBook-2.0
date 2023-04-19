<?php

namespace App\Http\Controllers;

use App\Models\Affinity;
use App\Models\BasketItem;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;


class BasketController extends Controller
{

    public function add($id): RedirectResponse
    {

        // Get the authenticated user
        $user = auth()->user();
        $product = Product::query()->where('id', '=', $id)->first();
        // Check if the product is already in the user's basket

        $basketItem = $user->basketItems()->where('product_id', $product -> id)->first();

        // If the product is already in the basket, increment the quantity
        if ($basketItem) {
            $basketItem->increment('quantity');
        } else {
            // Otherwise, create a new basket item for the product
            $basketItem = new BasketItem([
                'product_id' =>  $product -> id,
                'user_id' => $user->id,
                'quantity' => 1
            ]);
            $user->basketItems()->save($basketItem);
        }


        $affinity = $user->affinities()->where('product_id', $product -> id)->first();

        if ($affinity) {
            $affinity -> score = 3;
        } else {
            $affinity = new Affinity([
                'product_id' =>  $product -> id,
                'user_id' => $user->id,
                'score' => 3,
                'time' => time()
            ]);
        }
        $affinity ->save();

        // Redirect back to the product page with a success message
        return redirect('basket')->with('success', 'Product added to basket');
    }

    public function buy(BasketItem $order)
    {
            $order->order_status ='Processing';
            $order->save();
            return redirect('basket')->with('status', 'Order completed successfully!');

    }

    public function remove($id){
        $user = auth()->user();
        $product = Product::query()->where('id', '=', $id)->first();
        $basketItem = $user->basketItems()->where('product_id', $product -> id)->first();
        $basketItem->delete();
        return redirect('basket')->with('status', 'Product removed from basket');

    }
}

