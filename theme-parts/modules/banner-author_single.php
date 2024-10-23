<?php
extract($args);

$title               = !empty($txt)? $txt: get_the_title();
$app_banner_img	     = intval(carbon_get_post_meta(get_the_ID(), 'app_banner_img'));

if($app_banner_img){
    $img_data = apply_filters('ud_get_file_data', $app_banner_img);
}

?>
<section class="section section--overlay section_bg_7 section_custom_bg">
    <div class="container">
        <div class="section__inner">
            <div class="banner-author">
                <?php
                    get_template_part('/theme-parts/modules/breadcrumbs', '', ['inline' => true]);
                ?>
                <header class="banner-author__header">
                    <h1 class="banner-author__title">
                        <?php
                            echo do_shortcode($title);
                        ?>
                    </h1>
                </header>
                <?php get_template_part("/theme-parts/modules/post-info", null, ['tag' => 'footer']) ?>
            </div>
        </div>
    </div>

	<?php
	if ( !empty( $img_data ) ) {
		$overlay_img_id = attachment_url_to_postid($img_data['src']);

		$overlay_img = $img_data['src'];
		$overlay_img_sm = wp_get_attachment_image_src($overlay_img_id, 'large')[0];

	} else {
		$overlay_img = get_stylesheet_directory_uri() . '/assets/images/section/bg7.webp';
		$overlay_img_sm = get_stylesheet_directory_uri() . '/assets/images/section/bg7-sm.webp';
	}
	?>
    <div class="section__overlay">
        <picture>
            <source media="(max-width: 1024px)" srcset="<?php echo $overlay_img_sm; ?>">
            <img src="<?php echo $overlay_img; ?>" alt="" class="section__overlay-img" fetchpriority="high">
        </picture>
    </div>
</section>
