<?php
extract($args);

$post_type = get_post_type($id);
$current_id = $id;

$args_arr = [
    'items_number'  => $content['bonuses_count']
];
$tax        = 'bonus-category';

if($content['bonuses_parent'] == 'curent'){
    $bonus_cat  = wp_get_post_terms($id, $tax);
    $args_arr['category'] = $bonus_cat[0]->term_id;
}elseif($content['bonuses_parent'] == 'children'){
    $args_arr['parent_id'] = $id;
}

$bonuses = apply_filters('ud_get_bonuses', $args_arr);

if(!$bonuses['res']->have_posts()){
    return;
}

if($content['bonuses_filter_on']){
    get_template_part('theme-parts/modules/bonus-card-filter', '', ['bonuses' => $bonuses]);
    return;
}

$title_section      = !empty($content['bonuses_title'])? $content['bonuses_title']: get_the_title()." <em>bonuses</em>";
?>
<section class="section section_suits">
    <div class="container">
        <div class="section__inner">
            <header class="section__header">
                <div class="section__title"><?php echo $title_section?></div>
                <?php
                if(!empty($content['bonuses_subtitle'])):
                    ?>
                    <div class="section__subtitle">
                        <?php echo $content['bonuses_subtitle']?>
                    </div>
                    <?php
                endif;
                ?>
            </header>
            <div class="section__content">
                <div class="card-list">
                    <?php
                    while($bonuses['res']->have_posts()):
                        $bonuses['res']->the_post();
                        $b_id = get_the_ID();
                        $taxs = wp_get_post_terms($b_id, 'bonus-category');

                        $data = [
                            'title'             => get_the_title($b_id),
                            'short_desc'        => get_post_meta($b_id, 'bonus_short_desc', true),
                            'external_link'     => get_post_meta($b_id, 'bonus_external_link', true),
                            'button_notice'     => get_post_meta($b_id, 'bonus_button_notice', true),
                            'offer_detailed_tc' => get_post_meta($b_id, 'offer_detailed_tc', true),
                            'bonus_code'        => get_post_meta($b_id, 'bonus_code', true),
                            'bonus_valid_date'  => get_post_meta($b_id, 'bonus_valid_date', true),
                            'tax'               => !empty($taxs)? $taxs[0]->name: '',

                        ];
                        if($current_id !== $b_id){
                            echo apply_filters('print_single_bonus_card', $data);
                        }
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
