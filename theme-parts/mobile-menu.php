<div class="mobile-menu js-mobile-menu">
    <?php
        if ( has_nav_menu('main-menu') ) {
            wp_nav_menu( array(
                'container' => 'ul',
                'menu_class' => 'mobile-menu__inner',
                'theme_location' => 'main-menu',
                'depth' => 3,
                'fallback_cb' => '__return_empty_string'
            ) );
        }
    ?>
</div>
