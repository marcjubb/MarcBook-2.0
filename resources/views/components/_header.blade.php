<header class="header">
    <div class="header-container">
        <a href="/" class="title">eMarc</a>
        <form method="GET" action="/" class="search-bar">
            <input type="text" name="search" placeholder="Search Products" value="{{ request('search') }}">
        </form>
        <div class="header-buttons">
            <a href="#" class="button"><i class="fa fa-shopping-basket"></i> Basket</a>
            <a href="#" class="button"><i class="fa fa-heart"></i> Wishlist</a>
            <a href="#" class="button"><i class="fa fa-user"></i> Profile</a>
        </div>
    </div>
</header>
