<?php

$icon_cross  = get_stylesheet_directory_uri() . '/assets/images/icons/cross.svg';

?>

<form class="search-form-mobile js-form-mobile"
      action="<?= esc_url( home_url( '/' ) ) ?>"
      method="get"
      role="search"
>
    <div class="search-form-mobile__close js-close">
        <img src="<?= $icon_cross ?>" alt="Close">
    </div>
    <input class="search-form-mobile__input js-input-mobile"
           type="search"
           aria-label="search"
           value="<?= get_search_query() ?>"
           name="s"
    >
</form>
