<?php
extract($args);

$banner_txt         = carbon_get_post_meta($id, 'app_banner_txt');
$tax                = 'bonus-category';
$bonus_cat          = wp_get_post_terms($id, $tax);
$title              = !empty($banner_txt)? $banner_txt: get_the_title();
$author_id          = get_queried_object()->post_author;
$author_info        = apply_filters('ud_get_author_infos', $author_id);
$author_full_name   = $author_info['firs_name'] . " " . $author_info['last_name'];
$author_link        = get_author_posts_url($author_id);
$date_create        = get_queried_object()->post_date;
$date_c_u           = strtotime($date_create);
$date_f             = 'F d, Y';
$date_c_m           = date($date_f, $date_c_u);
$date_update        = ucfirst(get_the_modified_date('F j, Y'));
$view_count         = function_exists( 'pvc_get_post_views' )? pvc_get_post_views($id): 0;
$comment_count      = get_comment_count($id);
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
                    <footer class="banner-author__footer">
                        <a class="banner-author__author" href="<?php echo $author_link ?>">
                            <span class="banner-author__avatar">
                                <img src="<?php echo $author_info['ava_url']?>" alt="avatar">
                            </span>
                            <span class="banner-author__name">
                                <?php echo __('by')?> <?php echo $author_full_name?>
                            </span>
                        </a>
                        <time class="banner-author__date">
                            <?php echo $date_update ?>
                        </time>
                        <div class="banner-author__icons">
                            <?php
                            if(intval($view_count) > 0):
                            ?>
                            <div class="banner-author__icon">
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/icons/eye.svg' ?>" alt="views icon">
                                <span><?php echo $view_count?></span>
                            </div>
                            <?php
                            endif;
                            ?>
                            <div class="banner-author__icon">
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/icons/comment.svg' ?>" alt="views icon">
                                <span><?php echo $comment_count['total_comments']?></span>
                            </div>
                        </div>
                    </footer>
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
