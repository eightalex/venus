<?php
extract($args);

if(empty($content['text_editor'])){
    return;
}

$txt = $content['text_editor'];
$txt = do_shortcode($txt);
?>
<section class="section section_bg section_bg_6">
    <div class="container">
        <div class="section__inner">
            <div class="variable-content">
                <?php
                   echo $txt;
                ?>
            </div>
        </div>
    </div>
</section>
