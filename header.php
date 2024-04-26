<?php ?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport"
          id="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0, user-scalable=yes"/>
    <?php wp_head(); ?>
</head>
<body ontouchstart <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <!-- <div class="space-box relative<?php if (get_theme_mod('mercury_boxed_layout')) { ?> enabled<?php } ?>"> -->

        <!-- Header Start -->

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
                    <div class="header__search search">
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
                        <div class="navigation__burger space-mobile-menu-icon">
                            <span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </div>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Header End -->
