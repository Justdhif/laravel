@extends('components.app')

@section('content')
<section class="section">
    <div class="transaction">
        <div class="transaction_box">
            <div class="back" onclick="goBack()"><i class="fa-solid fa-chevron-left"></i> <h3>Transaction</h3></div>

            <div class="transaction_item">
                <div class="logo">
                    <h3>Dhif Store</h3>
                </div>
                <div class="transaction_detail">
                    <div class="detail">
                        <p>{{ $transaction->created_at }}</p>
                        <p>ID Transaksi: {{ $transaction->id }}</p>
                    </div>
                    <h3 class="status" style="font-weight: 500;"><i class="fa-solid fa-check-to-slot"></i>Success payment</h3>
                    <h3 class="status" style="font-size: 19px;">Buy Menu</h3>
                    <div class="total">
                        <h3>Total price :</h3>
                        <h3>Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</h3>
                    </div>
                    <div class="method">
                        <h3>Metode pembayaran :</h3>
                        <h3>via apk</h3>
                    </div>
                </div>
            </div>

            <div class="transaction_item" style="margin-top: 10px">
                <h3 style="margin-top: 10px">Transaction Detail</h3>
                @foreach ($transaction->items as $item)
                    <div class="menu_transaction">
                        <img src="{{ asset('storage/' . $item->menu->image) }}" alt="">
                        <div class="detail_menu">
                            <h3>{{ $item->menu->name }} : Rp. {{ number_format($item->price, 0, ',', '.') }}</h3>
                            <p>Quantity : {{  $item->quantity }} pcs</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="help">Need Help?</div>
        </div>
    </div>
</section>

<script>
    function goBack() {
        window.history.back();
    }
</script>
@endsection
