<?php
extract($args);

if(empty($content['adv_list'])){
    return;
}
?>
<section class="section section_suits">
    <div class="container">
        <div class="section__inner">
            <header class="section__header">
                <?php
                if(!empty($content['adv_title'])):
                    ?>
                    <h2 class="section__title section__title_s"><?php echo $content['adv_title']?></h2>
                    <?php
                endif;

                if(!empty($content['adv_subtitle'])):
                ?>
                <div class="section__subtitle">
                    <?php echo $content['adv_subtitle']?>
                </div>
                <?php
                endif;
                ?>
            </header>
            <div class="section__content">
                <div class="advantages">
                    <?php
                    foreach($content['adv_list'] as $k => $adv):
                        ?>
                        <div class="advantages__item">
                            <?php
                            if(!empty($adv['adv_item_txt'])):
                            ?>
                            <div class="advantages__text">
                                <?php echo $adv['adv_item_txt']?>
                            </div>
                            <?php
                            endif;

                            if(!empty($adv['adv_item_img'])):
                                $th_data = apply_filters('ud_get_file_data', $adv['adv_item_img']);
                            ?>
                            <div class="advantages__image">
                                <img src="<?php echo $th_data['src']?>" alt="<?php echo $th_data['alt']?>">
                            </div>
                            <?php
                            endif;
                            ?>
                        </div>
                        <?php
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
