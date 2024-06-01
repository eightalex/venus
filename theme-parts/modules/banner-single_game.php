<?php
extract($args);

$game_img_id    = get_post_thumbnail_id($id);
$game_img_data  = apply_filters('ud_get_file_data', $game_img_id);
$rat            = floatval(get_post_meta($id, 'game_rating_one', true));
$short_desc     = get_post_meta( $id, 'game_short_desc', true );
$unit_detailed  = get_post_meta( $id, 'unit_detailed_tc', true );
$external       = get_post_meta( $id, 'game_external_link', true );
$button_notice  = get_post_meta( $id, 'game_button_notice', true );
$button_title   = get_post_meta( $id, 'game_button_title', true );
$btn_txt        = !empty($button_title)? $button_title: __('PLAY NOW');


get_template_part('/theme-parts/modules/breadcrumbs');
?>
<section class="section section_p_0 section_bg_n">
    <div class="container">
        <div class="section__inner">
            <div class="banner-casino">
                <div class="banner-casino__image">
                    <img src="<?php echo $game_img_data['src']?>" alt="casino">
                </div>
                <div class="banner-casino__content">
                    <div class="banner-casino__header">
                        <div class="banner-casino__title"><?php echo get_the_title($id)?></div>
                        <div class="banner-casino__rating">
                            <!-- START: Такий блок вже є, але додано rating-mobile_inverted -->
                            <div class="rating-mobile rating-mobile_inverted" data-rating="<?php echo $rat?>">
                                <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/icons/star.svg'?>" alt="star">
                            </div>
                            <!-- END: Такий блок вже є -->
                        </div>
                    </div>
                    <?php
                    if(!empty($short_desc)):
                        ?>
                        <div class="banner-casino__subtitle">
                            <?php echo $short_desc?>
                        </div>
                        <?php
                    endif;

                    if(!empty($unit_detailed)):
                        ?>
                        <div class="banner-casino__text">
                            <?php echo $unit_detailed?>
                        </div>
                        <?php
                    endif;

                    if(!empty($external)):
                        ?>
                        <div class="banner-casino__cta">
                            <a href="<?php echo $external?>" class="button banner-casino__button"><?php echo $btn_txt?></a>
                            <?php
                            if(!empty($button_notice)):
                                ?>
                                <span><?php echo $button_notice?></span>
                                <?php
                            endif;
                            ?>
                        </div>
                        <?php
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>