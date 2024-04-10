<?php

function filter_menu_item_classes( $classes ) {
    $classes[] = 'navigation__item';
    return $classes;
}

add_filter( 'nav_menu_css_class', 'filter_menu_item_classes', 10, 4 );

function filter_submenu_classes( $classes, $args ) {
    if ( $args->theme_location === 'main-menu' ) {
        $classes[] = 'navigation__submenu';
    }
    return $classes;
}

add_filter( 'nav_menu_submenu_css_class', 'filter_submenu_classes', 10, 3 );

function venus_scripts() {
    wp_enqueue_script('app', get_theme_file_uri( '/scripts/app.js' ), array( 'jquery' ), $GLOBALS['mercury_version'], true );
}

add_action( 'wp_enqueue_scripts', 'venus_scripts' );
