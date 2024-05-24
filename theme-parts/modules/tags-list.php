<?php
extract($args);

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
                <div class="categories__item"><?php echo $tag?></div>
                <?php
            endforeach;
            ?>
        </div>
    </div>
</div>