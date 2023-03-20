
<h1>MarcBook</h1>
<label>
    <form method="GET" action="/">
        <input type="text"
               name="search"
               placeholder="Search Posts"
               value="{{ request('search') }}"
        >
    </form>

    @if(!auth()->user()==null)
    <form method="GET" action="/user/post/create">
        <button>Create Post</button>
    </form>
        @endif


</label>
