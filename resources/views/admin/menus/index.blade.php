<!-- resources/views/menus/index.blade.php -->

@extends('admin.layout.sidebar')

@section('title', 'Menu')

@section('content')
    <div class="container">
        <h1 style="margin-bottom: 20px;">Menu Makanan</h1>

        <!-- Menampilkan kategori -->
        @foreach($categories as $category)
            <h2 style="font-size: 15px; margin-bottom: 20px;">{{ $category->category_name }}</h2>

            <div class="row_content">
                <!-- Menampilkan menu berdasarkan kategori -->
                @foreach($category->menus as $menu)
                    <a href="{{ route('menu.show', $menu->id) }}" class="row_box">
                        @if($menu->image)
                            <img src="{{ asset('storage/' . $menu->image) }}" alt="Gambar Menu">
                        @else
                            <img src="{{ asset('images/default-menu.jpg') }}" alt="Gambar Default">
                        @endif
                        <div class="desc">
                            <h3 class="card-title">{{ $menu->name }}</h3>
                            <p class="card-text">{{ $menu->description }}</p>
                            <p class="card-text">Rp {{ number_format($menu->price, 2) }}</p>
                            <p class="card-text">Stok: {{ $menu->stock }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
