<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/profile/profile.css') }}">

    {{-- library --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
</head>
<body>

    @if (session('success'))
        <div class="custom-alert success" id="alert">
            {{ session('success') }}
            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
        </div>
    @endif

    <div class="profile_container">
        <div class="side">
            <div class="profile_detail">
                <img src="storage/{{ Auth::user()->profile_pic }}" alt="Profile Picture" class="cart"/>
                <div class="detail">
                    <h3>{{ Auth::user()->name }} @if (Auth::user()->premium_badge)
                        <i class="fa-solid fa-crown"></i>
                    @endif</h3>
                    <a href="{{ route('profile.show') }}">Edit profile</a>
                </div>
            </div>
            <nav>
                <a href="{{ route('profile.show') }}" class="{{ Route::is('profile.show') ? 'active' : '' }}"><i class="fa-regular fa-user"></i> Account</a>
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('yourMenu.show') }}" class="{{ Route::is('yourMenu.show') ? 'active' : '' }}"><i class="fa-solid fa-utensils"></i> Menu <p id="menu">{{ $totalMenus }}</p></a>
                @endif
                <a href="{{ route('yourOrder.show') }}" class="{{ Route::is('yourOrder.show') ? 'active' : '' }}"><i class="fa-solid fa-list"></i> Order <p id="order">{{ $orderCount }}</p></a>
                <a href="{{ route('home.show') }}"><i class="fa-solid fa-home"></i> Home</a>
            </nav>
        </div>

        <div class="container">
            <div class="title">
                <h3><i class="fa-solid fa-chevron-left" style="margin-right: 10px"></i> @yield('title')</h3>
                @if (request()->routeIs('yourMenu.show'))
                    <a href="{{ route('admin.dashboard') }}">Kelola</a>
                @endif
                @if (request()->routeIs('yourOrder.show'))
                    <a href="{{ route('order.show', Auth::user()->id) }}">See More</a>
                @endif
            </div>
            @yield('content')
        </div>
    </div>

</body>
</html>
