@extends('components.app')

@section('title', 'Cart')

@section('content')

<x-sidebar></x-sidebar>

<section class="section">
    <x-header></x-header>

    <div class="container">
        <h1 id="title">Keranjang</h1>
        <form action="{{ route('checkout.process') }}" method="POST" class="box_container">
            @csrf
            <div class="box_content">
                <div class="produk">
                    <h3>Produk</h3>
                </div>
                <div class="desc">
                    <h3 class="box">Nama</h3>
                    <h3 class="box">Harga</h3>
                    <h3 class="box">Quantity</h3>
                    <h3 class="box">Total</h3>
                    <h3 class="box">Aksi</h3>
                </div>
            </div>
            @foreach ($cartItems as $item)
                <div class="box_content" style="margin-top: 15px">
                    <div class="produk">
                        <img src="{{ asset('storage/' . $item->menu->image) }}" alt="{{ $item->menu->name }}" style="width: 100px; height: 100px; border-radius: .3rem; object-fit: cover;">
                    </div>
                    <div class="desc">
                        <h3 class="box">{{ $item->menu->name }}</h3>
                        <h3 class="box">Rp {{ number_format($item->menu->price, 2) }}</h3>
                        <div class="quantity-control box">
                            <button type="button" class="decrement"> -</button>
                            <input
                                type="number"
                                name="items[{{ $item->id }}][quantity]"
                                value="{{ $item->quantity }}"
                                min="1"
                                class="quantity-input box"
                                data-price="{{ $item->menu->price }}"
                                data-id="{{ $item->id }}" style="width: 50px">
                            <button type="button" class="increment">+</button>
                        </div>
                        <h3 id="total-{{ $item->id }}" class="box">Rp {{ number_format($item->menu->price * $item->quantity, 2) }}</h3>
                    </div>
                </div>
            @endforeach

            <div class="checkout">
                <h3>Total Jumlah Menu: <span id="total-selected">0</span></h3>
                <h3>Total Harga: <span id="grand-total">Rp {{ number_format($cartItems->sum(fn($item) => $item->menu->price * $item->quantity), 2) }}</span></h3>
                <button type="submit">Checkout</button>
            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const quantityInputs = document.querySelectorAll('.quantity-input');
        const decrementButtons = document.querySelectorAll('.decrement');
        const incrementButtons = document.querySelectorAll('.increment');
        const totalSelectedElement = document.getElementById('total-selected');
        const grandTotalElement = document.getElementById('grand-total');
        let cartItems = Array.from(quantityInputs).map(input => ({
            id: input.dataset.id,
            price: parseFloat(input.dataset.price),
            quantity: parseInt(input.value),
        }));

        // Update total jumlah menu yang dipilih
        function updateTotalSelected() {
            const selectedCount = cartItems.filter(item => item.quantity > 0).length;
            totalSelectedElement.textContent = selectedCount;
        }

        // Update total harga (grand total)
        function updateGrandTotal() {
            let total = 0;
            cartItems.forEach(item => {
                if (item.quantity > 0) {
                    total += item.price * item.quantity;
                }
            });
            grandTotalElement.textContent = `Rp ${total.toLocaleString('id-ID')}`;
        }

        // Event listener untuk tombol decrement
        decrementButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                const input = quantityInputs[index];
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                    cartItems[index].quantity = parseInt(input.value);
                    updateTotalSelected();
                    updateGrandTotal();
                }
            });
        });

        // Event listener untuk tombol increment
        incrementButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                const input = quantityInputs[index];
                input.value = parseInt(input.value) + 1;
                cartItems[index].quantity = parseInt(input.value);
                updateTotalSelected();
                updateGrandTotal();
            });
        });

        // Event listener untuk input manual pada quantity
        quantityInputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (parseInt(input.value) < 1) {
                    input.value = 1;
                }
                cartItems[index].quantity = parseInt(input.value);
                updateTotalSelected();
                updateGrandTotal();
            });
        });

        // Inisialisasi awal
        updateTotalSelected();
        updateGrandTotal();
    });

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
