<?php

global $float_bar_casino_id;
$float_bar_casino_id = null;

function filter_menu_item_classes( $classes ) {
    $classes[] = 'navigation__item';
    return $classes;
}

add_filter( 'nav_menu_css_class', 'filter_menu_item_classes', 10, 4 );

function filter_submenu_classes( $classes, $args ) {
    switch ($args->menu_class) {
        case 'navigation__inner':
            $classes[] = 'navigation__submenu';
            break;
        case 'mobile-menu__inner':
            $classes[] = 'navigation__submenu-mobile';
            break;
    }
    return $classes;
}

add_action( 'admin_enqueue_scripts', 'load_admin_custom_style' );
function load_admin_custom_style() {
    wp_enqueue_style( 'admin_custom_css', get_stylesheet_directory_uri() . '/styles/admin-custom-styles.css', false, false );
}

add_filter( 'nav_menu_submenu_css_class', 'filter_submenu_classes', 10, 3 );

function venus_scripts() {
    wp_enqueue_style('my_custom_style', get_stylesheet_directory_uri().'/styles/index.css', array(), filemtime(get_stylesheet_directory().'/styles/index.css'));
    wp_enqueue_style('swiper_style', get_stylesheet_directory_uri().'/scripts/libs/swiper-bundle.min.css');
    wp_enqueue_script('swiper_js', get_theme_file_uri( '/scripts/libs/swiper-bundle.min.js' ), array( 'jquery' ), $GLOBALS['mercury_version'], true );
    wp_enqueue_script('app', get_theme_file_uri( '/scripts/app.js' ), array( 'jquery' ), filemtime(get_stylesheet_directory().'/scripts/app.js'), true );
}

add_action( 'wp_enqueue_scripts', 'venus_scripts' );

add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
    require_once( 'vendor/autoload.php' );
    \Carbon_Fields\Carbon_Fields::boot();
}

// CUSTOM ACTIONS
// add_action('init', 'ud_register_post_types');
function ud_register_post_types(){
    register_post_type('faq', [
        'label' => null,
        'labels' => [
            'name'                  => __('FAQ`s'),
            'singular_name'         => __('FAQ`s'),
            'add_new'               => __('Add a new FAQ'),
            'add_new_item'          => __('Add a new FAQ'),
            'edit_item'             => __('Edit FAQ'),
            'new_item'              => __('New FAQ'),
            'view_item'             => __('View FAQ'),
            'search_items'          => __('Search'),
            'not_found'             => __('Not found'),
            'not_found_in_trash'    => __('Not found in the cart'),
            'parent_item_colon'     => '',
            'menu_name'             => __('FAQ`s'),
        ],
        'description'       => '',
        'public'            => true,
        'show_in_menu'      => true,
        'show_in_rest'      => null,
        'rest_base'         => null,
        'show_in_nav_menus' => true,
        'menu_position'     => null,
        'menu_icon'         => 'dashicons-list-view',
        'hierarchical'      => false,
        'supports'          => ['title','editor'], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'        => [],
        'has_archive'       => false,
        'rewrite'           => true,
        'query_var'         => true,
    ]);
}

add_filter( 'comment_form_defaults', 'ud_customise_comment_fields');
function ud_customise_comment_fields( $default ) {
    $default[ 'comment_field' ] = '<div class="form-reply__input input-label">
                                <label for="comment" class="input-label__label">Kommentar*</label>
                                <textarea id="comment" name="comment" class="input input_textarea" placeholder="Skriv din tekst her"></textarea>
                            </div>';
    $default['class_submit'] = 'form-reply__button button';
    $default['label_submit'] = 'Post Kommentar';
    $default['submit_button' ] = '<button class="%3$s">%4$s</button>';
    $default['submit_field'] = '<div class="form-reply__cta">%1$s %2$s</div>';

	return $default;
};

add_filter('comment_form_fields', 'custom_order_comment_field' );
if(!function_exists('customize_comment_form')){
  function custom_order_comment_field( $fields ){
	$new_fields = array();
	$new_order = array('author','email', 'url', 'cookies', 'comment');

	foreach( $new_order as $key ){
	   $new_fields[ $key ] = $fields[ $key ];
	   unset( $fields[ $key ] );
	}
	if( $fields )
	foreach( $fields as $key => $val ){
	    $new_fields[ $key ] = $val;
        }

	return $new_fields;
   }
}




add_filter('ud_get_file_data', 'ud_get_file_data');
/**
 * Use sizes "medium", "medium_large", "large", "full" or or other registered sizes
 */
function ud_get_file_data($attach_id, $size = 'thumbnal'){
    return array(
        'src'      => wp_get_attachment_image_url($attach_id, $size),
        'alt'      => get_post_meta($attach_id, '_wp_attachment_image_alt', TRUE),
    );
}

add_filter('ud_get_author_infos', 'ud_get_author_infos');
function ud_get_author_infos($author_id){
    $ava_id     = get_user_meta($author_id, 'wp_user_avatar', true);
    $ava_data   = apply_filters('ud_get_file_data', $ava_id);
    $infos = [
        'firs_name'          => get_user_meta($author_id, 'first_name', true),
        'last_name'          => get_user_meta($author_id, 'last_name', true),
        'desc'               => get_user_meta($author_id, 'description', true),
        'ava_url'            => $ava_data['src'], //get_user_meta($author_id, 'sabox-profile-image', true)
        'role'               => get_user_meta($author_id, 'wp_capabilities', true)
    ];

    return $infos;
}

add_filter('ud_print_single_game', 'ud_print_single_game');
function ud_print_single_game(array $data){
    extract($data);

    $img_src        = $g_img_data['src'];
    $img_alt        = $g_img_data['alt'];
    $desc           = "";
    $ext_lnk        = "";
    $bn             = "";
    $unt_d          = "";
    $play_btn_txt   = !empty(get_option('games_play_now_title'))? get_option('games_play_now_title'): 'Play now';

    if(!empty($short_desc)){
        $trimmed_short_desc = wp_trim_words($short_desc, 15, '... <a class="game-card__subtitle_link" href="' . get_the_permalink() . '">les mer</a>');
        $desc = "<div class='game-card__subtitle'>
                    {$trimmed_short_desc}
                </div>";
    }

    if(!empty($external_link)){
        $ext_lnk = "<div class='game-card__cta'>
                        <a href='{$external_link}' class='game-card__button button' rel='nofollow'>$play_btn_txt</a>
                    </div>";
    }

    if(!empty($button_notice)){
        $bn = "<br>{$button_notice}";
    }

    if(!empty($unit_detailed)){
        $unt_d = "<div class='tc-desc'>
                        {$unit_detailed}
                    </div>";
    }

    $cart = "<li class='game-card'>
                <div class='game-card__image'>
                    <img src='{$img_src}' alt='{$img_alt}'>
                </div>
                <div class='game-card__title'>
                    <a href='{$permalink}'>
                        {$title}
                    </a>    
                </div>
                {$desc}
                {$ext_lnk}
                <div class='game-card__info'>
                    Regler og vilkår gjelder
                    {$bn}

                    {$unt_d}
                </div>
            </li>";

    return $cart;
}

add_filter('ud_get_games', 'ud_get_games');
function ud_get_games(array $atts){
    extract($atts);

    $g_args = array (
	    'items_number'      => isset($items_number)? $items_number :4,
	    'external_link'     => isset($external_link)? $external_link: '',
	    'category'          => isset($category)? $category: '',
	    'vendor'            => isset($vendor)? $vendor: '',
	    'items_id'          => isset($items_id)? $items_id: '',
	    'parent_id'         => isset($parent_id)? $parent_id: '',
	    'exclude_id'        => isset($exclude_id)? $exclude_id: '',
	    'columns'           => isset($columns)? $columns :4,
	    'order'             => isset($order)? $order: '',
	    'orderby'           => isset($orderby)? $orderby: '',
	    'title'             => isset($title)? $title: '',
        // 'exclude_id_array'  => isset($exclude_id_array)? $exclude_id_array: [],
	);

    if(isset($_GET['games-cat'])){
        $g_args['category'] = $_GET['games-cat'];
    }

    extract($g_args);

    if ( !empty( $category ) & !empty( $vendor ) ) {

		$categories_id_array = explode( ',', $category );
		$vendors_id_array = explode( ',', $vendor );

		$args = array(
			'posts_per_page' => $items_number,
			'post_type'      => 'game',
			'post_status'    => 'publish',
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'game-category',
					'field'    => 'id',
					'terms'    => $categories_id_array
				),
				array(
					'taxonomy' => 'vendor',
					'field'    => 'id',
					'terms'    => $vendors_id_array
				)
			),
			'orderby'  => $orderby,
			'order'    => $order
		);

	} else if ( !empty( $category ) ) {

		// $categories_id_array = explode( ',', $category );

		$args = array(
			'posts_per_page' => $items_number,
			'post_type'      => 'game',
			'post_status'    => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'game-category',
					'field'    => 'term_id',
					'terms'    => $category
				)
			),
			'orderby'  => $orderby,
			'order'    => $order
		);

	} else if ( !empty( $vendor ) ) {

		$vendors_id_array = explode( ',', $vendor );

		$args = array(
			'posts_per_page' => $items_number,
			'post_type'      => 'game',
			'post_status'    => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'vendor',
					'field'    => 'id',
					'terms'    => $vendors_id_array
				)
			),
			'orderby'  => $orderby,
			'order'    => $order
		);

	} else if ( !empty( $items_id ) ) {

		$items_id_array = explode( ',', $items_id );

		$args = array(
			'posts_per_page' => $items_number,
			'post_type'      => 'game',
			'post__in'       => $items_id_array,
			'orderby'        => 'post__in',
			'post_status'    => 'publish'
		);

	} else if ( !empty( $parent_id ) ) {

		$parent_id = '"'.$parent_id.'"';

		$args = array(
			'posts_per_page' => $items_number,
			'post_type'      => 'game',
			'post_status'    => 'publish',
			'meta_query' => array(
		        array(
		            'key' => 'parent_casino',
		            'value' => $parent_id,
		            'compare' => 'LIKE'
		        )
		    )
		);

	} else {
		$args = array(
			'posts_per_page' => $items_number,
			'post_type'      => 'game',
			'post_status'    => 'publish',
			'orderby'        => $orderby,
			'order'          => $order
		);

	}


    $args['post__not_in'] = [$exclude_id];

    $paged = isset($_GET['games-page'])? $_GET['games-page']: 1;

    $args['paged'] = $paged;

	$game_query = new WP_Query( $args );

    $max_pages = intval($game_query->max_num_pages);

    wp_reset_postdata();

    $out = [
        'res' => $game_query,
    ];

    if($max_pages > 1){
        $pagenavi_items = apply_filters('my_pagination', $paged, $max_pages, "games-page");
        $out['pagenavi'] = "<div class='content-cards__footer'>
                                {$pagenavi_items}
                            </div>";
    }

    return $out;
}

add_filter('ud_get_casinos', 'ud_get_casinos');
function ud_get_casinos(array $atts){
    extract($atts);

    $args = [
        'posts_per_page' => isset($items_number)? $items_number : get_option('posts_per_page'),
        'post_type'      => 'casino',
        'post__not_in'   => isset($exclude_id_array)? $exclude_id_array: [],
        'post_status'    => 'publish',
        'order'          => 'DESC',
    ];

    if (empty($order_by)) {
        $args['orderby'] = 'post__in';
    } else {
        if ($order_by === 'rating') {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'casino_overall_rating';
            $args['meta_query'] = [
                [
                    'key'    => 'casino_overall_rating',
                    'type'   => 'NUMERIC',
                    'compare' => 'EXISTS'
                ]
            ];
        }
    }


    if ( !empty( $category ) || isset($_GET['casinos-cat']) ) {
        if(!empty( $category )){
            $categories = explode( ',', $category );
        }

        if(isset($_GET['casinos-cat'])){
            $categories = [$_GET['casinos-cat']];
        }

        $args['tax_query'] = [
                                'relation' => 'AND',
                                [
                                    'taxonomy' => 'casino-category',
                                    'field'    => 'id',
                                    'terms'    => $categories
                                ]
                            ];
	}

    if(!empty($post__in)){
		$args['post__in']       = $post__in;
        $args['post__not_in']   = [];
        $args['tax_query']      = [];
    }

    $paged          = isset($_GET['casinois-page'])? absint($_GET['casinois-page']): 1;
    $args['paged']  = $paged;

	$cas_query = new WP_Query( $args );
    wp_reset_postdata();

    return $cas_query;
}

add_filter('ud_get_games_cats', 'ud_get_games_cats');
function ud_get_games_cats(){
    $args = array(
        'taxonomy'   => 'game-category',
    );

    $gcq = get_terms($args);

    $out = [
        '' => __('All'),
    ];

    foreach($gcq as $gc){
        $out[$gc->term_id] = $gc->name;
    };

    return $out;
}

add_filter('ud_get_casinos_cats', 'ud_get_casinos_cats');
function ud_get_casinos_cats(){
    $args = array(
        'taxonomy'   => 'casino-category',
    );

    $cq = get_terms($args);

    $out = [
        '' => __('All'),
    ];

    foreach($cq as $c){
        $out[$c->term_id] = $c->name;
    };

    return $out;
}

add_filter('ud_get_faqs', 'ud_get_faqs');
function ud_get_faqs(array $faq_args){
    extract($faq_args);
    $args = array(
        'posts_per_page' => isset($items_number)? $items_number: -1,
        'post_type'      => 'faq',
        'post__not_in'   => isset($exclude_id_array)? $exclude_id_array: [],
        'post_status'    => 'publish',
    );

    $q = new WP_Query($args);
    wp_reset_postdata();
    return $q;
}

add_filter('ud_has_object_with_property', 'ud_has_object_with_property', 10, 3);
function ud_has_object_with_property($array, $propertyName, $propertyValue) {
    foreach ($array as $object) {
        if (is_object($object) && isset($object->$propertyName) && $object->$propertyName === $propertyValue) {
            return true;
        }
    }
    return false;
}

add_filter('ud_get_taxs', 'ud_get_taxs', 10, 2);
function ud_get_taxs($type, $id){
    $out = [];
    if($type == 'casino'){
        $necessary_taxs = [
            'software'              => 'Software',
            'deposit-method'        => 'Deposit Methods',
            'withdrawal-method'     => 'Withdrawal Methods',
            'withdrawal-limit'      => 'Withdrawal Limits',
            'restricted-country'    => 'Restricted Countries',
            'licence'               => 'Licences',
            'casino-language'       => 'Languages',
            'currency'              => 'Currencies',
            'device'                => 'Devices',
            'owner'                 => 'Owner',
            'casino-est'            => 'Established',
        ];

        // get_option('casinos_software_title')
        foreach($necessary_taxs as $tax_slug => $tax_name){
            $tax = wp_get_post_terms($id, $tax_slug);

            if(!empty($tax)){
                foreach($tax as $k => $item){
                    $out[$tax_name][$item->term_id] = $item->name;
                }
            }
        }

    }

    return $out;
}

add_filter('ud_get_post_ratings', 'ud_get_post_ratings', 10, 2);
function ud_get_post_ratings($type, $id){
    $rating_1_name          = !empty(get_option('rating_1'))? get_option('rating_1'): "Trust & Fairness";
    $rating_2_name          = !empty(get_option('rating_2'))? get_option('rating_2'): "Games & Software";
    $rating_3_name          = !empty(get_option('rating_3'))? get_option('rating_3'): "Bonuses & Promotions";
    $rating_4_name          = !empty(get_option('rating_4'))? get_option('rating_4'): "Customer Support";
    $rating_overall_name    = !empty(get_option('rating_overall'))? get_option('rating_overall'): "Overall Rating";

    $out = [
        'overall'   => [
                            'val'  => floatval(get_post_meta($id, "{$type}_overall_rating", true)),
                            'name' => $rating_overall_name
                        ],

        'trust'     => [
                            'val'  => floatval(get_post_meta($id, "{$type}_rating_trust", true)),
                            'name' => $rating_1_name
                        ],
        'games'     => [
                            'val'  => floatval(get_post_meta($id, "{$type}_rating_games", true)),
                            'name' => $rating_2_name
                        ],
        'bonus'     => [
                            'val'  => floatval(get_post_meta($id, "{$type}_rating_bonus", true)),
                            'name' => $rating_3_name
                        ],
        'customer'     => [
                            'val'  => floatval(get_post_meta($id, "{$type}_rating_customer", true)),
                            'name' => $rating_4_name
                        ],
    ];

    return $out;
}

add_filter('ud_get_bonuses', 'ud_get_bonuses');
function ud_get_bonuses($atts){
    extract($atts);

    $paged = isset($_GET['bonuses-page']) ? absint( $_GET['bonuses-page'] ) : 1;
    // $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

    $args = array(
        'posts_per_page' => isset($items_number)? $items_number: -1,
        'post_type'      => 'bonus',
        'paged'          => $paged,
        'post__not_in'   => isset($exclude_id)? [$exclude_id]: [],
        'post_status'    => 'publish',
        'orderby'        => 'modified',
        'order'          => 'DESC',
    );

    if(!empty($parent_id)){
        $args['meta_query'] = array(
            array(
                'key'       => 'bonus_parent_casino',
                'value'     => $parent_id,
                'compare'   => 'LIKE'
            )
        );
    }

    if(isset($_GET['bonuses-cat']) || isset($category)){
        $cat = 0;

        if(isset($_GET['bonuses-cat'])){
            $cat = $_GET['bonuses-cat'];
        }elseif(isset($category)){
            $cat = $category;
        }
        $args['tax_query'] = array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => 'bonus-category',
                                'field'    => 'term_id',
                                'terms'    => $cat
                            ),
                        );
    }

    $q = new WP_Query($args);

    $max_pages = intval($q->max_num_pages);

    wp_reset_postdata();

    $out = [
        'res' => $q,
    ];

    if($max_pages > 1){
        $pagenavi_items = apply_filters('my_pagination', $paged, $max_pages, "bonuses-page");
        $out['pagenavi'] = "<div class='content-cards__footer'>
                                {$pagenavi_items}
                            </div>";
    }

    return $out;
}

/**
 * $data = [
 *  'title',
 *  'img_src',
 *  'img_alt',
 *  'rating',
 *  'desc',
 *  'permalink',
 *  'external_link',
 *  'item_class' (opt)
 * ]
 */
add_action('print_single_casino_template', 'print_single_casino_template');
function print_single_casino_template($data = []){
    extract($data);

    $desc_html          = "";
    $external_link_html = "";
    $lb_txt             = !empty(get_option('casinos_read_review_title'))? get_option('casinos_read_review_title'): 'Read review';
    $elb_txt            = !empty(get_option('casinos_play_now_title'))? get_option('casinos_play_now_title'): 'Play now';
    $add_class          = isset($item_class)? $item_class: '';
    $directory_uri      = get_stylesheet_directory_uri();

    if(isset($desc) && !empty($desc)){
        $desc_html = "<div class='casino-card__subtitle'>{$desc}</div>";
    }

    if(isset($external_link) && !empty($external_link)){
        $external_link_html = "<a href='{$external_link}' target='_blank' class='casino-card__button button' rel='nofollow'>{$elb_txt}</a>";
    }

    $tmpl = "<div class='casino-card {$add_class}'>
                <div class='casino-card__image'>
                    <img src='{$img_src}' alt='{$img_alt}'>
                </div>
                
                <div class='casino-card__title'>
                    <a href='{$permalink}'>{$title}</a>
                </div>

                <div class='casino-card__rating' data-rating='{$rating}'>
                    <div class='rating-mobile casino-card__rating-mobile' data-rating='{$rating}'>
                        <img src='{$directory_uri}/assets/images/icons/star.svg' alt='star'>
                    </div>
                    <div class='star-rating casino-card__rating-desktop' data-rating='{$rating}'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='312' height='24' viewBox='0 0 312 24'>
                            <mask id='starMask'>
                                <rect width='312' height='24' fill='#fff'/>
                                <g fill='#000'>
                                    <use href='#starPath' x='0' y='0'/>
                                    <use href='#starPath' x='32' y='0'/>
                                    <use href='#starPath' x='64' y='0'/>
                                    <use href='#starPath' x='96' y='0'/>
                                    <use href='#starPath' x='128' y='0'/>
                                    <use href='#starPath' x='160' y='0'/>
                                    <use href='#starPath' x='192' y='0'/>
                                    <use href='#starPath' x='224' y='0'/>
                                    <use href='#starPath' x='256' y='0'/>
                                    <use href='#starPath' x='288' y='0'/>
                                </g>
                            </mask>
                            <defs>
                                <path id='starPath' d='M23.9374 9.20628C23.7803 8.7203 23.3493 8.37514 22.8393 8.32918L15.9123 7.7002L13.1731 1.28896C12.9712 0.8191 12.5112 0.514954 12.0001 0.514954C11.4891 0.514954 11.0291 0.8191 10.8271 1.29006L8.08797 7.7002L1.15982 8.32918C0.65077 8.37624 0.220828 8.7203 0.0628038 9.20628C-0.0952203 9.69225 0.0507185 10.2253 0.435799 10.5613L5.67183 15.1533L4.12785 21.9546C4.01487 22.4547 4.20897 22.9716 4.62389 23.2715C4.84692 23.4327 5.10785 23.5147 5.37098 23.5147C5.59786 23.5147 5.8229 23.4535 6.02487 23.3327L12.0001 19.7615L17.9732 23.3327C18.4103 23.5956 18.9612 23.5716 19.3752 23.2715C19.7904 22.9707 19.9843 22.4536 19.8713 21.9546L18.3273 15.1533L23.5633 10.5622C23.9484 10.2253 24.0955 9.69317 23.9374 9.20628Z'/>
                            </defs>
                            <rect width='312' height='24' fill='var(--star-rating-background, #262c3a)' mask='url(#starMask)'/>
                        </svg>
                    </div>
                </div>
            
                {$desc_html}
                <div class='casino-card__cta'>
                    <a href='{$permalink}' class='casino-card__button button button_outline'>{$lb_txt}</a>
                    {$external_link_html}
                </div>
            </div>";

    echo $tmpl;
}

add_filter('print_single_bonus_card', 'print_single_bonus_card');
function print_single_bonus_card(array $data){
    extract($data);

    $bonus_code_html = "";
    $bonus_img_def   = "<img src=" . get_stylesheet_directory_uri().'/assets/images/gift.svg' . " alt='gift' class='bonus-card__img'>";
    $description     = "";
    $external        = "";
    $bn              = "";
    $detailed_tc     = "";$tax_info        = "";
    $btn_txt         = !empty(get_option('bonuses_get_bonus_title'))? get_option('bonuses_get_bonus_title'): "Get Bonus";

    if(!empty($bonus_code) && !empty($bonus_valid_date)):
        $ds = strtotime($bonus_valid_date);
        $df = date('M d, Y', $ds);

        $bonus_code_html = "<div class='bonus-card__gift-content'>
                                <span></span>
                                <span>{$bonus_code}</span>
                                <span>Gyldig til: {$df}</span>
                            </div>";

    endif;

    if(!empty($short_desc)):
        $description = "<div class='bonus-card__subtitle'>
                            {$short_desc}
                        </div>";
    endif;

    if(!empty($external_link)):
        $external ="<div class='bonus-card__cta'>
                        <a href='$external_link' target='__blank' class='bonus-card__button button' rel='nofollow'>{$btn_txt}</a>
                    </div>";
    endif;

    if(!empty($button_notice)):
        $bn = "<br>{$button_notice}";
    endif;

    if(!empty($offer_detailed_tc)):
        $detailed_tc = "<div class='tc-desc'>
                            {$offer_detailed_tc}
                        </div>";
    endif;

    if(!empty($tax) && !empty($tax_link)):
        $tax_info = "<div class='bonus-card__tags'>
                        <a class='bonus-card__tag' href='{$tax_link}'>{$tax}</a>
                    </div>";
    endif;

    $cart = "<div class='bonus-card'>
                {$tax_info}
                <header class='bonus-card__header'>
                    $title
                </header>
                <div class='bonus-card__gift'>
                    $bonus_img_def
                    $bonus_code_html
                </div>
                
                $description

                $external

                <div class='bonus-card__info'>
                    Regler og vilkår gjelder
                    $bn

                    $detailed_tc
                </div>
            </div>";

    return $cart;
}

add_filter( 'my_pagination', 'my_pagination', 10, 3);
function my_pagination(int $current_page, int $max_page,string $url_param){
    $page_url = get_the_permalink();
    $html = "<div class='pagination content__pagination' data-max_pages='{$max_page}'>";
            $p = paginate_links([
                    "base"               => wp_normalize_path("?{$url_param}=%#%" ),
                    "format"             => "?{$url_param}=%#%",
                    "total"              => $max_page,
                    "current"            => $current_page,
                    "aria_current"       => "page",
                    "show_all"           => false,
                    "prev_next"          => true,
                    "prev_text"          => "<",
                    "next_text"          => ">",
                    "end_size"           => 2,
                    "mid_size"           => 2,
                    "type"               => "array",
                ]);

                foreach($p as $l){
                    $current_class = "";
                    if($l == '<span aria-current="page" class="pagination__item">' . $current_page . '</span>'){
                        $current_class = "pagination__item active";
                    }
                    $html .= "<li class='{$current_class}'>{$l}</li>";
                }

            $html .= "</div>";

        return $html;
}

add_action("ud_get_posts_loop", "ud_get_posts_loop");
function ud_get_posts_loop($atts){
    extract($atts);

    $wrap_class = isset($wrap_class)? $wrap_class: 'card-list card-list_col-2';
    $ID = get_the_ID();

    if(get_post_type() == 'post'){
        $exclude_id = $ID;
    }
    // $paged = $wp_query->get( 'paged' );
    $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
    $query = new WP_Query(array(
        'posts_per_page'    =>  get_option('posts_per_page'),
        'post_type'         => 'post',
        'paged'             => $paged,
        'post_status'       => 'publish',
        'post__not_in'      => isset($exclude_id)? [$exclude_id]: [],
    ));


    if(!$query->have_posts()){
        return;
    }

    $max_pages = intval($query->max_num_pages);

    $items = "";

    while($query->have_posts()){
        $query->the_post();
        $id = get_the_id();
        $thmb_id = get_post_thumbnail_id();

        $thmb_data  = $thmb_id > 0? apply_filters('ud_get_file_data', $thmb_id) : false;
        $thmb_src   = !$thmb_data? 'https://via.placeholder.com/315x220': $thmb_data['src'];
        $thmb_alt   = !$thmb_data? 'image': $thmb_data['alt'];
        $title      = get_the_title();
        $excerpt    = "";
        $post_date  = get_the_date();
        $permalink  = get_the_permalink();
        if(!empty(get_the_excerpt($id))){
            $excerpt    = "<div class='news-card__text'>
                                " . get_the_excerpt($id) . "
                            </div>";
                            }

        $items .= "<div class='news-card'>
                    <a href='{$permalink}'>        
                        <div class='news-card__image'>
                            <img src='{$thmb_src}' alt='{$thmb_alt}'>
                        </div>
                    </a>
                    <div class='news-card__content'>
                        <a href='{$permalink}'>
                            <div class='news-card__title'>{$title}</div>
                        </a>

                        <time class='news-card__date' datetime='2023-04-17'>{$post_date}</time>
                        {$excerpt}
                    </div>
                </div>";
    }

    $pagenavi           = "";
    $pagenavi_items     = "";
    $pagenavi_button    = "";

    if($max_pages > 1){
        if($paged < $max_pages){
            $pagenavi_button = "<button class='button button_outline content__more-button' data-current='{$paged}'>See more</button>";
        }

        $pagenavi_items = apply_filters('my_pagination', $paged, $max_pages);

        $pagenavi = "<div class='content__nav'>
                        {$pagenavi_items}
                    </div>";
    }

    $html = "<div class = '{$wrap_class}'>{$items}{$pagenavi}</div>";
    wp_reset_postdata();

    echo $html;
}

function get_games_options_arr(){
    $games = apply_filters('ud_get_games', ['items_number' => -1]);

    $out = [
        '' => __('Select games'),
    ];

    if($games['res']->have_posts()){
        foreach($games['res']->posts as $game){
            $out[$game->ID] = $game->post_title;
        }
    }
    return $out;
}

add_shortcode( 'print_quote', 'ud_print_quote' );
function ud_print_quote($atts){
    if(empty($atts) || is_admin()){
        return;
    }
    extract($atts);
    $content    = isset($text)? $text: '';
    $author     = isset($author_name)? $author_name: '';

    $html = "<blockquote class='quote'>
                <p class='quote__text'>
                    $content
                </p>
                <cite class='quote__author'>$author</cite>
            </blockquote>";

    return $html;
}

add_shortcode( 'author_annatation', 'ud_author_annatation' );
function ud_author_annatation($atts){
    if(empty($atts) || is_admin()){
        return;
    }
    extract($atts);
    $text           = isset($text)? $text: '';
    $author         = isset($author_id)? $author_id: get_queried_object()->post_author;
    $author_role    = isset($author_role)? $author_role: '';
    $rating         = isset($rating)? "<div class='quote-author__rating'>{$rating}</div>": "";
    $author_info    = apply_filters('ud_get_author_infos', $author);
    $ava            = $author_info['ava_url'];
    $full_name      = $author_info['firs_name'] . " " . $author_info['last_name'];
    $roles          = array_keys($author_info['role']);
    $roles_str      = implode(',', $roles);
    $role_result    = $author_role == '' ? $roles_str : $author_role;

    $html = "<blockquote class='quote-author'>
                <header class='quote-author__header'>
                    <cite class='quote-author__author'>
                        <img src='{$ava}' alt='author'>
                        <span class='quote-author__name'>
                            {$full_name}
                            <span class='quote-author__role'>{$role_result}</span>
                        </span>
                    </cite>
                    {$rating}
                </header>
                <p class='quote-author__text'>
                    {$text}
                </p>
            </blockquote>";

    return $html;
}

add_shortcode( 'print_casino_card', 'ud_print_casino' );
function ud_print_casino($atts){
    if(empty($atts) || !isset($atts['post']) || is_admin()){
        return;
    };

    extract($atts);

    $style                  = isset($atts['style'])? intval($atts['style']): 1;
    $lb_txt                 = !empty(get_option('casinos_read_review_title'))? get_option('casinos_read_review_title'): 'Read review';
    $elb_txt                = !empty(get_option('casinos_play_now_title'))? get_option('casinos_play_now_title'): 'Play now';

    $post_id                = intval($atts['post']);
    $post_title             = get_the_title($post_id);
    $post_th_id             = get_post_thumbnail_id($post_id);
    $post_th_data           = apply_filters('ud_get_file_data', $post_th_id);
    $post_th_src            = $post_th_data['src'];
    $post_th_alt            = $post_th_data['alt'];
    $post_desc              = get_post_meta($post_id, 'casino_short_desc', true);
    $post_overall_rating    = floatval(get_post_meta($post_id, 'casino_overall_rating', true));
    $post_external_link     = get_post_meta($post_id, 'casino_external_link', true);
    $post_link              = get_the_permalink($post_id);
    $post_button_notice     = get_post_meta($post_id, 'casino_button_notice', true);
    $casino_terms_desc      = get_post_meta($post_id, 'casino_terms_desc', true);
    $casino_detailed_tc     = get_post_meta($post_id, 'casino_detailed_tc', true);
    $star_icon              = get_stylesheet_directory_uri().'/assets/images/icons/star.svg';

    $post_rating     = "";
    $button_notice   = "";
    $terms_desc      = "";
    $detailed_tc     = "";
    $external        = "";

    $html = "";

    if($style == 1){
        if(!empty($post_button_notice)){
            $button_notice  = "<div class='casino-inline__casino-info'>
                                    {$post_button_notice}
                                </div>";
        }

        if(!empty($post_overall_rating)){
            $post_rating = "<div class='casino-inline__casino-rating'>
                                <div class='star-rating' data-rating='{$post_overall_rating}'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='312' height='24' viewBox='0 0 312 24'>
                                        <mask id='starMask'>
                                            <rect width='312' height='24' fill='#fff'/>
                                            <g fill='#000'>
                                                <use href='#starPath' x='0' y='0'/>
                                                <use href='#starPath' x='32' y='0'/>
                                                <use href='#starPath' x='64' y='0'/>
                                                <use href='#starPath' x='96' y='0'/>
                                                <use href='#starPath' x='128' y='0'/>
                                                <use href='#starPath' x='160' y='0'/>
                                                <use href='#starPath' x='192' y='0'/>
                                                <use href='#starPath' x='224' y='0'/>
                                                <use href='#starPath' x='256' y='0'/>
                                                <use href='#starPath' x='288' y='0'/>
                                            </g>
                                        </mask>
                                        <defs>
                                            <path id='starPath' d='M23.9374 9.20628C23.7803 8.7203 23.3493 8.37514 22.8393 8.32918L15.9123 7.7002L13.1731 1.28896C12.9712 0.8191 12.5112 0.514954 12.0001 0.514954C11.4891 0.514954 11.0291 0.8191 10.8271 1.29006L8.08797 7.7002L1.15982 8.32918C0.65077 8.37624 0.220828 8.7203 0.0628038 9.20628C-0.0952203 9.69225 0.0507185 10.2253 0.435799 10.5613L5.67183 15.1533L4.12785 21.9546C4.01487 22.4547 4.20897 22.9716 4.62389 23.2715C4.84692 23.4327 5.10785 23.5147 5.37098 23.5147C5.59786 23.5147 5.8229 23.4535 6.02487 23.3327L12.0001 19.7615L17.9732 23.3327C18.4103 23.5956 18.9612 23.5716 19.3752 23.2715C19.7904 22.9707 19.9843 22.4536 19.8713 21.9546L18.3273 15.1533L23.5633 10.5622C23.9484 10.2253 24.0955 9.69317 23.9374 9.20628Z'/>
                                        </defs>
                                        <rect width='312' height='24' fill='var(--star-rating-background, #262c3a)' mask='url(#starMask)'/>
                                    </svg>
                                </div>
                                <div class='rating-mobile' data-rating='{$post_overall_rating}'>
                                    <img src='{$star_icon}' alt='star'>
                                </div>
                            </div>";
        };

        if(!empty($casino_terms_desc)){
            $terms_desc   = "<div class='casino-inline__info'>
                                    {$casino_terms_desc}
                                </div>";
        };

        if(!empty($casino_detailed_tc)){
            $icon = get_stylesheet_directory_uri()."/assets/images/icons/attention.svg";
            $detailed_tc = "<div class='casino-inline__tip'>
                                    <div class='casino-inline__tip-icon'>
                                        <img src='{$icon}' alt='info'>
                                    </div>
                                    <div class='casino-inline__tip-text'>
                                        {$casino_detailed_tc}
                                    </div>
                                </div>";
        };

        if(!empty($post_external_link)){
            $external = "<a rel='nofollow' href='{$post_external_link}' class='button button_outline casino-inline__button'>{$elb_txt}</a>";
        }

        $html = "<div class='casino-inline'>
                    <div class='casino-inline__content'>
                        <div class='casino-inline__casino'>
                            <div class='casino-inline__casino-img'>
                                <img src='{$post_th_src}' alt='{$post_th_alt}'>
                            </div>
                            <div class='casino-inline__casino-content'>
                                <div class='casino-inline__casino-title'>
                                    {$post_title}
                                </div>
                                {$post_rating}
                                {$button_notice}
                            </div>
                        </div>
                        {$terms_desc}
                        <div class='casino-inline__cta'>
                            <a href='{$post_link}' class='button casino-inline__button'>{$lb_txt}</a>
                            {$external}
                        </div>
                    </div>
                    {$detailed_tc}
                </div>";
    }elseif($style == 2){
        $star_icon = get_stylesheet_directory_uri()."/assets/images/icons/star.svg";

        if(!empty($post_overall_rating)){
            $post_rating = "<div class='casino-inline-2__rating'>
                                <div class='rating-mobile' data-rating='{$post_overall_rating}'>
                                    <img src='{$star_icon}' alt='star'>
                                </div>
                            </div>";
        };

        // Central-top text content. May be $post_desc or $casino_terms_desc
        if(!empty($post_desc)){
            $terms_desc   = "<div class='casino-inline-2__bonus'>
                                {$post_desc}
                            </div>";
        };

        if(!empty($casino_detailed_tc)){
            $detailed_tc = "<div class='casino-inline-2__description'>
                                {$casino_detailed_tc}
                            </div>";
        };

        if(!empty($post_external_link)){
            $external = "<a rel='nofollow' href='{$post_external_link}' class='button casino-inline-2__button'>{$elb_txt}</a>";
        };

        if(!empty($post_button_notice)){
            $button_notice  = "<span>{$post_button_notice}</span>";
        }

        $html = "<div class='casino-inline-2'>
                    <div class='casino-inline-2__heading'>
                        <div class='casino-inline-2__img'>
                            <img src='{$post_th_src}' alt='{$post_th_alt}'>
                        </div>
                        <div class='casino-inline-2__header'>
                            <div class='casino-inline-2__title'>{$post_title}</div>
                        </div>
                    </div>
                    <div class='casino-inline-2__content'>
                        {$terms_desc}

                        {$detailed_tc}
                    </div>
                    <div class='casino-inline-2__attributes'>
                        {$post_rating}
                        <a href='{$post_link}' class='casino-inline-2__review'>{$lb_txt}</a>
                    </div>
                    <div class='casino-inline-2__cta'>
                        {$external}
                        {$button_notice}
                    </div>
                </div>";
    };

    return $html;
}

add_shortcode('year', "ud_set_present_year");
function ud_set_present_year() {
    if(is_admin()){
        return;
    }
    return date("Y");
}

add_filter('ud_get_tax_posts_tags', 'ud_get_tax_posts_tags');
function ud_get_tax_posts_tags($posts){
    $arr = [];

    foreach($posts->posts as $post){
        $p_id = $post->ID;
        $tags = get_the_tags($p_id);

        if(empty($tags)){
            return $arr;
        }
        foreach($tags as $tag){
            if(!in_array($tag->name, $arr)){
                array_push($arr, $tag->name);
            }
        }
    }

    return $arr;
}

function ud_get_casinos_options(){
    $casinois_q = apply_filters('ud_get_casinos', ['items_number' => -1]);

    if(empty($casinois_q->posts)){
        return;
    }

    $out = [
        ''=>'Select items',
    ];
    foreach($casinois_q->posts as $casino){
        $rat = apply_filters('ud_get_post_ratings', 'casino', $casino->ID)['overall']['val'];
        $out[$casino->ID] = $casino->post_title ." ( {$rat} )" ;
    }
    return $out;
}

add_filter('ud_get_pages_opt', 'ud_get_pages_opt');
function ud_get_pages_opt(){
    $args = [
        'post_type'         => 'page',
        'post_status'       => 'publish',
        'posts_per_page'    => -1
    ];

    $query = new WP_Query($args);
    wp_reset_postdata();

    $options_arr = [
        '' => __('Select page'),
    ];

    if($query->have_posts()){
        while($query->have_posts()){
            $query->the_post();

            $options_arr[get_the_ID()] = get_the_title();
        }
    }

    return $options_arr;
}

add_filter('ud_get_authors', 'ud_get_authors');
function ud_get_authors() {
    $user_query = new WP_User_Query(array(
        'capability'    => 'edit_posts',
        'fields'        => array('ID', 'display_name')
    ));

    $authors = $user_query->get_results();
    $author_array = [];

    foreach ($authors as $user) {
        $author_array[$user->ID] = $user->display_name;
    }

    $author_array = ['' => 'Select Author'] + $author_array;

    return $author_array;
}

add_filter('ud_has_children', 'ud_has_children', 10, 2);
function ud_has_children($postid, $posttype = "post"){
    $args = array(
        'post_parent' => $postid,
        'post_type'   => $posttype,
        'numberposts' => -1,
    );

    $children = get_children( $args );

    if ( !empty( $children ) ) {
        return true;
    } else {
        return false;
    }
}

add_filter('is_paginavi', 'ud_is_paginavi');
function ud_is_paginavi(){
    $get_params           	= $_GET;

    $pagi_lnks              = [
        'posts-page',
        'bonuses-page',
        'casinois-page',
        'games-page'
    ];

    $is_paginavi = false;

    foreach($get_params as $p => $v){
        if(in_array($p, $pagi_lnks)  && intval($v) > 1){
            $is_paginavi = true;
        }
    }

    return $is_paginavi;
}

add_filter( 'wp_robots', 'modify_robots_meta_tag' );
function modify_robots_meta_tag( $robots ) {
    $is_paginavi = apply_filters('is_paginavi', true);

    if( $is_paginavi ) {
        // Модифікуємо директиви robots
        $robots['noindex'] = true;
        $robots['follow'] = true;
    }

    return $robots;
}

// CUSTOM FIELDS
add_action( 'carbon_fields_register_fields', 'ud_custon_fields' );

use Carbon_Fields\Container;
use Carbon_Fields\Field;

$custom_field_dates_taxonomy = [
    'category' => 'category',
    'casino-category' => 'casino-category',
    'game-category' => 'game-category',
    'vendor' => 'vendor',
    'bonus-category' => 'bonus-category'
];

function ud_custon_fields() {
    global $custom_field_dates_taxonomy;


    $labels = [
        'sections' => [
            'singular_name' => __('Section'),
            'plural_name'   => __('Sections'),
        ],
        'guide' => [
            'singular_name' => __('Guide'),
            'plural_name'   => __('Guides'),
        ],
        'advantages' => [
            'singular_name' => __('Advantage'),
            'plural_name'   => __('Advantages'),
        ],
        'flaws' => [
            'singular_name' => __('Flaw'),
            'plural_name'   => __('Flaws'),
        ],
        'faq' => [
            'singular_name' => __('FAQ'),
            'plural_name'   => __('FAQ`s'),
        ],
        'game_types' => [
            'singular_name' => __('Game Type'),
            'plural_name'   => __('Game Types'),
        ],
        'characteristics' => [
            'singular_name' => __('Attribute'),
            'plural_name'   => __('Attributes'),
        ],
    ];

    $shortcodes_codex = "You can use: [print_quote text='*Text' author_name='*Author Name'] and [author_annatation text='*Text' rating='* 0-9' author_id='int (optional)' author_role='*Role (optional)']";

    Container::make('post_meta', 'Table of characteristics')
        ->where('post_type', '=', 'game')
        ->add_fields(array(
            Field::make('text', 'characteristics_title', 'Characteristics title')
                ->set_default_value('Egenskaper for <em>spilleautomater</em>')
                ->set_width(100),
            Field::make('complex', 'characteristics_attributes', 'Characteristics')
                ->set_collapsed(true)
                ->setup_labels($labels['characteristics'])
                ->add_fields(array(
                    Field::make('text', 'attribute', __('Attribute'))->set_width(50),
                    Field::make('text', 'attribute_value', __('Attribute value'))->set_width(50)
                ))
                ->set_header_template( '
                <% if (attribute) { %>
                    <%- attribute %>
                <% } %>    
                ')
        ));
    Container::make('post_meta', 'Slot Demo Mode')
        ->where('post_type', '=', 'game')
        ->add_fields(array(
            Field::make('text', 'slot_demo_mode_url', 'Slot Demo Mode URL')
                ->set_width(100),
            Field::make('textarea', 'slot_demo_subtitle', 'Subtitle')
                ->set_width(100)
                ->set_default_value('Spillet gratis i demoversjon eller spill for ekte penger hos et av våre anbefalte casinoer!')
        ));

    Container::make( 'post_meta', 'App banner')
        // ->where('post_type', '=', 'post')
        // ->or_where('post_type', '=', 'page')
        // ->or_where('post_type', '=', 'bonus')
        ->add_fields(array(
            Field::make('checkbox', 'app_banner_is_author', __('Auhtor banner'))
                ->set_default_value(true)
                ->set_width(15),
            Field::make('text', 'app_banner_txt', __('Title'))
                ->help_text("<span style='color: blue;'>".__('Leave blank to use post title')."</span>")
                ->set_width(70),
            Field::make('image', 'app_banner_img', __('Image'))
                ->set_width(15),
        ));

    Container::make( 'post_meta', 'Content manage' )
        ->add_fields( array(
            Field::make('complex', 'ud_post_content', __('Content'))
                ->setup_labels($labels['sections'])
                ->set_collapsed(true)
                ->add_fields('text-editor', __('Text editor'), array(
                    Field::make( 'separator', 'crb_separator', $shortcodes_codex ),
                    Field::make('rich_text', 'text_editor', __('Classic editor'))
                ))
                ->add_fields('card-top', __('Card'), array(
                    Field::make('checkbox', 'card_top_power', __('Display section'))
                        ->set_default_value('yes')
                ))
                ->add_fields('guide', array(
                    Field::make('image', 'guide_bg_img', __('Background'))
                        ->set_value_type( 'url' ),
                    Field::make('textarea', 'guide_title', __('Title'))
                        ->help_text("<span style='color: blue;'>".__('Leave blank to use post title')."</span>"),
                    Field::make('textarea', 'guide_desc', __('Description')),
                    Field::make('complex', 'guide_steps', __('Steps'))
                        ->set_collapsed(true)
                        ->setup_labels($labels['guide'])
                        ->add_fields(array(
                            Field::make('text', 'g_s_title', __('Step title'))
                                ->set_width(75),
                            Field::make('image', 'g_s_thmb', __('Step image'))
                                ->set_width(25),
                            Field::make('textarea', 'g_s_txt', __('Text'))
                        ))
                        ->set_header_template( '
                        <% if (g_s_title) { %>
                            <%- g_s_title %>
                        <% } %>    
                        '),
                ))
                ->add_fields('form-reply', array(
                    Field::make('text', 'fr_title', __('Title'))
                        ->set_default_value('Leave a <em>reply</em>')
                        ->set_width(75),
                    Field::make('image', 'fr_bg', __('Background'))
                        ->set_value_type('url')
                        ->set_width(25),
                    Field::make('textarea', 'fr_subtitle', __('Subtitle'))
                        ->set_default_value('Your email address will not be published. Required fields are marked')
                ))
                ->add_fields('game-card', __('Games'), array(
                    Field::make('text', 'gc_title', __('Title'))
                        ->help_text("<span style='color: blue;'>".__('Leave blank to use default text (post title + "GAMES")')."</span>")
                        ->set_width(75),
                    Field::make('image', 'gc_bg', __('Background'))
                        ->set_value_type('url')
                        ->set_width(25),
                    Field::make('textarea', 'gc_subtitle', __('Subtitle')),
                    Field::make('select', 'gc_category', __('Select category'))
                        ->add_options(ud_get_games_cats())
                        ->set_width(33),
                    Field::make('text', 'gs_count', __('Number of games to show'))
                        ->set_default_value(4)
                        ->set_attribute('type', 'number')
                        ->set_width(33),
                    Field::make('checkbox', 'gs_is_filter', __('Filter'))
                        ->set_width(33),
                ))
                ->add_fields('game-types', array(
                    Field::make('text', 'game_types_title', __('Title')),
                    Field::make('textarea', 'game_types_subtitle', __('Subtitle')),
                    Field::make('complex', 'game_types_repeater', __('Items'))
                        ->set_collapsed(true)
                        ->setup_labels($labels['game_types'])
                        ->add_fields(array(
                            Field::make('image', 'gt_icon', __('Icon'))
                                ->set_width(25),
                            Field::make('text', 'gt_title', __('Title'))
                                ->set_width(75),
                            Field::make('textarea', 'gt_desc', __('Description'))
                        ))
                        ->set_header_template( '
                        <% if (gt_title) { %>
                            <%- gt_title %>
                        <% } %>    
                        ')
                ))
                ->add_fields('games-slider', array(
                    Field::make('text', 'gs_title', __('Title')),
                    Field::make('textarea', 'gs_subtitle', __('Subtitle')),
                    Field::make('multiselect', 'gs_games', __('Games'))
                        ->add_options(get_games_options_arr())
                ))
                ->add_fields('casino-card', __('Casinos'), array(
                    Field::make('text', 'cas_title', __('Title'))
                        ->set_default_value('Top rated <em>casinos</em>')
                        ->set_width(50),
                    Field::make('textarea', 'cas_subtitle', __('Subtitle')),
                    Field::make('multiselect', 'cas_casionois', __('Select Casinos to show'))
                        ->add_options(ud_get_casinos_options())
                        ->set_width(65),
                    Field::make('select', 'cas_order_by', __('Order by'))
                        ->set_width(20)
                        ->add_options(array(
                            '' => __('Default'),
                            'rating' => __('Rating'),
                        )),
                    Field::make('text', 'cas_count', __('Number of casinos to show'))
                        ->set_default_value(4)
                        ->set_attribute('type', 'number')
                        ->set_width(15),
                    Field::make('checkbox', 'cas_show_pagination', __('Show pagination'))
                        ->set_default_value('yes')
                        ->set_width(50),
                    Field::make('checkbox', 'casino_card_v2', __('Card version 2'))
                        ->set_default_value('no')
                        ->set_width(50),
                    // Field::make('image', 'cas_bg', __('Background'))
                    //     ->set_value_type('url')
                    //     ->set_width(25),
                ))
                ->add_fields('faq', 'FAQ`s', array(
                    // Field::make('checkbox', 'faq_power', __('Include FAQ'))
                    //     ->set_default_value('yes')
                    //     ->set_width(50),
                    Field::make('image', 'faq_bg', __('Background'))
                        ->set_value_type('url')
                        ->set_width(50),
                    Field::make('textarea', 'faq_title', __("Title"))
                        ->set_width(50)
                        ->set_default_value("Shave a <em>questions?</em>"),
                    Field::make('textarea', 'faq_subtitle', __("Subtitle")),
                    Field::make('complex', 'faq_items', __('Items'))
                        ->set_collapsed(true)
                        ->setup_labels($labels['faq'])
                        ->add_fields(array(
                            Field::make('text', 'question', __('Question')),
                            Field::make('textarea', 'answer', __('Answer'))
                        ))
                        ->set_header_template( '
                        <% if (question) { %>
                            <%- question %>
                        <% } %>    
                        ')
                ))
                ->add_fields('author', array(
                    Field::make('checkbox', 'au_power', __('Include author info'))
                        ->set_default_value('yes')
                        ->set_width(50),
                    Field::make('image', 'ua_bg', __('Background'))
                        ->set_value_type('url')
                        ->set_width(50),
                    // Field::make('image', 'au_main_img', __('Main image'))
                    //     ->set_value_type('url')
                    //     ->help_text("<span style='color: blue;'>".__('Leave blank to use default image:')."<img width='50' src='".get_stylesheet_directory_uri()."/assets/images/author/picture.svg'></span>")
                    //     ->set_width(33),
                ))
                ->add_fields('benefits',array(
                    Field::make('text', 'benefits_title', __('Title'))
                        ->set_width(75),
                    Field::make('image', 'benefits_bg', __('Background'))
                        ->set_width(25)
                        ->set_value_type( 'url' ),
                    Field::make('textarea', 'benefits_subtitle', __('Subtitle')),
                    Field::make('text', 'advantages_title', __('Advantages list title'))
                        ->set_width(50)
                        ->set_default_value('Pros casino'),
                    Field::make('text', 'flaws_title', __('Flaws list title'))
                        ->set_width(50)
                        ->set_default_value('Cons casino'),
                    Field::make('complex', 'benefits_advantages', __('Advantages'))
                        ->setup_labels($labels['advantages'])
                        ->set_collapsed(true)
                        ->set_width(50)
                        ->add_fields(array(
                            Field::make('text', 'b_adv', __('Advantage'))
                        ))
                        ->set_header_template( '
                        <% if (b_adv) { %>
                            <%- b_adv %>
                        <% } %>    
                        '),
                    Field::make('complex', 'benefits_flaws', __('Flaws'))
                        ->setup_labels($labels['flaws'])
                        ->set_collapsed(true)
                        ->set_width(50)
                        ->add_fields(array(
                            Field::make('text', 'b_flaw', __('Flaw'))
                        ))
                        ->set_header_template( '
                        <% if (b_flaw) { %>
                            <%- b_flaw %>
                        <% } %>    
                        ')
                ))
                ->add_fields('bandit', __('Simple image->text section'), array(
                    Field::make('image', 'bandit_main_img', __('Image'))
                        ->help_text("<span style='color: blue;'>".__('Leave blank to use default image:')."<img width='50' src='".get_stylesheet_directory_uri()."/assets/images/section/bandit.svg'></span>")
                        ->set_width(25),
                    Field::make('image', 'bandit_main_img_bg', __('Background for image'))
                        ->set_value_type('url')
                        ->set_width(25),
                    Field::make('select', 'bandit_style_type', __('Style'))
                        ->set_width(25)
                        ->add_options(array(
                            'image_right'   => __('Picture on the right'),
                            'image_left'    => __('Picture on the left')
                        )),
                    Field::make('checkbox', 'bandit_fill_area', __('Fill area'))
                        ->set_width(25),
                    Field::make('text', 'bandit_title', __('Title'))
                        ->set_width(75),
                    Field::make('textarea', 'bandit_subtitle', __('Subtitle'))
                ))
                ->add_fields('tags', array(
                    Field::make('checkbox', 'tags_power', __('Display tags'))
                    ->set_default_value('yes')
                    ->set_width(20),
                    Field::make('text', 'tags_title', __('Title'))
                        ->help_text("<span style='color: blue;'>".__('Leave blank to use default text (post title + "DETAILS")')."</span>")
                        ->set_width(40),
                    Field::make('textarea', 'tags_subtitle', __('Subtitle'))
                        ->set_width(40)
                        ->help_text("<span style='color: blue;'>".__('Leave blank to use excerpt text')."</span>")
                ))
                ->add_fields('rating-card', __('Rating'), array(
                    Field::make('checkbox', 'rating_power', __('Display rating'))
                        ->set_default_value('yes')
                        ->set_width(50),
                    Field::make('checkbox', 'rating_games', __('Show game ratings'))
                        ->set_width(50),
                    Field::make('textarea', 'rating_games_title', __('Title section'))
                        ->set_rows(2)
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'rating_games',
                                'value' => true,
                                'compare' => '=',
                            )
                        ) ),
                    Field::make('textarea', 'rating_games_subtitle', __('Subtitle'))
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'rating_games',
                                'value' => true,
                                'compare' => '=',
                            )
                        ) ),
                    Field::make('multiselect', 'rating_posts_list', __('Games'))
                        ->add_options(get_games_options_arr())
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'rating_games',
                                'value' => true,
                                'compare' => '=',
                            )
                        ) )
                ))
                ->add_fields('bonus-card', __('Bonuses'), array(
                    Field::make('checkbox', 'bonuses_power', __('Display bonuses'))
                        ->set_default_value('yes')
                        ->set_width(25),
                    Field::make('checkbox', 'bonuses_filter_on', __('Filter'))
                        ->set_default_value('yes')
                        ->set_width(25),
                    Field::make('select', 'bonuses_parent', __('Include'))
                        ->add_options(array(
                            'all'       => 'All',
                            'children'  => 'Children',
                            'curent'    => 'Current category'
                        ))
                        ->set_width(25),
                    Field::make('text', 'bonuses_count', __('Number of bonuses to show'))
                        ->set_default_value(3)
                        ->set_attribute('type', 'number')
                        ->set_width(25),
                    Field::make('text', 'bonuses_title', __('Title'))
                        ->set_width(50)
                        ->help_text("<span style='color: blue;'>".__('Leave blank to use default text (post title + "BONUSES")')."</span>"),
                    Field::make('textarea', 'bonuses_subtitle', __('Subtitle'))
                        ->set_width(50)
                        ->help_text("<span style='color: blue;'>".__('Leave blank to use excerpt text')."</span>"),
                ))
                ->add_fields('advantages', array(
                    Field::make('text', 'adv_title', __('Title')),
                    Field::make('textarea', 'adv_subtitle', __('Subtitle')),
                    Field::make('complex', 'adv_list', __('Advantage list'))
                        ->set_collapsed(true)
                        ->setup_labels($labels['advantages'])
                        ->add_fields(array(
                            Field::make('textarea', 'adv_item_txt', __('Description'))
                                ->set_width(75),
                            Field::make('image', 'adv_item_img', __('Thumbnail'))
                                ->set_width(25)
                        ))
                ))
        ));

    Container::make( 'post_meta', 'Intro text' )
        ->set_context('side')
        ->add_fields(array(
            Field::make('textarea', 'intro_text', 'Intro')
        ));

    Container::make( 'post_meta', 'Promotional Description V2' )
        ->where('post_type', '=', 'casino')
        ->add_fields(array(
            Field::make('text', 'promo_text_title', __('Title'))
                ->set_width(25),
            Field::make('text', 'promo_text_price', __('Price'))
                ->set_width(25),
            Field::make('text', 'promo_text_price_2', __('Price (second line)'))
                ->help_text('(Optional)')
                ->set_width(25),
            Field::make('text', 'promo_text_subtitle', __('Subtitle'))
                ->set_width(25),
        ));

    Container::make( 'post_meta', __('Additional settings'))
        ->where('post_type', '=', 'bonus')
        ->or_where('post_type', '=', 'game')
        ->set_context('side')
        ->add_fields(array(
            Field::make('text', 'casinois_sidebar_title', __('Casinos sidebar title'))
        ));

    Container::make( 'term_meta', 'Sidebar' )
        ->where( 'term_taxonomy', '=', 'category' )
        ->add_fields(array(
            Field::make('separator', 'catsidebar', __('Sidebar')),
            Field::make('checkbox', 'embed_sitebar', __('Add Sitebar'))
                ->set_width(20),
            Field::make('text', 'sitebar_title', __('Title'))
                ->set_width(80)
                ->set_conditional_logic( array(
                    array(
                        'field'     => 'embed_sitebar',
                        'value'     => true,
                        'compare'   => '=',
                    )
                ) ),
            Field::make('multiselect', 'sidebar_casionois', __('Select Casinos to show'))
                ->add_options(ud_get_casinos_options())
                ->set_conditional_logic( array(
                    array(
                        'field'     => 'embed_sitebar',
                        'value'     => true,
                        'compare'   => '=',
                    )
                ) )
        ));

    Container::make( 'term_meta', 'App banner')
        ->where( 'term_taxonomy', '=', 'category' )
        ->or_where( 'term_taxonomy', '=', 'game-category' )
        ->or_where( 'term_taxonomy', '=', 'casino-category' )
        ->or_where( 'term_taxonomy', '=', 'bonus-category' )
        ->add_fields(array(
            Field::make('separator', 'hjfdcjydt', __('Main banner')),
            Field::make('text', 'app_banner_txt', __('Title'))
                ->help_text("<span style='color: blue;'>".__('Leave blank to use post title')."</span>")
                ->set_width(75),
            Field::make('image', 'app_banner_img', __('Image'))
                ->set_width(25),
        ));

    Container::make( 'term_meta', 'Intro text' )
        ->add_fields(array(
            Field::make('textarea', 'intro_text', 'Intro')
        ));

    Container::make( 'term_meta', 'Text content' )
        ->where( 'term_taxonomy', '=', 'category' )
        ->or_where( 'term_taxonomy', '=', 'game-category' )
        ->or_where( 'term_taxonomy', '=', 'casino-category' )
        ->or_where( 'term_taxonomy', '=', 'bonus-category' )
        ->add_fields(array(
            Field::make('rich_text', 'content_editor', __('Content'))
        ));

    Container::make( 'term_meta', 'Content manage' )
        ->add_fields( array(
            Field::make('complex', 'ud_cat_content', __('Content'))
                ->setup_labels($labels['sections'])
                ->set_collapsed(true)
                ->add_fields('text-editor', __('Text editor'), array(
                    Field::make( 'separator', 'crb_separator', $shortcodes_codex ),
                    Field::make('rich_text', 'text_editor', __('Classic editor'))
                ))
                ->add_fields('card-top', __('Card'), array(
                    Field::make('checkbox', 'card_top_power', __('Display section'))
                        ->set_default_value('yes')
                ))
                ->add_fields('guide', array(
                    Field::make('image', 'guide_bg_img', __('Background'))
                        ->set_value_type( 'url' ),
                    Field::make('textarea', 'guide_title', __('Title'))
                        ->help_text("<span style='color: blue;'>".__('Leave blank to use post title')."</span>"),
                    Field::make('textarea', 'guide_desc', __('Description')),
                    Field::make('complex', 'guide_steps', __('Steps'))
                        ->set_collapsed(true)
                        ->setup_labels($labels['guide'])
                        ->add_fields(array(
                            Field::make('text', 'g_s_title', __('Step title'))
                                ->set_width(75),
                            Field::make('image', 'g_s_thmb', __('Step image'))
                                ->set_width(25),
                            Field::make('textarea', 'g_s_txt', __('Text'))
                        ))
                        ->set_header_template( '
                        <% if (g_s_title) { %>
                            <%- g_s_title %>
                        <% } %>    
                        '),
                ))
                ->add_fields('form-reply', array(
                    Field::make('text', 'fr_title', __('Title'))
                        ->set_default_value('Leave a <em>reply</em>')
                        ->set_width(75),
                    Field::make('image', 'fr_bg', __('Background'))
                        ->set_value_type('url')
                        ->set_width(25),
                    Field::make('textarea', 'fr_subtitle', __('Subtitle'))
                        ->set_default_value('Your email address will not be published. Required fields are marked')
                ))
                ->add_fields('game-card', __('Games'), array(
                    Field::make('text', 'gc_title', __('Title'))
                        ->help_text("<span style='color: blue;'>".__('Leave blank to use default text (post title + "GAMES")')."</span>")
                        ->set_width(75),
                    Field::make('image', 'gc_bg', __('Background'))
                        ->set_value_type('url')
                        ->set_width(25),
                    Field::make('textarea', 'gc_subtitle', __('Subtitle')),
                    Field::make('select', 'gc_category', __('Select category'))
                        ->add_options(ud_get_games_cats())
                        ->set_width(33),
                    Field::make('text', 'gs_count', __('Number of games to show'))
                        ->set_default_value(4)
                        ->set_attribute('type', 'number')
                        ->set_width(33),
                    Field::make('checkbox', 'gs_is_filter', __('Filter'))
                        ->set_width(33),
                ))
                ->add_fields('game-types', array(
                    Field::make('text', 'game_types_title', __('Title')),
                    Field::make('textarea', 'game_types_subtitle', __('Subtitle')),
                    Field::make('complex', 'game_types_repeater', __('Items'))
                        ->set_collapsed(true)
                        ->setup_labels($labels['game_types'])
                        ->add_fields(array(
                            Field::make('image', 'gt_icon', __('Icon'))
                                ->set_width(25),
                            Field::make('text', 'gt_title', __('Title'))
                                ->set_width(75),
                            Field::make('textarea', 'gt_desc', __('Description'))
                        ))
                        ->set_header_template( '
                        <% if (gt_title) { %>
                            <%- gt_title %>
                        <% } %>    
                        ')
                ))
                ->add_fields('games-slider', array(
                    Field::make('text', 'gs_title', __('Title')),
                    Field::make('textarea', 'gs_subtitle', __('Subtitle')),
                    Field::make('multiselect', 'gs_games', __('Games'))
                        ->add_options(get_games_options_arr())
                ))
                ->add_fields('casino-card', __('Casinos'), array(
                    Field::make('text', 'cas_title', __('Title'))
                        ->set_default_value('Top rated <em>casinos</em>')
                        ->set_width(50),
                    // Field::make('image', 'cas_bg', __('Background'))
                    //     ->set_value_type('url')
                    //     ->set_width(25),
                    Field::make('textarea', 'cas_subtitle', __('Subtitle')),
                    Field::make('multiselect', 'cas_casionois', __('Select Casinos to show'))
                        ->add_options(ud_get_casinos_options())
                        ->set_width(50),
                    Field::make('select', 'cas_order_by', __('Order by'))
                        ->set_width(20)
                        ->add_options(array(
                            '' => __('Default'),
                            'rating' => __('Rating'),
                        )),
                    Field::make('text', 'cas_count', __('Number of casinos to show'))
                        ->set_default_value(4)
                        ->set_attribute('type', 'number')
                        ->set_width(30),
                    Field::make('checkbox', 'cas_show_pagination', __('Show pagination 1'))
                        ->set_default_value('yes')
                        ->set_width(33),
                ))
                ->add_fields('faq', 'FAQ`s', array(
                    // Field::make('checkbox', 'faq_power', __('Include FAQ'))
                    //     ->set_default_value('yes')
                    //     ->set_width(50),
                    Field::make('image', 'faq_bg', __('Background'))
                        ->set_value_type('url')
                        ->set_width(50),
                    Field::make('textarea', 'faq_title', __("Title"))
                        ->set_width(50)
                        ->set_default_value("Shave a <em>questions?</em>"),
                    Field::make('textarea', 'faq_subtitle', __("Subtitle")),
                    Field::make('complex', 'faq_items', __('Items'))
                        ->set_collapsed(true)
                        ->setup_labels($labels['faq'])
                        ->add_fields(array(
                            Field::make('text', 'question', __('Question')),
                            Field::make('textarea', 'answer', __('Answer'))
                        ))
                        ->set_header_template( '
                        <% if (question) { %>
                            <%- question %>
                        <% } %>    
                        ')
                ))
                ->add_fields('author', array(
                    Field::make('checkbox', 'au_power', __('Include author info'))
                        ->set_default_value('yes')
                        ->set_width(50),
                    Field::make('image', 'ua_bg', __('Background'))
                        ->set_value_type('url')
                        ->set_width(50),
                    Field::make('select', 'au_select', __('Select author'))
                        ->add_options(apply_filters('ud_get_authors', true)),
                ))
                ->add_fields('benefits',array(
                    Field::make('text', 'benefits_title', __('Title'))
                        ->set_width(75),
                    Field::make('image', 'benefits_bg', __('Background'))
                        ->set_width(25)
                        ->set_value_type( 'url' ),
                    Field::make('textarea', 'benefits_subtitle', __('Subtitle')),
                    Field::make('text', 'advantages_title', __('Advantages list title'))
                        ->set_width(50)
                        ->set_default_value('Pros casino'),
                    Field::make('text', 'flaws_title', __('Flaws list title'))
                        ->set_width(50)
                        ->set_default_value('Cons casino'),
                    Field::make('complex', 'benefits_advantages', __('Advantages'))
                        ->setup_labels($labels['advantages'])
                        ->set_collapsed(true)
                        ->set_width(50)
                        ->add_fields(array(
                            Field::make('text', 'b_adv', __('Advantage'))
                        ))
                        ->set_header_template( '
                        <% if (b_adv) { %>
                            <%- b_adv %>
                        <% } %>    
                        '),
                    Field::make('complex', 'benefits_flaws', __('Flaws'))
                        ->setup_labels($labels['flaws'])
                        ->set_collapsed(true)
                        ->set_width(50)
                        ->add_fields(array(
                            Field::make('text', 'b_flaw', __('Flaw'))
                        ))
                        ->set_header_template( '
                        <% if (b_flaw) { %>
                            <%- b_flaw %>
                        <% } %>    
                        ')
                ))
                ->add_fields('bandit', __('Simple image->text section'), array(
                    Field::make('image', 'bandit_main_img', __('Image'))
                        ->help_text("<span style='color: blue;'>".__('Leave blank to use default image:')."<img width='50' src='".get_stylesheet_directory_uri()."/assets/images/section/bandit.svg'></span>")
                        ->set_width(25),
                    Field::make('image', 'bandit_main_img_bg', __('Backgrownd for image'))
                        ->set_value_type('url')
                        ->set_width(25),
                    Field::make('select', 'bandit_style_type', __('Style'))
                        ->set_width(25)
                        ->add_options(array(
                            'image_right'   => __('Picture on the rigth'),
                            'image_left'    => __('Picture on the left')
                        )),
                    Field::make('checkbox', 'bandit_fill_area', __('Fill area'))
                        ->set_width(25),
                    Field::make('text', 'bandit_title', __('Title'))
                        ->set_width(75),
                    Field::make('textarea', 'bandit_subtitle', __('Subtitle'))
                ))
                ->add_fields('tags', array(
                    Field::make('checkbox', 'tags_power', __('Display tags'))
                    ->set_default_value('yes')
                    ->set_width(20),
                    Field::make('text', 'tags_title', __('Title'))
                        ->help_text("<span style='color: blue;'>".__('Leave blank to use default text (post title + "DETAILS")')."</span>")
                        ->set_width(40),
                    Field::make('textarea', 'tags_subtitle', __('Subitle'))
                        ->set_width(40)
                        ->help_text("<span style='color: blue;'>".__('Leave blank to use excerpt text')."</span>")
                ))
                ->add_fields('rating-card', __('Rating'), array(
                    Field::make('checkbox', 'rating_power', __('Display rating'))
                        ->set_default_value('yes')
                        ->set_width(50),
                    Field::make('checkbox', 'rating_games', __('Show game ratings'))
                        ->set_width(50),
                    Field::make('textarea', 'rating_games_title', __('Title section'))
                        ->set_rows(2)
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'rating_games',
                                'value' => true,
                                'compare' => '=',
                            )
                        ) ),
                    Field::make('textarea', 'rating_games_subtitle', __('Subtitle'))
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'rating_games',
                                'value' => true,
                                'compare' => '=',
                            )
                        ) ),
                    Field::make('multiselect', 'rating_posts_list', __('Games'))
                        ->add_options(get_games_options_arr())
                        ->set_conditional_logic( array(
                            array(
                                'field' => 'rating_games',
                                'value' => true,
                                'compare' => '=',
                            )
                        ) )
                ))
                ->add_fields('bonus-card', __('Bonuses'), array(
                    Field::make('checkbox', 'bonuses_power', __('Display bonuses'))
                        ->set_default_value('yes')
                        ->set_width(25),
                    Field::make('checkbox', 'bonuses_filter_on', __('Filter'))
                        ->set_default_value('yes')
                        ->set_width(25),
                    Field::make('select', 'bonuses_parent', __('Include'))
                        ->add_options(array(
                            'all'       => 'All',
                            'children'  => 'Children',
                            'curent'    => 'Current category'
                        ))
                        ->set_width(25),
                    Field::make('text', 'bonuses_count', __('Number of bonuses to show'))
                        ->set_default_value(3)
                        ->set_attribute('type', 'number')
                        ->set_width(25),
                    Field::make('text', 'bonuses_title', __('Title'))
                        ->set_width(50)
                        ->help_text("<span style='color: blue;'>".__('Leave blank to use default text (post title + "BONUSES")')."</span>"),
                    Field::make('textarea', 'bonuses_subtitle', __('Subtitle'))
                        ->set_width(50)
                        ->help_text("<span style='color: blue;'>".__('Leave blank to use excerpt text')."</span>"),
                ))
                ->add_fields('advantages', array(
                    Field::make('text', 'adv_title', __('Title')),
                    Field::make('textarea', 'adv_subtitle', __('Subtitle')),
                    Field::make('complex', 'adv_list', __('Advantage list'))
                        ->set_collapsed(true)
                        ->setup_labels($labels['advantages'])
                        ->add_fields(array(
                            Field::make('textarea', 'adv_item_txt', __('Description'))
                                ->set_width(75),
                            Field::make('image', 'adv_item_img', __('Thumbnail'))
                                ->set_width(25)
                        ))
                ))
        ));
    Container::make('term_meta', "Taxonomy Date")
        ->where('term_taxonomy', '=', $custom_field_dates_taxonomy['category'])
        ->or_where('term_taxonomy', '=', $custom_field_dates_taxonomy['casino-category'])
        ->or_where('term_taxonomy', '=', $custom_field_dates_taxonomy['game-category'])
        ->or_where('term_taxonomy', '=', $custom_field_dates_taxonomy['vendor'])
        ->or_where('term_taxonomy', '=', $custom_field_dates_taxonomy['bonus-category'])
        ->add_fields(
            array(
                Field::make('separator', 'dates_and_author', 'Taxonomy Date'),
                Field::make('date', 'published_date', 'Published date')
                    ->set_width(100),
                Field::make('checkbox', 'modify_updated_date', 'Change updated date')
                    ->set_width(20),
                Field::make('date', 'updated_date', 'Updated date')
                    ->set_width(50)
                    ->set_conditional_logic( array(
                        array(
                            'field'     => 'modify_updated_date',
                            'value'     => true,
                            'compare'   => '=',
                        )
                    ) ),
                Field::make('text', 'updated_date_auto', 'Updated date (auto)')
                    ->set_width(50)
                    ->set_attribute('readOnly', true)
                    ->set_conditional_logic( array(
                        array(
                            'field'     => 'modify_updated_date',
                            'value'     => false,
                            'compare'   => '=',
                        )
                    ) ),
            )
        );
    Container::make( 'theme_options', __('Additional theme options') )
        ->add_fields( array(
            Field::make('separator', 'defpgsopt', __('Default pages settings'))
                ->help_text(__('Set the selected pages to the "Default" template')),
            Field::make('select', 'default_page_game', __('Main page for Games'))
                ->add_options(apply_filters('ud_get_pages_opt', true)),
            Field::make('select', 'default_page_bonus', __('Main page for Bonuses'))
                ->add_options(apply_filters('ud_get_pages_opt', true)),
            Field::make('select', 'default_page_casinois', __('Main page for Casinos'))
                ->add_options(apply_filters('ud_get_pages_opt', true)),
            Field::make('separator', 'footer_settings', __('Footer Settings')),
            Field::make('complex', 'logos', __('Logos'))
                ->add_fields(array(
                    Field::make('image', 'logo_image', __('Logo Image'))
                        ->set_help_text('Upload a logo image'),
                    Field::make('text', 'logo_link', __('Logo Link'))
                        ->set_help_text('Enter the link for the logo')
                ))
                ->set_help_text('Upload a logos to display in the footer'),
            Field::make('separator', 'float_bar_settings', __('Float Bar Settings')),
            Field::make('checkbox', 'float_bar_show', __('Show'))
                ->set_help_text('Enable or disable the Float Bar'),
            Field::make('select', 'float_bar_casino', __('Casino'))
                ->add_options(ud_get_casinos_options())
                ->set_help_text('Select an casino to display in the Float Bar'),
            Field::make('text', 'float_bar_button_text', __('Button text'))
                ->set_help_text('Enter the text for the button'),
        ));
}

add_action('carbon_fields_term_meta_container_saved', function($term_id) {
    global $custom_field_dates_taxonomy;
    $date_format = 'Y-m-d';
    $taxonomy = get_term($term_id)->taxonomy;

    if ($custom_field_dates_taxonomy[$taxonomy]) {
        $saved_published_date = get_the_date($date_format);
        $today_date = date($date_format);
        $published_date = carbon_get_term_meta($term_id, 'published_date');

        if (!$published_date) {
            $published_date_value = $saved_published_date ? $saved_published_date : $today_date;
            carbon_set_term_meta($term_id, 'published_date', $published_date_value);
        }

        carbon_set_term_meta($term_id, 'updated_date_auto', $today_date);
    }
});

add_filter('the_content', 'add_carbon_fields_content_to_post', 20);

function add_carbon_fields_content_to_post($content) {
    if (is_singular()) {
        $post_id        = get_the_ID();
        $custom_content = carbon_get_post_meta($post_id, 'ud_post_content');

        if (empty($custom_content)) {
            return $content;
        }

        foreach ($custom_content as $part) {
            $part_tmpl = $part['_type'];

            if ($part_tmpl == 'text-editor') {
                $content .= $part['text_editor'];
            }
        }

        return $content;
    }
}

add_filter( 'body_class', 'remove_author_body_class' );
function remove_author_body_class( $classes ) {
    if ( is_author() ) {
        $classes = array_diff( $classes, array( 'author' ) );
    }
    return $classes;
}

add_filter("the_title", "with_do_shortcode");
add_filter("the_content", "with_do_shortcode");

function with_do_shortcode($txt) {
    if (is_admin()) {
        return $txt;
    }
    return do_shortcode($txt);
}

add_filter('wpseo_breadcrumb_single_link_info', function ($link_info) {
    $link_info['text'] = do_shortcode($link_info['text']);
    return $link_info;
});
