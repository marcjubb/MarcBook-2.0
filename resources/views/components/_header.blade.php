<header class="header">
    <div class="header-container">
        <a href="/" class="title">eMarc</a>
        <form method="GET" action="{{ route('home') }}">
            <label>
                <input type="text" name="search" placeholder="Search Products" value="{{ request('search') }}">
            </label>
            <input type="hidden" name="category" value="{{ request('category') }}">
            <input type="hidden" name="sort" value="{{ request('sort') }}">
        </form>

        <div class="header-buttons">


            @if(Auth::user() === null)
                <a href="/login" class="button"><i class="fa fa-user"></i>Login</a>
            @else
                @if(Auth::user()->is_admin)
                <a href="/orders" class="button"><i class="fa fa-user"></i>Orders</a>
                <a href="/admin" class="button"><i class="fa fa-user"></i>Admin Panel</a>
                @endif

                <a href="/basket" class="button"><i class="fa fa-shopping-basket"></i> Basket</a>
                <a href="/wishlist" class="button"><i class="fa fa-heart"></i> Wishlist</a>
                <a href="/profile" class="button"><i class="fa fa-user"></i>Profile</a>


                    <form method="POST" action="{{ route('logout') }}" class="fa fa-user">
                        @csrf
                        <button type="submit" class="button"><i class="fa fa-user"></i>Logout</button>
                    </form>
            @endif
        </div>
    </div>
</header>
