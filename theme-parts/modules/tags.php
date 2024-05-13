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
                                <li class="tags__item"><?php echo _e($item, 'mercury')?></li>
                                <?php
                                endforeach;
                                ?>
                            </ul>
                        </li>
                        <?php
                    endforeach;
                    ?>
                    <!-- <li class="tags__card">
                        <div class="tags__header">
                            <div class="tags__icon">
                                <img src="../assets/images/icons/tags/software.svg" alt="tag">
                            </div>
                            <div class="tags__title">Software</div>
                        </div>
                        <ul class="tags__list">
                            <li class="tags__item">ATM</li>
                            <li class="tags__item">$1,000 per day</li>
                            <li class="tags__item">$4,000 peer week</li>
                            <li class="tags__item">$8,000 per month</li>
                            <li class="tags__item">Turkey</li>
                            <li class="tags__item">Ukraine</li>
                            <li class="tags__item">United Kingdom</li>
                        </ul>
                    </li>
                    <li class="tags__card">
                        <div class="tags__header">
                            <div class="tags__icon">
                                <img src="../assets/images/icons/tags/deposit-methods.svg" alt="tag">
                            </div>
                            <div class="tags__title">Deposit Methods</div>
                        </div>
                        <ul class="tags__list">
                            <li class="tags__item">ATM</li>
                            <li class="tags__item">$1,000 per day</li>
                            <li class="tags__item">$4,000 peer week</li>
                            <li class="tags__item">$8,000 per month</li>
                            <li class="tags__item">Turkey</li>
                            <li class="tags__item">Ukraine</li>
                            <li class="tags__item">United Kingdom</li>
                        </ul>
                    </li>
                    <li class="tags__card">
                        <div class="tags__header">
                            <div class="tags__icon">
                                <img src="../assets/images/icons/tags/withdrawal-methods.svg" alt="tag">
                            </div>
                            <div class="tags__title">Withdrawal Methods</div>
                        </div>
                        <ul class="tags__list">
                            <li class="tags__item">ATM</li>
                            <li class="tags__item">$1,000 per day</li>
                            <li class="tags__item">$4,000 peer week</li>
                            <li class="tags__item">$8,000 per month</li>
                            <li class="tags__item">Turkey</li>
                            <li class="tags__item">Ukraine</li>
                            <li class="tags__item">United Kingdom</li>
                        </ul>
                    </li>
                    <li class="tags__card">
                        <div class="tags__header">
                            <div class="tags__icon">
                                <img src="../assets/images/icons/tags/withdrawal-limits.svg" alt="tag">
                            </div>
                            <div class="tags__title">Withdrawal Limits</div>
                        </div>
                        <ul class="tags__list">
                            <li class="tags__item">ATM</li>
                            <li class="tags__item">$1,000 per day</li>
                            <li class="tags__item">$4,000 peer week</li>
                            <li class="tags__item">$8,000 per month</li>
                            <li class="tags__item">Turkey</li>
                            <li class="tags__item">Ukraine</li>
                            <li class="tags__item">United Kingdom</li>
                        </ul>
                    </li>
                    <li class="tags__card">
                        <div class="tags__header">
                            <div class="tags__icon">
                                <img src="../assets/images/icons/tags/restricted-countries.svg" alt="tag">
                            </div>
                            <div class="tags__title">Restricted Countries</div>
                        </div>
                        <ul class="tags__list">
                            <li class="tags__item">ATM</li>
                            <li class="tags__item">$1,000 per day</li>
                            <li class="tags__item">$4,000 peer week</li>
                            <li class="tags__item">$8,000 per month</li>
                            <li class="tags__item">Turkey</li>
                            <li class="tags__item">Ukraine</li>
                            <li class="tags__item">United Kingdom</li>
                        </ul>
                    </li>
                    <li class="tags__card">
                        <div class="tags__header">
                            <div class="tags__icon">
                                <img src="../assets/images/icons/tags/licenses.svg" alt="tag">
                            </div>
                            <div class="tags__title">Licences</div>
                        </div>
                        <ul class="tags__list">
                            <li class="tags__item">ATM</li>
                            <li class="tags__item">$1,000 per day</li>
                            <li class="tags__item">$4,000 peer week</li>
                            <li class="tags__item">$8,000 per month</li>
                            <li class="tags__item">Turkey</li>
                            <li class="tags__item">Ukraine</li>
                            <li class="tags__item">United Kingdom</li>
                        </ul>
                    </li>
                    <li class="tags__card">
                        <div class="tags__header">
                            <div class="tags__icon">
                                <img src="../assets/images/icons/tags/languages.svg" alt="tag">
                            </div>
                            <div class="tags__title">Languages</div>
                        </div>
                        <ul class="tags__list">
                            <li class="tags__item">ATM</li>
                            <li class="tags__item">$1,000 per day</li>
                            <li class="tags__item">$4,000 peer week</li>
                            <li class="tags__item">$8,000 per month</li>
                            <li class="tags__item">Turkey</li>
                            <li class="tags__item">Ukraine</li>
                            <li class="tags__item">United Kingdom</li>
                        </ul>
                    </li>
                    <li class="tags__card">
                        <div class="tags__header">
                            <div class="tags__icon">
                                <img src="../assets/images/icons/tags/currencies.svg" alt="tag">
                            </div>
                            <div class="tags__title">Currencies</div>
                        </div>
                        <ul class="tags__list">
                            <li class="tags__item">ATM</li>
                            <li class="tags__item">$1,000 per day</li>
                            <li class="tags__item">$4,000 peer week</li>
                            <li class="tags__item">$8,000 per month</li>
                            <li class="tags__item">Turkey</li>
                            <li class="tags__item">Ukraine</li>
                            <li class="tags__item">United Kingdom</li>
                        </ul>
                    </li>
                    <li class="tags__card">
                        <div class="tags__header">
                            <div class="tags__icon">
                                <img src="../assets/images/icons/tags/devices.svg" alt="tag">
                            </div>
                            <div class="tags__title">Devices</div>
                        </div>
                        <ul class="tags__list">
                            <li class="tags__item">ATM</li>
                            <li class="tags__item">$1,000 per day</li>
                            <li class="tags__item">$4,000 peer week</li>
                            <li class="tags__item">$8,000 per month</li>
                            <li class="tags__item">Turkey</li>
                            <li class="tags__item">Ukraine</li>
                            <li class="tags__item">United Kingdom</li>
                        </ul>
                    </li>
                    <li class="tags__card">
                        <div class="tags__header">
                            <div class="tags__icon">
                                <img src="../assets/images/icons/tags/owner.svg" alt="tag">
                            </div>
                            <div class="tags__title">Owner</div>
                        </div>
                        <ul class="tags__list">
                            <li class="tags__item">ATM</li>
                            <li class="tags__item">$1,000 per day</li>
                            <li class="tags__item">$4,000 peer week</li>
                            <li class="tags__item">$8,000 per month</li>
                            <li class="tags__item">Turkey</li>
                            <li class="tags__item">Ukraine</li>
                            <li class="tags__item">United Kingdom</li>
                        </ul>
                    </li>
                    <li class="tags__card">
                        <div class="tags__header">
                            <div class="tags__icon">
                                <img src="../assets/images/icons/tags/established.svg" alt="tag">
                            </div>
                            <div class="tags__title">Established</div>
                        </div>
                        <ul class="tags__list">
                            <li class="tags__item">ATM</li>
                            <li class="tags__item">$1,000 per day</li>
                            <li class="tags__item">$4,000 peer week</li>
                            <li class="tags__item">$8,000 per month</li>
                            <li class="tags__item">Turkey</li>
                            <li class="tags__item">Ukraine</li>
                            <li class="tags__item">United Kingdom</li>
                        </ul>
                    </li> -->
                </ul>
            </div>
        </div>
    </div>
</section>