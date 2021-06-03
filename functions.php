<?php
define( 'CHILD_DIR', get_theme_file_uri() );
define( 'PARENT_DIR', get_stylesheet_directory_uri() );
define( 'SITE_URL', site_url() );

require_once get_stylesheet_directory().'/cpt-functions.php';
require_once get_stylesheet_directory().'/class/class-custom-widget.php';

add_action( 'wp_enqueue_scripts', 'sigma_mt_enqueue_styles', PHP_INT_MAX);
function sigma_mt_enqueue_styles() {
    $parent_style = 'adforest-style'; // This is 'adforest-style' for the AdForest theme.
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}

// load js files in footer & style in header start
add_action('wp_enqueue_scripts', 'sigma_mt_scripts');
function sigma_mt_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_style('dashicons');
    wp_enqueue_style('sigmamt-dashicons', get_bloginfo('url') . '/wp-includes/css/dashicons.css', array(), '1.0.0', true);
    wp_enqueue_style('sigmamt-all-fontawesome', CHILD_DIR . '/assets/css/all.css', array(), '1.0.0', true);
    wp_enqueue_style('sigmamt-search-style', CHILD_DIR .'/assets/css/search.css');
    wp_enqueue_style('home', CHILD_DIR .'/news/css/news.css'); 
    wp_enqueue_style('sigmamt-regular-fontawesome', CHILD_DIR . '/assets/css/regular.css', array(), '1.0.0', true);
    wp_enqueue_script('sigmamt-main-script', CHILD_DIR . '/assets/js/custom.js', array(), '1.0.0', true );    
    wp_enqueue_script('sigmamt-slick-script', CHILD_DIR . '/assets/js/slick.min.js', array(), '1.0.0', true );

    if (is_page('Online Casinos') || is_post_type('casinos-items')) {
        wp_enqueue_style('directory', get_stylesheet_directory_uri().'/online-casinos/css/online-casinos.css');
    }

    /****Autocomplete script ****/
    wp_enqueue_script('autocomplete-search', get_stylesheet_directory_uri() . '/assets/js/autocomplete.js', 
        ['jquery', 'jquery-ui-autocomplete'], null, true);
    wp_localize_script('autocomplete-search', 'AjaxRequest', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'ajax_nonce' => wp_create_nonce('autocompleteSearchNonce'),
        'security' => wp_create_nonce( 'load_more_people' ),
    ]);
 
    $wp_scripts = wp_scripts();
    wp_enqueue_style('jquery-ui-css',
        '//ajax.googleapis.com/ajax/libs/jqueryui/' . $wp_scripts->registered['jquery-ui-autocomplete']->ver . '/themes/smoothness/jquery-ui.css',
        false, null, false
    );
}

function is_post_type($type){
    global $wp_query;
    if($type == get_post_type($wp_query->post->ID)) 
        return true;
    return false;
}

// Shortcode for search form
add_shortcode('sigma-mt-wpbsearch', 'sigma_mt_wpbsearchform');
function sigma_mt_wpbsearchform( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="search-form"
            action="' . home_url( '/' ) . '" >
                <div class="s-form">
                    <label class="search-label" for="s">
                        <i aria-hidden="true" class="fa fa-search"></i>
                    </label>
                    <input type="text" class="search-field search-autocomplete" value="' . get_search_query() . '" name="s" id="s" />
                    <input type="submit" class="search-submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
                    <div class="hs-search-field__suggestions">
                        <ul id="search-results"></ul>
                    </div>
                </div>
            </form>';
    return $form;
}

// Autocomplete for search
add_action('wp_ajax_nopriv_autocompleteSearch', 'sigmamt_autocomplete_search');
add_action('wp_ajax_autocompleteSearch', 'sigmamt_autocomplete_search');
function sigmamt_autocomplete_search() {
    check_ajax_referer('autocompleteSearchNonce', 'security');
    $search_term = $_REQUEST['term'];
    if (!isset($_REQUEST['term'])) {
        echo json_encode([]);
    }
    $suggestions = [];
    $query = new WP_Query([
        's' => $search_term,
        'posts_per_page' => 3,
        'order' => 'DESC',
        'orderby' => 'ID',
    ]);
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $suggestion['ID'] = get_the_ID();
            $suggestion['label'] = get_the_title();
            $suggestion['link'] = get_the_permalink();
            $suggestions[]= $suggestion;
        }
        wp_reset_postdata();
    }
    echo json_encode($suggestions);
    wp_die();

}

// For upcoming news
add_shortcode('upcoming-event', 'sigma_mt_upcoming_event_shortcode');
function sigma_mt_upcoming_event_shortcode(){
    $upcomingevent = get_field('upcoming_event', 'option');
    if(is_array($upcomingevent) && !empty($upcomingevent)){
        $event_data =   '<div class="upcomingeventsection">
                            <div class="upcomingeventheading"> 
                                <h2>"'.$upcomingevent['title'].'"</h2>
                            </div>
                            <div class="upcomingeventintro">
                                <h3>"'.$upcomingevent['event_name'].'"</h3>
                                <h4>"'.$upcomingevent['event_date'].'"</h4>
                                <p>"'.$upcomingevent['event_description'].'"</p>
                                <a href="'.$upcomingevent['button_link'].'">"'.$upcomingevent['button_text'].'"</a>
                            </div>
                        </div>';
        return $event_data;
    }
}

//function to get news tags.
function sigma_mt_get_news_tags_lists() {
    $taxonomies = array( 
        'news-tag',
    );
    $args = array(
        'orderby'           => 'name', 
        'order'             => 'ASC',
        'hide_empty'        => true,
        'exclude'           => array(), 
        'exclude_tree'      => array(), 
        'include'           => array(),
        'number'            => '', 
        'fields'            => 'all', 
        'slug'              => '', 
        'parent'            => '',
        'hierarchical'      => true, 
        'child_of'          => 0, 
        'get'               => '', 
        'name__like'        => '',
        'description__like' => '',
        'pad_counts'        => false, 
        'offset'            => '', 
        'search'            => '', 
        'cache_domain'      => 'core'
    );
    $terms = get_terms( $taxonomies, $args );
    return $terms;
}

//function to get news tags.
function sigma_mt_get_testimonial_data() {
    $post_args = array(
      'posts_per_page' => -1,
      'post_type' => 'testimonial-items',
      'orderby'        => 'rand',
      'post_status'    => 'publish'
    );
    $get_posts = get_posts($post_args);
    return $get_posts;
}

//function to get magazine.
function sigma_mt_get_magazines($term_id) {
    $taxonomy = 'magazines-cat';
    $category = get_term_by('id', $term_id, $taxonomy);
    $post_args = array(
      'posts_per_page' => -1,
      'post_type' => 'magazine-items',
      'orderby'        => 'rand',
      'post_status'    => 'publish',
      'tax_query' => array(
              array(
                  'taxonomy' => $taxonomy,
                  'field' => 'term_id',
                  'terms' => $category->term_id,
              )
          )
    );
    $get_posts = get_posts($post_args);
    return $get_posts;
}

//Get tags menus
function sigma_mt_get_tags_menu() {
    $menu = '963';
    $args = array(
        'order'                  => 'ASC',
        'orderby'                => 'menu_order',
        'post_type'              => 'nav_menu_item',
        'post_status'            => 'publish',
        'output'                 => ARRAY_A,
        'output_key'             => 'menu_order',
        'nopaging'               => true,
        'update_post_term_cache' => false );
    $items = wp_get_nav_menu_items( $menu, $args );
    return $items;
}

function get_image_id_by_url( $url ) {
    global $wpdb;
    $image = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $url ));
    if(!empty($image)) {
        return $image[0];    
    }
    return false;
}

//Shortcode to display banner adds
add_shortcode( 'sigma-mt-banner-adds', 'sigma_mt_banner_adds' );
function sigma_mt_banner_adds($atts) {
    $banner_image = isset($atts['banner_add']) ? $atts['banner_add'] : '';
    $banner_link = isset($atts['banner_url']) ? $atts['banner_url'] : '';
    $image_id = get_image_id_by_url($banner_image);
    $image_info = wp_get_attachment_metadata($image_id);

    $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
    $image_title = get_the_title($image_id);
    $image_caption = $image_info['image_meta']['caption'];

    $output ='<section class="sigma-news">
                <div class="container">
                    <div class="single-news">
                        <div class="all-news">
                            <a href="'. $banner_link .'">
                                <img src="'. $banner_image .'" alt="'. $image_title .'">
                            </a>
                        </div>
                    </div>
                </div>
            </section>';
    return $output;
}

/**
 * Load ACF options page.
 */
if( function_exists('acf_add_options_page') ) {
    $general_settings =__( 'Theme General Settings', 'sigmaigaming' );
    $theme_settings = __( 'Theme Settings', 'sigmaigaming' );
    $newsletter_title =__( 'Newsletter Form', 'sigmaigaming' );
    acf_add_options_page(array(
        'page_title'    => $general_settings,
        'menu_title'    => $theme_settings,
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
    
    if( function_exists('acf_add_options_sub_page') ) {
        acf_add_options_sub_page(array(
            'page_title'    => $newsletter_title,
            'menu_title'    => $newsletter_title,
            'parent_slug'   => 'theme-general-settings',
        ));
    }
    
}

// PHP code to obtain country, city, etc using IP Address
function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    // PHP code to extract IP 
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}

//function to get news tags.
function sigma_mt_get_news_tags_data($tag_id, $taxonomy, $count) {
    $tag_data = array();
    $post_data = array();
    $tag_category = get_term_by('id', $tag_id, $taxonomy);
    if(isset($tag_id) && !empty($tag_id)) {
        $post_tag_args = array(
          'posts_per_page' => $count,
          'post_type' => 'news-items',
          'tax_query' => array(
              array(
                  'taxonomy' => 'news-tag',
                  'field' => 'term_id',
                  'terms' => $tag_category->term_id,
              )
          )
        );
    } else {
        $post_tag_args = array(
          'posts_per_page' => $count,
          'post_type' => 'news-items',
          'orderby'        => 'rand',
          'post_status'    => 'publish'
        );
    }
    $tag_data['term_value'] = $tag_category;
    $get_posts = get_posts($post_tag_args);
    $post_data['term_data'] = $get_posts;
    $result_array = array_merge($tag_data, $post_data);
    return $result_array;
}


// function to display order based on their continent
function sigma_mt_get_continent_order() {
    $taxonomy = 'news-tag';
    // Get the IP address
    $visitors_ip_info = ip_info();
    $continents = isset($visitors_ip_info['continent']) ? $visitors_ip_info['continent'] : '';
    if($continents === 'North America') {
        $continents = 'Americas';
    }
    $category = get_term_by('name', $continents, $taxonomy);
    $term_id = isset($category->term_id) ? $category->term_id : '';
    $term_name = isset($category->name) ? $category->name : '';

    $asia = __( 'Asia', 'sigmaigaming' );
    $europe = __( 'Europe', 'sigmaigaming' );
    $americas =__( 'Americas', 'sigmaigaming' );
    $africa = __( 'Africa', 'sigmaigaming' );

    if($continents === $asia ) {
        $order = require_once get_stylesheet_directory().'/home/home-asia.php';
    } elseif ($continents === $europe ) {
        $order = require_once get_stylesheet_directory().'/home/home-europe.php';
    } elseif ($continents === $americas) {
        $order = require_once get_stylesheet_directory().'/home/home-americas.php';
    } elseif ($continents === $africa) {
        $order = require_once get_stylesheet_directory().'/home/home-africa.php';
    } else {
        $order = require_once get_stylesheet_directory().'/home/home-europe.php';
    }
    return $order;
}

//function to get news tags.
function sigma_mt_get_casino_provider_data() {
    $post_tag_args = array(
      'posts_per_page' => 10,
      'post_type' => 'casinos-items',
      'orderby'        => 'ASC',
    );
    $get_posts = get_posts($post_tag_args);
    return $get_posts;
}

//Shortcode to get people lists
add_shortcode( 'sigma-mt-people-lists', 'sigma_mt_get_people_list' );
function sigma_mt_get_people_list($atts) {
    $content = '';
    $taxonomy = 'people-cat';
    $post_type = 'people-items';
    $post_id = isset($atts['post_id']) ? $atts['post_id'] : '';
    $speakers_text = get_field('speakers_text');
    $term_value = get_the_terms( $post_id, $taxonomy );
    $person_lname = isset($atts['person_lname']) ? $atts['person_lname'] : '';
    $person_phone = isset($atts['person_phone']) ? $atts['person_phone'] : '';
    $person_email = isset($atts['person_email']) ? $atts['person_email'] : '';
    $person_image = isset($atts['person_image']) ? $atts['person_image'] : '';
    $person_position = isset($atts['person_position']) ? $atts['person_position'] : '';
    $person_company = isset($atts['person_company']) ? $atts['person_company'] : '';
    $person_language = isset($atts['person_language']) ? $atts['person_language'] : '';
    $load_more = __( 'Load More', 'sigmaigaming' );
    $get_posts = array();
    foreach($term_value as $term) {
        $post_args = array(
          'posts_per_page' => 1,
          'post_type' => $post_type,
          'orderby'        => 'DESC',
          'post_status'    => 'publish',
          'paged' => 1,
          'tax_query' => array(
                  array(
                      'taxonomy' => $taxonomy,
                      'field' => 'term_id',
                      'terms' => $term->term_id,
                  )
              )
        );
        $get_posts = get_posts($post_args);
    }
    if(!empty($get_posts)) {
        $content .= '<section class="speakers">
                        <div class="container">
                            <div class="about-section-title">
                                <h2>'. (isset($speakers_text['speaker_title']) ? $speakers_text['speaker_title'] : 'Speakers') .'</h2>
                                <p>'. (isset($speakers_text['speaker_text']) ? $speakers_text['speaker_text'] : '') .'</p>
                            </div>
                            <div class="all-speakers">';
                                foreach($get_posts as $k => $post) {
                                    $title = $post->post_title;
                                    $people_icon = get_field('image_icon', $post->ID);
                                    $people_designation = get_field('designation', $post->ID);
                                    $people_company = get_field('company', $post->ID);
                                    $content .= '<div class="single-speaker">';
                                        if(!empty($person_image)) { $content .= '<img src="'. $people_icon .'" alt="">'; }
                                        if(!empty($title)) { $content .= '<h3>'.$post->post_title.'</h3>'; }
                                        if(!empty($person_position)) { $content .= '<h4>'. $people_designation .'</h4>'; }
                                        if(!empty($person_company)) { $content .= '<p>'. $people_company->post_title .'</p>'; }
                                    $content .= '</div>';
                                }
                            $content .= '</div>
                            <input type="hidden" value="'.$post_id.'" id="postID">
                            <div class="load-people"><button class="loadmore" id="loadmore">'.$load_more.'</button></div></div>
                    </section>';
    }
    return $content;
}

add_action('wp_ajax_load_people_by_ajax', 'load_people_by_ajax_callback');
add_action('wp_ajax_nopriv_load_people_by_ajax', 'load_people_by_ajax_callback');
function load_people_by_ajax_callback() {
    check_ajax_referer('load_more_people', 'security'); 
    $content = '';
    $taxonomy = 'people-cat';
    $post_type = 'people-items';
    $paged = $_POST['page'];
    $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : '';
    $term_value = get_the_terms( $post_id, $taxonomy );
    $get_posts = array();
    foreach($term_value as $term) {
        $post_args = array(
          'posts_per_page' => 1,
          'post_type' => $post_type,
          'orderby'        => 'DESC',
          'post_status'    => 'publish',
          'paged' => $paged,
          'tax_query' => array(
                  array(
                      'taxonomy' => $taxonomy,
                      'field' => 'term_id',
                      'terms' => $term->term_id,
                  )
              )
        );
        $get_posts = get_posts($post_args);
    }
    if(!empty($get_posts)) {
        foreach($get_posts as $k => $post) {
            $title = $post->post_title;
            $people_icon = get_field('image_icon', $post->ID);
            $people_designation = get_field('designation', $post->ID);
            $people_company = get_field('company', $post->ID);
            $content .= '<div class="single-speaker">';
                if(!empty($people_icon)) { $content .= '<img src="'. $people_icon .'" alt="">'; }
                if(!empty($title)) { $content .= '<h3>'.$title.'</h3>'; }
                if(!empty($people_designation)) { $content .= '<h4>'. $people_designation .'</h4>'; }
                if(!empty($people_company)) { $content .= '<p>'. $people_company->post_title .'</p>'; }
            $content .= '</div>';
            echo $content;
        }
    } 
    wp_die();
}

//function to get videos.
function sigma_mt_get_videos($term_id) {
    $taxonomy = 'videos-cat';
    $post_type = 'video-items';
    $post_args = array(
      'posts_per_page' => 10,
      'post_type' => $post_type,
      'orderby'        => 'DESC',
      'post_status'    => 'publish',
      'paged' => 1,
      'tax_query' => array(
              array(
                  'taxonomy' => $taxonomy,
                  'field' => 'term_id',
                  'terms' => $term_id,
              )
          )
    );
    $get_posts = get_posts($post_args);
    return $get_posts;
}

//function to get company.
function sigma_mt_get_company($term_id) {
    $taxonomy = 'company-cat';
    $post_type = 'company-items';
    $post_args = array(
      'posts_per_page' => 10,
      'post_type' => $post_type,
      'orderby'        => 'DESC',
      'post_status'    => 'publish',
      'paged' => 1,
      'tax_query' => array(
              array(
                  'taxonomy' => $taxonomy,
                  'field' => 'term_id',
                  'terms' => $term_id,
              )
          )
    );
    $get_posts = get_posts($post_args);
    return $get_posts;
}