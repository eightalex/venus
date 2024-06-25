<!-- Footer Start -->

<?php
	$logo_id = get_theme_mod( 'custom_logo' );

	$logo_data = apply_filters('ud_get_file_data', $logo_id);
?>
<footer class="footer">
	<div class="container footer__container">
		<div class="footer__info">
			<a class="footer__logo" href="<?php echo get_home_url()?>">
				<img src=<?php echo get_stylesheet_directory_uri()."/assets/images/logo.svg"?> alt="logo">
			</a>
			<div class="footer__text">
				<?php if(get_theme_mod('footer_copyright') == '') { ?>
						<?php esc_html_e( '&copy; Copyright', 'mercury' ); ?> <?php echo esc_html( date( 'Y' ) ) ?> <?php echo esc_html( get_bloginfo( 'name' ) ) ?> | <?php esc_html_e( 'Powered by', 'mercury' ); ?> <a href="<?php echo esc_url( __( 'https://wordpress.org', 'mercury' ) ); ?>" target="_blank" title="<?php esc_attr_e( 'WordPress', 'mercury' ); ?>"><?php esc_html_e( 'WordPress', 'mercury' ); ?></a> | <a href="<?php echo esc_url( __( 'https://mercurytheme.com', 'mercury' ) ); ?>" target="_blank" title="<?php esc_attr_e( 'Affiliate Marketing WordPress Theme. Reviews and Top Lists', 'mercury' ); ?>"><?php esc_html_e( 'Mercury Theme', 'mercury' ); ?></a>
					<?php } else { ?>
						<?php
							$allowed_html = array(
								'a' => array(
									'href' => true,
									'title' => true,
									'target' => true,
								),
								'br' => array(),
								'em' => array(),
								'strong' => array(),
								'span' => array(),
								'p' => array()
							);
							echo wp_kses( get_theme_mod( 'footer_copyright' ), $allowed_html );
						?>
					<?php } ?>
			</div>
		</div>
		<nav class="footer__nav">
			<?php
				$left_menu_items = "";
				$rigt_menu_items = "";
				$menu_items = wp_get_nav_menu_items('Footer menu');
				$menu_infos_items = wp_get_nav_menu_items('Footer - Further info');

				// if(!empty($menu_items)){
				// 	$items_count = count($menu_items);
				// 	foreach($menu_items as $k => $item){
				// 		$html = "<li class='footer__item'>
				// 					<a href='{$item->url}' class='footer__link'>{$item->title}</a>
				// 				</li>";
				// 		if($k < $items_count/2){
				// 			$left_menu_items .= $html;
				// 		}else{
				// 			$rigt_menu_items .= $html;
				// 		}

				// 	}
				// }

			if(!empty($menu_items)){
				foreach($menu_items as $k => $item){
					$html = "<li class='footer__item'>
								<a href='{$item->url}' class='footer__link'>{$item->title}</a>
							</li>";

					$rigt_menu_items .= $html;	
				}
			};

			if(!empty($menu_infos_items)){
				foreach($menu_infos_items as $k => $item){
					$html = "<li class='footer__item'>
								<a href='{$item->url}' class='footer__link'>{$item->title}</a>
							</li>";

					$left_menu_items .= $html;	
				}
			}	

			if(!empty($left_menu_items)):
				?>
				<ul class="footer__list">
					<?php echo $left_menu_items?>
				</ul>
				<?php
			endif;

			if(!empty($rigt_menu_items)):
				?>
				<ul class="footer__list">
					<?php echo $rigt_menu_items?>
				</ul>
				<?php
			endif;
			?>
		</nav>
		<div class="footer__social">
			<a href="#" class="footer__social-link">
				<img src=<?php echo get_stylesheet_directory_uri()."/assets/images/icons/social/hjelpelinjen.png"?> alt="hjelpelinjen" style="height: 29px;">
			</a>
			<a href="#" class="footer__social-link">
				<img src=<?php echo get_stylesheet_directory_uri()."/assets/images/icons/social/spill_ansvarlig.svg"?> alt="spill_ansvarlig">
			</a>
		</div>
	</div>
</footer>

<!-- Footer End -->

<!-- Mobile Menu Start -->

<?php get_template_part('/theme-parts/mobile-menu'); ?>

<!-- Mobile Menu End -->

<?php wp_footer(); ?>

</body>

</html>
