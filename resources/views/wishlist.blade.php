@extends('components.app')

@section('title', 'Wishlist')

@section('content')

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
        <a href="{{ route('menu.search') }}" class="nav_link"><i class="fa-solid fa-magnifying-glass"></i> <h3>Search</h3></a>
        @if (Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="nav_link"><i class="fa-solid fa-server"></i> <h3>Dashboard</h3></a>
        @endif
        <a href="{{ route('order.show', Auth::user()->id) }}" class="nav_link"><i class="fa-solid fa-money-bill-wheat"></i> <h3>Order</h3></a>
        <a href="{{ route('cart.index') }}" class="nav_link"><i class="fa-solid fa-cart-shopping"></i> <h3>Cart</h3></a>
        <a href="{{ route('profile.show') }}" class="nav_link"><i class="fa-solid fa-user-secret"></i> <h3>{{ Auth::user()->name }}</h3></a>
        <div class="nav_link"><i class="fa-solid fa-rocket"></i> <h3>UpPro</h3></div>
    </nav>
</aside>

<section class="section">
    <x-header></x-header>

    <div class="container">
        <h2 id="title">Wishlist Anda</h2>

        <div class="recomended_box" style="margin-top: 20px;">
            @foreach($wishlists as $wishlist)
                <div class="recomended_item">
                    <div class="img">
                        @if($wishlist->menu->image)
                        <img src="{{ asset('storage/' . $wishlist->menu->image) }}" alt="{{ $wishlist->menu->name }}">
                        @else
                            <img src="{{ asset('images/default-menu.jpg') }}" alt="Gambar Default">
                        @endif
                    </div>
                    <div class="desc_content">
                        <h3>{{ $wishlist->menu->name }}</h3>
                        <div class="stock" style="background-color: @if($wishlist->menu->stock > 0) #ccffcc @else #ffcccc @endif;">
                            Tersedia : {{ $wishlist->menu->stock > 0 ? $wishlist->menu->stock : 'Stok Habis'}}
                        </div>
                        <div class="menu-rating">
                            <span class="average-rating">⭐ {{ number_format($wishlist->menu->ratings_avg_rating, 1) }}</span>
                            <span class="review-count">({{ $wishlist->menu->ratings_count }} Ulasan)</span>
                        </div>
                        <div class="bottom">
                            <h3>Rp. {{ $wishlist->menu->price }}</h3>
                            <form action="{{ route('wishlist.remove', $wishlist->menu->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="more" style="border: none"><i class="fa-solid fa-heart"></i></button>
                            </form>
                            <a href="{{ route('menu.show', $wishlist->menu->id) }}" class="more">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- <div class="row">
            @forelse($wishlists as $wishlist)
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ asset('storage/' . $wishlist->menu->image) }}" alt="{{ $wishlist->menu->name }}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">{{ $wishlist->menu->name }}</h5>
                            <p class="card-text">{{ $wishlist->menu->description }}</p>
                            <form action="{{ route('wishlist.remove', $wishlist->menu->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Hapus dari Wishlist</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p>Wishlist Anda kosong.</p>
            @endforelse
        </div> --}}
    </div>
</section>

@endsection
