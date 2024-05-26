<?php

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

if(!empty($custom_content)){
	foreach($custom_content as $part){
		$part_tmpl = $part['_type'];
		
		get_template_part("/theme-parts/modules/$part_tmpl", "", ["id" => $ID, "content"=>$part, "post_type" => 'page']);
	}
}

get_footer(); 
?>