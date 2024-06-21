<?php

$ID 			= get_queried_object()->term_id;
$app_banner_img	= intval(carbon_get_term_meta($ID, 'app_banner_img'));
$app_banner_txt	= carbon_get_term_meta($ID, 'app_banner_txt');
$content_editor = carbon_get_term_meta($ID, 'content_editor');
$content 		= carbon_get_term_meta($ID, 'ud_cat_content');

$q_args = [
    'post_type'         => 'game',
    'post-status'       => 'publish',
    'posts_per_page'    => -1,
    'tax_query'         => array(
                                array(
                                    'taxonomy' => 'game-category',
                                    'field'    => 'term_id',
                                    'terms'    => [$ID]
                                )
                            ),
];

$posts  = new WP_Query($q_args);
wp_reset_postdata();
// $tags 	= apply_filters('ud_get_tax_posts_tags', $posts);

if(empty($app_banner_img)){
	$app_banner_img = get_stylesheet_directory_uri()."/assets/images/banner/banner-3.svg";
}

get_header();
?>

<?php 
get_template_part('/theme-parts/modules/app-banner', '', ['img' => $app_banner_img, 'txt' => $app_banner_txt]);


// if($tags){
// 	get_template_part("/theme-parts/modules/tags", "list", ["tags" => $tags]);
// }

if($posts->have_posts()):
?>
<section class="section section_bg section_bg_3">
    <div class="container">
        <div class="section__inner">
            <div class="section__content">
                <ul class="card-list">
                    <?php
                    while($posts->have_posts()):
                        $posts->the_post();

                        $g_id       = get_the_ID();
                        $g_img_id   = get_post_thumbnail_id();
                        $gel        = get_post_meta( $g_id, 'game_external_link', true );

                        $game_params = [
                            'g_img_data'      => apply_filters('ud_get_file_data', $g_img_id),
                            'title'           => get_the_title(),
                            'short_desc'      => get_post_meta( $g_id, 'game_short_desc', true ),
                            'button_notice'   => get_post_meta( $g_id, 'casino_button_notice', true ),
                            'external_link'   => !empty($gel)? esc_url( $gel ): get_the_permalink(),
                            'unit_detailed'   => get_post_meta( $g_id, 'unit_detailed_tc', true ),
                        ];

                        echo apply_filters('ud_print_single_game', $game_params);
                    endwhile;
                    ?>
                </ul>
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