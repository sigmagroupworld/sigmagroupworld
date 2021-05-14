<?php
define( 'CHILD_DIR', get_theme_file_uri() );
define( 'PARENT_DIR', get_stylesheet_directory_uri() );
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
    wp_enqueue_style('sigmamt-all-fontawesome', CHILD_DIR . '/assets/css/all.css', array(), '1.0.0', true);
    wp_enqueue_style('sigmamt-home-style', CHILD_DIR .'/home/css/style.css');
    wp_enqueue_style('sigmamt-search-style', CHILD_DIR .'/assets/css/search.css');
    wp_enqueue_style('home', CHILD_DIR .'/news/css/news.css'); 
    wp_enqueue_style('sigmamt-regular-fontawesome', CHILD_DIR . '/assets/css/regular.css', array(), '1.0.0', true);
    wp_enqueue_script('sigmamt-main-script', CHILD_DIR . '/assets/js/custom.js', array(), '1.0.0', true );
    wp_enqueue_script('sigmamt-home-script', CHILD_DIR .'/home/js/custom-home.js', array(), '1.0.0', true);
    wp_enqueue_script('sigmamt-slick-script', CHILD_DIR . '/assets/js/slick.min.js', array(), '1.0.0', true );

    /****Autocomplete script ****/
    /*wp_enqueue_script('autocomplete-search', get_stylesheet_directory_uri() . '/assets/js/autocomplete.js', 
        ['jquery', 'jquery-ui-autocomplete'], null, true);
    wp_localize_script('autocomplete-search', 'AutocompleteSearch', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'ajax_nonce' => wp_create_nonce('autocompleteSearchNonce')
    ]);
 
    $wp_scripts = wp_scripts();
    wp_enqueue_style('jquery-ui-css',
        '//ajax.googleapis.com/ajax/libs/jqueryui/' . $wp_scripts->registered['jquery-ui-autocomplete']->ver . '/themes/smoothness/jquery-ui.css',
        false, null, false
    );*/
}
// load js files in footer & style in header end

 //Autocomplete script
add_action( 'wp_enqueue_scripts', 'ja_global_enqueues' );
function ja_global_enqueues() {
    wp_enqueue_style(
        'jquery-auto-complete',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.css',
        array(),
        '1.0.7'
    );
    wp_enqueue_script(
        'jquery-auto-complete',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.js',
        array( 'jquery' ),
        '1.0.7',
        true
    );
    wp_enqueue_script(
        'global',
        get_template_directory_uri() . '/js/global.min.js',
        array( 'jquery' ),
        '1.0.0',
        true
    );
    wp_localize_script(
        'global',
        'global',
        array(
            'ajax' => admin_url( 'admin-ajax.php' ),
        )
    );
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
                </div>
            </form>';
    return $form;
}

// Autocomplete for search
add_action('wp_ajax_nopriv_autocompleteSearch', 'sigmamt_autocomplete_search');
add_action('wp_ajax_autocompleteSearch', 'sigmamt_autocomplete_search');
function sigmamt_autocomplete_search() {
    //check_ajax_referer('autocompleteSearchNonce', 'security');

    $results = new WP_Query( array(
        'post_type'     => 'news-items',
        'post_status'   => 'publish',
        'posts_per_page'=> 3,
        's'             => stripslashes( $_POST['search'] ),
    ) );

    $items = array();

    if ( !empty( $results->posts ) ) {
        foreach ( $results->posts as $result ) {
            $items[] = $result->post_title;
            /*$suggestions = [
                'id' => $result->ID,
                'label' => $result->post_title,
                'link' => get_the_permalink($result->ID)
            ];*/
        }
    }

    wp_send_json_success( $items );
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
function sigma_mt_banner_adds( $atts ) {
    $banner_image = $atts['banner_add'];
    $image_id = get_image_id_by_url($banner_image);
    $image_info = wp_get_attachment_metadata($image_id);

    $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
    $image_title = get_the_title($image_id);
    $image_caption = $image_info['image_meta']['caption'];

    $output ='<section class="sigma-news">
                <div class="container">
                    <div class="single-news">
                        <div class="all-news">
                            <a href="#">
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

// PHP code to extract IP 
function sigma_mt_get_ip_addr() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// PHP code to obtain country, city, etc using IP Address
function sigma_mt_get_ip_info() {
    $ip = sigma_mt_get_ip_addr();
    $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
    //$ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=2.20.178.255"));
    return $ip_data;
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


// function to display order based on their country
function sigma_mt_get_country_order() {
    $taxonomy = 'news-tag';
    // Get the IP address
    $visitors_ip_info = sigma_mt_get_ip_info();
    $coutry_name = $visitors_ip_info->geoplugin_continentName;
    $category = get_term_by('name', $coutry_name, $taxonomy);
    $term_id = $category->term_id;
    $term_name = $category->name;

    $asia = __( 'Asia', 'sigmaigaming' );
    $europe = __( 'Europe', 'sigmaigaming' );
    $americas =__( 'Americas', 'sigmaigaming' );
    $africa = __( 'Africa', 'sigmaigaming' );

    if($coutry_name === $asia ) {
        $order = require_once get_stylesheet_directory().'/home/home-asia.php';
    } elseif ($coutry_name === $europe ) {
        $order = require_once get_stylesheet_directory().'/home/home-europe.php';
    } elseif ($coutry_name === $americas) {
        $order = require_once get_stylesheet_directory().'/home/home-americas.php';
    } elseif ($coutry_name === $africa) {
        $order = require_once get_stylesheet_directory().'/home/home-africa.php';
    } else {
        $order = require_once get_stylesheet_directory().'/home/home-asia.php';
    }
    return $order;
}