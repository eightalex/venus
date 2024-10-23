<?php
extract($args); // tag: string, hide_activities: boolean, light: boolean

$main_tag            = $tag ? $tag : 'div';
$light_class        = isset($light) && $light ? ' pi__light' : '';
$author_id           = get_the_author_meta("ID");
$author_link         = get_author_posts_url($author_id);
$author_info         = apply_filters('ud_get_author_infos', $author_id);
$author_full_name    = $author_info['firs_name'] . " " . $author_info['last_name'];
$date_f              = 'F d, Y';
$post_published_date = get_the_date($date_f);
$post_modified_date  = get_the_modified_date($date_f);
$view_count          = function_exists( 'pvc_get_post_views' ) ? pvc_get_post_views($id): 0;
$comment_count       = get_comment_count(get_the_ID())['total_comments'];

if (!is_tax() && !empty($post_published_date)) { // TODO: Add published and updated fields for taxonomy
    echo "<{$main_tag} class='post-info__container{$light_class}'>";
    ?>
        <div class="post-info__about">
            <a class="post-info__author" href="<?php echo $author_link ?>">
                <span class="post-info__avatar">
                    <img src="<?php echo $author_info['ava_url']?>" alt="<?php echo $author_full_name ?>">
                </span>
                <span class="post-info__name">
                    <?php echo __('by')?> <?php echo $author_full_name?>
                </span>
            </a>
            <div class="post-info__date">
                <?php if ($post_published_date) {?>
                <time datetime="<?php echo get_the_date('c') ?>">
                    <?php echo "Publisert: " . $post_published_date; ?>
                </time>
                <?php }?>
                <?php if ($post_modified_date) {?>
                <time datetime="<?php echo get_the_modified_date('c') ?>">
                    <?php echo "Oppdatert: " . $post_modified_date; ?>
                </time>
                <?php }?>
            </div>
        </div>
        <?php if ((isset($hide_activities) && !$hide_activities) || ($view_count || $comment_count)) { ?>
        <div class="post-info__activities">
            <?php if(intval($view_count) > 0): ?>
                <div class="post-info__activity">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/icons/eye.svg' ?>" alt="views icon">
                    <span><?php echo $view_count?></span>
                </div>
            <?php endif; ?>
            <?php if ($comment_count > 0) {?>
            <div class="post-info__activity">
                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/icons/comment.svg' ?>" alt="views icon">
                <span><?php echo $comment_count?></span>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
    <?php 
    echo "</{$main_tag}>";
}
 ?>