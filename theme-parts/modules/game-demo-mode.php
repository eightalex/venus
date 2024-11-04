<?php 
$post_id          = get_the_ID();
$post_title       = get_the_title();
$post_subtitle    = carbon_get_post_meta($post_id, 'slot_demo_subtitle');
$post_image_id    = get_post_thumbnail_id($post_id);
$post_image_data  = apply_filters('ud_get_file_data', $post_image_id);
$button_play_txt  = get_post_meta( $post_id, 'game_button_title', true );
$button_play_link = get_post_meta( $post_id, 'game_external_link', true );
$demo_notice      = get_post_meta($post_id, 'unit_detailed_tc', true);
$demo_url         = carbon_get_post_meta($post_id, 'slot_demo_mode_url');

// die(print_r($post_image_data));
if ($demo_url):
?>

<div class="game-demo-mode" id="game-demo-mode-container">
    <div class="game-demo-mode__iframe-wrapper" 
        id="game-demo-mode-iframe-wrapper" 
        data-demo-src="<?php echo esc_url($demo_url) ?>"
    >
        <button id="game-demo-mode-close">
            <span class="bx-next dashicons dashicons-no-alt"></span>
        </button>
    </div>
    <div class="game-demo-mode__container" id="game-demo-mode__container">
       
        <?php if ($post_image_data && $post_image_data['src']): ?>
            <img 
            class="game-demo-mode__image" 
            src="<?php echo $post_image_data['src'] ?>" 
            alt="<?php echo $post_image_data['alt'] ?>">
        <?php endif ?>
        <h2 class="game-demo-mode__title">
            <?php echo $post_title ?>
        </h2>
        <?php if (!empty($post_subtitle)): ?>
            <p class="game-demo-mode__subtitle">
                <?php echo $post_subtitle ?>
            </p>
        <?php endif ?>
        <div class="game-demo-mode__actions">
            <button class="button button_outline" id="game-demo-mode__demo-btn">
                Spill gratis
            </button>
            <?php if (!empty($button_play_link)): ?>
                <a class="button" href="<?php echo $button_play_link ?>" rel='nofollow noopener' target="_blank">
                    <?php echo empty($button_play_txt) ? 'Spill Na' : $button_play_txt ?>
                </a>
            <?php endif ?>
        </div>
        <?php if (!empty($demo_notice)): ?>
            <span class="game-demo-mode__notice"><?php echo $demo_notice ?></span>
        <?php endif ?>
    </div>
</div>
<?php endif ?>