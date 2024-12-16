<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">

    {{-- library --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

</head>
<body>

    <aside class="side">
        <a href="{{ route('home.show') }}" class="logo"><i class="fa-solid fa-house"></i> <h3>Dhif Store</h3></a>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}" class="nav_link active"><i class="fa-solid fa-server"></i> <h3>Dashboard</h3></a>
            <a href="{{ route('admin.menus.create') }}" class="nav_link"><i class="fa-solid fa-plus"></i> <h3>Create</h3></a>
            <a href="{{ route('menus.index') }}" class="nav_link"><i class="fa-solid fa-list"></i> <h3>Category</h3></a>
            <a href="{{ route('admin.track') }}" class="nav_link"><i class="fa-solid fa-chart-line"></i> <h3>Track</h3></a>
            <div class="nav_link"><i class="fa-solid fa-rocket"></i> <h3>UpPro</h3></div>
        </nav>
    </aside>

    <section class="section">
        @yield('content')
    </section>

    <script src="{{ asset('js/admin/adminJs.js') }}"></script>

    <script>
        const iconOpen = document.getElementById('open');
        const side = document.querySelector('.side');

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

</body>
</html>
