@extends('profile.sidebar.sidebar')

@section('title', 'Your order')

@section('content')

<div class="your_order">
    <h3>Your Orders</h3>
    @if ($orders->isEmpty())
        <p>No orders placed yet.</p>
    @else
        <ul>
            @foreach ($orders as $order)
                <li>Order #{{ $order->id }} - Total: Rp {{ number_format($order->total_price, 2) }}</li>
            @endforeach
        </ul>
    @endif
</div>

@endsection
