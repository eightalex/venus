<?php

$float_bar_show        = carbon_get_theme_option('float_bar_show');
$casino_id             = carbon_get_theme_option('float_bar_casino');
$casino                = get_post_meta($casino_id, 'casino', true);
$casino_title          = get_the_title($casino_id);
$casino_img_id         = get_post_thumbnail_id($casino_id);
$casino_img_data       = apply_filters('ud_get_file_data', $casino_img_id);
$casino_overall_rating = floatval(get_post_meta($casino_id, 'casino_overall_rating', true));
$casino_external_link  = get_post_meta($casino_id, 'casino_external_link', true);
$button_text           = carbon_get_theme_option('float_bar_button_text');

?>

<div class="float-bar js-float-bar <?php echo $float_bar_show ? '' : 'd-none' ?>">
    <div class="container full-height">
        <div class="float-bar__inner">
            <div class="float-bar__casino">
                <div class="float-bar__logo">
                    <img src="<?php echo $casino_img_id !== 0 ? $casino_img_data['src'] : '' ?>" alt="<?php echo $casino_img_id !== 0 ? $casino_img_data['alt'] : $casino_title ?>">
                </div>
                <div class="float-bar__casino-info">
                    <div class="float-bar__title">
                        <?php echo $casino_title ?>
                    </div>
                    <div class="float-bar__rating">
                        <div class="rating-mobile float-bar__rating-mobile" data-rating="<?php echo $casino_overall_rating ?>">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/icons/star.svg' ?>" alt="star">
                        </div>
                        <div class="star-rating float-bar__rating-desktop" data-rating="<?php echo $casino_overall_rating ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="312" height="24" viewBox="0 0 312 24">
                                <mask id="starMask">
                                    <rect width="312" height="24" fill="#fff"/>
                                    <g fill="#000">
                                        <use href="#starPath" x="0" y="0"/>
                                        <use href="#starPath" x="32" y="0"/>
                                        <use href="#starPath" x="64" y="0"/>
                                        <use href="#starPath" x="96" y="0"/>
                                        <use href="#starPath" x="128" y="0"/>
                                        <use href="#starPath" x="160" y="0"/>
                                        <use href="#starPath" x="192" y="0"/>
                                        <use href="#starPath" x="224" y="0"/>
                                        <use href="#starPath" x="256" y="0"/>
                                        <use href="#starPath" x="288" y="0"/>
                                    </g>
                                </mask>
                                <defs>
                                    <path id="starPath" d="M23.9374 9.20628C23.7803 8.7203 23.3493 8.37514 22.8393 8.32918L15.9123 7.7002L13.1731 1.28896C12.9712 0.8191 12.5112 0.514954 12.0001 0.514954C11.4891 0.514954 11.0291 0.8191 10.8271 1.29006L8.08797 7.7002L1.15982 8.32918C0.65077 8.37624 0.220828 8.7203 0.0628038 9.20628C-0.0952203 9.69225 0.0507185 10.2253 0.435799 10.5613L5.67183 15.1533L4.12785 21.9546C4.01487 22.4547 4.20897 22.9716 4.62389 23.2715C4.84692 23.4327 5.10785 23.5147 5.37098 23.5147C5.59786 23.5147 5.8229 23.4535 6.02487 23.3327L12.0001 19.7615L17.9732 23.3327C18.4103 23.5956 18.9612 23.5716 19.3752 23.2715C19.7904 22.9707 19.9843 22.4536 19.8713 21.9546L18.3273 15.1533L23.5633 10.5622C23.9484 10.2253 24.0955 9.69317 23.9374 9.20628Z"/>
                                </defs>
                                <rect width="312" height="24" fill="var(--star-rating-background, #262c3a)" mask="url(#starMask)"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <a href="<?php echo $casino_external_link ?>" target="_blank" class="float-bar__button button" rel="nofollow"><?php echo $button_text ?></a>
            </div>
        </div>
    </div>
</div>
