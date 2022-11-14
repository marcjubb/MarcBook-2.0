
<x-layout>
    <main class="max-w-6xl mx-auto mt-6 lg:mt-20 space-y-6">

            <label>

                <input type="text"
                       name="comment"
                       placeholder="Comment"
                       value="{{ request('comment') }}"
                >
            </label>

        @if ($comment -> count())
            @foreach ($comments as $comment)
                <x-comment-card
                    :comment="$comment"/>
            @endforeach
        @else
            <p class="text-center">No Comments yet. Check back later</p>
        @endif

    </main>

</x-layout>

