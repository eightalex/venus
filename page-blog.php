<?php
/*
Template Name: Blog Page
*/

$casinois 		= apply_filters('ud_get_casinos', []);
$ID 			= get_the_ID();
$custom_content = carbon_get_post_meta(get_the_ID(), 'ud_post_content');
$app_banner_img	= carbon_get_post_meta(get_the_ID(), 'app_banner_img');
$app_banner_txt	= carbon_get_post_meta(get_the_ID(), 'app_banner_txt');

get_header();

if(empty($app_banner_img)){
	get_template_part('/theme-parts/modules/breadcrumbs');
}else{
	get_template_part('/theme-parts/modules/app-banner', '', ['img' => $app_banner_img, 'txt' => $app_banner_txt]);
}

?>
<section class="section section_bg section_bg_6">
    <div class="container">
        <div class="section__inner">
            <div class="content">
                <main class="content__main">
					<?php do_action("ud_get_posts_loop", []);?>
                </main>

				<?php
				if($casinois->have_posts()):
					?>
					<aside class="content__sidebar">
						<div class="content__subtitle">
							News casino
						</div>
						<div class="content__sidebar-cards">

							<?php
								while($casinois->have_posts()):
									$casinois->the_post();

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
										'item_class'		=> 'casino-card_compact'
									];
									do_action('print_single_casino_template', $atts);
								endwhile;
							?>
						</div>
					</aside>
					<?php
				endif;
				?>	
            </div>
        </div>
    </div>
</section>
<?php 
if(!empty($custom_content)){
	foreach($custom_content as $part){
		$part_tmpl = $part['_type'];
		
		get_template_part("/theme-parts/modules/$part_tmpl", "", ["id" => $ID, "content"=>$part, "post_type" => 'page']);
	}
}

get_footer(); 
?>