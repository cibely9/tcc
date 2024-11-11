var swiper = new Swiper('.swiper-container', {
    slidesPerView: 1, 
    spaceBetween: 0, 
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
});

document.getElementById('discard-button').addEventListener('click', function() {
    swiper.removeSlide(swiper.activeIndex);
    if (swiper.slides.length > 0) {
        swiper.slideNext();
    }
});

document.getElementById('like-button').addEventListener('click', function() {
    console.log('Slide curtido:', swiper.activeIndex);
    swiper.removeSlide(swiper.activeIndex);
  
    if (swiper.slides.length > 0) {
        swiper.slideNext();
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const swiper = new Swiper('.swiper-container', {
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
        },
    });

    document.getElementById('like-button').addEventListener('click', () => {
        const currentSlide = swiper.slides[swiper.activeIndex];
        const imgSrc = currentSlide.querySelector('img').src;
        const title = currentSlide.querySelector('.title').textContent;
        const caption = currentSlide.querySelector('.caption').textContent;

        let likedPhotos = JSON.parse(localStorage.getItem('likedPhotos')) || [];

        const photoExists = likedPhotos.some(photo => photo.src === imgSrc);

        if (!photoExists) {
            likedPhotos.push({ src: imgSrc, title, caption });
            localStorage.setItem('likedPhotos', JSON.stringify(likedPhotos));
        }
    });

    document.getElementById('discard-button').addEventListener('click', () => {
        swiper.slideNext();
    });
});

