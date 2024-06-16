<?php
extract($args);

if(empty($content['game_types_repeater'])){
    return;
}

$games              = $content['game_types_repeater'];
$section_title      = $content['game_types_title'];
$section_subtitle   = $content['game_types_subtitle'];

?>
<section class="section section_suits section_img">
    <div class="container">
        <div class="section__inner">
            <header class="section__header">
                <div class="section__title">
                    <?php echo $section_title ?>
                </div>
                <div class="section__subtitle">
                    <?php echo $section_subtitle ?>
                </div>
            </header>
            <div class="section__content">
                <div class="game-types">
                    <?php
                    foreach($games as $game):
                        $icon_id    = $game['gt_icon'];
                        $icon_data  = apply_filters('ud_get_file_data', $icon_id);
                        $title      = $game['gt_title'];
                        $desc       = $game['gt_desc'];
                        ?>
                        <div class="game-types__item">
                            <div class="game-types__header">
                                <?php
                                if(!empty($icon_data)):
                                    ?>
                                    <div class="game-types__icon">
                                        <img src="<?php echo $icon_data['src']?>" alt="<?php echo $icon_data['alt']?>">
                                    </div>
                                <?php
                                endif;

                                if(!empty($title)):
                                    ?>
                                    <div class="game-types__title">
                                        <?php echo $title?>
                                    </div>
                                <?php
                                endif;
                                ?>
                            </div>
                            <?php
                            if(!empty($desc)):
                                ?>
                                <div class="game-types__text">
                                    <?php echo $desc?>
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
