<?php

$icon_search = get_stylesheet_directory_uri() . '/assets/images/icons/search.svg';

?>

<form class="search-form js-form"
      action="<?= esc_url( home_url( '/' ) ) ?>"
      method="get"
      role="search"
>
    <input class="search-form__input input input_search desktop js-input"
           type="search"
           aria-label="search"
           value="<?= get_search_query() ?>"
           name="s"
    >
    <button class="search-form__button desktop">
        <img src="<?= $icon_search ?>" alt="Search">
    </button>
    <div class="search-form__button mobile js-button">
        <img src="<?= $icon_search ?>" alt="Search">
    </div>
</form>
