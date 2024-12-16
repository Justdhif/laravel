<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login</title>
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
        <form action="{{ route('post.login') }}" method="POST" enctype="multipart/form-data" class="form">
            @csrf
            <h2>Form Login</h2>
            <div class="input_container">
                <label for="email" class="label"><i class="fa-solid fa-envelope"></i></label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}" placeholder="Your Email">
            </div>
            @error('email')
                <div style="font-size: 12px; color: red;">{{ $message }}</div>
            @enderror
            <div class="input_container">
                <label for="password" class="label"><i class="fa-solid fa-lock"></i></label>
                <input type="password" name="password" id="password" required placeholder="Your Password">
            </div>
            @error('password')
                <div style="font-size: 12px; color: red;">{{ $message }}</div>
            @enderror
            <x-button>Login</x-button>
            <h3 style="margin-top: 5px">Follow me in :</h3>
            <div class="box_login">
                <div class="box">
                    <i class="fa-brands fa-google"></i>
                </div>
                <div class="box">
                    <i class="fa-brands fa-facebook"></i>
                </div>
                <div class="box">
                    <i class="fa-brands fa-google"></i>
                </div>
                <div class="box">
                    <i class="fa-brands fa-facebook"></i>
                </div>
            </div>
        </form>
        <div class="overlay">
            <div class="img">
                <img src="{{ asset('images/drink.png') }}" alt="">
            </div>
            <h1>Selamat Datang!!!</h1>
            <h3>Belum punya akun?</h3>
            <a href="{{ route('register') }}" class="btn">Register</a>
        </div>
    </div>
</body>
</html>
