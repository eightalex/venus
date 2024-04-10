<!-- new header -->
<!-- <header class="header">
	<div class="container">
		<div class="header__inner">
			<a href="./index.html" class="header__logo">
				<img src="./images/logo.svg" alt="Logo">
			</a>
			<div class="header__search search">
				<input class="search__input custom-input" type="text" aria-label="search"
					placeholder="Type your text here">
				<button class="search__button">
					<img src="./images/icons/search.svg" alt="Search">
				</button>
			</div>
			<nav class="navigation">
				<ul class="navigation__inner">
					<li class="navigation__item dropdown"><a href="./bonus.html">Bonus</a></li>
					<li class="navigation__item dropdown"><a href="./games.html">Nettkasino</a></li>
					<li class="navigation__item dropdown"><a href="#">Betalingsmåter</a></li>
					<li class="navigation__item dropdown"><a href="#">Spilleautomater</a></li>
					<li class="navigation__item"><a href="#">Casinospill</a></li>
				</ul>
				<div class="navigation__burger">
					<img src="./images/icons/burger.svg" alt="burger">
				</div>
			</nav>
		</div>
	</div>
</header> -->

<!-- merge header -->


<!-- old header -->
<!-- <div
	class="space-header-height relative <?php if (get_theme_mod('mercury_enable_top_bar')) { ?> enable-top-bar<?php } ?>">
	<div class="space-header-wrap space-header-float relative">
		<?php if (get_theme_mod('mercury_enable_top_bar')) { ?>
			<div class="space-header-top relative">
				<div class="space-header-top-ins space-wrapper relative">
					<div class="space-header-top-menu box-75 left relative">
						<?php
						if (has_nav_menu('top-menu')) {
							wp_nav_menu(array('container' => 'ul', 'menu_class' => 'space-top-menu', 'theme_location' => 'top-menu', 'depth' => 1, 'fallback_cb' => '__return_empty_string'));
						}
						?>
					</div>
					<div class="space-header-top-soc box-25 right text-right relative">
						<?php get_template_part('/theme-parts/social-icons'); ?>
					</div>
				</div>
			</div>
		<?php } ?>
		<div class="space-header relative">
			<div class="space-header-ins space-wrapper relative">
				<div class="space-header-logo box-25 left relative">
					<div class="space-header-logo-ins relative">
						<?php
						$site_name = esc_attr(get_bloginfo('name'));
						$custom_logo_id = get_theme_mod('custom_logo');

						if (has_custom_logo()) {
							echo '<a href="' . esc_url(home_url('/')) . '" title="' . $site_name . '">' . wp_get_attachment_image($custom_logo_id, 'mercury-custom-logo', "", array("alt" => $site_name)) . '</a>';
						} else {
							echo '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name')) . '" class="text-logo">' . esc_html(get_bloginfo('name')) . '</a><span>' . esc_html(get_bloginfo('description')) . '</span>';
						}
						?>
					</div>
				</div>
				<div class="space-header-menu box-75 left relative">
					<?php
					if (has_nav_menu('main-menu')) {
						wp_nav_menu(array('container' => 'ul', 'menu_class' => 'main-menu', 'theme_location' => 'main-menu', 'depth' => 3, 'fallback_cb' => '__return_empty_string'));
					}
					?>
					<div class="space-header-search absolute">
						<i class="fas fa-search desktop-search-button"></i>
					</div>
					<div class="space-mobile-menu-icon absolute">
						<div></div>
						<div></div>
						<div></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
