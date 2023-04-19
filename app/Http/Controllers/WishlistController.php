<?php

namespace App\Http\Controllers;

use App\Models\Affinity;
use App\Models\BasketItem;
use App\Models\Product;
use App\Models\WishlistItem;
use Auth;
use Illuminate\Http\RedirectResponse;

class WishlistController extends Controller
{
    public function add($id): RedirectResponse
    {

        // Get the authenticated user
        $user = auth()->user();
        $product = Product::query()->where('id', '=', $id)->first();

            // Otherwise, create a new basket item for the product
            $wishlistItem = new WishlistItem([
                'product_id' =>  $product -> id,
                'user_id' => $user->id,
                'quantity' => 1,
            ]);
            $user->wishlistItems()->save($wishlistItem);

        $affinity = $user->affinities()->where('product_id', $product -> id)->first();

        if ($affinity) {
            $affinity -> score = 2;
        } else {
            $affinity = new Affinity([
                'product_id' =>  $product -> id,
                'user_id' => $user->id,
                'score' => 2,
                'time' => time()
            ]);
        }
        $affinity ->save();



        // Redirect back to the product page with a success message
        return redirect('wishlist')->with('success', 'Product added to Wishlist');
    }

    public function remove($id): RedirectResponse
    {
            // Get the authenticated user
        $user = auth()->user();
        $product = Product::query()->where('id', '=', $id)->first();
        $user->wishlistItems()->where('product_id', $product -> id)->delete();
        return redirect('wishlist')->with('success', 'Product removed from Wishlist');
    }

    public function addBasket($id): RedirectResponse
    {
        // Get the authenticated user
        $user = auth()->user();
        $product = Product::query()->where('id', '=', $id)->first();
        $order = new BasketItem([
            'product_id' =>  $product -> id,
            'user_id' => $user->id,
            'quantity' => 1,
            'order_status' => 'Pending'
            ]);
        $user->basketItems()->save($order);

        //Remove from wishlist
        $user->wishlistItems()->where('product_id', $product -> id)->delete();
        // Redirect back to the product page with a success message
        return redirect('basket')->with('status', 'Product added to Basket');
    }
    public function buy(BasketItem $order)
    {
        if(\Illuminate\Support\Facades\Auth::user()->is_admin){

            $order->order_status ='Processing';
            $order->save();
            return redirect('basket')->with('status', 'Order completed successfully!');

        }
        return redirect('/');
    }


    public function wishlist()
    {
        if (Auth::user()===null){
            redirect('home');
        }else{
            $user = Auth::user();
            $user->load('wishlistItems.product');
            return view('wishlist', ['user' => $user]);
        }

    }
}
