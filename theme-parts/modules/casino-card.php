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

                        $atts = [
                            'title'             => get_the_title(),
                            'img_src'           => $cas_img_id !== 0? $cas_img_data['src']: '',
                            'img_alt'           => $cas_img_id !== 0? $cas_img_data['alt']: get_the_title(), 
                            'rating'            => $casino_overall_rating,
                            'desc'              => $desc,
                            'permalink'         => get_the_permalink(),
                            'external_link'     => $casino_external_link,
                        ];
                        do_action('print_single_casino_template', $atts);
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
endif;