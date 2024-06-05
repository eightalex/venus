<form role="search"
      method="get"
      class="search__form"
      action="<?= esc_url( home_url( '/' ) ) ?>"
>
    <input class="search__input input input_search"
           type="search"
           aria-label="search"
           value="<?= get_search_query() ?>"
           name="s"
    >
    <button class="search__button">
        <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/icons/search.svg" alt="Search">
    </button>
</form>
