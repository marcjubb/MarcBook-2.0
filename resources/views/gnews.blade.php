<x-guest-layout>
{{ddd($articles)}}
    @foreach ($articles as $article )

       <h1>{{$article['title']}}</h1>
        <body>{{$article['description']}}</body>

    @endforeach

</x-guest-layout>
