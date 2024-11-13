<?php

extract($args); // => $id, $post_type

global $float_bar_casino_id;

if ($post_type === 'casino') {
    $casino_id = $id ?: carbon_get_theme_option('float_bar_casino');
} else {
    $casino_id = $float_bar_casino_id ?: carbon_get_theme_option('float_bar_casino');
}

$float_bar_show        = carbon_get_theme_option('float_bar_show');
$casino                = get_post_meta($casino_id, 'casino', true);
$casino_title          = get_the_title($casino_id);
$casino_img_id         = get_post_thumbnail_id($casino_id);
$casino_img_data       = apply_filters('ud_get_file_data', $casino_img_id);
$casino_overall_rating = floatval(get_post_meta($casino_id, 'casino_overall_rating', true));
$casino_external_link  = get_post_meta($casino_id, 'casino_external_link', true);
$button_text           = carbon_get_theme_option('float_bar_button_text');

if (!$float_bar_show) {
    return;
}

?>

<div class="float-bar js-float-bar">
    <div class="container full-height">
        <div class="float-bar__inner">
            <div class="float-bar__casino">
                <div class="float-bar__logo">
                    <img
                        src="<?php echo $casino_img_id !== 0 ? $casino_img_data['src'] : '' ?>"
                        alt="<?php echo $casino_img_id !== 0 ? $casino_img_data['alt'] : $casino_title ?>"
                    >
                </div>
                <div class="float-bar__casino-info">
                    <div class="float-bar__title">
                        <?php echo $casino_title ?>
                    </div>
                    <div class="float-bar__rating">
                        <div class="rating-mobile float-bar__rating-mobile" data-rating="<?php echo $casino_overall_rating ?>">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/icons/star.svg' ?>" alt="star">
                        </div>
                        <?php get_template_part('theme-parts/modules/star-rating', '', [
                            'id' => 3,
                            'rating' => $casino_overall_rating,
                            'classname' => 'float-bar__rating-desktop',
                            'bg_stars' => true,
                        ]) ?>
                    </div>
                </div>
                <a href="<?php echo $casino_external_link ?>" target="_blank" class="float-bar__button button" rel="nofollow"><?php echo $button_text ?></a>
            </div>
        </div>
    </div>
</div>
