<?php
extract($args);

// $gc_bg = !empty($content['gc_bg'])? $content['gc_bg']: get_stylesheet_directory_uri()."/assets/images/section/bg3.jpeg";

$author_id = 0;
if(is_category() || is_tax()){
    $sa = $content['au_select'];

    if(!empty($sa)){
        $author_id = intval($sa);
    }
}else{
    $author_id = get_post_field('post_author', $id);
};

if($content['au_power']):

$author             = apply_filters('ud_get_author_infos', $author_id);
$firs_name          = $author['firs_name'];
$last_name          = $author['last_name'];
$author_desc        = $author['desc'];
$main_image_meta    = isset($content['au_main_img'])? $content['au_main_img']: '';
$ava_url            = $author['ava_url'];
$ava                = !empty($ava_url)? $ava_url: get_stylesheet_directory_uri()."/assets/images/author/picture.svg";
// $main_image         = !empty($main_image_meta)? $main_image_meta: get_stylesheet_directory_uri()."/assets/images/author/picture.svg";

?>

<!-- <style>
    .section_bg_3::before{
        background-image: url(<?php echo $gc_bg?>);
    }
</style> -->

<section class="section section_suits">
    <div class="container">
        <div class="section__inner">
            <div class="author">
                <div class="author__content">
                    <div class="author__name"><?php echo $firs_name?> <em><?php echo $last_name?></em></div>
                    <div class="author__title"><?php echo __( 'Author' ); ?></div>
                    <div class="author__about">
                        <?php echo $author_desc?>
                    </div>
                    <!-- <div class="author__preview">
                        <img src="<?php echo $ava?>" alt="author">
                        by <?php echo $firs_name . " " . $last_name?>
                    </div> -->
                </div>
                <div class="author__image">
                    <img src="<?php echo $ava?>" alt="author">
                </div>
            </div>
        </div>
    </div>
</section>
<?php
endif;
