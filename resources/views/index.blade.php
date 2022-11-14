   @include ('components._header')

    <main>
        @if ($posts -> count())
            @foreach ($posts as $post)
                <x-post-card
                    :post="$post"
                    class="{{ $loop -> iteration < 3 ? 'col-span-3' : 'col-span-2'}}"/>

            @endforeach
        @else
            <p class="text-center">No posts yet</p>
        @endif
    </main>
