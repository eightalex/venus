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
				Trd.by er en anmeldelsesside for populære nettcasinoer i Norge. På nettstedet vårt kan du bare
				finne aktuelle og ærlige anmeldelser av casinomerker, bonuser, spill og andre tilbud.
			</div>
		</div>
		<nav class="footer__nav">
			<ul class="footer__list">
				<li class="footer__item">
					<a href="#" class="footer__link">Happy Spins Casino</a>
				</li>
				<li class="footer__item">
					<a href="#" class="footer__link">Lilibet casino</a>
				</li>
				<li class="footer__item">
					<a href="#" class="footer__link">Dette er trd.by</a>
				</li>
				<li class="footer__item">
					<a href="#" class="footer__link">Kontakt</a>
				</li>
				<li class="footer__item">
					<a href="#" class="footer__link">Ansvarlig spilling</a>
				</li>
				<li class="footer__item">
					<a href="#" class="footer__link">Informasjoskapsler</a>
				</li>
			</ul>
			<ul class="footer__list">
				<li class="footer__item">
					<a href="#" class="footer__link">Personvernerklaring</a>
				</li>
				<li class="footer__item">
					<a href="#" class="footer__link">Vart oppdrag</a>
				</li>
				<li class="footer__item">
					<a href="#" class="footer__link">Hvordan vurderer vi nettcasinoer?</a>
				</li>
				<li class="footer__item">
					<a href="#" class="footer__link">Teamet vart</a>
				</li>
				<li class="footer__item">
					<a href="#" class="footer__link">FAQ</a>
				</li>
			</ul>
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

<!-- <div class="space-footer box-100 relative">
	<?php if ( is_active_sidebar( 'footer-center-sidebar' ) ) { ?>
	<div class="space-footer-top box-100 relative" <?php if(get_theme_mod('mercury_footer_bg')) { ?>style="background-position: center bottom; background-repeat: no-repeat; background-size: cover; background-image: url('<?php echo esc_url( get_theme_mod( 'mercury_footer_bg' ) ) ?>');"<?php } ?>>
		<div class="space-footer-ins relative">
			<div class="space-footer-top-center box-100 relative">
				<?php dynamic_sidebar( 'footer-center-sidebar' ); ?>
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="space-footer-copy box-100 relative">
		<div class="space-footer-ins relative">
			<div class="space-footer-copy-left box-50 left relative">
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
			<div class="space-footer-copy-menu box-50 left relative">
				<?php
					if (has_nav_menu('footer-menu')) {
						wp_nav_menu( array( 'container' => 'ul', 'menu_class' => 'space-footer-menu', 'theme_location' => 'footer-menu', 'depth' => 1, 'fallback_cb' => '__return_empty_string' ) );
					}
				?>
			</div>
		</div>
	</div>
</div> -->

<!-- Footer End -->

<!-- </div> -->

<!-- Mobile Menu Start -->

<?php get_template_part('/theme-parts/mobile-menu'); ?>

<!-- Mobile Menu End -->

<!-- Back to Top Start -->

<div class="space-to-top">
    <a href="#" id="scrolltop" title="<?php esc_attr_e('Back to Top', 'mercury'); ?>"><i
            class="far fa-arrow-alt-circle-up"></i></a>
</div>

<!-- Back to Top End -->

<?php wp_footer(); ?>

</body>

</html>