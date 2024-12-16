@extends('components.app')

@section('title', 'home')

@section('content')

<x-sidebar></x-sidebar>

<section class="section">
    @if (session('success'))
        <div class="custom-alert success" id="alert">
            {{ session('success') }}
            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
        </div>
    @endif
    <header class="header">
        <div class="left" style="display: flex; align-items: center; gap: 15px">
            <i class="fa-solid fa-bars" id="open" style="font-size: 25px"></i>
            <h3>Home</h3>
        </div>
        <form action="{{ route('menu.search') }}" method="GET" class="input_search">
            <label for="search" class="label_input"><i class="fa-solid fa-magnifying-glass"></i></label>
            <input type="search" name="search" id="search" placeholder="Search for new menu">
            <button type="submit">Search</button>
        </form>
        <div class="user_content">
            <a href="{{ route('wishlist.show', Auth::user()->id) }}" class="cart">
                <i class="fa-solid fa-heart"></i>
                @if ($totalWishlist > 0)
                    <h3 class="total">{{ $totalWishlist }}</h3>
                @endif
                <div class="tooltip-text">Wishlist</div>
            </a>
            <a href="{{ route('cart.index') }}" class="cart">
                <i class="fa-solid fa-cart-shopping"></i>
                @if ($totalCart > 0)
                    <h3 class="total">{{ $totalCart }}</h3>
                @endif
                <div class="tooltip-text">Cart</div>
            </a>
            <div class="img_content">
                <img src="{{ asset('storage/' . Auth::user()->profile_pic) }}" alt="Picture" class="cart">
                <div class="img_box">
                    <a href="{{ route('profile.show', Auth::user()->id) }}" class="item_acc"><i class="fa-regular fa-user"></i> {{ Auth::user()->name }}</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="item_acc">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="menuFav_container">
            <div class="fav_container">
                <div class="fav_wrapper">
                    <div class="fav_box mySwiper">
                        <div class="fav_content swiper-wrapper">
                            <div class="fav_slide swiper-slide">
                                <div class="banner">
                                    Populer!!!
                                </div>
                                <div class="img">
                                    <img src="{{ asset('images/burger.png') }}" alt="">
                                </div>
                                <div class="desc_menu">
                                    <h1>Burger King</h1>
                                    <h3>Rp. 50.000</h3>
                                    <div class="dsc_content">
                                        <div class="dsc_box">
                                            <h3><i class="fa-solid fa-ticket"></i> 15%</h3>
                                        </div>
                                        <div class="dsc_box">
                                            <h3><i class="fa-solid fa-user"></i> 100+</h3>
                                        </div>
                                        <div class="dsc_box">
                                            <h3><i class="fa-solid fa-star"></i> 4.9</h3>
                                        </div>
                                    </div>
                                    <a href="" class="button">Beli sekarang</a>
                                </div>
                            </div>
                            <div class="fav_slide sec swiper-slide">
                                <div class="banner">
                                    Populer!!!
                                </div>
                                <div class="img">
                                    <img src="{{ asset('images/drink.png') }}" alt="">
                                </div>
                                <div class="desc_menu">
                                    <h1>Es Teller</h1>
                                    <h3>Rp. 30.000</h3>
                                    <div class="dsc_content">
                                        <div class="dsc_box">
                                            <h3><i class="fa-solid fa-ticket"></i> 20%</h3>
                                        </div>
                                        <div class="dsc_box">
                                            <h3><i class="fa-solid fa-user"></i> 50+</h3>
                                        </div>
                                        <div class="dsc_box">
                                            <h3><i class="fa-solid fa-star"></i> 4.7</h3>
                                        </div>
                                    </div>
                                    <a href="" class="button">Beli sekarang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ad_container">
                <div class="voucher" id="content">
                    <h1 id="greeting">Selamat Datang!</h1>
                    <h2 id="clock">00:00:00</h2>
                    <div id="celestial"></div>
                </div>
                <div class="voucher sec">
                    <div class="voucher_content">
                        <div class="desc">
                            <h1>Pilih Lokal</h1>
                            <h3>Tempat belanja barang lokal</h3>
                        </div>
                        <div class="voucher_box">
                            <div class="star">
                                <i class="fa-solid fa-star-of-life"></i>
                                <i class="fa-solid fa-star-of-life"></i>
                                <i class="fa-solid fa-star-of-life"></i>
                            </div>
                            <div class="text">
                                <div class="desc">
                                    <h3>Semua produk lokal</h3>
                                    <h3>MAKIN MURAH UP TO</h3>
                                </div>
                                <h1>15%</h1>
                            </div>
                            <div class="star">
                                <i class="fa-solid fa-star-of-life"></i>
                                <i class="fa-solid fa-star-of-life"></i>
                                <i class="fa-solid fa-star-of-life"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="user_saldo">
            <p><i class="fa-solid fa-wallet" style="margin-right: 10px;"></i> Rp {{ number_format(Auth::user()->saldo, 0, ',', '.') }}</p>
            <div class="btn_topup" id="topup">
                <i class="fa-solid fa-money-bill-wheat" style="margin-right: 10px;"></i> Topup
            </div>
        </div>

        <div class="saldo_modal">
            <i class="fa-solid fa-xmark" id="xmark"></i>
            <div class="modal">
                <h3 style="font-size: 20px;">Top up</h3>
                <form action="{{ route('saldo.topup.process') }}" method="POST" class="formTopup">
                    @csrf
                    <div class="radio-container">
                        <label class="radio-label">
                            <input type="radio" name="nominal" value="50000">
                            <span class="custom-radio">
                                <div class="circle"></div>
                                Rp 50.000
                            </span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="nominal" value="100000">
                            <span class="custom-radio">
                                <div class="circle"></div>
                                Rp 100.000
                            </span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="nominal" value="150000">
                            <span class="custom-radio">
                                <div class="circle"></div>
                                Rp 150.000
                            </span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="nominal" value="200000">
                            <span class="custom-radio">
                                <div class="circle"></div>
                                Rp 200.000
                            </span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="nominal" value="250000">
                            <span class="custom-radio">
                                <div class="circle"></div>
                                Rp 250.000
                            </span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="nominal" value="300000">
                            <span class="custom-radio">
                                <div class="circle"></div>
                                Rp 300.000
                            </span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="nominal" value="350000">
                            <span class="custom-radio">
                                <div class="circle"></div>
                                Rp 350.000
                            </span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="nominal" value="400000">
                            <span class="custom-radio">
                                <div class="circle"></div>
                                Rp 400.000
                            </span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="nominal" value="450000">
                            <span class="custom-radio">
                                <div class="circle"></div>
                                Rp 450.000
                            </span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="nominal" value="500000">
                            <span class="custom-radio">
                                <div class="circle"></div>
                                Rp 500.000
                            </span>
                        </label>
                    </div>

                    <div class="button_content">
                        <button type="submit" class="button">Top Up</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="menu_instant">
            @foreach ($menus->take(14) as $menu )
                <div class="menu">
                    <img src="{{ asset('storage/' . $menu->image) }}" class="img" alt="{{ $menu->menu_name }}" width="10px">

                    <a href="{{ route('menu.show', $menu->id) }}" class="more"><i class="fa-solid fa-eye"></i></a>
                </div>
            @endforeach
        </div>

        <div class="categories-navbar">
            <ul>
                <li class="category-item active" data-category="all">All</li>
                @foreach ($categories as $category)
                    <li class="category-item" data-category="{{ $category->id }}">{{ $category->category_name }}</li>
                @endforeach
            </ul>
        </div>

        <div class="recomended">
            <div class="recomended_box">
                @foreach ($menus as $menu)
                    <div class="recomended_item menu-item" data-category="{{ $menu->category_id }}">
                        <div class="img">
                            @if($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}" alt="Gambar Menu">
                            @else
                                <img src="{{ asset('images/default-menu.jpg') }}" alt="Gambar Default">
                            @endif

                            @if ($menu->vouchers->count() > 0)
                                @foreach ($menu->vouchers->take(3) as $voucher)
                                    <div class="voucher">
                                        <h3>{{ $voucher->discount }}%</h3>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="desc_content">
                            <h3>{{ $menu->name }}</h3>
                            <div class="stock" style="background-color: @if($menu->stock > 0) #ccffcc @else #ffcccc @endif;">
                                Tersedia : {{ $menu->stock > 0 ? $menu->stock : 'Stok Habis'}}
                            </div>
                            <div class="menu-rating">
                                <span class="average-rating">⭐ {{ number_format($menu->average_rating, 1) }}</span>
                                <span class="review-count">({{ $menu->review_count }} Ulasan)</span>
                            </div>
                            <div class="bottom">
                                @if ($menu->discount_price)
                                    <span class="text-muted"><s>Rp {{ number_format($menu->price, 0, ',', '.') }}</s></span>
                                    <span>Rp {{ number_format($menu->discount_price, 0, ',', '.') }}</span>
                                @else
                                    <span>Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                @endif
                                <div class="btn_content" style="display: flex; align-items: center; gap: 10px;">
                                    @php
                                        $isInWishlist = \App\Models\Wishlist::where('user_id', auth()->id())
                                            ->where('menu_id', $menu->id)
                                            ->exists();
                                    @endphp
                                    @if($isInWishlist)
                                        <form action="{{ route('wishlist.remove', $menu->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="more" style="border: none"><i class="fa-solid fa-heart"></i></button>
                                        </form>
                                    @else
                                        <form action="{{ route('wishlist.add', $menu->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="more" style="border: none"><i class="fa-regular fa-heart"></i></button>
                                        </form>
                                    @endif
                                    <a href="{{ route('menu.show', $menu->id) }}" class="more">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<script>
    const iconOpen = document.getElementById('open');
    const side = document.querySelector('.side');

    const label = document.querySelector('.label_input');
    const search = document.querySelector('.input_search');

    label.addEventListener('click', function() {
        search.classList.toggle('show');
    });

    iconOpen.addEventListener('click', function() {
        side.classList.toggle('active');

        if (side.classList.contains('active')) {
            iconOpen.classList.remove('fa-bars');
            iconOpen.classList.add('fa-xmark');
        } else {
            iconOpen.classList.remove('fa-xmark');
            iconOpen.classList.add('fa-bars');
        }
    });

    document.getElementById('topup').addEventListener('click', function () {
        document.querySelector('.saldo_modal').classList.add('active');
        document.querySelector('section').style.overflow = 'hidden';
    });

    document.getElementById('xmark').addEventListener('click', function () {
        document.querySelector('.saldo_modal').classList.remove('active');
        document.querySelector('section').style.overflow = '';
    });

    document.addEventListener('DOMContentLoaded', () => {
        const alert = document.getElementById('alert');
        if (alert) {
            // Tambahkan kelas active untuk memulai animasi turun
            setTimeout(() => {
                alert.classList.add('active');
            }, 100);

            // Hilangkan alert secara otomatis setelah 3 detik
            setTimeout(() => {
                alert.classList.remove('active');
                setTimeout(() => alert.remove(), 500); // Hapus elemen setelah animasi selesai
            }, 3000);
        }

        const categoryItems = document.querySelectorAll('.category-item');
        const menuItems = document.querySelectorAll('.menu-item');

        categoryItems.forEach(categoryItem => {
            categoryItem.addEventListener('click', function() {
                const selectedCategory = this.dataset.category;

                // Remove active class from all categories and set to the selected one
                categoryItems.forEach(item => item.classList.remove('active'));
                this.classList.add('active');

                // Show/hide menu items based on the selected category
                menuItems.forEach(menuItem => {
                    if (selectedCategory === 'all' || menuItem.dataset.category === selectedCategory) {
                        menuItem.style.display = 'block';
                    } else {
                        menuItem.style.display = 'none';
                    }
                });
            });
        });

    });

</script>
@endsection
