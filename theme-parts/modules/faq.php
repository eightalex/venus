<?php
extract($args);
if(!empty($content['faq_items'])):

$faq_bg = !empty($content['faq_bg'])? $content['faq_bg']: get_stylesheet_directory_uri()."/assets/images/section/bg1.png";
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
                    foreach($content['faq_items'] as $k => $item):
                        $i = $k+1;
                        ?>
                        <li class="faq__item">
                            <input class="faq__trigger" type="checkbox" id="question-<?php echo $i?>">
                            <label class="faq__question" for="question-<?php echo $i?>">
                                <?php echo $item['question']?>
                            </label>
                            <div class="faq__answer">
                                <?php echo wpautop($item['answer'])?>
                            </div>
                        </li>
                        <?php
                    endforeach;
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<?php
endif;