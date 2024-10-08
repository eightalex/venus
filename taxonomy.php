<?php

$ID 			= get_queried_object()->term_id;
$intro_text 	= carbon_get_term_meta($ID, 'intro_text');
$content_editor = carbon_get_term_meta($ID, 'content_editor');
$content 		= carbon_get_term_meta($ID, 'ud_cat_content');

get_header();

$posts 	= get_posts(['category' => $ID, 'post-status' => 'publish']);
$tags 	= apply_filters('ud_get_tax_posts_tags', $posts);
 
get_template_part('/theme-parts/modules/breadcrumbs');

if($tags){
	get_template_part("/theme-parts/modules/tags", "list", ["tags" => $tags]);
}

if(!empty($intro_text)):
	get_template_part('/theme-parts/modules/intro-text', '', ['text'=>$intro_text]);
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