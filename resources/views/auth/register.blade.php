<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi</title>
    <link rel="stylesheet" href="{{ asset('css/authCss/auth.css') }}">

    {{-- library --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
</head>
<body>
    <div class="container">
        <div class="overlay">
            <div class="img">
                <img src="{{ asset('images/burger.png') }}" alt="">
            </div>
            <h1>Selamat Datang!!!</h1>
            <h3>Sudah punya akun?</h3>
            <a href="{{ route('login') }}" class="btn">Login</a>
        </div>
        <form action="{{ route('post.register') }}" method="POST" enctype="multipart/form-data" class="form">
            <h2>Form Registrasi</h2>
            @csrf
            <div class="input_container">
                <label for="name" class="label"><i class="fa-solid fa-user"></i></label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="Your Name">
                @error('name')
                    <div>{{ $message }}</div>
                @enderror
            </div>
            <div class="input_container">
                <label for="email" class="label"><i class="fa-solid fa-envelope"></i></label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}" placeholder="Your Email">
                @error('email')
                    <div>{{ $message }}</div>
                @enderror
            </div>
            {{-- <div>
                <label for="profile_pic">Profile Picture (Opsional):</label>
                <input type="file" name="profile_pic" id="profile_pic" accept="image/*">
                @error('profile_pic')
                    <div>{{ $message }}</div>
                @enderror
            </div> --}}
            <div class="input_container">
                <label for="password" class="label"><i class="fa-solid fa-lock"></i></label>
                <input type="password" name="password" id="password" required placeholder="Your Password">
                @error('password')
                    <div>{{ $message }}</div>
                @enderror
            </div>
            <div class="input_container">
                <label for="password_confirmation" class="label"><i class="fa-solid fa-lock"></i></label>
                <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Confirm Password">
            </div>
            <div>
                <label for="role">Role:</label>
                <select name="role" id="role" required>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="pembeli" {{ old('role') == 'pembeli' ? 'selected' : '' }}>Pembeli</option>
                </select>
                @error('role')
                    <div>{{ $message }}</div>
                @enderror
            </div>
            <x-button>Register</x-button>
        </form>
    </div>
</body>
</html>
