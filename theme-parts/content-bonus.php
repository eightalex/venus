<?php
$p_id                   = get_the_ID();
$casinois_list          = get_post_meta($id, 'bonus_parent_casino', true);
$casinois_list_title    = carbon_get_post_meta($id, 'casinois_sidebar_title');
$custom_content         = carbon_get_post_meta($p_id, 'ud_post_content');
$post_type 		        = get_post_type();

$q_arr = [
    'posts_per_page' => get_option('posts_per_page'),
    'post_type'      => 'casino',
    'post_status'    => 'publish',
    'order'          => 'DESC',
    'orderby'        => 'meta_value_num',
    'meta_key'       => 'casino_overall_rating',
    'post__in'       =>  $casinois_list,  
    'meta_query'     => [
                            [
                                'key'    => 'casino_overall_rating',
                                'type'   => 'NUMERIC',
                                'compare' => 'EXISTS'
                            ]
                        ],
];

$casinois = new WP_Query($q_arr);
wp_reset_postdata();

get_template_part('/theme-parts/modules/banner', 'author', ['id' => $p_id]);

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
                    <!-- <div class="content__footer">
                        <div class="content__socials">
                            Share:
                            <a href="#" class="content__social">
                                <img src="../assets/images/icons/social/facebook.svg" alt="facebook">
                            </a>
                            <a href="#" class="content__social">
                                <img src="../assets/images/icons/social/twitter.svg" alt="twitter">
                            </a>
                            <a href="#" class="content__social">
                                <img src="../assets/images/icons/social/linkedin.svg" alt="linkedin">
                            </a>
                            <a href="#" class="content__social">
                                <img src="../assets/images/icons/social/share.svg" alt="share">
                            </a>
                        </div>
                    </div> -->
                </main>
                <?php
                if(!empty($casinois_list)):
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
                                            <a class="casino-card__button button button_outline" href='<?php echo get_the_permalink($casino_id)?>'><?php echo __('Read review') ?></a>
                                            <?php
                                            if(!empty($casino_external_link)):
                                            ?>
                                            <a class="casino-card__button button" href="<?php echo $casino_external_link?>"><?php echo __('Play now')?></a>
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
<?php
    foreach($custom_content as $part){
        $part_tmpl = $part['_type'];
        get_template_part("/theme-parts/modules/$part_tmpl", "", ["id" => $p_id, "content"=>$part, "post_type" => $post_type]);
    }
