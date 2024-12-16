<aside class="side">
    <a href="{{ route('home.show') }}" class="logo">
        @if (request()->routeIs('home.show'))
            <i class="fa-solid fa-house"></i>
        @else
            <i class="fa-solid fa-house" style="opacity: .7"></i>
        @endif
        <h3>Dhif Store</h3>
    </a>
    <nav class="nav">
        <a href="{{ route('menu.search') }}" class="nav_link {{ Route::is('menu.search') ? 'active' : '' }}"><i class="fa-solid fa-magnifying-glass"></i> <h3>Search</h3></a>
        @if (Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="nav_link"><i class="fa-solid fa-server"></i> <h3>Dashboard</h3></a>
        @endif
        <a href="{{ route('order.show', Auth::user()->id) }}" class="nav_link {{ Route::is('order.show') ? 'active' : '' }}"><i class="fa-solid fa-money-bill-wheat"></i> <h3>Order</h3></a>
        <a href="{{ route('cart.index') }}" class="nav_link {{ Route::is('cart.index') ? 'active' : '' }}"><i class="fa-solid fa-cart-shopping"></i> <h3>Cart</h3></a>
        <a href="{{ route('premium.index') }}" class="nav_link {{ Route::is('premium.index') }}"><i class="fa-solid fa-rocket"></i> <h3>UpPro</h3></a>
    </nav>
</aside>
