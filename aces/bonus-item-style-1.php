<?php
global $post;
$bonus_allowed_html = array(
    'a' => array(
        'href' => true,
        'title' => true,
        'target' => true,
        'rel' => true
    ),
    'br' => array(),
    'em' => array(),
    'strong' => array(),
    'span' => array(
        'class' => true
    ),
    'div' => array(
        'class' => true
    ),
    'p' => array()
);
$bonus_short_desc = wp_kses(get_post_meta(get_the_ID(), 'bonus_short_desc', true), $bonus_allowed_html);
$bonus_external_link = esc_url(get_post_meta(get_the_ID(), 'bonus_external_link', true));
$bonus_button_title = esc_html(get_post_meta(get_the_ID(), 'bonus_button_title', true));
$bonus_button_notice = wp_kses(get_post_meta(get_the_ID(), 'bonus_button_notice', true), $bonus_allowed_html);
$bonus_code = esc_html(get_post_meta(get_the_ID(), 'bonus_code', true));
$bonus_valid_date = esc_html(get_post_meta(get_the_ID(), 'bonus_valid_date', true));
$bonus_dark_style = esc_attr(get_post_meta(get_the_ID(), 'bonus_dark_style', true));

$offer_detailed_tc = wp_kses(get_post_meta(get_the_ID(), 'offer_detailed_tc', true), $bonus_allowed_html);
$offer_popup_title = esc_html(get_post_meta(get_the_ID(), 'aces_offer_popup_title', true));

if ($bonus_button_title) {
    $button_title = $bonus_button_title;
} else {
    if (get_option('bonuses_get_bonus_title')) {
        $button_title = esc_html(get_option('bonuses_get_bonus_title'));
    } else {
        $button_title = esc_html__('Get Bonus', 'mercury');
    }
}

if ($offer_popup_title) {
    $custom_popup_title = $offer_popup_title;
} else {
    $custom_popup_title = esc_html__('T&Cs Apply', 'mercury');
}

if ($bonus_external_link) {
    $external_link_url = $bonus_external_link;
} else {
    $external_link_url = get_the_permalink();
}

$terms = get_the_terms($post->ID, 'bonus-category');

?>

<div class="bonus-card left relative<?php if ($bonus_dark_style == true) { ?> space-dark-style<?php } ?>">
    <div class="bonus-card__tags">
        <?php if ($terms) { ?>
            <div class="bonus-card__tag">
                <?php foreach ($terms as $term) { ?>
                    <a href="<?php echo esc_url(get_term_link((int)$term->term_id, $term->taxonomy)); ?>"
                       title="<?php echo esc_attr($term->name); ?>"><?php echo esc_html($term->name); ?></a>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <header class="bonus-card__header">
        <a href="<?php the_permalink(); ?>"
           title="<?php the_title_attribute(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
    </header>

    <div class="bonus-card__gift">
        <img
                src="<?= get_stylesheet_directory_uri() ?>/assets/images/bonus-card/gift.svg"
                alt="gift"
                class="bonus-card__img"
        >
        <?php if ($bonus_code) { ?>
            <div class="bonus-card__gift-content">
                <span><?php esc_html_e('Bonus Code', 'mercury'); ?>&#58;</span>
                <span><?php echo esc_html($bonus_code); ?></span>
                <?php if ($bonus_valid_date) { ?>
                    <span>
                        <?php esc_html_e('Valid Until:', 'mercury'); ?>
                        <span><?php echo esc_html(date_i18n('M d, Y', strtotime($bonus_valid_date))); ?></span>
                    </span>
                <?php } ?>
            </div>

        <?php } ?>
    </div>

    <?php if ($bonus_short_desc) { ?>
        <div class="bonus-card__subtitle">
            <?php echo wp_kses($bonus_short_desc, $bonus_allowed_html); ?>
        </div>
    <?php } ?>
    <div class="bonus-card__cta">
        <a
                class="bonus-card__button button"
                href="<?php echo esc_url($external_link_url); ?>"
                title="<?php echo esc_attr($button_title); ?>"
                <?php if ($bonus_external_link) { ?>target="_blank" rel="nofollow"<?php } ?>
        >
            <?php echo esc_html($button_title); ?>
        </a>
    </div>
    <div class="bonus-card__info relative">
        <?php if ($offer_detailed_tc) { ?>
            <span class="tc-apply"><?php echo esc_html($custom_popup_title); ?></span>
            <div class="tc-desc">
                <?php
                if ($offer_detailed_tc) {
                    echo wp_kses($offer_detailed_tc, $bonus_allowed_html);
                }
                ?>
            </div>
        <?php } ?>
        <?php if ($bonus_button_notice) { ?>
            <div><?php echo wp_kses($bonus_button_notice, $bonus_allowed_html); ?></div>
        <?php } ?>
    </div>
</div>