<?php

$ID 			    = get_queried_object()->term_id;
$app_banner_img	    = intval(carbon_get_term_meta($ID, 'app_banner_img'));
$app_banner_txt	    = carbon_get_term_meta($ID, 'app_banner_txt');
$intro_text 		= carbon_get_term_meta($ID, 'intro_text');
$show_sidebar	    = carbon_get_term_meta($ID, 'embed_sitebar');
$sitebar_title	    = carbon_get_term_meta($ID, 'sitebar_title');
$sidebar_casionois	= carbon_get_term_meta($ID, 'sidebar_casionois');
$custom_content     = carbon_get_term_meta($ID, 'content_editor');
$content 		    = carbon_get_term_meta($ID, 'ud_cat_content');
$paged 			    = isset($_GET['posts-page']) ? absint( $_GET['posts-page'] )  : 1;
$is_paginavi 		= apply_filters('is_paginavi', 0);

if(empty($app_banner_img)){
	$app_banner_img = get_stylesheet_directory_uri()."/assets/images/banner/banner.svg";
}
get_header();

$posts = new WP_Query(['cat' => $ID, 'post_status' => 'publish', 'posts_per_page' => 6, 'paged' => $paged]);
wp_reset_postdata();

$tags 	= apply_filters('ud_get_tax_posts_tags', $posts);

get_template_part('/theme-parts/modules/app-banner', '', ['img' => $app_banner_img, 'txt' => $app_banner_txt]);

if($tags){
	get_template_part("/theme-parts/modules/tags", "list", ["tags" => $tags]);
}

if(!empty($intro_text)):
	get_template_part('/theme-parts/modules/intro-text', '', ['text'=>$intro_text]);
endif;

?>
<section class="section section_bg section_bg_6">
    <div class="container">
        <div class="section__inner">
            <div class="content">
                <main class="content__main">
					<?php
					if($posts->have_posts()):
						$max_pages = intval($posts->max_num_pages);
						?>
						<div class="card-list card-list_col-2">
							<?php
								while($posts->have_posts()):
									$posts->the_post();
									$post_id 		= get_the_ID();
									$th_id   		= get_post_thumbnail_id($post_id);
									$th_data 		= apply_filters('ud_get_file_data', $th_id);
									$th_src         = !empty($th_data) && !empty($th_data['src'])? $th_data['src']: 'https://via.placeholder.com/315x220';
									$date_f         = 'F d, Y';
									$date_c_m       = get_the_date($date_f, $post_id);
									$excerpt        = get_the_excerpt($post_id);
										?>
										<div class="news-card">
											<div class="news-card__image">
												<img src="<?php echo $th_src?>" alt="image">
											</div>
											<div class="news-card__content">
												<div class="news-card__title">
                                                    <a href="<?php echo get_the_permalink()?>">
                                                        <?php the_title()?>
                                                    </a>
                                                </div>

												<time class="news-card__date"><?php echo $date_c_m?></time>
												<?php
												if(!empty($excerpt)):
													?>
													<div class="news-card__text">
														<?php echo $excerpt?>
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
						<?php
					    if($max_pages > 1):
							?>
							<div class='content__nav'>
								<?php echo apply_filters('my_pagination', $paged, $max_pages, "posts-page")?>
							</div>
						<?php
						endif;
					endif;
					?>
                </main>
                <?php
                if($show_sidebar && !empty($sidebar_casionois)):
                    ?>
                    <aside class="content__sidebar">
                        <?php
                        if(!empty($sitebar_title)):
                            ?>
                            <div class="content__subtitle">
                                <?php echo $sitebar_title?>
                            </div>
                            <?php
                        endif;
                        ?>
                        <div class="content__sidebar-cards">
                            <?php
                                foreach($sidebar_casionois as $casino_id):
                                    if(get_post_type($casino_id) !== 'casino'){
                                        continue;
                                    }
                                    $c_th_id          = get_post_thumbnail_id($casino_id);
                                    $c_th_data        = apply_filters('ud_get_file_data', $c_th_id);
                                    $c_title          = get_the_title($casino_id);
                                    $c_desc           = get_post_meta($casino_id, 'casino_short_desc', true);
									$c_overall_rating = floatval(get_post_meta($casino_id, 'casino_overall_rating', true));
                                    $c_pemalink       = get_the_permalink($casino_id);
									$c_external_link  = get_post_meta($casino_id, 'casino_external_link', true);
                                    $lb_txt           = !empty(get_option('casinos_read_review_title'))? get_option('casinos_read_review_title'): 'Read review';
                                    $elb_txt          = !empty(get_option('casinos_play_now_title'))? get_option('casinos_play_now_title'): 'Play now';
                                ?>
                                <div class="casino-card casino-card_compact">
                                    <div class="casino-card__image">
                                        <img src="<?php echo $c_th_data['src']?>" alt="<?php echo $c_th_data['alt']?>">
                                    </div>

                                    <div class="casino-card__title">
                                        <a href="<?php echo $c_pemalink?>">
                                            <?php echo $c_title?>
                                        </a>
                                    </div>

                                    <?php
                                    if(!empty($c_overall_rating)):
                                        ?>

                                        <div class="rating-mobile casino-card__rating" data-rating="<?php echo $c_overall_rating?>">
                                            <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/icons/star.svg'?>" alt="star">
                                        </div>

                                        <?php
                                    endif;

                                    if(!empty($c_desc)):
                                        ?>
                                        <div class="casino-card__subtitle">
                                            <?php echo $c_desc?>
                                        </div>
                                        <?php
                                    endif;
                                    ?>
                                    <div class="casino-card__cta">
                                        <a href="<?php echo $c_pemalink?>" class="casino-card__button button button_outline"><?php echo $lb_txt?></a>
                                        <?php
                                        if(!empty($c_external_link)):
                                            ?>
                                            <a href="<?php echo $c_external_link?>" target="_blank" class="casino-card__button button" rel="nofollow"><?php echo $elb_txt?></a>
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
if(!$is_paginavi){
    if(!empty($custom_content)){
        $part = ['text_editor' => $custom_content];
        get_template_part("/theme-parts/modules/text-editor", "", ["id" => $ID, "content"=>$part]);
    }

    if(!empty($content)){
        foreach($content as $part){
            $part_tmpl = $part['_type'];

            get_template_part("/theme-parts/modules/$part_tmpl", "", ["id" => $ID, "content"=>$part, "post_type" => 'page']);
        }
    }
}

get_footer();
?>
