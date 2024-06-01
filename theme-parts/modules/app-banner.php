<?php
    extract($args);

    $title = $txt;

    if(empty($title)){
        $post_title = get_the_title();

        $title_arr = explode(' ', $post_title);
        if(count($title_arr) > 1){
            $last_index = count($title_arr) - 1;
            $title_arr[$last_index] = "<em>$title_arr[$last_index]</em>";

            $title = implode(' ', $title_arr);
        }else{
            $title = $post_title;
        }
    }

    $img_data = apply_filters('ud_get_file_data', $img);
?>

<section class="section section_p_0 section_suits">
    <div class="container">
        <div class="section__inner">
            <div class="banner">
                <div class="banner__content">
                    <?php get_template_part('/theme-parts/modules/breadcrumbs');?>

                    <h1 class="banner__title"><?php echo $title?></h1>
                </div>

                <div class="banner__image">
                    <img src="<?php echo $img_data['src']?>" alt="banner" class="banner__img">
                </div>
            </div>
        </div>
    </div>
</section>