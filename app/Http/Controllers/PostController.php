<?php

namespace App\Http\Controllers;

use App\Http\Facebook;
use App\Http\GNews;
use App\Http\Twitter;
use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
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
        $categories = Category::all();
        return view('create_post',compact('categories'));
    }

    public function store()
    {
        $image = request()->file('image');
        if($image !== null) {
            $image->move(public_path('images'), $image->getClientOriginalName());

            $post = Post::create(array_merge($this->validatePost(), [
                'user_id' => request()->user()->id,
            ]));
            Image::create([
                'image_path' => "images/" . request()->file('image')->getClientOriginalName(),
                'imageable_id' => $post->id,
                'imageable_type' => 'App\Models\Post'
            ]);

        }

        Post::create(array_merge($this->validatePost(), [
            'user_id' => request()->user()->id,
        ]));
        return redirect()->route('home')->with('success', 'Post Published!');

    }
    public function show(Post $post)
    {

        return view('post', [
            'post' => $post
        ]);
    }

    public function index()
    {

        return view('index', [
            'categories'=> Category::all(),
            'posts' => Post::query()->latest()->filter(
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
    public function update_post(Request $request, $id)
    {

        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required'
        ]);

        $post = Post::query()->where('id', '=', $id)->first();
        if ($request->user()->cannot('update', $post)) {
            abort(403);
        }
        $post->title = $request->title;
        $post->body = $request->body;
        $post->category_id = $request->category_id;
        $post->save();

        $image = request()->file('image');
        if($image !== null) {
            $image->move(public_path('images'), $image->getClientOriginalName());

            $image = Image::query()->where('imageable_id', '=', $id)
                ->where('imageable_type', '=', "App\Models\Post")->first();
            if($image !== null) {
                $image->image_path = "images/" . request()->file('image')->getClientOriginalName();
                $image->save();
            }else{
                Image::create([
                    'image_path' => "images/" . request()->file('image')->getClientOriginalName(),
                    'imageable_id' => $post->id,
                    'imageable_type' => 'App\Models\Post'
                ]);
            }

        }
        return redirect()->route('home')->with('success', 'Project Updated Successfully!');

    }
    public function edit_post($post_id)
    {
        $post = Post::query()->where('id', '=', $post_id)->first();
        if(Auth::user()->id === $post->author->id|| Auth::user()->is_admin){
            $categories = Category::all();
            return view('edit_post', compact('post','categories'));
        }
        return redirect('/');

    }

    protected function validatePost(?Post $post = null): array
    {
        $post ??= new Post();

        return request()->validate([
            'title' => ['required', 'max:255'],
            'slug' => ['required', Rule::unique('posts', 'slug')->ignore($post)],
            'body' => 'required',
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'image' => 'mimes:jpeg,jpg,png,gif'
        ]);

    }



}

