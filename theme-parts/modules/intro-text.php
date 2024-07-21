<?php
extract($args);

if(empty($text)){
    return;
}
?>
<section class="section section_suits section_p_0">
    <div class="container">
        <div class="section__inner">
            <header class="section__header">
                <p class="section__subtitle section__subtitle_single">
                    <?php echo $text?>
                </p>
            </header>
        </div>
    </div>
</section>