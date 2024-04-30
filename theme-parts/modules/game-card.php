<?php
extract($args);

$gc_bg = !empty($content['gc_bg'])? $content['gc_bg']: get_stylesheet_directory_uri()."/assets/images/section/bg3.jpeg";

$q_params = [
    'category'      => $content['gc_category'],
    'items_number'  => $content['gs_count'],
];

if($post_type = "casino"){
    $q_params['parent_id'] = $id;
}
$games = apply_filters('ud_get_games', $q_params);

if($games->have_posts()):
    $section_title      = !empty($content['gc_title'])? $content['gc_title']: get_the_title()." <em>games</em>";
    $section_subtitle   = !empty($content['gc_subtitle'])? $content['gc_subtitle']: get_the_excerpt($id);
?>

<style>
    .section_bg_3::before{
        background-image: url(<?php echo $gc_bg?>); 
    }
</style>

<section class="section section_bg section_bg_3">
    <div class="container">
        <div class="section__inner">

            <header class="section__header">
                <div class="section__title"><?php echo $section_title?></div>
                <?php
                if($section_subtitle):
                    ?>
                    <div class="section__subtitle">
                        <?php echo $section_subtitle?>
                    </div>
                    <?php
                endif;
                ?>
            </header>

            <div class="section__content">
                <ul class="card-list">
                    <?php
                    while($games->have_posts()):
                        $games->the_post();

                        $g_id            = get_the_ID();
                        $g_img_id        = get_post_thumbnail_id();
                        $g_img_data      = apply_filters('ud_get_file_data', $g_img_id);
                        $short_desc      = get_post_meta( $g_id, 'game_short_desc', true );
                        $gel             = get_post_meta( $g_id, 'game_external_link', true );
                        $button_notice   = get_post_meta( $g_id, 'casino_button_notice', true );
                        $external_link   = !empty($gel)? esc_url( $gel ): get_the_permalink();
                        $unit_detailed   = get_post_meta( $g_id, 'unit_detailed_tc', true );
                    ?>
                    <li class="game-card">
                        <div class="game-card__image">
                            <img src="<?php echo $g_img_data['src']?>" alt="<?php echo $g_img_data['alt']?>">
                        </div>
                        <div class="game-card__title"><?php the_title()?></div>
                        <?php
                        if(!empty($short_desc)):
                        ?>
                        <div class="game-card__subtitle">
                            <?php echo $short_desc?>
                        </div>
                        <?php
                        endif;
                        ?>
                        <div class="game-card__cta">
                            <a href="<?php echo $external_link?>" class="game-card__button button"><?php echo __("Play now")?></a>
                        </div>
                        <div class="game-card__info">
                            T&Cs Apply
                            <?php
                            if(!empty($button_notice)):
                                ?>
                                <br><?php echo $button_notice?>
                                <?php
                            endif;

                            if(!empty($unit_detailed)):
                                ?>
                                <div class="tc-desc">
                                    <?php echo $unit_detailed?>
                                </div>
                                <?php
                            endif;
                            ?>
                        </div>
                    </li>
                    <?php
                    endwhile;
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<?php
endif;