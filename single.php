<?php get_header(); ?>

<div id="post-<?php the_ID(); ?>">
	<?php

    $ID 					= get_the_ID();
    $custom_content 		= carbon_get_post_meta($ID, 'ud_post_content');
	$app_banner_is_author 	= carbon_get_post_meta($ID, 'app_banner_is_author');
	$app_banner_txt 		= carbon_get_post_meta($ID, 'app_banner_txt');
	$app_banner_img 		= intval(carbon_get_post_meta($ID, 'app_banner_img'));
	$intro_text 			= carbon_get_post_meta($ID, 'intro_text');
	$post_type 				= get_post_type();

    if(!empty($custom_content)){
		if(is_singular( 'bonus' )){
			get_template_part('/theme-parts/content', 'bonus');
		}elseif(is_singular( 'game' )){
			get_template_part('/theme-parts/content', 'game');
		}elseif(is_singular( 'post' )){
            include_once('theme-parts/content-article.php');
		}else{
			get_template_part('/theme-parts/modules/breadcrumbs');

			foreach($custom_content as $part){
				$part_tmpl = $part['_type'];
				get_template_part("/theme-parts/modules/$part_tmpl", "", ["id" => $ID, "content"=>$part, "post_type" => $post_type]);
			}
		}

    }elseif ( is_singular( 'casino' ) ) {

		// Get the page template if the custom post type is "Casino"

		$casino_style = get_post_meta( get_the_ID(), 'casino_style', true );

		if ($casino_style == 1) {
			get_template_part( '/aces/single-casino/style-1' );
		} else if ($casino_style == 2) {
			get_template_part( '/aces/single-casino/style-2' );
		} else if ($casino_style == 3) {
			get_template_part( '/aces/single-casino/style-1-without-sidebar' );
		} else if ($casino_style == 4) {
			get_template_part( '/aces/single-casino/style-2-without-sidebar' );
		} else if ($casino_style == 5) {
			get_template_part( '/aces/single-casino/style-3' );
		} else if ($casino_style == 6) {
			get_template_part( '/aces/single-casino/style-3-without-sidebar' );
		} else if ($casino_style == 7) {
			get_template_part( '/theme-parts/single-empty' );
		} else if ($casino_style == 8) {
			get_template_part( '/theme-parts/single-empty-sidebar' );
		} else {
			get_template_part( '/aces/single-casino/style-1' );
		}

	} elseif ( is_singular( 'game' ) ) {
		get_template_part('/theme-parts/content', 'game');
		// Get the page template if the custom post type is "Game"

		// $game_style = get_post_meta( get_the_ID(), 'game_style', true );

		// if ($game_style == 2) {
		// 	get_template_part( '/aces/single-game/style-1-without-sidebar' );
		// } else if ($game_style == 3) {
		// 	get_template_part( '/aces/single-game/style-2' );
		// } else if ($game_style == 4) {
		// 	get_template_part( '/aces/single-game/style-2-without-sidebar' );
		// } else if ($game_style == 5) {
		// 	get_template_part( '/aces/single-game/style-3' );
		// } else if ($game_style == 6) {
		// 	get_template_part( '/aces/single-game/style-3-without-sidebar' );
		// } else if ($game_style == 7) {
		// 	get_template_part( '/theme-parts/single-empty' );
		// } else if ($game_style == 8) {
		// 	get_template_part( '/theme-parts/single-empty-sidebar' );
		// } else {
		// 	get_template_part( '/aces/single-game/style-1' );
		// }

	} elseif ( is_singular( 'bonus' ) ) {
		get_template_part('/theme-parts/content', 'bonus');

	} elseif ( is_singular( 'slotsl' ) ) {

		// Get the page template if the custom post type is "Slots Launch"

		get_template_part( '/theme-parts/slotslaunch/style-1' );

	} else {

		// Get the page template if the custom post type is "Post"

		$post_style = get_post_meta( get_the_ID(), 'post_style', true );

        if ($post_style == 1) {
        get_template_part( '/theme-parts/single/style-1' );
        } else if ($post_style == 2) {
            get_template_part( '/theme-parts/single/style-2' );
        } else if ($post_style == 3) {
            get_template_part( '/theme-parts/single/style-3' );
        } else if ($post_style == 4) {
            get_template_part( '/theme-parts/single/style-4' );
        } else if ($post_style == 5) {
            get_template_part( '/theme-parts/single-empty' );
        } else if ($post_style == 6) {
            get_template_part( '/theme-parts/single-empty-sidebar' );
        } else {
            get_template_part( '/theme-parts/single/style-1' );
        }
	}

	?>

</div>

<?php get_footer( null, [ 'id' => $ID, 'post_type' => $post_type ] ); ?>
