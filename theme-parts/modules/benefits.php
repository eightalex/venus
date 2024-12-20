<?php
extract($args);

if(empty($content['benefits_advantages']) && empty($content['benefits_flaws'])){
    return;
}

$benefits_bg        = !empty($content['benefits_bg'])? $content['benefits_bg']: get_stylesheet_directory_uri()."/assets/images/section/bg1.png";
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
                    <h2 class="section__title"><?php echo do_shortcode( $content['benefits_title'] );?></h2>
                    <?php
                endif;

                if(!empty($content['benefits_subtitle'])):
                    ?>
                    <div class="section__subtitle">
                        <?php echo do_shortcode( $content['benefits_subtitle'] );?>
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
                            <div class="benefits__title"><?php echo do_shortcode( $content['advantages_title'] );?></div>
                            <?php
                        endif;
                        ?>
                        <ul class="benefits__list">
                            <?php
                            foreach($content['benefits_advantages'] as $item):
                                ?>
                                <li class="benefits__item"><?php echo do_shortcode( $item['b_adv'] );?></li>
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
                            <div class="benefits__title"><?php echo do_shortcode( $content['flaws_title'] );?></div>
                            <?php
                        endif;
                        ?>
                        <ul class="benefits__list">
                            <?php
                            foreach($content['benefits_flaws'] as $item):
                                ?>
                                <li class="benefits__item"><?php echo do_shortcode( $item['b_flaw'] );?></li>
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
