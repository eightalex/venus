<?php
extract($args);

$cas_args = [
    'items_number'  => $content['cas_count'],
    'orderby'       => $content['cas_order_by'],
    'exclude_id'    => ''
];


if(get_post_type() == 'casino'){
    $term_data = wp_get_post_terms($id, 'casino-category');

    $cas_args['category'] = $term_data[0]->term_taxonomy_id;
    $cas_args['exclude_id'] = $id;
}elseif(!empty($content['cas_category'])){
    $cas_args['category'] = $content['cas_category'];
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
                        <div class="section__title"><?php echo $content['cas_title']?></div>
                        <?php
                    endif;

                    if(!empty($content['cas_subtitle'])):
                        ?>
                        <div class="section__subtitle">
                            <?php echo $content['cas_subtitle']?>
                        </div>
                        <?php
                    endif;
                    ?>
                </header>
                <?php
            endif;
            ?>
            <div class="section__content">
                <div class="card-list card-list_col-2">
                    <?php
                    while($casinos->have_posts()):
                        $casinos->the_post();

                        $id                         = get_the_ID();
                        $cas_img_id                 = get_post_thumbnail_id();
                        $cas_img_data               = apply_filters('ud_get_file_data', $cas_img_id);
                        $desc                       = get_post_meta($id, 'casino_short_desc', true);
                        $casino_overall_rating      = floatval(get_post_meta($id, 'casino_overall_rating', true));
                        $casino_external_link       = get_post_meta($id, 'casino_external_link', true);
                        ?>
                        <div class="casino-card">
                            <div class="casino-card__image">
                                <img src="<?php echo $cas_img_data['src']?>" alt="<?php echo $cas_img_data['alt']?>">
                            </div>
                            <div class="casino-card__title"><?php the_title()?></div>
                            <div class="casino-card__rating" data-rating="<?php echo $casino_overall_rating?>">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            <?php
                            if(!empty($desc)):
                            ?>
                            <div class="casino-card__subtitle">
                                <?php echo $desc?>
                            </div>
                            <?php
                            endif;
                            ?>
                            <div class="casino-card__cta">
                                <a href="<?php the_permalink()?>" class="casino-card__button button button_outline">Read review</a>
                                <?php
                                if(!empty($casino_external_link)):
                                    ?>
                                    <a href="<?php echo $casino_external_link?>" target="_blank" class="casino-card__button button">Play now</a>
                                    <?php
                                endif;
                                ?>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
endif;