<?php
extract($args);

if(empty($content['gs_games'])){
    return;
}

$section_title      = $content['gs_title'];
$section_subtitle   = $content['gs_subtitle'];
$games              = $content['gs_games'];
?>
<section class="section section_suits">
    <div class="container">
        <div class="section__inner">
            <?php
            if(!empty($section_title) || !empty($section_subtitle)):
                ?>
                <header class="section__header">
                    <?php
                    if(!empty($section_title)):
                        ?>
                        <div class="section__title section__title_s"><?php echo $section_title?></div>
                        <?php
                    endif;

                    if(!empty($section_subtitle)):
                        ?>
                        <div class="section__subtitle">
                            <?php echo $section_subtitle?>
                        </div>
                        <?php
                    endif;
                    ?>
                </header>
                <?php
            endif;
            ?>
            <div class="section__content">
                <div class="slider">
                    <div class="slider__prev js-button-prev"></div>
                    <div class="slider__inner swiper">
                        <div class="swiper-wrapper">
                            <?php
                            foreach($games as $game):
                                $post_type          = get_post_type($game);
                                $rating             = floatval(get_post_meta($game, "{$post_type}_rating_one", true));
                                $external_link      = get_post_meta($game, "{$post_type}_external_link", true);
                                $attach_id          = get_post_thumbnail_id($game);
                                $attach_data        = apply_filters('ud_get_file_data', $attach_id);

                                ?>
                                <div class="swiper-slide">
                                    <div class="slot">
                                        <div class="slot__image">
                                            <img src="<?php echo $attach_data['src']?>" alt="<?php echo $attach_data['alt']?>" />
                                        </div>
                                        <div class="slot__content">
                                            <div class="slot__header">
                                                <div class="slot__title"><?php echo get_the_title($game)?></div>
                                                <div class="slot__rating-mobile">
                                                    <!-- START: Зробити новий блок rating-mobile -->
                                                    <!-- Та використати його в game-rating блоці -->
                                                    <div class="rating-mobile" data-rating="<?php echo $rating?>">
                                                        <img src="../assets/images/icons/star.svg" alt="star">
                                                    </div>
                                                    <!-- END: Зробити новий блок rating-mobile -->
                                                </div>
                                            </div>
                                            <div class="slot__rating">
                                                <?php
                                                get_template_part('/theme-parts/modules/rating', 'stars', ['rat' => $rating])
                                                ?>
                                            </div>
                                            <div class="slot__text">
                                                <?php the_excerpt($game)?>
                                            </div>
                                            <div class="slot__footer">
                                                <a href="<?php echo $external_link?>" class="button slot__button">Play now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endforeach;
                            ?>
                        </div>
                    </div>
                    <div class="slider__next js-button-next"></div>
                </div>
            </div>
        </div>
    </div>
</section>