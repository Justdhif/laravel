<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>welcome</title>

    <link rel="stylesheet" href="{{ asset('css/landing_page.css') }}">

    {{-- library --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
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

    <div class="carousel">
        <div class="header">
            <div class="logo">
                <h1>Dhif Store</h1>
            </div>

            <div class="btn_content" style="display: flex; gap: 10px; align-items: center;">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('home.show') }}" class="nav_button">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="nav_button">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="nav_button">Register</a>
                        @endif
                    @endauth
                @endif

                <div class="nav_button chat" id="chat">
                    <i class="fa-solid fa-comment-dots"></i>
                </div>
            </div>
        </div>

        <div class="bg_box">
            <div class="bg active"></div>
            <div class="bg"></div>
            <div class="bg"></div>
            <div class="bg"></div>
        </div>

        <div class="img_box">
            <div class="img_list">
                <div class="img_slider">
                    @foreach ($menus as $menu)
                        <div class="img_item" style="--i:{{ $loop->index }};">
                            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="info_box">
            <div class="info_slider">
                @foreach ($menus as $menu)
                    <div class="info_item">
                        <h2>{{ $menu->name }}</h2>
                        <p>{{ $menu->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="large_text">
            <h2>メ ニ ュ ー</h2>
        </div>

        <div class="navigator">
            <span class="prev_btn"><i class="fa-solid fa-chevron-left"></i></span>
            <span class="next_btn"><i class="fa-solid fa-chevron-right"></i></span>
        </div>

    </div>

    <script>
        const imgSlider = document.querySelector('.img_slider');
        const infoSlider = document.querySelector('.info_slider');

        const infoBox = document.querySelector('.info_box');
        const nextBtn = document.querySelector('.next_btn');
        const prevBtn = document.querySelector('.prev_btn');

        const bgs = document.querySelectorAll('.bg');

        let indexSlider = 0;
        let index = 0;
        let direction;
        let autoSlideInterval;
        const slideIntervalTime = 5000;

        function startAutoSlide() {
            autoSlideInterval = setInterval(() => {
                nextBtn.click();
            }, slideIntervalTime);
        }

        function stopAutoSlide() {
            clearInterval(autoSlideInterval);
        }

        nextBtn.addEventListener('click', () => {
            stopAutoSlide();
            indexSlider++;
            imgSlider.style.transform = `rotate(${indexSlider * -90}deg)`;

            if (direction === 1) {
                infoSlider.prepend(infoSlider.lastElementChild);
            }

            index++;
            if (index > bgs.length - 1) {
                index = 0;
            }

            document.querySelector('.bg.active').classList.remove('active');
            bgs[index].classList.add('active');

            direction = -1;
            infoSlider.style.transform = `translateY(-25%)`;
            infoBox.style.justifyContent = 'flex-start';

            startAutoSlide();
        });

        prevBtn.addEventListener('click', () => {
            stopAutoSlide();
            indexSlider--;
            imgSlider.style.transform = `rotate(${indexSlider * -90}deg)`;

            if (direction === -1) {
                infoSlider.appendChild(infoSlider.firstElementChild);
            }

            index--;
            if (index < 0) {
                index = bgs.length - 1;
            }

            document.querySelector('.bg.active').classList.remove('active');
            bgs[index].classList.add('active');

            direction = 1;
            infoSlider.style.transform = `translateY(25%)`;
            infoBox.style.justifyContent = 'flex-end';

            startAutoSlide();
        });

        infoSlider.addEventListener('transitionend', () => {
            if (direction === -1) {
                infoSlider.appendChild(infoSlider.firstElementChild);
            } else if (direction === 1) {
                infoSlider.prepend(infoSlider.lastElementChild);
            }

            infoSlider.style.transition = 'none';
            infoSlider.style.transform = 'translateY(0)';

            setTimeout(() => {
                infoSlider.style.transition = '.5s cubic-bezier(0.645, 0.045, 0.355, 1)';
            });
        });

        // Mulai auto-slide saat halaman dimuat
        startAutoSlide();

    </script>

</body>
</html>
