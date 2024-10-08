<?php

$ID 			= get_queried_object()->term_id;
$app_banner_img	= intval(carbon_get_term_meta($ID, 'app_banner_img'));
$app_banner_txt	= carbon_get_term_meta($ID, 'app_banner_txt');
$intro_text 	= carbon_get_term_meta($ID, 'intro_text');
$content_editor = carbon_get_term_meta($ID, 'content_editor');
$content 		= carbon_get_term_meta($ID, 'ud_cat_content');

$q_args = [
    'post_type'         => 'game',
    'post-status'       => 'publish',
    'posts_per_page'    => -1,
    'tax_query'         => array(
                                array(
                                    'taxonomy' => 'vendor',
                                    'field'    => 'term_id',
                                    'terms'    => [$ID]
                                )
                            ),
];


if(empty($app_banner_img)){
	$app_banner_img = get_stylesheet_directory_uri()."/assets/images/banner/banner.svg";
}

get_header();

$posts  = new WP_Query($q_args);
wp_reset_postdata();

 
get_template_part('/theme-parts/modules/app-banner', '', ['img' => $app_banner_img, 'txt' => $app_banner_txt]);

if(!empty($intro_text)):
	get_template_part('/theme-parts/modules/intro-text', '', ['text'=>$intro_text]);
endif;

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
								'permalink'       => get_the_permalink(),
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