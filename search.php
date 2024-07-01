<?php

global $wp_query;

$q_arr = [
    'posts_per_page' => get_option('posts_per_page'),
    'post_type'      => 'casino',
    'post_status'    => 'publish',
    'order'          => 'DESC',
    'orderby'        => 'meta_value_num',
    'meta_key'       => 'casino_overall_rating',
    'meta_query'     => [
        [
            'key'    => 'casino_overall_rating',
            'type'   => 'NUMERIC',
            'compare' => 'EXISTS'
        ]
    ],
];

$casinos = new WP_Query($q_arr);

$max_pages = $wp_query->max_num_pages;

get_header();

get_template_part('/theme-parts/modules/app-banner', '', [
    'txt' => __( 'Søkeresultater for: ' ) . '<em>' . get_search_query() . '</em>',
    'img' => get_stylesheet_directory_uri() . '/assets/images/banner/banner-search.svg',
]);

?>

<section class="section section_bg section_bg_6">
    <div class="container">
        <div class="section__inner">
            <div class="content">
                <main class="content__main">
                    <div class="search-results-list">
                        <header class="search-results-list__header">
                            <h2 class="search-results-list__title">
                                <?php

                                if ( have_posts() ) {
                                    echo $wp_query->found_posts . ' ' . __( 'Resultater funnet' );
                                } else {
                                    echo __( 'Ingenting funnet' );
                                }

                                ?>
                            </h2>
                            <?php

                            if ( ! have_posts() ) {
                                echo '<div class="search-results-list__subtitle">';
                                echo __( 'Prøv et annet søkeord.' );
                                echo '</div>';
                            }

                            if ( have_posts() && $max_pages > 1 ) {
                                echo '<div class="search-results-list__subtitle">';
                                $current_page = max(1, get_query_var('paged'));
                                echo __( 'Side' ) . ' ' . $current_page . ' ' . __( 'av' ) . ' ' . $max_pages;
                                echo '</div>';
                            }

                            ?>
                        </header>

                        <?php if ( have_posts() ) : ?>
                            <div class="search-results-list__content">
                                <?php while ( have_posts() ) : the_post();

                                $post_image = has_post_thumbnail() ? esc_url( get_the_post_thumbnail_url() ) : get_stylesheet_directory_uri() . '/assets/images/no-image.jpg';

                                ?>
                                    <a class="search-result" href="<?php the_permalink(); ?>">
                                        <div class="search-result__image">
                                            <img src="<?php echo $post_image ?>"
                                                 alt="<?php the_title_attribute(); ?>"
                                            >
                                        </div>
                                        <div class="search-result__content">
                                            <div class="search-result__title">
                                                <?php the_title(); ?>
                                            </div>
                                            <div class="search-result__date">
                                                <?php the_time( get_option( 'date_format' ) ); ?>
                                            </div>
                                            <div class="search-result__excerpt">
                                                <?php the_excerpt(); ?>
                                            </div>
                                        </div>
                                    </a>
                                <?php endwhile; ?>
                            </div>
                        <?php endif;

                        $big = 999999999;

                        echo '<div class="pagination content__pagination" data-max_pages="' . $max_pages . '">';

                        echo paginate_links(array(
                            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                            'format' => '?paged=%#%',
                            'current' => max(1, get_query_var('paged')),
                            'total' => $max_pages,
                            'mid_size' => 3,
                            'prev_next' => true,
                            'add_args' => false,
                            'add_fragment' => '',
                        ));

                        echo '</div>';
                        ?>
                    </div>
                </main>
                <aside class="content__sidebar">
                    <div class="content__subtitle">
                        <?php echo __('Popular casino'); ?>
                    </div>
                    <div class="content__sidebar-cards">
                        <?php
                        foreach($casinos->posts as $casino):
                            $casino_id                  = $casino->ID;
                            $cas_img_id                 = get_post_thumbnail_id($casino_id);
                            $cas_img_data               = apply_filters('ud_get_file_data', $cas_img_id);
                            $casino_overall_rating      = floatval(get_post_meta($casino_id, 'casino_overall_rating', true));
                            $casino_external_link       = get_post_meta($casino_id, 'casino_external_link', true);
                            $desc                       = get_post_meta($casino_id, 'casino_short_desc', true);
                            $lb_txt                     = !empty(get_option('casinos_read_review_title'))? get_option('casinos_read_review_title'): 'Read review';
                            $elb_txt                    = !empty(get_option('casinos_play_now_title'))? get_option('casinos_play_now_title'): 'Play now';
                            ?>
                            <div class="casino-card casino-card_compact">
                                <div class="casino-card__image">
                                    <img src="<?php echo $cas_img_data['src']?>" alt="<?php echo $cas_img_data['alt']?>">
                                </div>
                                <div class="casino-card__title"><?php echo get_the_title($casino_id)?></div>

                                <div class="rating-mobile casino-card__rating" data-rating="<?php echo $casino_overall_rating?>">
                                    <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/icons/star.svg'?>" alt="star">
                                </div>

                                <div class="casino-card__subtitle">
                                    <?php echo $desc?>
                                </div>

                                <div class="casino-card__cta">
                                    <a class="casino-card__button button button_outline" href='<?php echo get_the_permalink($casino_id)?>'><?php echo $lb_txt ?></a>
                                    <?php
                                    if(!empty($casino_external_link)):
                                        ?>
                                        <a class="casino-card__button button" href="<?php echo $casino_external_link?>"><?php echo $elb_txt?></a>
                                    <?php
                                    endif;
                                    ?>
                                </div>
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
