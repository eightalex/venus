<?php
extract($args);

global $float_bar_casino_id;

$cas_args = [
    'items_number' => isset($content) && isset($content['cas_count'])? $content['cas_count']: 9,
    'order_by' => isset($content) && isset($content['cas_order_by']) ? $content['cas_order_by'] : ''
];

$show_pagination = isset($content) && isset($content['cas_show_pagination']) && $content['cas_show_pagination'];
$casino_card_v2  = isset($content) && isset($content['casino_card_v2']) && $content['casino_card_v2'];

if(get_post_type() == 'casino'){
    $term_data = wp_get_post_terms($id, 'casino-category');

    $cas_args['category']   = $term_data[0]->term_taxonomy_id;
    $cas_args['exclude_id'] = $id;
}elseif(!empty($content['cas_category'])){
    $cas_args['category'] = $content['cas_category'];
}

if(isset($content) && isset($content['cas_casionois'])){
    $_post__in_arr = array_filter($content['cas_casionois'],function($value) {
        return ($value !== '');
    });
}


if(!empty($_post__in_arr)){
    $cas_args['post__in'] = $_post__in_arr;
}

$casinos = apply_filters('ud_get_casinos', $cas_args);

if($casinos->have_posts()):
?>
<section class="section section_suits">
    <div class="container">
        <div class="section__inner">
            <?php
            if(!empty($content['cas_title']) || !empty($content['cas_subtitle'])):
                ?>
                <header class="section__header">
                    <?php
                    if(!empty($content['cas_title'])):
                        ?>
                        <h2 class="section__title"><?php echo do_shortcode( $content['cas_title'] )?></h2>
                        <?php
                    endif;

                    if(!empty($content['cas_subtitle'])):
                        ?>
                        <div class="section__subtitle">
                            <?php echo do_shortcode( $content['cas_subtitle'] ) ?>
                        </div>
                        <?php
                    endif;
                    ?>
                </header>
                <?php
            endif;
            ?>
            <div class="section__content">
                <?php if(!$casino_card_v2): ?>
                    <div class="card-list card-list_col-1">
                        <?php while($casinos->have_posts()): ?>

                        <?php

                        $casinos->the_post();

                        $id                    = get_the_ID();
                        $is_first_casino       = $casinos->current_post === 0;
                        $img_id                = get_post_thumbnail_id();
                        $img_data              = apply_filters('ud_get_file_data', $img_id);
                        $img_src               = $img_id !== 0? $img_data['src']: '';
                        $img_alt               = $img_id !== 0? $img_data['alt']: get_the_title();
                        $description           = get_post_meta($id, 'casino_short_desc', true);
                        $overall_rating        = floatval(get_post_meta($id, 'casino_overall_rating', true));
                        $external_link         = get_post_meta($id, 'casino_external_link', true);
                        $title                 = get_the_title();
                        $permalink             = get_the_permalink();
                        $button_external_text  = !empty(get_option('casinos_play_now_title')) ? get_option('casinos_play_now_title') : 'Spill Na';
                        $button_permalink_text = !empty(get_option('casinos_read_review_title')) ? get_option('casinos_read_review_title') : 'Les Anmeldelse';
                        $promo_text_title      = carbon_get_post_meta($id, 'promo_text_title') ?: 'Temp text';
                        $promo_text_price      = carbon_get_post_meta($id, 'promo_text_price') ?: 'Temp text';
                        $promo_text_price_2    = carbon_get_post_meta($id, 'promo_text_price_2'); // optional
                        $promo_text_subtitle   = carbon_get_post_meta($id, 'promo_text_subtitle') ?: 'Temp text';
                        $detailed_tc           = get_post_meta($id, 'casino_detailed_tc', true);

                        if ($is_first_casino) {
                            $float_bar_casino_id = $id;
                        }

                        ?>

                        <div class="casino-card-v2">
                            <div class="casino-card-v2__casino">
                                <div class="casino-card-v2__logo">
                                    <img src="<?= $img_src ?>" alt="<?= $img_alt ?>">
                                </div>
                                <div class="casino-card-v2__info">
                                    <div class="casino-card-v2__title"><?= $title ?></div>
                                    <div class="casino-card-v2__rating">
                                        <?php get_template_part('theme-parts/modules/star-rating', '', [
                                            'id' => 2,
                                            'number_of_stars' => 5,
                                            'rating' => $overall_rating,
                                            'classname' => 'casino-card-v2__star-rating',
                                            'bg_color' => $is_first_casino ? '#5c2ed2' : '#223147',
                                            'bg_stars' => true,
                                        ]) ?>
                                        <div class="casino-card-v2__number-rating">
                                            <?= number_format($overall_rating, 2); ?>
                                        </div>
                                    </div>
                                    <div class="casino-card-v2__clarification">
                                        <span>*Kun nye spillere</span>
                                        <i class="info-tooltip">
                                            <span><?= $detailed_tc ?></span>
                                        </i>
                                    </div>
                                </div>
                            </div>
                            <div class="casino-card-v2__details">
                                <span class="detail-1"><?= $promo_text_title ?></span>
                                <span class="detail-2"><?= $promo_text_price ?></span>
                                <?php if ($promo_text_price_2): ?>
                                    <span class="detail-3"><?= $promo_text_price_2 ?></span>
                                <?php endif; ?>
                                <span class="detail-4"><?= $promo_text_subtitle ?></span>
                            </div>
                            <div class="casino-card-v2__cta">
                                <a href="<?= $external_link ?>" class="button button_v2">
                                    <?= $button_external_text ?>
                                </a>
                                <a href="<?= $permalink ?>" class="button button_v2 button_outline">
                                    <?= $button_permalink_text ?>
                                </a>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>

                <?php else: ?>

                    <table class="card-list card-list_col-2 table">
                        <?php
                        while($casinos->have_posts()):
                            $casinos->the_post();

                            $id                         = get_the_ID();
                            $is_first_casino            = $casinos->current_post === 0;
                            $cas_img_id                 = get_post_thumbnail_id();
                            $cas_img_data               = apply_filters('ud_get_file_data', $cas_img_id);
                            $desc                       = get_post_meta($id, 'casino_short_desc', true);
                            $casino_overall_rating      = floatval(get_post_meta($id, 'casino_overall_rating', true));
                            $casino_external_link       = get_post_meta($id, 'casino_external_link', true);

                            if ($is_first_casino) {
                                $float_bar_casino_id = $id;
                            }

                            $atts = [
                                'title'             => get_the_title(),
                                'img_src'           => $cas_img_id !== 0? $cas_img_data['src']: '',
                                'img_alt'           => $cas_img_id !== 0? $cas_img_data['alt']: get_the_title(),
                                'rating'            => $casino_overall_rating,
                                'desc'              => $desc,
                                'permalink'         => get_the_permalink(),
                                'external_link'     => $casino_external_link,
                                'is_table'          => true,
                            ];

                            echo '<tr>';
                                do_action('print_single_casino_template', $atts);
                            echo '</tr>';
                        endwhile;
                        ?>
                    </table>

                <?php endif; ?>
            </div>
            <?php
                $max_pages = $casinos->max_num_pages;
                $paged = $casinos->query['paged'];
                if($show_pagination && $max_pages > 1){
                    $pagenavi_items = apply_filters('my_pagination', $paged, $max_pages, "casinois-page");
                    echo "<div class='content-cards__footer'>
                                {$pagenavi_items}
                          </div>";
                }
            ?>
        </div>
    </div>
</section>
<?php
endif;
