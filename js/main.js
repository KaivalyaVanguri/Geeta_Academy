document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.getElementById('carousel');
    const slides = document.querySelector('.carousel__slides');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    let currentIndex = 0;
    const totalSlides = document.querySelectorAll('.carousel__slide').length;

    nextBtn.addEventListener('click', function () {
        goToSlide(currentIndex + 1);
    });

    prevBtn.addEventListener('click', function () {
        goToSlide(currentIndex - 1);
    });

    function goToSlide(index) {
        currentIndex = (index + totalSlides) % totalSlides;
        updateCarousel();
    }

    function updateCarousel() {
        const translateValue = -currentIndex * 100 + '%';
        slides.style.transform = 'translateX(' + translateValue + ')';
    }

    // Swipe support for touch devices
    let touchStartX;

    carousel.addEventListener('touchstart', function (event) {
        touchStartX = event.touches[0].clientX;
    });

    carousel.addEventListener('touchmove', function (event) {
        if (touchStartX === undefined) return;

        const touchEndX = event.touches[0].clientX;
        const deltaX = touchEndX - touchStartX;

        if (Math.abs(deltaX) > 50) {
            goToSlide(deltaX > 0 ? currentIndex - 1 : currentIndex + 1);
            touchStartX = undefined;
        }
    });

    carousel.addEventListener('touchend', function () {
        touchStartX = undefined;
    });

    // Check if the button exists
    const showSidebarBtn = document.getElementById('show__sidebar-btn');
    if (showSidebarBtn) {
        // Add the event listener only if the button exists
        showSidebarBtn.addEventListener('click', showSidebar);
    }

    // Your existing navigation and sidebar code
    const navItems = document.querySelector('.nav__items');
    const openNavBtn = document.querySelector('#open__nav-btn');
    const closeNavBtn = document.querySelector('#close__nav-btn');

    const openNav = () => {
        navItems.style.display = 'flex';
        openNavBtn.style.display = 'none';
        closeNavBtn.style.display = 'inline-block';
    };

    const closeNav = () => {
        navItems.style.display = 'none';
        openNavBtn.style.display = 'inline-block';
        closeNavBtn.style.display = 'none';
    };

    openNavBtn.addEventListener('click', openNav);
    closeNavBtn.addEventListener('click', closeNav);

    const sidebar = document.querySelector('aside');
    const hideSidebarBtn = document.querySelector('#hide__sidebar-btn');

    const showSidebar = () => {
        sidebar.style.left = '0';
        showSidebarBtn.style.display = 'none';
        hideSidebarBtn.style.display = 'inline-block';
    };

    const hideSidebar = () => {
        sidebar.style.left = '-100%';
        showSidebarBtn.style.display = 'inline-block';
        hideSidebarBtn.style.display = 'none';
    };

    hideSidebarBtn.addEventListener('click', hideSidebar);
});
