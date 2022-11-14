
<x-layout>
    @include ('components._header')
    <h1>Posts</h1>
        <main class="max-w-6xl mx-auto mt-6 lg:mt-20 space-y-6">
        @if ($posts -> count())

        @foreach ($posts as $post)

            <x-post-card
                :post="$post"
                class="{{ $loop -> iteration < 3 ? 'col-span-3' : 'col-span-2'}}"/>

        @endforeach
        @else
            <p class="text-center">No posts yet</p>
        @endif

            <h1>Comments</h1>
            @if ($comments -> count())

                @foreach ($comments as $comment)
                    <h3>Commented on {{$comment -> post -> title}}</h3>
                    <x-comment-card
                        :comment="$comment"/>

                @endforeach
            @else
                <p class="text-center">No comments yet</p>
            @endif

    </main>

</x-layout>

