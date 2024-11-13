<?php
extract($args);
$tags = get_the_tags($id);
if(empty($tags)){
    return;
}
?>

<div class="categories js-categories">
        <div class="container">
            <div class="categories__inner">
                <?php
                foreach($tags as $tag):
                    ?>
                    <div class="tag"><?php echo do_shortcode( $tag->name )?></div>
                    <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>