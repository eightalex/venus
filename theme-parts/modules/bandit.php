<?php
extract($args);

if(empty($content['bandit_title']) && empty($content['bandit_subtitle'])){
    return;
}

$bandit_image_id    = $content['bandit_main_img']; 
$main_image_url     = get_stylesheet_directory_uri()."/assets/images/section/bandit.svg";
$main_image_alt     = "automat";
$type_class         = $content['bandit_style_type'] == 'image_right'? '': 'section_img_2';
$fill               = $content['bandit_fill_area']? 'section_img-v2': '';

if(!empty($bandit_image_id)){
    $img_data = apply_filters('ud_get_file_data', $bandit_image_id, 'large');
    $main_image_url = $img_data['src'];

    if(!empty($img_data['alt'])){
        $main_image_alt = $img_data['alt'];
    }
}
?>

<section class="section section_suits section_img <?php echo $type_class . $fill?>">
    <div class="container">
        <div class="section__inner">
            <div class="section__image">
                <img src="<?php echo $main_image_url?>" alt="<?php echo $main_image_alt?>" />
                <?php
                if(!empty($content['bandit_main_img_bg'])):
                    ?>
                    <img src=<?php echo $content['bandit_main_img_bg']?> alt="sun" />
                    <?php
                endif;
                ?>
            </div>
            <header class="section__header">
                <?php
                if(!empty($content['bandit_title'])):
                    ?>
                    <div class="section__title"><?php echo $content['bandit_title']?></div>
                    <?php
                endif;

                if(!empty($content['bandit_subtitle'])):
                ?>
                <div class="section__subtitle">
                    <?php echo $content['bandit_subtitle']?>
                </div>
                <?php
                endif;
                ?>
            </header>
        </div>
    </div>
</section>