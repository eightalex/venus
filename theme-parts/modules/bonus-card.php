<?php
extract($args);

$args_arr = [
    'parent_id'     => $id,
    'items_number'  => $content['bonuses_count']
];

$bonuses = apply_filters('ud_get_bonuses', $args_arr);

if(!$bonuses->have_posts()){
    return;
}

$title_section      = !empty($content['bonuses_title'])? $content['bonuses_title']: get_the_title()." <em>bonuses</em>";
$section_subtitle   = !empty($content['bonuses_subtitle'])? $content['bonuses_subtitle']: get_the_excerpt($id);
?>
<section class="section section_suits">
    <div class="container">
        <div class="section__inner">
            <header class="section__header">
                <div class="section__title"><?php echo $title_section?></div>
                <?php
                if(!empty($section_subtitle)):
                    ?>
                    <div class="section__subtitle">
                        <?php echo $section_subtitle?>
                    </div>
                    <?php
                endif;
                ?>
            </header>
            <div class="section__content">
                <div class="card-list">
                    <?php
                    while($bonuses->have_posts()):
                        $bonuses->the_post();
                        $b_id = get_the_ID();
                        $short_desc         = get_post_meta($b_id, 'bonus_short_desc', true);
                        $external_link      = get_post_meta($b_id, 'bonus_external_link', true);
                        $button_notice      = get_post_meta($b_id, 'bonus_button_notice', true);
                        $offer_detailed_tc  = get_post_meta($b_id, 'offer_detailed_tc', true);
                        $bonus_code         = get_post_meta($b_id, 'bonus_code', true);
                        $bonus_valid_date   = get_post_meta($b_id, 'bonus_valid_date', true);
                        ?>
                        <div class="bonus-card">
                            <div class="bonus-card__tags">
                                <div class="bonus-card__tag">Deposit Bonus</div>
                            </div>
                            <header class="bonus-card__header">
                                <?php the_title()?>
                            </header>
                            <div class="bonus-card__gift">
                                <img src=<?php echo get_stylesheet_directory_uri()."/assets/images/bonus-card/gift.svg"?> alt="gift" class="bonus-card__img">
                                <?php
                                if(!empty($bonus_code) && !empty($bonus_valid_date)):
                                    $ds = strtotime($bonus_valid_date);
                                    $df = date('M d, Y', $ds);
                                    ?>
                                    <div class="bonus-card__gift-content">
                                        <span>Bonus code:</span>
                                        <span><?php echo $bonus_code?></span>
                                        <span>Valid Until: <?php echo $df?></span>
                                    </div>
                                    <?php
                                endif;
                                ?>
                            </div>
                            <?php
                            if(!empty($short_desc)):
                                ?>
                                <div class="bonus-card__subtitle">
                                    <?php echo $short_desc?>
                                </div>
                                <?php
                            endif;

                            if(!empty($external_link)):
                            ?>
                            <div class="bonus-card__cta">
                                <a href="<?php echo $external_link?>" target="__blank"  class="bonus-card__button button">Play now</a>
                            </div>
                            <?php
                            endif;
                            ?>
                            <div class="bonus-card__info">
                                T&Cs Apply
                                <?php
                                if(!empty($button_notice)):
                                    ?>
                                    <br><?php echo $button_notice?>
                                    <?php
                                endif;

                                if(!empty($offer_detailed_tc)):
                                    ?>
                                    <div class="tc-desc">
                                        <?php echo $offer_detailed_tc?>
                                    </div>
                                    <?php
                                endif;
                                ?>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>