<?php
if(isset($args)){
    extract($args);
}

if(!isset($show_all_btn)){
    $show_all_btn = true;
}

$terms = get_terms( array(
    'taxonomy'   => 'casino-category',
) );

$has_filter         = isset($filter) && $filter == false? false: true;
$main_casinois_page	= carbon_get_theme_option('default_page_casinois');
$def_url            = get_the_permalink();

if($main_casinois_page && !empty($main_casinois_page)){
    $def_url = get_the_permalink($main_casinois_page);
}
?>

<section class="section section_suits section_p_0">
    <div class="container">
        <div class="section__inner">
            <div class="content-cards">
                <?php
                    if($has_filter && !empty($terms)):
                        $def_active = isset($_GET['casinos-cat'])? '': 'active';

                        if(is_page() && $id == $main_casinois_page){
                            $def_active = 'active';
                        }
                        ?>
                        <div class="content-cards__switch">
                            <div class="page-switch">
                            <?php
                                if($has_filter && $show_all_btn):
                                ?>
                                    <a href="<?php echo $def_url?>" class="page-switch__button <?php echo $def_active?>">alle nettkasinoer</a>
                                <?php
                                endif;

                                foreach($terms as $term):
                                    $t_id   = $term->term_id;
                                    // $url    = $has_filter? "?casinos-cat={$t_id}": get_term_link($t_id);
                                    $url    = get_term_link($t_id);
                                    $active = isset($_GET['casinos-cat']) && $_GET['casinos-cat'] == $t_id? 'active': '';
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

                <div class="card-list card-list_col-2" style="margin-top: 40px;">
                    <?php
                    while($casinos->have_posts()):
                        $casinos->the_post();

                        $id                         = get_the_ID();
                        $cas_img_id                 = get_post_thumbnail_id();
                        $cas_img_data               = apply_filters('ud_get_file_data', $cas_img_id);
                        $desc                       = get_post_meta($id, 'casino_short_desc', true);
                        $casino_overall_rating      = floatval(get_post_meta($id, 'casino_overall_rating', true));
                        $casino_external_link       = get_post_meta($id, 'casino_external_link', true);

                        $atts = [
                            'title'             => get_the_title(),
                            'img_src'           => $cas_img_id !== 0? $cas_img_data['src']: '',
                            'img_alt'           => $cas_img_id !== 0? $cas_img_data['alt']: get_the_title(),
                            'rating'            => $casino_overall_rating,
                            'desc'              => $desc,
                            'permalink'         => get_the_permalink(),
                            'external_link'     => $casino_external_link,
                        ];
                        do_action('print_single_casino_template', $atts);
                    endwhile;
                    ?>
                </div>

                <?php
                    $max_pages = $casinos->max_num_pages;
                    $paged = $casinos->query['paged'];
                    if($max_pages  > 1){
                        $pagenavi_items = apply_filters('my_pagination', $paged, $max_pages, "casinois-page");
                        echo "<div class='content-cards__footer'>
                                    {$pagenavi_items}
                            </div>";
                    }
                ?>
            </div>
        </div>
    </div>
</section>
