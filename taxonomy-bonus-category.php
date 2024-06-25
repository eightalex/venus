<?php

$ID 			= get_queried_object()->term_id;
$app_banner_img	= intval(carbon_get_term_meta($ID, 'app_banner_img'));
$app_banner_txt	= carbon_get_term_meta($ID, 'app_banner_txt');
$content_editor = carbon_get_term_meta($ID, 'content_editor');
$content 		= carbon_get_term_meta($ID, 'ud_cat_content');

$bonuses = apply_filters('ud_get_bonuses', ['items_number' => -1, 'category' => $ID]);

if(empty($app_banner_img)){
	$app_banner_img = get_stylesheet_directory_uri()."/assets/images/banner/banner-2.svg";
}

get_header();
?>

<?php 
get_template_part('/theme-parts/modules/app-banner', '', ['img' => $app_banner_img, 'txt' => $app_banner_txt]);

if($bonuses['res']->have_posts()):
	?>

<section class="section section_suits">
    <div class="container">
        <div class="section__inner">
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
                            echo apply_filters('print_single_bonus_card', $data);
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
endif;

if(!empty($content_editor)){
	$part = ['text_editor' => $content_editor];
	get_template_part("/theme-parts/modules/text-editor", "", ["id" => $ID, "content"=>$part]);
}

if(!empty($content)){
	foreach($content as $part){
		$part_tmpl = $part['_type'];
		
		get_template_part("/theme-parts/modules/$part_tmpl", "", ["id" => $ID, "content"=>$part, "post_type" => 'page']);
	}
}

get_footer(); 
?>