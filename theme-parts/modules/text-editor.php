<?php
extract($args);

if(empty($content['text_editor'])){
    return;
}
?>
<section class="section section_suits">
    <div class="container">
        <div class="section__inner">
            <div class="variable-content">
                <?php
                    echo $content['text_editor'];
                ?>
            </div>
        </div>
    </div>
</section>