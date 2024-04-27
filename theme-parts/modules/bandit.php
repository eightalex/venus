<?php
extract($args);

if(empty($content['bandit_title']) && empty($content['bandit_subtitle'])){
    return;
}

$bandit_image_id    = $content['bandit_main_img']; 
$main_image_url     = get_stylesheet_directory_uri()."/assets/images/section/bandit.svg";
$main_image_alt     = "automat";
if(!empty($bandit_image_id)){
    $img_data = apply_filters('ud_get_file_data', $bandit_image_id, 'large');
    $main_image_url = $img_data['src'];

    if(!empty($img_data['alt'])){
        $main_image_alt = $img_data['alt'];
    }
}
?>

<section class="section section_suits section_img">
    <div class="container">
        <div class="section__inner">
            <div class="section__image">
                <img src="<?php echo $main_image_url?>" alt="<?php echo $main_image_alt?>" />
                <img src=<?php echo get_stylesheet_directory_uri()."/assets/images/section/sun.png"?> alt="sun" />
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