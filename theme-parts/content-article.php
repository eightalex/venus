<?php
$terms          = wp_get_post_terms($ID, 'category');
$category_id    = $terms[0]->term_id;

$posts_q_args = [
    'post_type'         => 'post',
    'post_status'       => 'publish',
    'cat'               => $category_id,
    'posts_per_page'    => 6,
    'post__not_in'      => [$ID]
];

$q_posts = new WP_Query($posts_q_args);

if(!empty($app_banner_is_author) && $app_banner_is_author == true){
    get_template_part('/theme-parts/modules/banner', 'author_single', ['id' => $ID]);
}else{
    get_template_part('/theme-parts/modules/app', 'banner', ['txt' => $app_banner_txt, 'img' => $app_banner_img]);
}

get_template_part('/theme-parts/modules/post', 'tags', ['id' => $ID]);

if(!empty($intro_text)):
    get_template_part('/theme-parts/modules/intro-text', '', ['text'=>$intro_text]);
endif;

foreach($custom_content as $part){
    $part_tmpl = $part['_type'];
    get_template_part("/theme-parts/modules/$part_tmpl", "", ["id" => $ID, "content"=>$part, "post_type" => $post_type]);
}

if($q_posts->have_posts()):
?>
<section class="section section_bg section_bg_6">
    <div class="container">
        <div class="section__inner">
            <div class="content">
                <main class="content__main">
                    <div class="card-list card-list_col-2">
                        <?php
                        while($q_posts->have_posts()):
                            $q_posts->the_post();
                            $post_id 		= get_the_ID();
                            $th_id   		= get_post_thumbnail_id($post_id);
                            $th_data 		= apply_filters('ud_get_file_data', $th_id);
                            $th_src         = !empty($th_data) && !empty($th_data['src'])? $th_data['src']: 'https://via.placeholder.com/315x220';
                            $date_f         = 'F d, Y';
                            $post_modify    = get_the_modified_date($date_f, $post_id);
                            // $date_c_m       = get_the_date($date_f, $post_id);
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

                                        <time class="news-card__date"><?php echo $post_modify?></time>
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
                </main>
            </div>
        </div>
    </div>
</section>
<?php
endif;    