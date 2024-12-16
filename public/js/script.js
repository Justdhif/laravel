var swiper = new Swiper(".fav_box", {
    slidesPerView: 1,
    spaceBetween: 10,
    loop: true,
    grabCursor: true,
    autoplay: {
        delay: 3500,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});

function createClouds() {
    if (document.querySelectorAll('.cloud').length >= 4) return;

    for (let i = 0; i < 3; i++) {
        const cloud = document.createElement('div');
        cloud.classList.add('cloud');
        cloud.style.top = `${Math.random() * 50 + 10}%`;
        cloud.style.left = `${Math.random() * 80}vw`;
        const body = document.getElementById('content');
        body.appendChild(cloud);

        setTimeout(() => {
            cloud.classList.add('visible');
        }, 100);
    }
}

function createStars() {
    for (let i = 0; i < 10; i++) {
        const star = document.createElement('div');
        star.classList.add('stars');
        star.style.top = `${Math.random() * 100}vh`;
        star.style.left = `${Math.random() * 100}vw`;
        const body = document.getElementById('content');
        body.appendChild(star);
    }
}

function updateGreetingAndTime() {
    const now = new Date();
    const hour = now.getHours();
    const minutes = now.getMinutes();
    const seconds = now.getSeconds();

    const body = document.getElementById('content');
    const greeting = document.getElementById('greeting');
    const clock = document.getElementById('clock');

    // Format waktu menjadi HH:MM:SS
    const formattedTime = `${String(hour).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    clock.textContent = formattedTime;

    // Mengatur sapaan dan latar belakang sesuai waktu
    if (hour >= 5 && hour < 12) {
        body.classList.add('morning');
        body.classList.remove('afternoon');
        body.classList.remove('evening');
        body.classList.remove('night');
        greeting.textContent = "Selamat Pagi!";
        createClouds();
    } else if (hour >= 12 && hour < 16) {
        body.classList.remove('morning');
        body.classList.add('afternoon');
        body.classList.remove('evening');
        body.classList.remove('night');
        greeting.textContent = "Selamat Siang!";
        createClouds();
    } else if (hour >= 16 && hour < 19) {
        body.classList.remove('morning');
        body.classList.remove('afternoon');
        body.classList.add('evening');
        body.classList.remove('night');
        greeting.textContent = "Selamat Sore!";
        createClouds();
    } else {
        body.classList.remove('morning');
        body.classList.remove('afternoon');
        body.classList.remove('evening');
        body.classList.add('night');
        greeting.textContent = "Selamat Malam!";
        createStars();
    }
}

// Update tampilan sesuai waktu saat ini
    updateGreetingAndTime();

// Memperbarui tampilan setiap detik agar jam terlihat secara real-time
    setInterval(updateGreetingAndTime, 1000); // 1 detik = 1000 ms

