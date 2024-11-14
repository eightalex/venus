document.addEventListener('DOMContentLoaded', function () {
    initFloatBar();
    initSwiper();
    initCategories();
    initSearch();
    initMobileMenu();
    initDemoGame();
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
    const searchButton = searchForm.querySelector('.js-mobile-search-button');

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

function initMobileMenu() {
    const body = document.querySelector('body');
    const mobileMenu = document.querySelector('.js-mobile-menu');
    const mobileMenuButton = document.querySelector('.js-mobile-menu-button');
    const mobileSearchButton = document.querySelector('.js-mobile-search-button');

    mobileMenuButton.addEventListener('click', function() {
        window.scrollTo({ top: 0 });
        body.classList.toggle('popup-open');
        mobileMenu.classList.toggle('active');
        mobileMenuButton.classList.toggle('active');
        mobileSearchButton.classList.toggle('hidden');
    });

    // children behavior are in the script.js in the parent theme
}

function initFloatBar() {
    const floatBar = document.querySelector('.js-float-bar');
    const breakpoint = 120;

    if (floatBar === null) {
        return;
    }

    window.addEventListener('scroll', debounce(() => {
        if (window.scrollY > breakpoint) {
            floatBar.classList.add('active');
        } else {
            floatBar.classList.remove('active');
        }
    }, 100));
}

function debounce(func, wait, immediate) {
    let timeout;
    return function() {
        const context = this;
        const args = arguments;
        const later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

function initDemoGame() {
    const demoButton = document.getElementById('game-demo-mode__demo-btn');
    const closeDemoButton = document.getElementById('game-demo-mode-close');
    const demoContainer = document.getElementById('game-demo-mode-container');
    const showDemoClass = 'show-demo'

    if (!demoButton) return;

    demoButton.addEventListener("click", () => {
        const iframeWrapper = document.getElementById('game-demo-mode-iframe-wrapper');
        const iframeElement = iframeWrapper.querySelector('iframe');

        if (!iframeElement) {
            const iframe = document.createElement('iframe')
            iframe.src = iframeWrapper.dataset.demoSrc;
            iframe.width = "100%";
            iframe.height = "600px";

            iframeWrapper.append(iframe);
        }
        demoContainer.classList.add(showDemoClass);

    })

    if (!closeDemoButton) return;

    closeDemoButton.addEventListener('click', () => {
        demoContainer.classList.remove(showDemoClass)
    })
}
