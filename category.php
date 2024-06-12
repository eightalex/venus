<?php

$ID 			= get_queried_object()->term_id;
$app_banner_img	= carbon_get_term_meta($ID, 'app_banner_img');
$app_banner_txt	= carbon_get_term_meta($ID, 'app_banner_txt');
$custom_content = carbon_get_term_meta($ID, 'content_editor');
$content 		= carbon_get_term_meta($ID, 'ud_cat_content');

get_header();

$posts 	= get_posts(['category' => $ID, 'post-status' => 'publish']);
$tags 	= apply_filters('ud_get_tax_posts_tags', $posts);
?>

<?php 

get_template_part('/theme-parts/modules/app-banner', '', ['img' => $app_banner_img, 'txt' => $app_banner_txt]);

if($tags){
	get_template_part("/theme-parts/modules/tags", "list", ["tags" => $tags]);
}

if(!empty($custom_content)){
	$part = ['text_editor' => $custom_content];
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