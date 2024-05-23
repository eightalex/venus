document.addEventListener('DOMContentLoaded', function () {
    initSwiper();
    initCategories();
});

window.addEventListener('resize', () => {
    initCategories();
});

function initCategories() {
    const categories = document.querySelectorAll('.js-categories');

    categories.forEach((category) => {
        category.style.marginBottom = `-${category.clientHeight}px`;
        const nextElement = category.nextElementSibling;
        console.log(nextElement.classList);
        nextElement.style.paddingTop = `${category.clientHeight}px`;
    });
}

function initSwiper() {
    new Swiper('.swiper', {
        loop: true,
        navigation: {
            nextEl: '.js-button-next',
            prevEl: '.js-button-prev',
            disabledClass: 'disabled',
        },
    });
}
