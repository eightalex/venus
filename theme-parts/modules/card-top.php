<?php
extract($args);

if(!$content['card_top_power']){
    return;
}

$featured_id            = get_post_thumbnail_id();
$featured_data          = apply_filters('ud_get_file_data', $featured_id);
$short_desc             = get_post_meta( $id, "{$post_type}_short_desc", true );
$rating                 = floatval(get_post_meta($id, "{$post_type}_overall_rating", true));
$detailed_tc            = get_post_meta( $id, "{$post_type}_detailed_tc", true );
$button_notice          = get_post_meta( $id, "{$post_type}_button_notice", true );
$restricted_countries   = wp_get_post_terms($id, 'restricted-country');
$review_btn_txt         = !empty(get_option('casinos_read_review_title'))?get_option('casinos_read_review_title'): "Read Review";
$external_link          = get_post_meta($id, 'casino_external_link', true);
// $has_country            = apply_filters('ud_has_object_with_property',$restricted_countries, 'name', 'Ukraine');
// $has_country_str        = $has_country? __("Users from Ukraine accepted"): __("Users from Ukraine are not accepted");
?>
<section class="section-top">
    <div class="container relative">
        <div class="card-top">
            <div class="card-top__image">
                <img src="<?php echo $featured_data['src']?>" alt="<?php echo $featured_data['alt']?>">
            </div>

            <h1 class="card-top__title"><?php the_title()?></h1>

            <div class="card-top__subtitle">
                    <?php
                    if(!empty($short_desc)):
                        ?>
                        <span>
                            <?php echo do_shortcode( $short_desc );?>
                        </span>
                        <?php
                    endif;
                    ?>
                <div class="card-top__rating">
                    (<?php echo $rating?>)
                </div>
            </div>
            <?php
            if(!empty($detailed_tc)):
            ?>
            <div class="card-top__text">
                <?php echo do_shortcode( $detailed_tc );?>
            </div>
            <?php
            endif;
            ?>
            <div class="card-top__cta">
                <div class="card-top__cta-button">
                    <?php if(!empty($external_link)):
                    $btn_txt = !empty(get_post_meta($id, 'casino_button_title', true))? get_post_meta($id, 'casino_button_title', true):$review_btn_txt;
                    ?>
                    <a class="card-top__button button" href="<?php echo $external_link?>" targrt="_blank" rel="nofollow"><?php echo $btn_txt?></a>
                    <?php endif; ?>
                    
                    <?php if(!empty($button_notice)): ?>
                    <span class="notice"><?php echo do_shortcode( $button_notice );?></span>
                    <?php endif; ?>
                </div>
                <div class="card-top__cta-text">
                    <?php get_template_part("/theme-parts/modules/post-info", null, ['show_activities' => true]) ?>
                </div>
            </div>
            <!-- <div class="card-top__info">
                <?php //echo $has_country_str?>
            </div> -->
        </div>
    </div>
    <img class="section-top__clouds-1" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/section/clouds-1.png" alt="clouds">
    <img class="section-top__clouds-2" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/section/clouds-2.png" alt="clouds">
    <img class="section-top__deer" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/deer.svg" alt="deer">
</section>
<?php
