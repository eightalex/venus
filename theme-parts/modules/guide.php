<?php
extract($args);

$g_title = !empty($content['guide_title'])? $content['guide_title']: get_the_title($id);
?>
<section class="section section_suits">
    <div class="container">
        <div class="section__inner">
            <div class="guide">
                <header class="guide__header">
                    <h2 class="guide__title"><?php echo do_shortcode( $g_title )?></h2>
                    <?php
                    if(!empty($content['guide_desc'])):
                        ?>
                        <div class="guide__subtitle">
                            <?php echo do_shortcode( $content['guide_desc'] )?>
                        </div>
                        <?php
                    endif;
                    ?>
                </header>

                <?php
                if(!empty($content['guide_steps'])):
                    ?>
                    <div class="guide__content">
                        <?php
                        foreach($content['guide_steps'] as $key => $step):
                            ?>
                            <div class="guide__step">
                                <div class="guide__info">
                                    <?php
                                    if(!empty($step['g_s_title'])):
                                        ?>
                                        <div class="guide__step-title"><?php echo do_shortcode( $step['g_s_title'] )?></div>
                                        <?php
                                    endif;

                                    if(!empty($step['g_s_txt'])):
                                        ?>
                                        <div class="guide__step-text">
                                            <?php echo do_shortcode( $step['g_s_txt'] )?>
                                        </div>
                                        <?php
                                    endif;
                                    ?>
                                </div>
                                <?php
                                if(!empty($step['g_s_thmb'])):
                                    $th_data = apply_filters('ud_get_file_data', $step['g_s_thmb'], "large");
                                    ?>
                                    <div class="guide__image">
                                        <img  src="<?php echo $th_data['src']?>" alt="<?php echo $th_data['alt']?>">
                                    </div>
                                    <?php
                                endif;
                                ?>
                            </div>
                            <?php
                        endforeach;
                        ?>
                    </div>
                    <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</section>
