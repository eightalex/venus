<?php
extract($args);

if(empty($content['text_editor'])){
    return;
}

$txt = $content['text_editor'];
?>
<section class="section section_suits">
    <div class="container">
        <div class="section__inner">
            <div class="variable-content">
                <?php
                    apply_filters('the_content',$txt);
                ?>
            </div>
        </div>
    </div>
</section>