<header class="header">
    <div class="left" style="display: flex; align-items: center; gap: 15px">
        <i class="fa-solid fa-bars" id="open" style="font-size: 25px"></i>
        <h3>@yield('title')</h3>
    </div>
    @if (request()->routeIs('menu.search'))
        <form action="{{ route('menu.search') }}" method="GET" class="input_search show">
            <label for="search" class="label_input"><i class="fa-solid fa-magnifying-glass"></i></label>
            <input type="search" name="query" id="search" placeholder="Search for new menu">
            <button type="submit">Search</button>
        </form>
    @else
        <form action="{{ route('menu.search') }}" method="GET" class="input_search">
            <label for="search" class="label_input"><i class="fa-solid fa-magnifying-glass"></i></label>
            <input type="search" name="query" id="search" placeholder="Search for new menu">
            <button type="submit">Search</button>
        </form>
    @endif
    <div class="user_content">
        <a href="{{ route('wishlist.show', Auth::user()->id) }}" class="cart">
            <i class="fa-solid fa-heart"></i>
            <div class="tooltip-text">Wishlist</div>
        </a>
        <a href="{{ route('cart.index') }}" class="cart">
            <i class="fa-solid fa-cart-shopping"></i>
            <div class="tooltip-text">Cart</div>
        </a>
        <img src="{{ asset('storage/' . Auth::user()->profile_pic) }}" alt="Picture" class="cart">
    </div>
</header>
