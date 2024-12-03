<?php ?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport"
          id="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0, user-scalable=yes"/>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@400;500;600&family=Montserrat:ital,wght@0,600;0,700;0,800;1,500&family=Ubuntu&display=swap" rel="stylesheet">

    <?php

    global $current_id;
    $current_id = get_the_ID();

    ?>

    <script>
        const php_vars = {
            current_id: <?= $current_id ?>,
            toc_excluded_pages: <?= json_encode(carbon_get_theme_option('toc_excluded_pages')) ?>,
            toc_excluded_posts: <?= json_encode(carbon_get_theme_option('toc_excluded_posts')) ?>,
        };
    </script>

    <?php wp_head(); ?>
</head>
<body ontouchstart <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header class="header">
        <div class="container">
            <div class="header__inner">
                <div class="header__logo">
                    <a
                        href="<?= esc_url(home_url('/')) ?>"
                        title="<?= esc_attr(get_bloginfo('name')) ?>"
                        class="header__logo"
                    >
                        <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/logo.svg" alt="Logo">
                    </a>
                </div>
                <div class="header__search">
                    <?php get_search_form(); ?>
                </div>
                <nav class="navigation">
                    <?php
                        if (has_nav_menu('main-menu')) {
                            wp_nav_menu(array(
                                'container' => 'ul',
                                'menu_class' => 'navigation__inner',
                                'theme_location' => 'main-menu',
                                'depth' => 3,
                                'fallback_cb' => '__return_empty_string'
                            ));
                        }
                    ?>
                    <div class="navigation__burger js-mobile-menu-button">
                        <span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                        <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/icons/cross.svg" alt="Close">
                    </div>
                </nav>
            </div>
        </div>
    </header>
