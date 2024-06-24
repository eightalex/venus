<?php

$ID 			= get_queried_object()->term_id;
$app_banner_img	= intval(carbon_get_term_meta($ID, 'app_banner_img'));
$app_banner_txt	= carbon_get_term_meta($ID, 'app_banner_txt');
$custom_content = carbon_get_term_meta($ID, 'content_editor');
$content 		= carbon_get_term_meta($ID, 'ud_cat_content');
$paged 			= isset($_GET['posts-page']) ? absint( $_GET['posts-page'] )  : 1;
$posts 			= new WP_Query(['category' => $ID, 'post_status' => 'publish', 'posts_per_page' => 6, 'paged' => $paged]);
wp_reset_postdata();
$tags 	= apply_filters('ud_get_tax_posts_tags', $posts);

if(empty($app_banner_img)){
	$app_banner_img = get_stylesheet_directory_uri()."/assets/images/banner/banner.svg";
}
get_header();
?>

<?php 

get_template_part('/theme-parts/modules/app-banner', '', ['img' => $app_banner_img, 'txt' => $app_banner_txt]);

if($tags){
	get_template_part("/theme-parts/modules/tags", "list", ["tags" => $tags]);
}

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
												<div class="news-card__title"><?php the_title($post_id)?></div>
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
                <aside class="content__sidebar">
                    <div class="content__subtitle">
                        News casino
                    </div>
                    <div class="content__sidebar-cards">
                        <div class="casino-card casino-card_compact">
                            <div class="casino-card__image">
                                <img src="../assets/images/game.png" alt="casino">
                            </div>
                            <div class="casino-card__title">Royal Casino</div>
                            <div class="casino-card__rating" data-rating="9.0">
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
                                Get 100% up to $150 + 50 bonus spins at Royal Casino
                            </div>
                            <div class="casino-card__cta">
                                <button class="casino-card__button button button_outline">Read review</button>
                                <button class="casino-card__button button">Play now</button>
                            </div>
                        </div>
                        <div class="casino-card casino-card_compact">
                            <div class="casino-card__image">
                                <img src="../assets/images/game.png" alt="casino">
                            </div>
                            <div class="casino-card__title">Royal Casino</div>
                            <div class="casino-card__rating" data-rating="9.0">
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
                                Get 100% up to $150 + 50 bonus spins at Royal Casino
                            </div>
                            <div class="casino-card__cta">
                                <button class="casino-card__button button button_outline">Read review</button>
                                <button class="casino-card__button button">Play now</button>
                            </div>
                        </div>
                        <div class="casino-card casino-card_compact">
                            <div class="casino-card__image">
                                <img src="../assets/images/game.png" alt="casino">
                            </div>
                            <div class="casino-card__title">Royal Casino</div>
                            <div class="casino-card__rating" data-rating="9.0">
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
                                Get 100% up to $150 + 50 bonus spins at Royal Casino
                            </div>
                            <div class="casino-card__cta">
                                <button class="casino-card__button button button_outline">Read review</button>
                                <button class="casino-card__button button">Play now</button>
                            </div>
                        </div>
                        <div class="casino-card casino-card_compact">
                            <div class="casino-card__image">
                                <img src="../assets/images/game.png" alt="casino">
                            </div>
                            <div class="casino-card__title">Royal Casino</div>
                            <div class="casino-card__rating" data-rating="9.0">
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
                                Get 100% up to $150 + 50 bonus spins at Royal Casino
                            </div>
                            <div class="casino-card__cta">
                                <button class="casino-card__button button button_outline">Read review</button>
                                <button class="casino-card__button button">Play now</button>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
<?php

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

get_footer(); 
?>