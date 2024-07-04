document.addEventListener('DOMContentLoaded', function () {
    initSwiper();
    initCategories();
    initSearch();
});

window.addEventListener('resize', () => {
    initCategories();
});

function initCategories() {
    const categories = document.querySelectorAll('.js-categories');

    categories.forEach((category) => {
        category.style.marginBottom = `-${category.clientHeight}px`;
        const nextElement = category.nextElementSibling;
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

function initSearch() {
    const body = document.querySelector('body');

    const searchForm = document.querySelector('.js-form');
    const searchInput = searchForm.querySelector('.js-input');
    const searchButton = searchForm.querySelector('.js-button');

    const searchFormMobile = document.querySelector('.js-form-mobile');
    const searchInputMobile = searchFormMobile.querySelector('.js-input-mobile');
    const closeButton = searchFormMobile.querySelector('.js-close');

    searchForm.addEventListener('submit', function(event) {
        if (searchInput.value === '') {
            event.preventDefault();
        }
    });

    searchFormMobile.addEventListener('submit', function(event) {
        if (searchInputMobile.value === '') {
            event.preventDefault();
        }
    });

    searchButton.addEventListener('click', function() {
        window.scrollTo({ top: 0 });
        body.classList.add('popup-open');
        searchFormMobile.classList.add('active');
    });

    closeButton.addEventListener('click', function() {
        body.classList.remove('popup-open');
        searchFormMobile.classList.remove('active');
    });
}
