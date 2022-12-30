<x-guest-layout>

   @include ('components._header')

    <main>
        <button>
            <a class="btn btn-primary" href="{{route('send.notification')}}">Send Notification</a>
        </button>
        @if(!auth()->user()==null)
        <h1>Notifications:

        @if (auth()->user()->notifications -> count())
            @foreach (auth()->user()->notifications as $notification)
                   <h3>You have recieved a comment: {{ $notification->data['body']}}</h3>
                <h4>This was commented on post:</h4>
                    @php
                $id = $notification->data['comment_id'];
                $post = \App\Models\Comment::query()->where('id','=',$id )->first()->post;
                @endphp
                    <a href="/posts/{{$post -> slug }}">
                        <h3 class="font-bold">
                            {{$post->title}}</h3>
                    </a>


            @endforeach
                <button>
                    <a class="btn btn-primary" href="{{route('clear.notifications')}}">Clear Notifications</a>
                </button>

            @endif

        @endif


        <h1>Category Selection:</h1>
        @if ($categories -> count())
            @foreach ($categories as $category)
                <a href="/category/{{$category -> slug }}">
                    <h3 class="font-bold">{{$category -> name}}</h3>
                </a>
            @endforeach
        @else
            <p class="text-center">No Categories</p>
        @endif
        <h1>All posts :</h1>
        @if ($posts -> count())
            @foreach ($posts as $post)
                <x-post-card
                    :post="$post"
                    class="{{ $loop -> iteration < 3 ? 'col-span-3' : 'col-span-2'}}"/>
            @if(!auth()->user()==null)
                @if($post->author == auth()->user()|| auth()-> user()->is_admin)
                    <button>
                        <a class="btn btn-primary" href="{{route('user.post.edit', $post->id)}}">Edit</a>
                    </button>
                @endif
                @endif
            @endforeach
        @else
            <p class="text-center">No posts yet</p>
        @endif
    </main>
    </x-guest-layout>
