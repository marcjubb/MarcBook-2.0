<?php

namespace App\Http\Controllers;

use App\Http\Facebook;
use App\Http\GNews;
use App\Http\Twitter;
use App\Models\Affinity;
use App\Models\BasketItem;
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

    public function adminPanel()
    {

        if(Auth::user()->is_admin){

            $products = Product::all();
            return view('admin_panel', compact('products'));

        }
        return redirect('/');
    }

    public function orders()
    {
        if(Auth::user()->is_admin){
            $orders = BasketItem::query() ->where('order_status', '<>', 'basket')
                ->where('order_status', '<>', 'complete')
                ->get();
            return view('orders', ['orders' => $orders]);
        }
        return redirect('/');
    }

    public function ship(BasketItem $order)
    {
        if(Auth::user()->is_admin){


                $order->order_status ='Shipped';
                $order->save();
                return redirect()->back()->with('status', 'Order shipped successfully!');

        }
        return redirect('/');
    }
    public function complete(BasketItem $order)
    {
        if(Auth::user()->is_admin){

            $order->order_status ='Complete';
            $order->save();
            return redirect()->back()->with('status', 'Order completed successfully!');

        }
        return redirect('/');
    }


    public function show(Product $product)
    {

        return view('product', [
            'product' => $product
        ]);
    }


    public function index()
    {
        $last_export_time = session('last_export_time', 0);
        $current_time = time();
        $elapsed_time = $current_time - $last_export_time;

        // Check if the elapsed time is greater than 1 hour (3600 seconds)
        if ($elapsed_time > 60) {
            // Export the CSV file
            (new AffinitiesController())->generateRecommended();
            // Store the current time as the last export time in session data
            session(['last_export_time' => $current_time]);
        }

        $products = $this->getFilteredProducts();

        if (Auth::user()){
            $recommended_products = $this->getRecommendedProducts();

            return view('index', [
                'categories' => Category::all(),
                'products' => $products,
                'recommended_products' => $recommended_products,
            ]);
        }
        return view('index', [
            'categories' => Category::all(),
            'products' => $products
        ]);


    }

    private function getFilteredProducts()
    {
        $query = Product::query();

        return $query->filter(request(['search', 'category', 'sort']))->paginate(12)->withQueryString();

    }

    private function getRecommendedProducts()
    {
        $file = fopen('T:/PHPProjects/eMarc/storage/app/exports/recommendations.csv', 'rb');
        $user_id = Auth::user()->id;
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
        fclose($file);

        // Get the recommended products
        $recommended_products = [];
        foreach ($recommendations as $recommendation) {
            $product = Product::find($recommendation['item_id']);
            if ($product) {
                $recommended_products[] = [
                    'product' => $product,
                    'score' => $recommendation['score'],
                ];
            }
        }
        // Sort recommended products by score
        usort($recommended_products, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        // Take the top 5 recommended products
        $recommended_products = array_slice($recommended_products, 0, 5);

        return $recommended_products;
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


        $file = fopen('T:/PHPProjects/eMarc/storage/app/exports/recommendations.csv', 'rb');

        $user_id = Auth::user()->id;
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
            'price' => 'required|numeric',
            'category_id' => 'required'
        ]);

        $product = Product::query()->where('id', '=', $id)->first();
       // if ($request->user()->cannot('update', $product)) {
            //abort(403);
       // }
        $product->title = $request->title;
        $product->body = $request->body;
        $product->price = $request->price;
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

