<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Premium Page</title>

    {{-- Library --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 20px;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: auto;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn[disabled] {
            opacity: 0.65;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Daftar Paket Premium</h2>

    {{-- Cek apakah user memiliki paket premium aktif --}}
    @if ($premiumPackage)
        <div class="alert alert-success">
            <h4>Paket Premium Aktif Anda:</h4>
            <p><strong>{{ $premiumPackage->name }}</strong></p>
            <p>Harga Sebelumnya: <strong>Rp {{ number_format($premiumPackage->price, 0, ',', '.') }}</strong></p>
            <p>Masa berlaku hingga: <strong>{{ \Carbon\Carbon::parse($premiumPackage->pivot->premium_expires_at)->format('d F Y') }}</strong></p>
        </div>
    @else
        <div class="alert alert-warning">
            <p>Anda belum memiliki paket premium.</p>
        </div>
    @endif

    {{-- Form untuk memilih paket dan melakukan pembelian --}}
    <form id="premiumForm" action="{{ route('premium.purchase', 0) }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Pilih Paket:</label>
            @foreach ($packages as $package)
                <div>
                    <input type="radio" id="package-{{ $package->id }}" name="package_id" value="{{ $package->id }}" data-price="{{ $package->price }}">
                    <label for="package-{{ $package->id }}">
                        {{ $package->name }} - Rp {{ number_format($package->price, 0, ',', '.') }}
                    </label>
                </div>
            @endforeach
        </div>

        <div class="form-group">
            <button type="submit" id="purchaseButton" class="btn btn-primary" disabled>Beli Sekarang</button>
        </div>
    </form>
</div>

<script>
    // Ambil elemen-elemen yang diperlukan
    const radioButtons = document.querySelectorAll('input[name="package_id"]');
    const purchaseButton = document.getElementById('purchaseButton');
    const premiumForm = document.getElementById('premiumForm');

    // Event listener untuk setiap radio button
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function () {
            const selectedPackage = document.querySelector('input[name="package_id"]:checked');
            const packageId = selectedPackage.value;
            const packagePrice = selectedPackage.getAttribute('data-price');

            if (packageId) {
                purchaseButton.disabled = false;
                purchaseButton.textContent = `Beli Sekarang - Rp ${new Intl.NumberFormat('id-ID').format(packagePrice)}`;

                // Update action form sesuai paket yang dipilih
                premiumForm.action = `{{ url('premium/purchase') }}/${packageId}`;
            } else {
                purchaseButton.disabled = true;
                purchaseButton.textContent = 'Beli Sekarang';
            }
        });
    });
</script>

</body>
</html>
