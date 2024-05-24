<?php

$ID 			= get_queried_object()->term_id;
$custom_content = carbon_get_term_meta($ID, 'content_editor');

get_header();

$posts 	= get_posts(['category' => $ID, 'post-status' => 'publish']);
$tags 	= apply_filters('ud_get_tax_posts_tags', $posts);
?>

<?php 
if($tags){
	get_template_part("/theme-parts/modules/tags", "list", ["tags" => $tags]);
}

if(!empty($custom_content)){
	$part = ['text_editor' => $custom_content];
	get_template_part("/theme-parts/modules/text-editor", "", ["id" => $ID, "content"=>$part]);
}

get_footer(); 
?>