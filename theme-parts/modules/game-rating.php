<?php
if(!empty($args)){
    extract($args);
}

$games = $content['rating_posts_list'];

if(empty($games)){
    return;
}

$play_now_txt       = !empty(get_option('games_play_now_title'))? get_option('games_play_now_title'): __('Play now');
$read_review_txt    = !empty(get_option('games_read_review_title'))? get_option('games_read_review_title'): __('Read Review');

?>
<section class="section section_suits">
    <div class="container">
        <div class="section__inner">
            <header class="section__header">
                <?php
                if(!empty($content['rating_games_title'])):
                    ?>
                    <h2 class="section__title section__title_s"><?php echo $content['rating_games_title']?></h2>
                    <?php
                endif;

                if(!empty($content['rating_games_subtitle'])):
                ?>
                <div class="section__subtitle">
                    <?php
                        echo $content['rating_games_subtitle'];
                    ?>
                </div>
                <?php
                endif;
                ?>
            </header>
            <div class="section__content">
                <ul class="game-rating">
                    <?php
                    foreach($games as $game):
                        $post_type          = get_post_type($game);
                        $rating             = floatval(get_post_meta($game, "{$post_type}_rating_one", true));
                        $external_link      = get_post_meta($game, "{$post_type}_external_link", true);
                        $attach_id          = get_post_thumbnail_id($game);
                        $attach_data        = apply_filters('ud_get_file_data', $attach_id);
                        $external_link      = get_post_meta($game, "{$post_type}_external_link", true);
                        $permalink          = get_the_permalink($game);
                        ?>
                        <li class="game-rating__item">
                            <div class="game-rating__img">
                                <img src="<?php echo $attach_data['src']?>" alt="<?php echo $attach_data['alt']?>">
                            </div>
                            <header class="game-rating__header">
                                <div class="game-rating__title"><?php echo get_the_title($game)?></div>
                                <div class="game-rating__rating-mobile" data-rating="<?php echo $rating?>">
                                    <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/icons/star.svg'?>" alt="star">
                                </div>
                                <div class="game-rating__rating">
                                    <?php
                                    get_template_part('theme-parts/modules/rating-stars','', ['rat' => $rating]);
                                    ?>
                                </div>
                            </header>
                            <div class="game-rating__cta">
                                <a href="<?php echo $permalink?>" class="game-rating__button button button_outline"><?php echo $read_review_txt?></a>
                                <?php
                                if(!empty($external_link)):
                                ?>
                                <a href="<?php echo $external_link?>" target="_blank" class="game-rating__button button"><?php echo $play_now_txt?></a>
                                <?php
                                endif;
                                ?>
                            </div>
                        </li>
                        <?php
                    endforeach;
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>
