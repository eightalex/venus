<?php

$ID 				= get_queried_object()->term_id;
$app_banner_img		= intval(carbon_get_term_meta($ID, 'app_banner_img'));
$app_banner_txt		= carbon_get_term_meta($ID, 'app_banner_txt');
$intro_text 		= carbon_get_term_meta($ID, 'intro_text');
$content_editor 	= carbon_get_term_meta($ID, 'content_editor');
$content 			= carbon_get_term_meta($ID, 'ud_cat_content');
$main_casinois_page	= carbon_get_theme_option('default_page_casinois');
$is_paginavi 		= apply_filters('is_paginavi', 0);
$casino_card_v1     = carbon_get_term_meta($ID, 'casino_card_v1');;

$cas_args = [
    'items_number'   => 9,
	'category'       => $ID
];

$terms = get_terms( array(
    'taxonomy'   => 'casino-category',
) );

$casinos = apply_filters('ud_get_casinos', $cas_args);

if(empty($app_banner_img)){
	$app_banner_img = get_stylesheet_directory_uri()."/assets/images/banner/banner.svg";
}

get_header();
get_template_part('/theme-parts/modules/app-banner', '', ['img' => $app_banner_img, 'txt' => $app_banner_txt]);

if(!empty($intro_text)):
	get_template_part('/theme-parts/modules/intro-text', '', ['text'=>$intro_text]);
endif;

if($casinos->have_posts()):
	?>
	<section class="section section_suits">
		<div class="container">
			<div class="section__inner">
                <div class="content-cards content-cards_p_0">
                    <div class="content-cards__switch">
                        <div class="page-switch">
                            <?php
                            if($main_casinois_page && !empty($main_casinois_page)):
                                ?>
                                <a href="<?php echo get_the_permalink($main_casinois_page)?>" class="page-switch__button">alle nettkasinoer</a>
                                <?php
                            endif;

                            foreach($terms as $term):
                                $t_id   = $term->term_id;
                                $url    = get_term_link($t_id);
                                $active = $ID == $t_id? 'active': '';
                                ?>
                                <a href="<?php echo $url?>" class="page-switch__button <?php echo $active?>"><?php echo $term->name?></a>
                                <?php
                            endforeach;
                            ?>
                        </div>
                    </div>
                    <?php if ($casino_card_v1):?>
                    <table class="card-list card-list_col-2 table" style="margin-top: 40px;">
                        <?php
                        while($casinos->have_posts()):
                            $casinos->the_post();

                            $id                         = get_the_ID();
                            $cas_img_id                 = get_post_thumbnail_id();
                            $cas_img_data               = apply_filters('ud_get_file_data', $cas_img_id);
                            $desc                       = get_post_meta($id, 'casino_short_desc', true);
                            $casino_overall_rating      = floatval(get_post_meta($id, 'casino_overall_rating', true));
                            $casino_external_link       = get_post_meta($id, 'casino_external_link', true);

                            $atts = [
                                'title'             => get_the_title(),
                                'img_src'           => $cas_img_id !== 0? $cas_img_data['src']: '',
                                'img_alt'           => $cas_img_id !== 0? $cas_img_data['alt']: get_the_title(),
                                'rating'            => $casino_overall_rating,
                                'desc'              => $desc,
                                'permalink'         => get_the_permalink(),
                                'external_link'     => $casino_external_link,
                                'is_table'          => true,
                            ];

                            echo '<tr>';
                                do_action('print_single_casino_template', $atts);
                            echo '</tr>';
                        endwhile;
                        ?>
                    </table>
                    <?php else : ?>
                    <div class="card-list card-list_col-1" style="margin-top: 40px;">
                        <?php while($casinos->have_posts()): ?>

                        <?php

                        $casinos->the_post();

                        $id                    = get_the_ID();
                        $is_first_casino       = $casinos->current_post === 0;
                        $img_id                = get_post_thumbnail_id();
                        $img_data              = apply_filters('ud_get_file_data', $img_id);
                        $img_src               = $img_id !== 0? $img_data['src']: '';
                        $img_alt               = $img_id !== 0? $img_data['alt']: get_the_title();
                        $description           = get_post_meta($id, 'casino_short_desc', true);
                        $overall_rating        = floatval(get_post_meta($id, 'casino_overall_rating', true));
                        $external_link         = get_post_meta($id, 'casino_external_link', true);
                        $title                 = get_the_title();
                        $permalink             = get_the_permalink();
                        $button_external_text  = !empty(get_option('casinos_play_now_title')) ? get_option('casinos_play_now_title') : 'Spill Na';
                        $button_permalink_text = !empty(get_option('casinos_read_review_title')) ? get_option('casinos_read_review_title') : 'Les Anmeldelse';
                        $promo_text_title      = carbon_get_post_meta($id, 'promo_text_title') ?: 'Temp text';
                        $promo_text_price      = carbon_get_post_meta($id, 'promo_text_price') ?: 'Temp text';
                        $promo_text_price_2    = carbon_get_post_meta($id, 'promo_text_price_2'); // optional
                        $promo_text_subtitle   = carbon_get_post_meta($id, 'promo_text_subtitle') ?: 'Temp text';
                        $detailed_tc           = get_post_meta($id, 'casino_detailed_tc', true);

                        if ($is_first_casino) {
                            $float_bar_casino_id = $id;
                        }

                        ?>

                        <div class="casino-card-v2">
                            <div class="casino-card-v2__casino">
                                <div class="casino-card-v2__logo">
                                    <img src="<?= $img_src ?>" alt="<?= $img_alt ?>">
                                </div>
                                <div class="casino-card-v2__info">
                                    <div class="casino-card-v2__title"><?= $title ?></div>
                                    <div class="casino-card-v2__rating">
                                        <?php get_template_part('theme-parts/modules/star-rating', '', [
                                            'id' => 2,
                                            'number_of_stars' => 5,
                                            'rating' => $overall_rating,
                                            'classname' => 'casino-card-v2__star-rating',
                                            'bg_color' => $is_first_casino ? '#5c2ed2' : '#223147',
                                            'bg_stars' => true,
                                        ]) ?>
                                        <div class="casino-card-v2__number-rating">
                                            <?= number_format($overall_rating, 2); ?>
                                        </div>
                                    </div>
                                    <div class="casino-card-v2__clarification">
                                        <span>*Kun nye spillere</span>
                                        <i class="info-tooltip">
                                            <span><?= $detailed_tc ?></span>
                                        </i>
                                    </div>
                                </div>
                            </div>
                            <div class="casino-card-v2__details">
                                <span class="detail-1"><?= $promo_text_title ?></span>
                                <span class="detail-2"><?= $promo_text_price ?></span>
                                <?php if ($promo_text_price_2): ?>
                                    <span class="detail-3"><?= $promo_text_price_2 ?></span>
                                <?php endif; ?>
                                <span class="detail-4"><?= $promo_text_subtitle ?></span>
                            </div>
                            <div class="casino-card-v2__cta">
                                <a href="<?= $external_link ?>" class="button button_v2">
                                    <?= $button_external_text ?>
                                </a>
                                <a href="<?= $permalink ?>" class="button button_v2 button_outline">
                                    <?= $button_permalink_text ?>
                                </a>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <?php endif ?>
                </div>
				<?php
					$max_pages = $casinos->max_num_pages;
					$paged = $casinos->query['paged'];
					if($max_pages  > 1){
						$pagenavi_items = apply_filters('my_pagination', $paged, $max_pages, "casinois-page");
						echo "<div class='content-cards__footer'>
									{$pagenavi_items}
							  </div>";
					}
				?>
			</div>
		</div>
	</section>
<?php
endif;

if(!$is_paginavi){
	if(!empty($content_editor)){
		$part = ['text_editor' => $content_editor];
		get_template_part("/theme-parts/modules/text-editor", "", ["id" => $ID, "content"=>$part]);
	}

	if(!empty($content)){
		foreach($content as $part){
			$part_tmpl = $part['_type'];

			get_template_part("/theme-parts/modules/$part_tmpl", "", ["id" => $ID, "content"=>$part, "post_type" => 'page']);
		}
	}
}

get_footer();
?>
