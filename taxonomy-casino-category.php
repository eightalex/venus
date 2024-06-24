<?php

$ID 			= get_queried_object()->term_id;
$app_banner_img	= intval(carbon_get_term_meta($ID, 'app_banner_img'));
$app_banner_txt	= carbon_get_term_meta($ID, 'app_banner_txt');
$content_editor = carbon_get_term_meta($ID, 'content_editor');
$content 		= carbon_get_term_meta($ID, 'ud_cat_content');

$cas_args = [
    'items_number'   => 9,
	'category'       => $ID
];

$casinos = apply_filters('ud_get_casinos', $cas_args);

if(empty($app_banner_img)){
	$app_banner_img = get_stylesheet_directory_uri()."/assets/images/banner/banner.svg";
}

get_header();
get_template_part('/theme-parts/modules/app-banner', '', ['img' => $app_banner_img, 'txt' => $app_banner_txt]);

if($casinos->have_posts()):
	?>
	<section class="section section_suits">
		<div class="container">
			<div class="section__inner">
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
				<?php
					$max_pages = $casinos->max_num_pages;
					$paged = $casinos->query['paged'];
					if($max_pages  > 1){
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