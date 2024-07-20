<?php
extract($args);

$title              = !empty($txt)? $txt: get_the_title();
$author_id          = get_queried_object()->post_author;
$author_info        = apply_filters('ud_get_author_infos', $author_id);
$author_full_name   = $author_info['firs_name'] . " " . $author_info['last_name'];
$date_create        = get_queried_object()->post_date;
$date_c_u           = strtotime($date_create);
$date_f             = 'F d, Y';
$date_c_m           = date($date_f, $date_c_u);
$view_count         = function_exists( 'pvc_get_post_views' )? pvc_get_post_views($id): 0;
$comment_count      = get_comment_count($id);
?>
<section class="section section_bg section_bg_7">
    <div class="container">
        <div class="section__inner">
            <div class="banner-author">
                <?php
                    get_template_part('/theme-parts/modules/breadcrumbs', '', ['inline' => true]);
                ?>
                <header class="banner-author__header">
                    <h1 class="banner-author__title">
                        <?php
                            echo $title;
                        ?>
                    </h1>
                </header>
                <footer class="banner-author__footer">
                    <div class="banner-author__author">
                        <div class="banner-author__avatar">
                            <img src="<?php echo $author_info['ava_url']?>" alt="avatar">
                        </div>
                        <div class="banner-author__name">
                            <?php echo __('by')?> <?php echo $author_full_name?>
                        </div>
                    </div>
                    <time class="banner-author__date">
                        <?php echo $date_c_m?>
                    </time>
                    <div class="banner-author__icons">
                        <?php
                            if(intval($view_count) > 0):
                            ?>
                            <div class="banner-author__icon">
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/icons/eye.svg' ?>" alt="views icon">
                                <span><?php echo $view_count?></span>
                            </div>
                            <?php
                            endif;
                        ?>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</section>
