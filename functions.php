<?php

function filter_menu_item_classes( $classes ) {
    $classes[] = 'navigation__item';
    return $classes;
}

add_filter( 'nav_menu_css_class', 'filter_menu_item_classes', 10, 4 );

function filter_submenu_classes( $classes, $args ) {
    if ( $args->theme_location === 'main-menu' ) {
        $classes[] = 'navigation__submenu';
    }
    return $classes;
}

add_filter( 'nav_menu_submenu_css_class', 'filter_submenu_classes', 10, 3 );

function venus_scripts() {
    wp_enqueue_style('my_custom_style', get_stylesheet_directory_uri().'/styles/index.css');
    wp_enqueue_script('app', get_theme_file_uri( '/scripts/app.js' ), array( 'jquery' ), $GLOBALS['mercury_version'], true );
}

add_action( 'wp_enqueue_scripts', 'venus_scripts' );

add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
    require_once( 'vendor/autoload.php' );
    \Carbon_Fields\Carbon_Fields::boot();
}

// CUSTOM ACTIONS
add_action('init', 'ud_register_post_types');
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
                                <label for="comment" class="input-label__label">Comment*</label>
                                <textarea id="comment" class="input input_textarea" placeholder="Type your text here"></textarea>
                            </div>';
    $default['class_submit'] = 'form-reply__button button';
    $default['label_submit'] = 'Post Comment';
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

    extract($g_args);

    if ( !empty( $category ) & !empty( $vendor ) ) {

		$categories_id_array = explode( ',', $category );
		$vendors_id_array = explode( ',', $vendor );

		$args = array(
			'posts_per_page' => $items_number,
			'post_type'      => 'game',
			'post__not_in'   => $exclude_id_array,
			'no_found_rows'  => true,
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

		$categories_id_array = explode( ',', $category );

		$args = array(
			'posts_per_page' => $items_number,
			'post_type'      => 'game',
			'post__not_in'   => $exclude_id_array,
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'game-category',
					'field'    => 'id',
					'terms'    => $categories_id_array
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
			'post__not_in'   => $exclude_id_array,
			'no_found_rows'  => true,
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
			'no_found_rows'  => true,
			'post_status'    => 'publish'
		);

	} else if ( !empty( $parent_id ) ) {

		$parent_id = '"'.$parent_id.'"';

		$args = array(
			'posts_per_page' => $items_number,
			'post_type'      => 'game',
			'post__not_in'   => $exclude_id_array,
			'no_found_rows'  => true,
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
			'post__not_in'   => $exclude_id_array,
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'orderby'        => $orderby,
			'order'          => $order
		);

	}

	$game_query = new WP_Query( $args );

    wp_reset_postdata();

    return $game_query;
}

add_filter('ud_get_casinos', 'ud_get_casinos');
function ud_get_casinos(array $atts){
    extract($atts);

    $cas_args = array (
	    'items_number'      => isset($items_number)? $items_number :4,
	    'category'          => isset($category)? $category: '',
	    'items_id'          => isset($items_id)? $items_id: '',
	    'order'             => isset($order)? $order: '',
	    'orderby'           => isset($orderby)? $orderby: '',
        'post__not_in'      => isset($exclude_id)? [$exclude_id]: [],
        // 'exclude_id_array'  => isset($exclude_id_array)? $exclude_id_array: [],
	);

    extract($cas_args);

    if ( !empty( $category ) ) {

		$categories_id_array = explode( ',', $category );

		$args = array(
			'posts_per_page' => $items_number,
			'post_type'      => 'casino',
			'post__not_in'   => isset($exclude_id)? [$exclude_id]: [],
			'post_status'    => 'publish',
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'casino-category',
					'field'    => 'id',
					'terms'    => $categories_id_array
				),
			),
			'orderby'  => $orderby,
			'order'    => $order
		);

	} else {
		$args = array(
			'posts_per_page' => $items_number,
			'post_type'      => 'casino',
			'post__not_in'   => $exclude_id_array,
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'orderby'        => $orderby,
			'order'          => $order
		);

	}

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

// add_filter('get_current_post_cat', 'get_current_post_cat');
// function get_current_post_cat($tax){
//     $req = $_REQUEST;
//     return get_the_terms($_REQUEST['post'], $tax);
// }

// var_dump(get_current_post_cat('casino-category'));

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

// CUSTOM FIELDS
add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );

use Carbon_Fields\Container;
use Carbon_Fields\Field;

function crb_attach_theme_options() {
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
        ]
    ];

    Container::make( 'post_meta', 'Content menage' )
        ->where('post_type', '=', 'post')
        ->or_where('post_type', '=', 'casino')
        ->add_fields( array(
            // Field::make('text', 'current_post_type', 'Post Type')
            //     ->set_default_value(apply_filters('ud_get_post_type', true)),
            Field::make('complex', 'ud_post_content', __('Content'))
                ->setup_labels($labels['sections'])
                ->set_collapsed(true)
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
                    Field::make('image', 'fr_bg', __('Bacground'))
                        ->set_value_type('url')
                        ->set_width(25),
                    Field::make('textarea', 'fr_subtitle', __('Subtitle'))
                        ->set_default_value('Your email address will not be published. Required fields are marked')
                ))
                ->add_fields('game-card', __('Games'), array(
                    Field::make('text', 'gc_title', __('Title'))
                        ->set_width(75),
                    Field::make('image', 'gc_bg', __('Bacground'))
                        ->set_value_type('url')
                        ->set_width(25),
                    Field::make('textarea', 'gc_subtitle', __('Subtitle')),
                    Field::make('select', 'gc_category', __('Select category'))
                        ->add_options(apply_filters('ud_get_games_cats', true))
                        ->set_width(75),
                    Field::make('text', 'gs_count', __('Number of games to show'))
                        ->set_default_value(4)
                        ->set_attribute('type', 'number')
                        ->set_width(25),
                ))
                ->add_fields('casino-card', __('Casinos'), array(
                    Field::make('text', 'cas_title', __('Title'))
                        ->set_default_value('Top rated <em>casinos</em>')
                        ->set_width(50),
                    // Field::make('image', 'cas_bg', __('Bacground'))
                    //     ->set_value_type('url')
                    //     ->set_width(25),
                    Field::make('textarea', 'cas_subtitle', __('Subtitle')),
                    Field::make('select', 'cas_category', __('Select category'))
                        ->add_options(apply_filters('ud_get_casinos_cats', true))
                        ->set_width(33),
                    Field::make('text', 'cas_count', __('Number of casinos to show'))
                        ->set_default_value(4)
                        ->set_attribute('type', 'number')
                        ->set_width(33),
                    Field::make('select', 'cas_order_by', __('Order by'))
                        ->set_width(33)
                        ->add_options(array(
                            'date' => __('Date'),
                            'name' => __('Name'),
                        ))
                ))
                ->add_fields('faq', 'FAQ`s', array(
                    Field::make('checkbox', 'faq_power', __('Include FAQ'))
                        ->set_default_value('yes')
                        ->set_width(50),
                    Field::make('image', 'faq_bg', __('Background'))
                        ->set_value_type('url')
                        ->set_width(50),
                    Field::make('textarea', 'faq_title', __("Title"))
                        ->set_default_value("Shave a <em>questions?</em>"),
                    Field::make('textarea', 'faq_subtitle', __("Subtitle"))
                ))
                ->add_fields('author', array(
                    Field::make('checkbox', 'au_power', __('Include author info'))
                        ->set_default_value('yes')
                        ->set_width(33),
                    Field::make('image', 'ua_bg', __('Background'))
                        ->set_value_type('url')
                        ->set_width(33),
                    Field::make('image', 'au_main_img', __('Main image'))
                        ->set_value_type('url')
                        ->help_text("<span style='color: blue;'>".__('Leave blank to use default image:')."<img width='50' src='".get_stylesheet_directory_uri()."/assets/images/author/picture.svg'></span>")
                        ->set_width(33),
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
                    Field::make('text', 'bandit_title', __('Title'))
                        ->set_width(75),
                    Field::make('textarea', 'bandit_subtitle', __('Subtitle'))
                ))
        ));
}
