<?php
    extract($args);

    $title = $txt;

    if(empty($title)){
        $post_title = is_tax()?get_queried_object()->name:get_the_title();

        $title_arr = explode(' ', $post_title);
        if(count($title_arr) > 1){
            $last_index = count($title_arr) - 1;
            $title_arr[$last_index] = "<em>$title_arr[$last_index]</em>";

            $title = implode(' ', $title_arr);
        }else{
            $title = $post_title;
        }
    }

    if(gettype($img) == 'integer'){
        $img_data = apply_filters('ud_get_file_data', $img);
    }elseif(gettype($img) == 'string'){
        $img_data = ['src'=>$img];
    }
?>

<section class="section section_p_0 section_suits">
    <div class="container">
        <div class="section__inner">
            <div class="banner">
                <div class="banner__content">
                    <?php get_template_part('/theme-parts/modules/breadcrumbs', '', ['inline' => true]); ?>

                    <h1 class="banner__title"><?php echo do_shortcode($title); ?></h1>
                    <?php get_template_part("/theme-parts/modules/post-info") ?>
                </div>

                <div class="banner__image">
                    <?php
                    if(!empty($img_data['src'])):
                    ?>
                    <img src="<?php echo $img_data['src']?>" alt="banner" class="banner__img">
                    <?php
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
