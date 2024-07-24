<?php

$ID 				= get_queried_object()->term_id;
$app_banner_img		= intval(carbon_get_term_meta($ID, 'app_banner_img'));
$app_banner_txt		= carbon_get_term_meta($ID, 'app_banner_txt');
$intro_text 		= carbon_get_term_meta($ID, 'intro_text');
$content_editor 	= carbon_get_term_meta($ID, 'content_editor');
$content 			= carbon_get_term_meta($ID, 'ud_cat_content');
$main_casinois_page	= carbon_get_theme_option('default_page_casinois');
$is_paginavi 		= apply_filters('is_paginavi', 0);

$cas_args = [
    'items_number'   => 9,
	'category'       => $ID
];

$terms = get_terms( array(
    'taxonomy'   => 'casino-category',
) );

$casinos = apply_filters('ud_get_casinos', $cas_args);

if(empty($app_banner_img)){
	$app_banner_img = get_stylesheet_directory_uri()."/assets/images/banner/banner.svg";
}

get_header();
get_template_part('/theme-parts/modules/app-banner', '', ['img' => $app_banner_img, 'txt' => $app_banner_txt]);

if(!empty($intro_text)):
	get_template_part('/theme-parts/modules/intro-text', '', ['text'=>$intro_text]);
endif;

if($casinos->have_posts()):
	?>
	<section class="section section_suits">
		<div class="container">
			<div class="section__inner">
				<div class="section__content">
					<div class="content-cards">
						<div class="content-cards__switch">
							<div class="page-switch">
								<?php
								if($main_casinois_page && !empty($main_casinois_page)):
									?>
									<a href="<?php echo get_the_permalink($main_casinois_page)?>" class="page-switch__button">alle nettkasinoer</a>
									<?php
								endif;

								foreach($terms as $term):
									$t_id   = $term->term_id;
									$url    = get_term_link($t_id);
									$active = $ID == $t_id? 'active': '';
									?>
									<a href="<?php echo $url?>" class="page-switch__button <?php echo $active?>"><?php echo $term->name?></a>
									<?php
								endforeach;
								?>
							</div>
						</div>

						<div class="card-list card-list_col-2" style="margin-top: 40px;">
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

if(!$is_paginavi){
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
}

get_footer(); 
?>