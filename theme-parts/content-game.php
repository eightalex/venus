<?php
    $p_id                   = get_the_ID();
    $intro_text 			= carbon_get_post_meta($p_id, 'intro_text');
    $casinois_list          = get_post_meta($p_id, 'parent_casino', true);
    $casinois_list_title    = carbon_get_post_meta($p_id, 'casinois_sidebar_title');
    $custom_content         = carbon_get_post_meta($p_id, 'ud_post_content');

    $q_arr = [
        'posts_per_page' => get_option('posts_per_page'),
        'post_type'      => 'casino',
        'post_status'    => 'publish',
        'order'          => 'DESC',
        'orderby'        => 'meta_value_num',
        'meta_key'       => 'casino_overall_rating',
        'post__in'       =>  $casinois_list,  
        'meta_query'     => [
                                [
                                    'key'    => 'casino_overall_rating',
                                    'type'   => 'NUMERIC',
                                    'compare' => 'EXISTS'
                                ]
                            ],
    ];
    
    $casinois = new WP_Query($q_arr);
    wp_reset_postdata();
    

    get_template_part('/theme-parts/modules/banner', 'single_game', ['id' => $p_id]);

    get_template_part('/theme-parts/modules/intro-text', '', ['text'=>$intro_text]);
 
    get_template_part('/theme-parts/modules/text-editor-sidebar', '', ['casinois' => $casinois, 'casinois_list_title' => $casinois_list_title] );

    if(!isset($custom_content)){
        return;
    }

    foreach($custom_content as $part){
        $part_tmpl = $part['_type'];
        get_template_part("/theme-parts/modules/$part_tmpl", "", ["id" => $p_id, "content"=>$part, "post_type" => $post_type]);
    }