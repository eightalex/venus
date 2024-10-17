<?php
get_header();

$ID 			= get_the_ID();
$app_banner_img	= intval(carbon_get_post_meta(get_the_ID(), 'app_banner_img'));
$app_banner_txt	= carbon_get_post_meta(get_the_ID(), 'app_banner_txt');
$custom_content = carbon_get_post_meta(get_the_ID(), 'ud_post_content');



echo '<pre>';
print_r($custom_content);
echo '</pre>';



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
}else{
    get_template_part("/theme-parts/modules/text", "editor", ['content' => ['text_editor' => get_the_content()]]);
}

get_footer();

