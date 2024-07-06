<?php
extract($args);

if(!$content['rating_power']){
    return;
}

if($content['rating_games']){
    get_template_part('theme-parts/modules/game-rating','', ['content' => $content]);

    return;
};

$terms_desc             = get_post_meta($id, "{$post_type}_terms_desc", true);
$terms_desc_arr         = explode('<br />', wpautop($terms_desc));
$ratings_data           = apply_filters('ud_get_post_ratings', $post_type, $id);
$external_link          = get_post_meta($id, "{$post_type}_external_link", true);
$btn_txt                = !empty(get_option('casinos_play_now_title'))? get_option('casinos_play_now_title'): "Play Now";


?>
<section class="section_suits">
    <div class="container">
        <div class="section__inner">
            <div class="rating-card">
                <?php
                if(is_array($terms_desc_arr)):
                ?>
                <div class="rating-card__tags">
                    <div class="rating-card__tag"><?php echo str_replace('<p>', '',$terms_desc_arr[0])?></div>
                </div>
                <div class="rating-card__about">
                    <div class="rating-card__price"><?php echo $terms_desc_arr[1]?></div>
                    <div class="rating-card__title"><?php echo $terms_desc_arr[2]?></div>
                    <div class="rating-card__subtitle"><?php echo str_replace('</p>', '',$terms_desc_arr[3])?></div>
                </div>
                <?php
                endif;
                ?>
                <div class="rating-card__cta">
                    <?php
                    if(!empty($external_link)):
                        ?>
                        <a href="<?php echo $external_link?>" target="__blank" class="rating-card__button button"><?php echo $btn_txt?></a>
                        <span><?php echo get_post_meta($id, "{$post_type}_button_notice", true)?></span>
                        <?php
                    endif;
                    ?>
                </div>

                <div class="rating-card__content">

                    <div class="rating-card__overall-rating">
                        <var><?php echo $ratings_data['overall']['val']?></var>
                        <span><?php echo $ratings_data['overall']['name']?></span>
                    </div>
                    <ul class="rating-card__list">
                        <?php
                        foreach($ratings_data as $rn => $rv):
                            if($rn !== "overall"):
                                ?>
                                <li class="rating-card__item">
                                    <div class="rating-card__name"><?php echo $rv['name']?></div>
                                    <div class="rating-card__rating" data-rating="<?php echo $rv['val']?>">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </li>
                                <?php
                            endif;
                        endforeach;
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
