<?php
extract($args);

$gc_bg = !empty($content['gc_bg'])? $content['gc_bg']: get_stylesheet_directory_uri()."/assets/images/section/bg3.jpeg";

$q_params = [
    'category'      => $content['gc_category'],
    'items_number'  => $content['gs_count'],
];

if($post_type !== "page"){
    $q_params['parent_id'] = $id;
}
$games = apply_filters('ud_get_games', $q_params);


if(!$games['res']->have_posts()){
    return;
}

if($content['gs_is_filter']){
    get_template_part('theme-parts/modules/game-card-filter', '', ['games' => $games]);
    return;
}

$section_title = !empty($content['gc_title'])? $content['gc_title']: get_the_title()." <em>games</em>";

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
                if(!empty($content['gc_subtitle'])):
                    ?>
                    <div class="section__subtitle">
                        <?php echo $content['gc_subtitle']?>
                    </div>
                    <?php
                endif;
                ?>
            </header>

            <div class="section__content">
                <ul class="card-list">
                    <?php
                    while($games['res']->have_posts()):
                        $games['res']->the_post();
                        $g_id       = get_the_ID();
                        $g_img_id   = get_post_thumbnail_id();
                        $gel        = get_post_meta( $g_id, 'game_external_link', true );

                        $game_params = [
                            'g_img_data'      => apply_filters('ud_get_file_data', $g_img_id),
                            'title'           => get_the_title(),  
                            'short_desc'      => get_post_meta( $g_id, 'game_short_desc', true ),
                            'button_notice'   => get_post_meta( $g_id, 'casino_button_notice', true ),
                            'external_link'   => !empty($gel)? esc_url( $gel ): get_the_permalink(),
                            'unit_detailed'   => get_post_meta( $g_id, 'unit_detailed_tc', true ),
                        ];

                        echo apply_filters('ud_print_single_game', $game_params);
                    endwhile;
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<?php
