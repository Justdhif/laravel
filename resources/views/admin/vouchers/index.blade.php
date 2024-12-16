@extends('admin.layout.sidebar')

@section('content')
<div class="container">
    <h1 style="margin-bottom: 20px"><button class="nav_button" onclick="goBack()"><i class="fa-solid fa-circle-chevron-left"></i></button> Voucher Menu</h1>

    <a href="{{ route('admin.vouchers.create') }}" class="button">Buat Voucher</a>
    <div class="table">
        <div class="head">
            <div class="box action">
                <h3>Kode voucher</h3>
            </div>
            <div class="box">
                <h3>Diskon</h3>
            </div>
            <div class="box">
                <h3>Menu</h3>
            </div>
            <div class="box">
                <h3>Expire</h3>
            </div>
            <div class="box action">
                <h3>Aksi</h3>
            </div>
        </div>
        @foreach($vouchers as $voucher)
        <div class="body_table voucher" style="background: #ccffcc">
            <div class="box action">
                <h3>{{ $voucher->voucher_code }}</h3>
            </div>
            <div class="box">
                <h3>{{ $voucher->discount }}%</h3>
            </div>
            <div class="box">
                <h3>{{ $voucher->menu->name ?? 'Tidak terkait dengan menu' }}</h3>
            </div>
            <div class="box">
                <h3>{{ $voucher->expiry_date }}</h3>
            </div>
            <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" class="box">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger"><i class="fa-solid fa-trash"></i></button>
            </form>
        </div>
        @endforeach
    </div>
</div>
@endsection
