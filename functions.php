<?php

// For custom functions and hooks...

// Add filter to modify nav menu item classes
add_filter('nav_menu_css_class', 'custom_menu_item_classes', 10, 4);

function custom_menu_item_classes($classes, $item, $args, $depth)
{
    $classes[] = 'navigation__item dropdown';
    return $classes;
}
