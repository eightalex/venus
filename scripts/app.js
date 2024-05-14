document.addEventListener('DOMContentLoaded', function () {
    const swiper = new Swiper('.swiper', {
        loop: true,
        navigation: {
            nextEl: '.js-button-next',
            prevEl: '.js-button-prev',
            disabledClass: 'disabled',
        },
    });
});
