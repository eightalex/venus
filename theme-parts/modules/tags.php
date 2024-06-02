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

                        $custom_title = "";
            
                        switch($conv_name){
                            case "casino-language":
                                $custom_title = get_option("casinos_languages_title");
                                break;
                            case "established":
                                $custom_title = get_option("casinos_est_title");
                                break;
                            case "deposit-methods":
                                $custom_title = get_option("casinos_deposit_method_title");
                                break;
                            case "withdrawal-methods":
                                $custom_title = get_option("casinos_withdrawal_method_title");
                                break;
                            case "withdrawal-limits":
                                $custom_title = get_option("casinos_withdrawal_limit_title");
                                break;       
                            case "restricted-countries":
                                $custom_title = get_option("casinos_restricted_countries_title");
                                break;                         
                            default :
                                $custom_title = get_option("casinos_{$conv_name}_title");
                        }
            
                        if(!empty($custom_title)){
                            $name = $custom_title;
                        }else{
                            $name = $tk;
                        }
                        ?>
                        <li class="tags__card">
                            <div class="tags__header">
                                <div class="tags__icon">
                                    <img src="<?php echo $icon_url?>" alt="<?php echo $name?>">
                                </div>
                                <div class="tags__title"><?php echo $name?></div>
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
