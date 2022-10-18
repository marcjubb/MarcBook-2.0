
<x-layout>

    <main class="max-w-6xl mx-auto mt-6 lg:mt-20 space-y-6">
        @if ($posts -> count())

        @foreach ($posts as $post)

            <x-post-card
                :post="$post"
                class="{{ $loop -> iteration < 3 ? 'col-span-3' : 'col-span-2'}}"/>

        @endforeach

        @else
            <p class="text-center">No posts yet. Check back later</p>
        @endif
    </main>

</x-layout>

