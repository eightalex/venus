<?php
extract($args);
$faqs = apply_filters('ud_get_faqs', []);
$faq_bg = !empty($content['faq_bg'])? $content['faq_bg']: get_stylesheet_directory_uri()."/assets/images/section/bg1.png";

if($faqs->have_posts()):
?>

<style>
    .faq_section::before{
        background-image: url(<?php echo $faq_bg?>); 
    }
</style>

<section class="section section_bg faq_section">
    <div class="container">
        <div class="section__inner">
            <?php
            if(!empty($content['faq_title']) || !empty($content['faq_subtitle'])):
                ?>
                <header class="section__header">
                    <?php
                    if(!empty($content['faq_title'])):
                        ?>
                        <div class="section__title"><?php echo $content['faq_title']?></div>
                        <?php
                    endif;

                    if(!empty($content['faq_subtitle'])):
                        ?>
                        <div class="section__subtitle">
                            <?php echo $content['faq_subtitle']?>
                        </div>
                        <?php
                    endif;
                    ?>
                </header>
                <?php
            endif;
            ?>
            <div class="section__content">
                <ul class="faq">
                    <?php
                    $i = 0;
                    while($faqs->have_posts()):
                        $faqs->the_post();
                        $i ++;
                        ?>
                        <li class="faq__item">
                            <input class="faq__trigger" type="checkbox" id="question-<?php echo $i?>">
                            <label class="faq__question" for="question-<?php echo $i?>">
                                <?php the_title()?>
                            </label>
                            <div class="faq__answer">
                                <?php echo  wpautop(get_the_content())?>
                            </div>
                        </li>
                        <?php
                    endwhile;
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<?php
endif;