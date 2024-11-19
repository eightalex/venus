<?php
extract($args); // tag: string, show_activities: boolean, light: boolean

$main_tag            = $tag ? $tag : 'div';
$light_class         = isset($light) && $light ? '_light' : '';
$date_f              = 'F d, Y';
$post_published_date = get_the_date($date_f);
$post_modified_date  = get_the_modified_date($date_f);
$author_id           = get_the_author_meta("ID");
$term_id		     = get_queried_object()->term_id;

if (is_tax() || $term_id ) {
    $tax_content = carbon_get_term_meta($term_id, 'ud_cat_content');
    $filtered_array = array_filter($tax_content, function($part) {
        return isset($part['_type']) && $part['_type'] === 'author';
    });

    $author = array_shift($filtered_array);
    $cbn_published_date = strtotime(carbon_get_term_meta($term_id, 'published_date'));
    $cbn_updated_date = strtotime(carbon_get_term_meta($term_id, 'updated_date'));
    $cbn_updated_date_auto =strtotime(carbon_get_term_meta($term_id, 'updated_date_auto'));
    $is_changed_updated_date = carbon_get_term_meta($term_id, 'modify_updated_date');

    if ($cbn_published_date) {
        $post_published_date = date_i18n($date_f, $cbn_published_date);
    }

    if ($cbn_updated_date || $cbn_updated_date_auto) {
        $post_modified_date      = $is_changed_updated_date
        ? date_i18n($date_f, $cbn_updated_date)
        : date_i18n($date_f, $cbn_updated_date_auto);
    }

    $author_id = isset($author) ? $author['au_select'] : $author_id;

}

$author_info         = apply_filters('ud_get_author_infos', $author_id);
$author_page_link    = $author_info['author_page_link'];
$author_full_name    = $author_info['firs_name'] . " " . $author_info['last_name'];
$view_count          = function_exists( 'pvc_get_post_views' ) ? pvc_get_post_views($id): 0;
$comment_count       = get_comment_count(get_the_ID())['total_comments'];


echo "<{$main_tag} class='post-info__container{$light_class}'>";
?>
    <?php if ($author_id || $post_published_date):?>
    <div class="post-info__about">
        <?php if ($author_id):?>
        <a class="post-info__author" href="<?php echo $author_page_link ?>">
            <span class="post-info__avatar">
                <img src="<?php echo $author_info['ava_url']?>" alt="<?php echo $author_full_name ?>">
            </span>
            <span class="post-info__name">
                <?php echo __('by')?> <?php echo $author_full_name?>
            </span>
        </a>
        <?php endif ?>
        <?php if ($post_published_date):?>
        <div class="post-info__date">
            <time datetime="<?php echo get_the_date('c') ?>">
                <?php echo "Publisert: " . $post_published_date; ?>
            </time>
            <?php if ($post_modified_date) {?>
            <time datetime="<?php echo get_the_modified_date('c') ?>">
                <?php echo "Oppdatert: " . $post_modified_date; ?>
            </time>
            <?php }?>
        </div>
        <?php endif ?>
    </div>
    <?php endif ?>
    <?php if (isset($show_activities) && $show_activities && ($view_count || $comment_count)) { ?>
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
 ?>
