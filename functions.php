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
    wp_enqueue_style('swiper_style', get_stylesheet_directory_uri().'/scripts/libs/swiper-bundle.min.css');
    wp_enqueue_script('swiper_js', get_theme_file_uri( '/scripts/libs/swiper-bundle.min.js' ), array( 'jquery' ), $GLOBALS['mercury_version'], true );
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
                                <textarea id="comment" name="comment" class="input input_textarea" placeholder="Type your text here"></textarea>
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

add_filter('ud_get_author_infos', 'ud_get_author_infos');
function ud_get_author_infos($author_id){
    $infos = [
        'firs_name'          => get_user_meta($author_id, 'first_name', true),
        'last_name'          => get_user_meta($author_id, 'last_name', true),
        'desc'               => get_user_meta($author_id, 'description', true),
        'ava_url'            => get_user_meta($author_id, 'sabox-profile-image', true)
    ];

    return $infos;
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
			// 'post__not_in'   => $exclude_id_array,
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
			// 'post__not_in'   => $exclude_id_array,
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
			// 'post__not_in'   => $exclude_id_array,
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
			// 'post__not_in'   => $exclude_id_array,
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
			// 'post__not_in'   => $exclude_id_array,
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
	    'items_number'      => isset($items_number)? $items_number : get_option('posts_per_page'),
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
			'post__not_in'   => isset($exclude_id)? [$exclude_id]: [],
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
    $out = [
        'Overall rating'        => floatval(get_post_meta($id, "{$type}_overall_rating", true)),
        'Trust & Fairness'      => floatval(get_post_meta($id, "{$type}_rating_trust", true)),
        'Bonuses & Promotions'  => floatval(get_post_meta($id, "{$type}_rating_bonus", true)),
        'Games & Software'      => floatval(get_post_meta($id, "{$type}_rating_games", true)),
        'Customer Support'      => floatval(get_post_meta($id, "{$type}_rating_customer", true)),
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

    $term = $_GET['bonuses-cat'];
    if(isset($terms)){
        $args['tax_query'] = array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => 'bonus-category',
                                'field'    => 'id',
                                'terms'    => [$term]
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
        $pagenavi_items = apply_filters('my_pagination', $paged, $max_pages);
        $out['pagenavi'] = "<div class='content-cards__footer'>
                                <div class='pagination'>
                                    {$pagenavi_items}
                                </div>
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
 *  'lnk_btn_txt' (link btn text)(opt),
 *  'ex_lnk_btn_txt' (external link btn text)(opt),
 *  'item_class' (opt)
 * ]
 */
add_action('print_single_casino_template', 'print_single_casino_template');
function print_single_casino_template($data = []){
    extract($data); 

    $desc_html          = "";
    $external_link_html = "";
    $lb_txt             = isset($lnk_btn_txt)? $lnk_btn_txt: 'Read review';
    $elb_txt            = isset($ex_lnk_btn_txt)? $ex_lnk_btn_txt: 'Play now';
    $add_class          = isset($item_class)? $item_class: '';

    if(isset($desc) && !empty($desc)){
        $desc_html = "<div class='casino-card__subtitle'>{$desc}</div>"; 
    }

    if(isset($external_link) && !empty($external_link)){
        $external_link_html = "<a href='{$external_link}' target='_blank' class='casino-card__button button'>{$elb_txt}</a>";
    }
    
    $tmpl = "<div class='casino-card {$add_class}'>
                <div class='casino-card__image'>
                    <img src='{$img_src}' alt='{$img_alt}'>
                </div>
                
                <div class='casino-card__title'>{$title}</div>
                <div class='casino-card__rating' data-rating='{$rating}'>
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
    $bonus_img_def   = "<img src=" . get_stylesheet_directory_uri().'/assets/images/bonus-card/gift.svg' . " alt='gift' class='bonus-card__img'>";        
    $description     = "";  
    $external        = "";  
    $bn              = "";  
    $detailed_tc     = "";   

    if(!empty($bonus_code) && !empty($bonus_valid_date)):
        $ds = strtotime($bonus_valid_date);
        $df = date('M d, Y', $ds);

        $bonus_code_html = "<div class='bonus-card__gift-content'>
                                <span>Bonus code:</span>
                                <span>{$bonus_code}</span>
                                <span>Valid Until: {$df}</span>
                            </div>";
        
    endif;

    if(!empty($short_desc)):
        $description = "<div class='bonus-card__subtitle'>
                            {$short_desc}
                        </div>";
    endif;

    if(!empty($external_link)):
        $external ="<div class='bonus-card__cta'>
                        <a href='$external_link' target='__blank'  class='bonus-card__button button'>Play now</a>
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

    $cart = "<div class='bonus-card'>
                <div class='bonus-card__tags'>
                    <div class='bonus-card__tag'>Deposit Bonus</div>
                </div>
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
                    T&Cs Apply
                    $bn

                    $detailed_tc
                </div>
            </div>";

    return $cart;        
}

add_filter( 'my_pagination', 'my_pagination', 10, 3);
function my_pagination(int $current_page, int $max_page, $ajax = 0){
    $is_ajax = ($ajax == 1)? 'is_ajax': '';
    $page_url = get_the_permalink();
    $html = "<div class='pagination content__pagination {$is_ajax}' data-max_pages='{$max_page}'>";
            $p = paginate_links([
                    "base"               => wp_normalize_path("?bonuses-page=%#%" ),            
                    "format"             => "?bonuses-page=%#%",            
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
        '' => __('Choice games'),
    ];

    if($games->have_posts()){
        foreach($games->posts as $game){
            $out[$game->ID] = $game->post_title; 
        } 
    }
    return $out;
}

add_shortcode( 'print_quote', 'ud_print_quote' );
function ud_print_quote($atts){
    if(empty($atts)){
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
    if(empty($atts)){
        return;
    }
    extract($atts);
    $text           = isset($text)? $text: '';
    $author         = isset($author_id)? $author_id: get_queried_object()->post_author;
    $rating         = isset($rating)? $rating: '';
    $author_info    = apply_filters('ud_get_author_infos', $author);
    $ava            = $author_info['ava_url'];
    $full_name      = $author_info['firs_name'] . " " . $author_info['last_name'];

    $html = "<blockquote class='quote-author'>
                <header class='quote-author__header'>
                    <cite class='quote-author__author'>
                        <img src='{$ava}' alt='author'>
                        {$full_name}
                    </cite>
                    <div class='quote-author__rating'>
                        {$rating}
                    </div>
                </header>
                <p class='quote-author__text'>
                    {$text}
                </p>
            </blockquote>";

    return $html;     
}

add_filter('ud_get_tax_posts_tags', 'ud_get_tax_posts_tags');
function ud_get_tax_posts_tags($posts){
    $arr = [];

    foreach($posts as $post){
        $p_id = $post->ID;
        $tags = get_the_tags($p_id);
    
        foreach($tags as $tag){
            if(!in_array($tag->name, $arr)){
                array_push($arr, $tag->name);
            }
        }
    }

    return $arr;
}

// CUSTOM FIELDS
add_action( 'carbon_fields_register_fields', 'ud_custon_fields' );

use Carbon_Fields\Container;
use Carbon_Fields\Field;

function ud_custon_fields() {
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
        ]
    ];

    $shortcodes_codex = "You can use: [print_quote text='*Text' author_name='*Author Nane'] and [author_annatation text='*Text' rating='* 0-9' author_id='int (optional)']";

    Container::make('post_meta', 'App banner')
        // ->where('post_type', '=', 'post')
        ->where('post_type', '=', 'page')
        ->add_fields(array(
            Field::make('text', 'app_banner_txt', __('Title'))
                ->help_text("<span style='color: blue;'>".__('Leave blank to use post title')."</span>")
                ->set_width(75),
            Field::make('image', 'app_banner_img', __('Image'))
                ->set_width(25),
        ));

    Container::make( 'post_meta', 'Content menage' )
        ->where('post_type', '=', 'post')
        ->or_where('post_type', '=', 'casino')
        ->or_where('post_type', '=', 'page')
        ->add_fields( array(
            Field::make('complex', 'ud_post_content', __('Content'))
                ->setup_labels($labels['sections'])
                ->set_collapsed(true)
                ->add_fields('text-editor', __('Text editor'), array(
                    Field::make( 'separator', 'crb_separator', $shortcodes_codex ),
                    Field::make('rich_text', 'text_editor', __('Classic editor'))
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
                    Field::make('image', 'fr_bg', __('Bacground'))
                        ->set_value_type('url')
                        ->set_width(25),
                    Field::make('textarea', 'fr_subtitle', __('Subtitle'))
                        ->set_default_value('Your email address will not be published. Required fields are marked')
                ))
                ->add_fields('game-card', __('Games'), array(
                    Field::make('text', 'gc_title', __('Title'))
                        ->help_text("<span style='color: blue;'>".__('Leave blank to use default text (post title + "GAMES")')."</span>")
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
                ->add_fields('card-top', __('Card'), array(
                    Field::make('checkbox', 'card_top_power', __('Display section'))
                        ->set_default_value('yes')
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
                            'children'  => 'Children'
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
        ));

    Container::make( 'term_meta', 'Content' )
        ->where( 'term_taxonomy', '=', 'category' )    
        ->add_fields(array(
            Field::make('rich_text', 'content_editor', __('Content'))
        ));
}
