{{--

    @foreach ($recommendations as $recommendation)
        <p>Item ID: {{  $recommendation['item_id'] }}</p>
        <p>Score: {{ $recommendation['score'] }}</p>
    @endforeach
--}}


<p>Item ID: {{  $recommendation }}</p>
<p>Score: {{ $recommendation['score'] }}</p>


