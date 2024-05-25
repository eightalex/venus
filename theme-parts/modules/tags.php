<?php
extract($args);

$taxs = apply_filters('ud_get_taxs', $post_type, $id);

if(!$content['tags_power'] || empty($taxs)){
    return;
}
$title_section = !empty($content['tags_title'])? $content['tags_title']: get_the_title(). " <em>details</em>";
?>
<section class="section section_bg section_bg_2">
    <div class="container">
        <div class="section__inner">
            <header class="section__header">
                <div class="section__title"><?php echo $title_section?></div>

                <?php
                if(!empty($content['tags_subtitle'])):
                    ?>
                    <div class="section__subtitle">
                        <?php echo $content['tags_subtitle']?>
                    </div>
                    <?php
                endif;
                ?>
            </header>
            <div class="section__content">
                <ul class="tags">
                    <?php
                    foreach($taxs as $tk => $items):
                        $conv_name  = strtolower(str_replace(' ', '-', $tk));
                        $icon_url   = get_stylesheet_directory_uri()."/assets/images/icons/tags/$conv_name.svg";
                        ?>
                        <li class="tags__card">
                            <div class="tags__header">
                                <div class="tags__icon">
                                    <img src="<?php echo $icon_url?>" alt="<?php echo _e($tk, 'mercury')?>">
                                </div>
                                <div class="tags__title"><?php echo _e($tk, 'mercury')?></div>
                            </div>
                            <ul class="tags__list">
                                <?php
                                foreach($items as $item):
                                ?>
                                <li class="tag"><?php echo _e($item, 'mercury')?></li>
                                <?php
                                endforeach;
                                ?>
                            </ul>
                        </li>
                        <?php
                    endforeach;
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>
