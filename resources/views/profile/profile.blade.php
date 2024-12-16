@extends('profile.sidebar.sidebar')

@section('title', 'Profile')

@section('content')

<form action="{{ route('profile.update') }}" method="POST" class="profileForm" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="input_container">
        <div class="row">
            <div class="input_group">
                <label for="name">Name : </label>
                <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" placeholder="Your name">
            </div>
            <div class="input_group">
                <label for="Email">Email : </label>
                <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" placeholder="Your email">
            </div>
        </div>
        <div class="input_group" style="margin-top: 20px">
            <label for="bio">Bio : </label>
            <textarea name="bio" id="bio" cols="30" rows="10" placeholder="Your bio">{{ Auth::user()->bio ?? 'belum ada bio' }}</textarea>
        </div>

        <button type="submit" class="button" style="margin-top: 20px">Save</button>
    </div>

    <div class="image_container">
        <img id="profile_preview"
        src="{{ Auth::user()->profile_pic ? asset('storage/' . Auth::user()->profile_pic) : asset('images/profile/default-profile.png') }}"
        alt="Foto Profil" class="profile_preview">
        <img id="preview" src="#" alt="Preview Image" style="display: none;" class="profile_preview">

        <label for="profile_pic">
            Upload Gambar
        </label>
        <input type="file" class="form-control" id="profile_pic" name="profile_pic" accept="image/*" style="display: none">
    </div>
</form>

<script>
    const imageInput = document.getElementById('profile_pic');
    const upload = document.getElementById('profile_preview');
    const preview = document.getElementById('preview');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            // filePath.textContent = `File selected: ${file.name}`;

            const reader = new FileReader();
            reader.onload = function(event) {
            preview.src = event.target.result;
            preview.style.display = 'block';
            upload.style.display = 'none';
            }
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
            upload.style.display = 'flex'
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        const alert = document.getElementById('alert');
        if (alert) {
            // Tambahkan kelas active untuk memulai animasi turun
            setTimeout(() => {
                alert.classList.add('active');
            }, 100);

            // Hilangkan alert secara otomatis setelah 3 detik
            setTimeout(() => {
                alert.classList.remove('active');
                setTimeout(() => alert.remove(), 500); // Hapus elemen setelah animasi selesai
            }, 3000);
        }
    });
</script>

@endsection
