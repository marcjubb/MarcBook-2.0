<?php

namespace App\Http\Controllers;

use App\Http\Facebook;
use App\Http\GNews;
use App\Http\Twitter;
use App\Models\Affinity;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{


    public function gnewsTest(GNews $GNews){

        return view('gnews', [
            'articles' => $GNews ->get_articles()
        ]);

    }

    /**
     * Show the form for creating a new Post.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {

        $affinities = Affinity::all();

        $interactions = $affinities->map(function ($affinity) {
            return [
                'User ID' => $affinity->user_id,
                'Item ID' => $affinity->product_id,
                'Time' => $affinity->created_at->timestamp,
                'Event Type' => 'purchase',
                'Event Weight' => $affinity->score,
            ];
        });



        $categories = Category::all();
        return view('create_product',compact('categories'));
    }

    public function store()
    {
        $image = request()->file(
            'image');
        if($image !== null) {
            $image->move(public_path('images'), $image->getClientOriginalName());

            $product = Product::create($this->validateProduct());
            Image::create([
                'image_path' => "images/" . request()->file('image')->getClientOriginalName(),
                'imageable_id' => $product->id,
                'imageable_type' => 'App\Models\Product'
            ]);

        }


        return redirect()->route('home')->with('success', 'Product Published!');

    }
    public function show(Product $product)
    {

        return view('product', [
            'product' => $product
        ]);
    }
    public function index()
    {
        return view('index', [
            'categories'=> Category::all(),
            'products' => Product::query()->latest()->filter(
                request(['search', 'author'])
            )->paginate(10)->withQueryString()
        ]);
    }
    public function uploadPP(Request $request){

        $id = Auth::user()->id;
        $image = request()->file('image');
        if($image !== null) {
            $image->move(public_path('images'), $image->getClientOriginalName());
                Image::create([
                    'image_path' => "images/" . request()->file('image')->getClientOriginalName(),
                    'imageable_id' => $id,
                    'imageable_type' => 'App\Models\User'
                ]);


        }
        return redirect()->back()->with('success', 'Profile Picture Updated!');

    }
    public function update_product(Request $request, $id)
    {

        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required'
        ]);

        $product = Product::query()->where('id', '=', $id)->first();
        if ($request->user()->cannot('update', $product)) {
            abort(403);
        }
        $product->title = $request->title;
        $product->body = $request->body;
        $product->category_id = $request->category_id;
        $product->save();

        $image = request()->file('image');
        if($image !== null) {
            $image->move(public_path('images'), $image->getClientOriginalName());

            $image = Image::query()->where('imageable_id', '=', $id)
                ->where('imageable_type', '=', "App\Models\Product")->first();
            if($image !== null) {
                $image->image_path = "images/" . request()->file('image')->getClientOriginalName();
                $image->save();
            }else{
                Image::create([
                    'image_path' => "images/" . request()->file('image')->getClientOriginalName(),
                    'imageable_id' => $product -> id,
                    'imageable_type' => Product::class
                ]);
            }

        }
        return redirect()->route('home')->with('success', 'Project Updated Successfully!');

    }
    public function edit_product($product_id)
    {
        $product = Product::query()->where('id', '=', $product_id)->first();
        if(Auth::user()->is_admin){
            $categories = Category::all();
            return view('edit_product', compact('product','categories'));
        }
        return redirect('/');

    }

    protected function validateProduct(?Product $product = null): array
    {
        $product ??= new Product();

        return request()->validate([
            'title' => ['required', 'max:255'],
            'body' => 'required',
            'price' => 'required|numeric',
            'slug' => 'required|unique:products,slug',
            'category_id' => ['required', Rule::exists('categories', 'id')],
        ]);

    }



}

