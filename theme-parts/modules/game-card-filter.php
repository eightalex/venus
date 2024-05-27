<?php
extract($args);

$terms = get_terms( array(
    'taxonomy'   => 'game-category',
) );

$def_url = get_the_permalink();

?>
<section class="section section_p_0 section_bg section_bg_2">
    <div class="container">
        <div class="section__inner">
            <div class="content-cards">
                <?php
                if(!empty($terms)):
                    $def_active = isset($_GET['games-cat'])? '': 'active';
                    ?>
                    <div class="content-cards__switch">
                        <div class="page-switch">
                            <a href="<?php echo $def_url?>" class="page-switch__button <?php echo $def_active?>">All</a>
                            <?php
                            foreach($terms as $term):
                                $t_id   = $term->term_id;
                                $url    = "?games-cat={$t_id}";
                                $active = isset($_GET['games-cat']) && $_GET['games-cat'] == $t_id? 'active': '';
                                ?>
                                <a href="<?php echo $url?>" class="page-switch__button <?php echo $active?>"><?php echo $term->name?></a>
                                <?php
                            endforeach;
                            ?>
                        </div>
                    </div>
                    <?php
                endif;
                ?>
                <div class="content-cards__list">
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

                <?php
                    if(isset($games['pagenavi'])){
                        echo $games['pagenavi'];
                    }
                ?>
            </div>
        </div>
    </div>
</section>