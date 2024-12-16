@extends('components.app')

@section('title', 'Search')

@section('content')

<x-sidebar></x-sidebar>

<section class="section">
    <x-header></x-header>

    <div class="container">
        @if(!request('query') && empty(request('category')) && !empty($searchHistory))
            <div class="search_history" style="margin-bottom: 30px;">
                <h1>Riwayat Pencarian :</h1>
                <div class="search_list">
                    @foreach($searchHistory as $history)
                    <a href="{{ route('menu.search', ['query' => $history]) }}" class="history_box">
                        <h3>{{ $history }}</h3>
                        <form action="{{ route('menu.clearHistory') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-xmark"></i></button>
                        </form>
                    </a>
                        {{-- <a href="{{ route('menu.search', ['query' => $history]) }}">{{ $history }}</a> --}}
                    @endforeach
                </div>
                {{-- <ul style="list-style: none; padding: 0; display: flex; gap: 10px;">
                    @foreach($searchHistory as $history)
                        <li>
                            <a href="{{ route('menu.search', ['query' => $history]) }}"
                            style="text-decoration: none; padding: 5px 10px; border: 1px solid #ddd; border-radius: 5px; background: #f0f0f0;">
                                {{ $history }}
                            </a>
                        </li>
                    @endforeach
                </ul> --}}
            </div>
        @endif

        @if(isset($menus) && $menus->isEmpty())
            <p class="text-center">Tidak ada menu yang ditemukan.</p>
        @elseif(isset($menus))
            <div class="recomended_box">
                @foreach ($menus as $menu )
                    <div class="recomended_item">
                        <div class="img">
                            @if($menu->image)
                            <img src="{{ asset('storage/' . $menu->image) }}" alt="Gambar Menu">
                            @else
                                <img src="{{ asset('images/default-menu.jpg') }}" alt="Gambar Default">
                            @endif

                            @if ($menu->vouchers->count() > 0)
                                @foreach ($menu->vouchers->take(3) as $voucher )
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
                            <div class="bottom">
                                <h3>Rp. {{ $menu->price }}</h3>
                                <a href="{{ route('menu.show', $menu->id) }}" class="more">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
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
</script>

@endsection
