@extends('components.app')

@section('title', 'Order')

@section('content')

<x-sidebar></x-sidebar>

<section class="section">
    <x-header></x-header>

    <div class="container">
        <h1 id="title">Pesanan Saya</h1>

        @if ($orders && $orders->isNotEmpty())
            <div class="order_grid">
                @foreach ($orders as $order)
                    <div class="order_card">
                        <h2>Id pesanan #{{ $order->id }}</h2>
                        <p><strong>Total Harga:</strong> Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
                        <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>

                        <div class="items" style="margin-top: 20px;">
                            <h3>Item Pesanan:</h3>
                            @foreach ($order->items as $item)
                                <div class="items_detail">
                                    <img src="{{ asset('storage/' . $item->menu->image) }}" alt="">
                                    <div class="details">
                                        <h3>{{ $item->menu->name }} (x{{ $item->quantity }})</h3>
                                        <p>Harga: Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <a href="{{ route('transactions.show', $order->id) }}" class="button">more</a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="no-orders">Anda belum memiliki pesanan.</p>
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
