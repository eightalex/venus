<?php
extract($args);

$banner_txt         = carbon_get_post_meta($id, 'app_banner_txt');
$tax                = 'bonus-category';
$bonus_cat          = wp_get_post_terms($id, $tax);
$title              = !empty($banner_txt)? $banner_txt: get_the_title();
$date_f             = 'F d, Y';
$bonus_code         = get_post_meta($id, 'bonus_code', true);
$bonus_valid_date   = get_post_meta($id, 'bonus_valid_date', true);
$bonus_v_d_u        = strtotime($bonus_valid_date);
$bonus_v_d_m        = date($date_f, $bonus_v_d_u);
$short_desc         = get_post_meta($id, 'bonus_short_desc', true);
$external_link      = get_post_meta($id, 'bonus_external_link', true);
$button_notice      = get_post_meta($id, 'bonus_button_notice', true);
$offer_detailed_tc  = get_post_meta($id, 'offer_detailed_tc', true);

$show_tags          = false;

?>
<section class="section section_p_0 section_suits">
    <div class="container">
        <div class="section__inner">
            <div class="banner-author banner-author_bonus">
                <div class="banner-author__content">
                    <?php
                        get_template_part('/theme-parts/modules/breadcrumbs', '', ['inline' => true]);

                        if(!empty($bonus_cat) && $show_tags):
                            $cat_lnk = get_term_link($bonus_cat[0]->term_id, $tax);
                        ?>

                        <div class="banner-author__tags">
                            <a href="<?php echo $cat_lnk?>" class="tag"><?php echo $bonus_cat[0]->name ?></a>
                        </div>
                        <?php
                        endif;
                    ?>
                    <header class="banner-author__header">
                        <h1 class="banner-author__title">
                            <?php echo $title ?>
                        </h1>
                    </header>
                    <?php get_template_part("/theme-parts/modules/post-info", null, ['tag' => 'footer', 'show_activities' => true]) ?>
                </div>

                <div class="banner-author__bonus">
                    <div class="bonus-widget">
                        <div class="bonus-widget__header">
                            <div class="bonus-widget__gift">
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/gift.svg' ?>" alt="gift">
                            </div>
                            <div class="bonus-widget__heading">
                                <?php
                                if(!empty($bonus_code)):
                                    ?>
                                    <!-- <div class="bonus-widget__subtitle"><?php echo __('Bonus code') ?>:</div> -->
                                    <div class="bonus-widget__title"><?php echo do_shortcode( $bonus_code )?></div>
                                    <?php
                                endif;

                                if(!empty($bonus_v_d_m)):
                                    ?>
                                    <div class="bonus-widget__date">Gyldig til: <?php echo $bonus_v_d_m?></div>
                                    <?php
                                endif;
                                ?>
                            </div>
                        </div>
                        <div class="bonus-widget__content">
                            <?php
                            if(!empty($external_link)):
                                $btn_txt = !empty(get_option('bonuses_get_bonus_title'))? get_option('bonuses_get_bonus_title'): __('Get bonus');
                            ?>
                            <a rel='nofollow' href="<?php echo $external_link?>" class="bonus-widget__button button"><?php echo do_shortcode($btn_txt);?></a>
                            <?php
                                if(!empty($button_notice)):
                                    ?>
                                    <span><?php echo do_shortcode( __($button_notice) )?></span>
                                    <?php
                                endif;
                            endif;
                            ?>
                        </div>
                        <?php
                        if(!empty($offer_detailed_tc)):
                        ?>
                        <div class="bonus-widget__footer">
                            <?php echo do_shortcode( $offer_detailed_tc );?>
                        </div>
                        <?php
                        endif;
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
