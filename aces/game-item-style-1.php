<?php
global $post;
$game_allowed_html = array(
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

$game_short_desc = wp_kses(get_post_meta(get_the_ID(), 'game_short_desc', true), $game_allowed_html);
$game_external_link = esc_url(get_post_meta(get_the_ID(), 'game_external_link', true));
$game_button_title = esc_html(get_post_meta(get_the_ID(), 'game_button_title', true));
$game_button_notice = wp_kses(get_post_meta(get_the_ID(), 'game_button_notice', true), $game_allowed_html);
$unit_popup_title = esc_html(get_post_meta(get_the_ID(), 'aces_unit_popup_title', true));

$unit_detailed_tc = wp_kses(get_post_meta(get_the_ID(), 'unit_detailed_tc', true), $game_allowed_html);

if ($game_button_title) {
    $button_title = $game_button_title;
} else {
    if (get_option('games_play_now_title')) {
        $button_title = esc_html(get_option('games_play_now_title'));
    } else {
        $button_title = esc_html__('Play Now', 'mercury');
    }
}

if ($game_external_link) {
    $external_link_url = $game_external_link;
} else {
    $external_link_url = get_the_permalink();
}

if ($unit_popup_title) {
    $custom_popup_title = $unit_popup_title;
} else {
    $custom_popup_title = esc_html__('T&Cs Apply', 'mercury');
}

$terms = get_the_terms($post->ID, 'game-category');
?>


<div class="game-card">

    <div class="game-card__image">
        <?php
        $post_title_attr = the_title_attribute('echo=0');
        if (wp_get_attachment_image(get_post_thumbnail_id())) { ?>
            <div class="space-units-archive-item-img relative">
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <?php echo wp_get_attachment_image(get_post_thumbnail_id(), 'mercury-450-317', "", array("alt" => $post_title_attr)); ?>
                </a>
            </div>
        <?php } ?>
    </div>

    <div class="game-card__title">
        <a href="<?php the_permalink(); ?>"
           title="<?php the_title_attribute(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
    </div>

    <?php if ($game_short_desc) { ?>
        <div class="game-card__subtitle">
            <?php echo wp_kses($game_short_desc, $game_allowed_html); ?>
        </div>
    <?php } ?>

    <div class="game-card__cta">
        <a
                class="game-card__button button" href="<?php echo esc_url($external_link_url); ?>"
                title="<?php echo esc_attr($button_title); ?>"
                <?php if ($game_external_link) { ?>target="_blank"
                rel="nofollow"<?php } ?>><?php echo esc_html($button_title); ?></a>
    </div>

    <div class="game-card__info relative">
        <?php if ($unit_detailed_tc) { ?>
            <span class="tc-apply"><?php echo esc_html($custom_popup_title); ?></span>
            <div class="tc-desc">
                <?php
                if ($unit_detailed_tc) {
                    echo wp_kses($unit_detailed_tc, $game_allowed_html);
                }
                ?>
            </div>
        <?php } ?>
        <?php if ($game_button_notice) { ?>
            <div><?php echo wp_kses($game_button_notice, $game_allowed_html); ?></div>
        <?php } ?>
    </div>
</div>