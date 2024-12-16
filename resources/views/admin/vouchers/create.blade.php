@extends('admin.layout.sidebar')

@section('content')
<div class="container containerInput">
    <h1 style="margin-bottom: 20px"><button class="nav_button" onclick="goBack()"><i class="fa-solid fa-circle-chevron-left"></i></button> Tambah Voucher</h1>

    <form action="{{ route('admin.vouchers.store') }}" method="POST" class="formInput">
        @csrf

        <div class="input_container">
            <div class="input_group">
                <label for="voucher_code" class="form-label">Kode Voucher</label>
                <input type="text" class="form-control" name="voucher_code" required>
            </div>
            <div class="input_group">
                <label for="discount" class="form-label">Diskon (%)</label>
                <input type="number" class="form-control" name="discount" min="1" max="100" required>
            </div>
            <div class="input_group">
                <label for="expiry_date" class="form-label">Tanggal Kadaluarsa</label>
                <input type="date" class="form-control" name="expiry_date" required>
            </div>
            <div class="input_group">
                <label for="type">Jenis Voucher</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="general">General (Berlaku untuk semua menu)</option>
                    <option value="specific">Specific (Berlaku untuk menu tertentu)</option>
                </select>
            </div>
            <div class="input_group" id="menu-selection" style="display: none;">
                <label for="menu_id" class="form-label">Pilih Menu</label>
                <select name="menu_id" class="form-control">
                    <option value="" disabled selected>Tidak ada menu</option>
                    @foreach($menus as $menu)
                        <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="button">Simpan</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('type').addEventListener('change', function() {
        const menuSelection = document.getElementById('menu-selection');
        menuSelection.style.display = this.value === 'specific' ? 'block' : 'none';
    });
</script>
@endsection
