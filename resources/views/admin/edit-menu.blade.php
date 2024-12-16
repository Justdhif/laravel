@extends('admin.layout.sidebar')

@section('title', 'edit-menu.admin')

@section('content')
    <div class="container">
        <h1 style="margin-bottom: 20px"><button class="nav_button" onclick="goBack()"><i class="fa-solid fa-circle-chevron-left"></i></button> Edit Menu</h1>

        <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="formInput">
            @csrf
            @method('PUT')
            <!-- Input lainnya -->

            <div class="input_container">
                <div class="input_group">
                    <label for="category_id">Kategori:</label>
                    <select name="category_id">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $menu->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="input_group">
                    <label for="name">Nama:</label>
                    <input type="text" name="name" value="{{ old('name', $menu->name) }}" required>
                </div>

                <div class="input_group">
                    <label for="description">Deskripsi:</label>
                    <textarea name="description">{{ $menu->description }}</textarea>
                </div>

                <div class="input_group large">
                    <label for="price">Harga:</label>
                    <input type="number" name="price" value="{{ $menu->price }}" step="0.01" required>
                </div>

                <div class="input_group">
                    <label for="stock">Stok:</label>
                    <input type="number" name="stock" value="{{ $menu->stock }}" min="0" required>
                </div>

                <button type="submit" class="button add_menu">Edit Menu</button>
            </div>

            <div class="image">
                <label for="image">
                    <div class="image_container">
                        @if($menu->image)
                            <p>Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $menu->image) }}" alt="Gambar Menu" style="width: 100px; height: 100px;" id="upload">
                        @endif
                        <img id="preview" src="#" alt="Preview Image" style="display: none;">
                        <p id="filePath">No file chosen</p>

                    </div>
                </label>
                <input type="file" name="image" id="image" accept="image/*" style="display: none;">
            </div>
        </form>
    </div>

    <script>
        const imageInput = document.getElementById('image');
        const filePath = document.getElementById('filePath');
        const preview = document.getElementById('preview');
        const upload = document.getElementById('upload');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                filePath.textContent = `File selected: ${file.name}`;

                const reader = new FileReader();
                reader.onload = function(event) {
                preview.src = event.target.result;
                preview.style.display = 'block';
                upload.style.display = 'none';
                }
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
                upload.style.display = 'block';
            }
        });
    </script>
@endsection
