<?php

$ID 					= get_the_ID();
$custom_content 		= carbon_get_post_meta(get_the_ID(), 'ud_post_content');
$app_banner_img			= intval(carbon_get_post_meta(get_the_ID(), 'app_banner_img'));
$app_banner_txt			= carbon_get_post_meta(get_the_ID(), 'app_banner_txt');
$is_main_game_page 		= (carbon_get_theme_option('default_page_game') == $ID);
$is_main_bonus_page		= (carbon_get_theme_option('default_page_bonus') == $ID);
$is_main_casinois_page	= (carbon_get_theme_option('default_page_casinois') == $ID);

get_header();


if(empty($app_banner_img)){
	get_template_part('/theme-parts/modules/breadcrumbs');
}else{
	get_template_part('/theme-parts/modules/app-banner', '', ['img' => $app_banner_img, 'txt' => $app_banner_txt]);
}

if($is_main_game_page){
	$games = apply_filters('ud_get_games', ['items_number'  => 9]);
	get_template_part('theme-parts/modules/game-card-filter', '', ['games' => $games, 'filter' => false]);
}elseif($is_main_bonus_page){
	$content = ['bonuses_count' => -1];
	get_template_part('theme-parts/modules/bonus-card', '', ['id' => $ID, 'content' => $content]);
}elseif($is_main_casinois_page){
	$casinois = apply_filters('ud_get_casinos', ['items_number'  => 8]);
	get_template_part('theme-parts/modules/casino-card', '', ['casinos' => $casinois, 'filter' => false]);
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
?>