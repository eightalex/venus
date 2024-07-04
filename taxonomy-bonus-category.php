<?php

$ID 			= get_queried_object()->term_id;
$app_banner_img	= intval(carbon_get_term_meta($ID, 'app_banner_img'));
$app_banner_txt	= carbon_get_term_meta($ID, 'app_banner_txt');
$content_editor = carbon_get_term_meta($ID, 'content_editor');
$content 		= carbon_get_term_meta($ID, 'ud_cat_content');

$terms = get_terms( array(
    'taxonomy'   => 'bonus-category',
) );

$bonuses = apply_filters('ud_get_bonuses', ['items_number' => -1, 'category' => $ID]);

if(empty($app_banner_img)){
	$app_banner_img = get_stylesheet_directory_uri()."/assets/images/banner/banner-2.svg";
}

get_header();
 
get_template_part('/theme-parts/modules/app-banner', '', ['img' => $app_banner_img, 'txt' => $app_banner_txt]);

if($bonuses['res']->have_posts()):
	?>

<section class="section section_p_0 section_bg section_bg_2">
    <div class="container">
        <div class="section__inner">
            <div class="content-cards">
                <?php
                if(!empty($terms)):
                    $def_active = isset($_GET['bonuses-cat'])? '': 'active';
                    ?>
                    <div class="content-cards__switch">
                        <div class="page-switch">
                            <?php
                            foreach($terms as $term):
                                $t_id   = $term->term_id;
                                $url    = get_term_link($t_id);
                                $active = $ID == $t_id? 'active': '';  
                                ?>
                                <a href="<?php echo $url?>" data-id="<?php echo $term->term_id?>" class="page-switch__button <?php echo $active?>"><?php echo $term->name?></a>
                                <?php
                            endforeach;
                            ?>
                        </div>
                    </div>
                    <?php
                endif;
                ?>
                <div class="content-cards__list">
                    <div class="card-list">
                        <?php
                        while($bonuses['res']->have_posts()):
                            $bonuses['res']->the_post();
                            $b_id   = get_the_ID();
                            $taxs   = wp_get_post_terms($b_id, 'bonus-category');
                            $lnk    = get_the_permalink();
                            $title  = get_the_title($b_id);
                            $data   = [
                                'title'             => "<a href='{$lnk}'>$title</a>",
                                'short_desc'        => get_post_meta($b_id, 'bonus_short_desc', true),
                                'external_link'     => get_post_meta($b_id, 'bonus_external_link', true),
                                'button_notice'     => get_post_meta($b_id, 'bonus_button_notice', true),
                                'offer_detailed_tc' => get_post_meta($b_id, 'offer_detailed_tc', true),
                                'bonus_code'        => get_post_meta($b_id, 'bonus_code', true),
                                'bonus_valid_date'  => get_post_meta($b_id, 'bonus_valid_date', true),
                                'tax'               => !empty($taxs)? $taxs[0]->name: '',
                                'tax_link'          => !empty($taxs)? get_term_link($taxs[0]->term_id): "",
                            ];

                            
                            echo apply_filters('print_single_bonus_card', $data);
                        endwhile;
                        ?>
                    </div>
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