@extends('components.app')

@section('title', 'Menu')

@section('content')

<section class="section">
    <div class="container menu_detail">
        <div class="detail_container">
            <div class="img">
                <img src="{{ asset('storage/' . $menu->image) }}" class="img-fluid" alt="{{ $menu->name }}" width="10px">
            </div>
            <div class="detail_menu">
                <button class="backHome" onclick="goBack()" style="cursor: pointer"><i class="fa-solid fa-house"></i></button>

                <h1>{{ $menu->name }} <span style="font-size: 12px; font-weight: 600">{{ $menu->category->category_name ?? 'Tidak ada kategori' }}</span></h1>
                {{-- <p>Kategori: </p> --}}
                <h1 class="price">Start to : Rp{{ number_format($menu->price, 0, ',', '.') }}</h1>
                <p>Tersedia : {{ $menu->stock > 0 ? $menu->stock : 'Habis' }}</p>
                <p class="desc">{{ $menu->description }}</p>

                @if($menu->vouchers->count() > 0 || $generalVouchers->count() > 0)

                    <h3>Voucher : </h3>
                    {{-- Voucher General --}}
                    @foreach($generalVouchers->take(3) as $voucher)
                        <div class="voucher_menu">
                            <div class="voucher_box">
                                <h3>discount : {{ $voucher->discount }}%</h3>
                                {{-- <h3>{{ $voucher->expiry_date }}</h3> --}}
                            </div>
                        </div>
                    @endforeach
                    {{-- Voucher Specific --}}
                    @foreach($menu->vouchers->take(3) as $voucher)
                        <div class="voucher_menu">
                            <div class="voucher_box">
                                <h3>discount : {{ $voucher->discount }}%</h3>
                                {{-- <h3>{{ $voucher->expiry_date }}</h3> --}}
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>Tidak ada voucher tersedia untuk menu ini.</p>
                @endif

                @if($menu->stock > 0)
                    <form action="{{ route('cart.add', $menu->id) }}" method="POST" class="cart_form">
                        @csrf
                        <input type="number" name="quantity" value="1" min="1" class="control">
                        <button type="submit" class="button"><i class="fa-solid fa-cart-shopping" style="margin-right: 10px;"></i> Tambah ke Keranjang</button>
                    </form>
                @else
                <button class="button" disabled>Stok Habis</button>
                @endif

            </div>
        </div>

        <div class="review">
            <div class="review_total">
                <span class="average-stars" style="font-size: 25px">
                    @php
                        $averageRating = round($menu->ratings->avg('rating'), 1);
                    @endphp

                    @for ($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= $averageRating ? 'filled' : '' }}"><i class="fa-solid fa-star"></i></span>
                    @endfor
                </span>
                <span>( {{ $menu->ratings->avg('rating') }} / 5 )</span>
                <span>( {{ $menu->ratings->count() }} Ulasan )</span>
            </div>
            <h3 id="rate" style="margin: 10px 0;">Beri penialaian</h3>
            @auth
                <form action="{{ route('menu.rate', $menu->id) }}" method="POST" enctype="multipart/form-data" class="rating_box">
                    @csrf
                    <div class="stars">
                        @for ($i = 5; $i >= 1; $i--)
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required />
                            <label for="star{{ $i }}" title="{{ $i }} bintang">
                                <i class="fa-solid fa-star"></i>
                            </label>
                        @endfor
                    </div>
                    <label for="review"><h3>Ulasan : </h3></label>
                    <textarea name="review" id="review" rows="3"></textarea>

                    <div class="file-input-container">
                        <h3 style="margin-bottom: 10px;">Upload image : </h3>
                        <div id="previewContainer" class="preview_container"></div>
                        <label class="custom-file-input" for="imageInput">
                            <input type="file" name="photos[]" id="imageInput" multiple accept="image/*" hidden>
                            <span>Upload Images</span>
                        </label>
                    </div>

                    <button type="submit" class="btn">Kirim</button>
                </form>
            @else
                <p><a href="{{ route('login') }}">Login</a> untuk memberikan penilaian.</p>
            @endauth
            <h3>Ulasan:</h3>
            @forelse($menu->ratings as $rating)
                <div class="review_box">
                    <div class="detail_review">
                        <img src="{{ asset('storage/' . $rating->user->profile_pic) }}" alt="" width="10px">
                        <strong>{{ $rating->user->name }}</strong>
                    </div>
                    <div style="margin: 5px 0;">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= $rating->rating ? 'filled' : '' }}"><i class="fa-solid fa-star"></i></span>
                        @endfor
                        ({{ $rating->rating }} / 5)
                    </div>
                    <p>{{ $rating->review }}</p>
                    @if ($rating->photos->count() > 0)
                        <div class="review_photo">
                            @foreach ($rating->photos as $photo)
                                <img src="{{ asset('storage/' . $photo->path) }}" alt="Foto ulasan" />
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <p>Belum ada ulasan.</p>
            @endforelse
        </div>
    </div>
</section>

<script>
    function goBack() {
        window.history.back();
    }

    document.addEventListener("DOMContentLoaded", () => {
        const imageInput = document.getElementById("imageInput");
        const previewContainer = document.getElementById("previewContainer");

        imageInput.addEventListener("change", (event) => {
            const files = event.target.files;

            // Clear existing previews
            previewContainer.innerHTML = "";

            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const previewItem = document.createElement("div");
                    previewItem.classList.add("preview-item");

                    const img = document.createElement("img");
                    img.src = e.target.result;
                    previewItem.appendChild(img);

                    const removeBtn = document.createElement("button");
                    removeBtn.classList.add("remove-btn");
                    removeBtn.textContent = "×";
                    removeBtn.addEventListener("click", () => {
                        previewItem.remove();

                        // Update input files
                        const updatedFiles = Array.from(imageInput.files).filter(
                            (_, i) => i !== index
                        );
                        const dataTransfer = new DataTransfer();
                        updatedFiles.forEach((file) => dataTransfer.items.add(file));
                        imageInput.files = dataTransfer.files;
                    });

                    previewItem.appendChild(removeBtn);
                    previewContainer.appendChild(previewItem);
                };
                reader.readAsDataURL(file);
            });
        });
    });

    document.getElementById('rate').addEventListener('click', () => {
        document.querySelector('.rating_box').classList.toggle('show');
    });

</script>
@endsection
