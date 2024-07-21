<?php

$ID                 = get_queried_object()->term_id;
$app_banner_img     = intval(carbon_get_term_meta($ID, 'app_banner_img'));
$app_banner_txt     = carbon_get_term_meta($ID, 'app_banner_txt');
$intro_text 	    = carbon_get_term_meta($ID, 'intro_text');
$content_editor     = carbon_get_term_meta($ID, 'content_editor');
$content            = carbon_get_term_meta($ID, 'ud_cat_content');
$main_game_page     = carbon_get_theme_option('default_page_game');

$q_args = [
    'post_type'         => 'game',
    'post-status'       => 'publish',
    'posts_per_page'    => -1,
    'tax_query'         => array(
                                array(
                                    'taxonomy' => 'game-category',
                                    'field'    => 'term_id',
                                    'terms'    => [$ID]
                                )
                            ),
];

$terms = get_terms( array(
    'taxonomy'   => 'game-category',
) );

get_header();

$posts  = new WP_Query($q_args);
wp_reset_postdata();

if(empty($app_banner_img)){
    $app_banner_img = get_stylesheet_directory_uri()."/assets/images/banner/banner-3.svg";
}
 
get_template_part('/theme-parts/modules/app-banner', '', ['img' => $app_banner_img, 'txt' => $app_banner_txt]);

if(!empty($intro_text)):
	get_template_part('/theme-parts/modules/intro-text', '', ['text'=>$intro_text]);
endif;

if($posts->have_posts()):
?>
<section class="section section_bg section_bg_3">
    <div class="container">
        <div class="section__inner">
            <?php
                if(!empty($terms)):
                    $def_active = isset($_GET['games-cat'])? '': 'active';
                    ?>
                    <div class="content-cards__switch">
                        <div class="page-switch">
                            <?php
                            if($main_game_page && !empty($main_game_page)):
                                ?>
                                <a href="<?php echo get_the_permalink($main_game_page)?>" class="page-switch__button">AllE</a>
                                <?php
                            endif;    
                            
                            foreach($terms as $term):
                                $t_id   = $term->term_id;
                                // $url    = $has_filter? "?games-cat={$t_id}": get_term_link($t_id);
                                $url    = get_term_link($t_id);
                                $active = $t_id == $ID? 'active': '';
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

            <div class="section__content">
                <ul class="card-list">
                    <?php
                    while($posts->have_posts()):
                        $posts->the_post();

                        $g_id       = get_the_ID();
                        $g_img_id   = get_post_thumbnail_id();
                        $gel        = get_post_meta( $g_id, 'game_external_link', true );

                        $game_params = [
                            'g_img_data'      => apply_filters('ud_get_file_data', $g_img_id),
                            'title'           => get_the_title(),
                            'permalink'       => get_the_permalink(),  
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
endif;  

if(!empty($content_editor)){
    $part = ['text_editor' => $content_editor];
    get_template_part("/theme-parts/modules/text-editor", "", ["id" => $ID, "content"=>$part]);
}

if(!empty($content)){
    foreach($content as $part){
        $part_tmpl = $part['_type'];
        
        get_template_part("/theme-parts/modules/$part_tmpl", "", ["id" => $ID, "content"=>$part, "post_type" => 'page']);
    }
}

get_footer(); 
?>