<?php
extract($args);

$terms = get_terms( array(
    'taxonomy'   => 'bonus-category',
) );

$has_filter = isset($filter) && $filter == false? false: true;

$current_id         = $id;
$def_url            = get_the_permalink();
$main_bonus_page    = carbon_get_theme_option('default_page_bonus');

if($main_bonus_page && !empty($main_bonus_page)){
    $def_url = get_the_permalink($main_bonus_page);
}
?>
<section class="section section_p_0 section_bg section_bg_2">
    <div class="container">
        <div class="section__inner">
            <div class="content-cards">
                <?php
                if(!empty($terms)):
                    $def_active = (is_page() && $current_id == $main_bonus_page)? 'active': '';

                    ?>
                    <div class="content-cards__switch">
                        <div class="page-switch">
                            <?php
                            if($has_filter):
                                ?>
                                <a href="<?php echo $def_url ?>" class="page-switch__button <?php echo $def_active?>">AllE</a>
                                <?php
                            endif;

                            foreach($terms as $term):
                                $t_id   = $term->term_id;
                                // $url    = $has_filter? "?bonuses-cat={$t_id}": get_term_link($t_id);
                                $url    = $has_filter? get_term_link($t_id): "$bonuses-cat={$t_id}";
                                $active = isset($_GET['bonuses-cat']) && $_GET['bonuses-cat'] == $t_id? 'active': '';
                                ?>
                                <a href="<?php echo $url?>" data-id="<?php echo $term->term_id?>" class="page-switch__button <?php echo $active?>"><?php echo $term->name?></a>
                                <?php
                            endforeach;
                            ?>
                        </div>
                    </div>
                    <?php
                endif;
                ?>
                <div class="content-cards__list">
                    <div class="card-list">
                        <?php
                        while($bonuses['res']->have_posts()):
                            $bonuses['res']->the_post();
                            $b_id = get_the_ID();
                            $taxs = wp_get_post_terms($b_id, 'bonus-category');
                            $lnk    = get_the_permalink();
                            $title  = get_the_title($b_id);
                            $data   = [
                                'title'             => "<a href='{$lnk}'>$title</a>",
                                'short_desc'        => get_post_meta($b_id, 'bonus_short_desc', true),
                                'external_link'     => get_post_meta($b_id, 'bonus_external_link', true),
                                'button_notice'     => get_post_meta($b_id, 'bonus_button_notice', true),
                                'offer_detailed_tc' => get_post_meta($b_id, 'offer_detailed_tc', true),
                                'bonus_code'        => get_post_meta($b_id, 'bonus_code', true),
                                'bonus_valid_date'  => get_post_meta($b_id, 'bonus_valid_date', true),
                                'tax'               => !empty($taxs)? $taxs[0]->name: '',
                                'tax_link'          => !empty($taxs)? get_term_link($taxs[0]->term_id): "",
                            ];


                            if($current_id !== $b_id){
                                echo apply_filters('print_single_bonus_card', $data);
                            }
                        endwhile;
                        ?>
                    </div>
                </div>
                <?php
                    if(isset($bonuses['pagenavi'])){
                        echo $bonuses['pagenavi'];
                    }
                ?>
            </div>
        </div>
    </div>
</section>
