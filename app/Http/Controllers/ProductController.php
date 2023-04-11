<?php

namespace App\Http\Controllers;

use App\Http\Facebook;
use App\Http\GNews;
use App\Http\Twitter;
use App\Models\Affinity;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Recommendation;
use Auth;
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
        $query = Product::query();

        $categorySlug = request('category');
        if ($categorySlug && $categorySlug !== 'all') {
            $category = Category::where('slug', $categorySlug)->firstOrFail();
            $query->where('category_id', $category->id);
        }

        $sort = request('sort');
        if ($sort === 'asc') {
            $query->orderBy('price');
        } elseif ($sort === 'desc') {
            $query->orderByDesc('price');
        } else {
            $query->latest();
        }

        $products = $query->filter(request(['search', 'author']))->paginate(10)->withQueryString();

        return view('index', [
            'categories' => Category::all(),
            'products' => $products,
        ]);
    }


    public function bought(Product $product)
    {
        $user = auth()->user();
        $affinity = $user->affinities()->where('product_id', $product -> id)->first();

        if ($affinity) {
            $affinity -> score = 5;
        } else {
            $affinity = new Affinity([
                'product_id' =>  $product -> id,
                'user_id' => $user->id,
                'score' => 5,
                'time' => time()
            ]);
        }
        $affinity ->save();

        return redirect('bought.add')->with('success', 'Product added to basket');
    }

    public function getRecommendations()
    {


        $file = fopen('T:\\PyCharm\\SAReccomend\\recommenders\\examples\\00_quick_start\\recommendations.csv', 'rb');
        $user_id = 7;
        $header = fgetcsv($file); // Read the header row
        $recommendations = [];
        while (($row = fgetcsv($file)) !== false) {
            if ($row[0] == $user_id) {
                // If the row corresponds to the logged-in user, add the recommendation to the array
                $recommendations[] = [
                    'item_id' => $row[1],
                    'score' => $row[2],
                ];
            }
        }

// Store the recommendations in the database
        /*foreach ($recommendations as $rec) {
            $recommendation = new Recommendation([
                'user_id' => $rec[0],
                'item_id' => $rec[1],
                'score' => $rec[2]
            ]);
            $recommendation->save();
        }*/


        fclose($file);

        $product = Product::query()->where('id', '=', $recommendations[0]['item_id'])->first();

        return view('product',['product'=> $product]);
    }

    public function basket()
    {
        if (Auth::user()===null){
            redirect('home');
        }else{
            $user = Auth::user();
            $user->load('basketItems.product');
            return view('basket', ['user' => $user]);
        }

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

