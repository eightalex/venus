<?php
extract($args);

if(empty($content['text_editor'])){
    return;
}

$txt = $content['text_editor'];
?>
<section class="section section_bg section_bg_6">
    <div class="container">
        <div class="section__inner">
            <div class="variable-content">
                <?php
                   echo apply_filters('the_content',$txt);
                ?>
            </div>
        </div>
    </div>
</section>
