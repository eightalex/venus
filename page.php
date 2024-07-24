<?php

$ID 					= get_the_ID();
$custom_content 		= carbon_get_post_meta($ID, 'ud_post_content');
$app_banner_img			= intval(carbon_get_post_meta($ID, 'app_banner_img'));
$app_banner_txt			= carbon_get_post_meta($ID, 'app_banner_txt');
$app_banner_is_author	= carbon_get_post_meta($ID, 'app_banner_is_author');
$intro_text 			= carbon_get_post_meta($ID, 'intro_text');
$is_main_game_page 		= (carbon_get_theme_option('default_page_game') == $ID);
$is_main_bonus_page		= (carbon_get_theme_option('default_page_bonus') == $ID);
$is_main_casinois_page	= (carbon_get_theme_option('default_page_casinois') == $ID);

get_header();

if(empty($app_banner_img) && !$app_banner_is_author){
	get_template_part('/theme-parts/modules/breadcrumbs');

	?>
	<h1 class="section__title"><?php the_title()?></h1>
	<?php
}elseif(!empty($app_banner_img) && !$app_banner_is_author){
	get_template_part('/theme-parts/modules/app-banner', '', ['img' => $app_banner_img, 'txt' => $app_banner_txt]);
}elseif($app_banner_is_author){
	get_template_part('/theme-parts/modules/banner', 'author_single', ['id' => $ID]);
}

if(!empty($intro_text)):
	get_template_part('/theme-parts/modules/intro-text', '', ['text'=>$intro_text]);
endif;

if($is_main_game_page){
	$games = apply_filters('ud_get_games', ['items_number'  => 9]);
	get_template_part('theme-parts/modules/game-card-filter', '', ['games' => $games, 'filter' => true]);
}elseif($is_main_bonus_page){
	// $content = ['bonuses_count' => -1];
	// get_template_part('theme-parts/modules/bonus-card', '', ['id' => $ID, 'content' => $content]);
	$bonuses = apply_filters('ud_get_bonuses', ['bonuses_count' => -1]);
	$b_args = ['bonuses' => $bonuses];
	$bonuses = apply_filters('ud_get_bonuses', $b_args);
	get_template_part('theme-parts/modules/bonus-card-filter', '', ['id' => $ID, 'bonuses' => $bonuses]);
}elseif($is_main_casinois_page){
	$casinois = apply_filters('ud_get_casinos', ['items_number'  => 8]);
	// $content = ['casinos' => $casinois, 'filter' => false]; 
	get_template_part('theme-parts/modules/casinois-card-filter', '', ['casinos' => $casinois]);
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