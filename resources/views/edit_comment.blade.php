<!DOCTYPE html>
<html lang="en">
<body>
<h1 class="text-center">Edit Comment</h1>
<hr>
<div class=" mt-2 ">
    <form action="{{route('user.comment.update_comment', $comment->id)}}" method="POST" enctype="multipart/form-data">
        @csrf



        <div class="form-group m-3 p-3">
            <label for="body">Comment body</label>
            <label>
                <textarea class="form-control" name="body" cols="40" rows="5">{{$comment->body}}</textarea>
            </label>
        </div>

        <button  type="submit" value="submit">Update Comment</button>
    </form>

</div>

</body>
</html>
