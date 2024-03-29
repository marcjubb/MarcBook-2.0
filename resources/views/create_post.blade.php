<x-guest-layout>
<!DOCTYPE html>
<html lang="en">
<body>
<h1 class="text-center">Create Post</h1>
<hr>
<div class=" mt-2 ">
    <form action="{{route('user.post.publish_post')}}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group m-3 p-3">
            <label for="title">Post Title</label>
            <label>
                <input class="form-control" type="text" name="title" value="">
            </label>
        </div>

        <div class="form-group m-3 p-3">
            <label for="body">Post body</label>
            <label>
                <textarea class="form-control" name="body" cols="40" rows="5"></textarea>
            </label>
        </div>

        <div class="form-group m-3 p-3">
            <label for="body">Post Slug</label>
            <label>
                <textarea class="form-control" name="slug" cols="40" rows="5"></textarea>
            </label>
        </div>

        <div class="form-group m-3 p-3">
            <label for="body">image</label>
            <label>
                <input class="form-control" name="image" type="file" >
            </label>
        </div>

        <div class="form-group m-3 p-3">
            <label for="category_id">Category</label>
            <select class="form-control" name="category_id" id="category_id">
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>

        <button  type="submit" value="submit">Publish Post</button>
    </form>

</div>

</body>
</html>
    </x-guest-layout>
