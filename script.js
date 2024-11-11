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