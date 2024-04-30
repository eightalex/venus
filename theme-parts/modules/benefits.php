<?php
extract($args);

if(empty($content['benefits_advantages']) && empty($content['benefits_flaws'])){
    return;
}

$benefits_bg        = !empty($content['benefits_bg'])? $content['benefits_bg']: get_stylesheet_directory_uri()."/assets/images/section/bg1.png";
$section_subtitle   = !empty($content['benefits_subtitle'])? $content['benefits_subtitle']: get_the_excerpt($id);
?>

<style>
    .benefits_section::before{
        background-image: url(<?php echo $benefits_bg?>); 
    }
</style>
<section class="section section_bg benefits_section">
    <div class="container">
        <div class="section__inner">
            <header class="section__header">
                <?php
                if(!empty($content['benefits_title'])):
                    ?>
                    <div class="section__title"><?php echo $content['benefits_title']?></div>
                    <?php
                endif;

                if(!empty($section_subtitle)):
                    ?>
                    <div class="section__subtitle">
                        <?php echo $section_subtitle?>
                    </div>
                    <?php
                endif;
                ?>
            </header>

            <div class="section__content">
                <?php
                if(!empty($content['benefits_advantages'])):
                    ?>
                    <div class="benefits benefits_spades">
                        <?php
                        if(!empty($content['advantages_title'])):
                            ?>
                            <div class="benefits__title"><?php echo $content['advantages_title']?></div>
                            <?php
                        endif;
                        ?>
                        <ul class="benefits__list">
                            <?php
                            foreach($content['benefits_advantages'] as $item):
                                ?>
                                <li class="benefits__item"><?php echo $item['b_adv']?></li>
                                <?php
                            endforeach;
                            ?>
                        </ul>
                    </div>
                    <?php
                endif;

                if(!empty($content['benefits_flaws'])):
                    ?>
                    <div class="benefits benefits_clubs benefits_negative">
                        <?php
                        if(!empty($content['flaws_title'])):
                            ?>
                            <div class="benefits__title"><?php echo $content['flaws_title']?></div>
                            <?php
                        endif;
                        ?>
                        <ul class="benefits__list">
                            <?php
                            foreach($content['benefits_flaws'] as $item):
                                ?>
                                <li class="benefits__item"><?php echo $item['b_flaw']?></li>
                                <?php
                            endforeach;
                            ?>
                        </ul>
                    </div>
                    <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</section>