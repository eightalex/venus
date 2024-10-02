<!-- Footer Start -->

<?php
$logo_id = get_theme_mod('custom_logo');
$logo_data = apply_filters('ud_get_file_data', $logo_id);
$logos = carbon_get_theme_option('logos');
?>
<footer class="footer">
    <div class="container footer__container">
        <div class="footer__info">
            <a class="footer__logo" href="<?php echo get_home_url() ?>">
                <img src=<?php echo get_stylesheet_directory_uri() . "/assets/images/logo.svg" ?> alt="logo">
            </a>
            <div class="footer__text">
                <?php if (get_theme_mod('footer_copyright') == '') { ?>
                    <?php esc_html_e('&copy; Copyright', 'mercury'); ?><?php echo esc_html(date('Y')) ?><?php echo esc_html(get_bloginfo('name')) ?> | <?php esc_html_e('Powered by', 'mercury'); ?>
                    <a href="<?php echo esc_url(__('https://wordpress.org', 'mercury')); ?>" target="_blank"
                       title="<?php esc_attr_e('WordPress', 'mercury'); ?>"><?php esc_html_e('WordPress', 'mercury'); ?></a> |
                    <a href="<?php echo esc_url(__('https://mercurytheme.com', 'mercury')); ?>" target="_blank"
                       title="<?php esc_attr_e('Affiliate Marketing WordPress Theme. Reviews and Top Lists', 'mercury'); ?>"><?php esc_html_e('Mercury Theme', 'mercury'); ?></a>
                <?php } else { ?>
                    <?php
                    $allowed_html = array(
                        'a' => array(
                            'href' => true,
                            'title' => true,
                            'target' => true,
                        ),
                        'br' => array(),
                        'em' => array(),
                        'strong' => array(),
                        'span' => array(),
                        'p' => array()
                    );
                    echo wp_kses(get_theme_mod('footer_copyright'), $allowed_html);
                    ?>
                <?php } ?>
            </div>
        </div>
        <nav class="footer__nav">
            <?php
            $left_menu_items = "";
            $rigt_menu_items = "";
            $menu_items = wp_get_nav_menu_items('Footer menu');
            $menu_infos_items = wp_get_nav_menu_items('Footer - Further info');

            if (!empty($menu_items)) {
                foreach ($menu_items as $k => $item) {
                    $html = "<li class='footer__item'>
                                 <a href='{$item->url}' class='footer__link'>{$item->title}</a>
                             </li>";

                    $rigt_menu_items .= $html;
                }
            };

            if (!empty($menu_infos_items)) {
                foreach ($menu_infos_items as $k => $item) {
                    $html = "<li class='footer__item'>
                                 <a href='{$item->url}' class='footer__link'>{$item->title}</a>
                             </li>";

                    $left_menu_items .= $html;
                }
            }

            if (!empty($left_menu_items)):
                ?>
                <ul class="footer__list">
                    <?php echo $left_menu_items ?>
                </ul>
            <?php
            endif;

            if (!empty($rigt_menu_items)):
                ?>
                <ul class="footer__list">
                    <?php echo $rigt_menu_items ?>
                </ul>
            <?php
            endif;
            ?>
        </nav>
        <?php if (!empty($logos)): ?>
            <div class="footer__social">
                <?php $site_url = home_url(); ?>
                <?php foreach ($logos as $logo): ?>
                    <?php
                    $img = apply_filters('ud_get_file_data', $logo['logo_image']);
                    $link_url = $logo['logo_link'] ?: '#';

                    if (!empty($link_url) && strpos($link_url, $site_url) === false && strpos($link_url, 'http') === 0) {
                        $rel = 'rel="nofollow"';
                    } else {
                        $rel = '';
                    }

                    $link_url_escaped = esc_url($link_url);
                    $img_src = esc_url($img['src']);
                    $img_alt = esc_attr($img['alt'] ?: 'Logo');
                    ?>
                    <a href="<?php echo $link_url_escaped; ?>" class="footer__social-link" <?php echo $rel; ?>>
                        <img src="<?php echo $img_src; ?>" alt="<?php echo $img_alt; ?>">
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</footer>

<!-- Footer End -->

<!-- Mobile Search Start -->

<?php get_template_part('/theme-parts/mobile-search'); ?>

<!-- Mobile Search End -->

<!-- Mobile Menu Start -->

<?php get_template_part('/theme-parts/mobile-menu'); ?>

<!-- Mobile Menu End -->

<?php wp_footer(); ?>

</body>

</html>
