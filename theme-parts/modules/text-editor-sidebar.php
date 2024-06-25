<?php
extract($args);

$play_now_txt       = !empty(get_option('games_play_now_title'))? get_option('games_play_now_title'): __('Play now');
$read_review_txt    = !empty(get_option('games_read_review_title'))? get_option('games_read_review_title'): __('Read Review');
?>
<section class="section section_p_0 section_bg section_bg_6">
    <div class="container">
        <div class="section__inner">
            <div class="content">
                <main class="content__main">
                    <!-- START: TEXT-EDITOR BLOCK -->
                    <div class="variable-content">
                        <?php echo apply_filters('the_content',get_the_content());?>
                    </div>
                    <!-- END: TEXT-EDITOR BLOCK -->
                    <!-- SOCIAL BUTTONS -->

                    <!-- END: SOCIAL BUTTONS -->
                </main>
                <?php
                if(!empty($casinois)):
                    ?>
                    <aside class="content__sidebar">
                        <?php
                        if(!empty($casinois_list_title)):
                            ?>
                            <div class="content__subtitle">
                                <?php echo $casinois_list_title?>
                            </div>
                            <?php
                        endif;
                        ?>
                        <div class="content__sidebar-cards">
                            <?php
                            foreach($casinois->posts as $casino):
                                $casino_id                  = $casino->ID;
                                $cas_img_id                 = get_post_thumbnail_id($casino_id);
                                $cas_img_data               = apply_filters('ud_get_file_data', $cas_img_id);
                                $casino_overall_rating      = floatval(get_post_meta($casino_id, 'casino_overall_rating', true));
                                $casino_external_link       = get_post_meta($casino_id, 'casino_external_link', true);
                                $desc                       = get_post_meta($casino_id, 'casino_short_desc', true);
                                ?>
                                    <div class="casino-card casino-card_compact">
                                        <div class="casino-card__image">
                                            <img src="<?php echo $cas_img_data['src']?>" alt="<?php echo $cas_img_data['alt']?>">
                                        </div>
                                        <div class="casino-card__title"><?php echo get_the_title($casino_id)?></div>

                                        <div class="casino-card__rating" data-rating="<?php echo $casino_overall_rating ?>">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>

                                        <div class="casino-card__subtitle">
                                            <?php echo $desc?>
                                        </div>

                                        <div class="casino-card__cta">
                                            <a class="casino-card__button button button_outline" href='<?php echo get_the_permalink($casino_id)?>'><?php echo $read_review_txt?></a>
                                            <?php
                                            if(!empty($casino_external_link)):
                                            ?>
                                            <a class="casino-card__button button" href="<?php echo $casino_external_link?>"><?php echo $play_now_txt?></a>
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
                    <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</section>