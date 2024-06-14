<?php get_header(); ?>

<section class="section section_suits">
    <div class="container">
        <div class="section__inner">
            <div class="page-404">
                <div class="page-404__title">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/404.svg" alt="404">
                </div>
                <div class="page-404__content">
                    <div class="page-404__subtitle">Oops!</div>
                    <div class="page-404__text">Noe gikk <em>galt!</em></div>
                    <div class="page-404__description">Side ikke funnet.</div>
                </div>
                <a href="<?php echo esc_url( home_url( '/' ) ) ?>" class="page-404__button button">Gå til hjemmesiden</a>
                <div class="page-404__image">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/ghost.svg" alt="ghost">
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
