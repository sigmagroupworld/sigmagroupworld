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
    wp_enqueue_style('sigmamt-exhibits', CHILD_DIR .'/exhibit/css/exhibit.css'); 
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

//function to get videos term name by page ID
function sigma_mt_get_video_term($page_id) {
    $taxonomy = 'videos-cat';
    $term_value = get_the_terms( $page_id, $taxonomy );
    return $term_value;
}

//Shortcode to get people lists
add_shortcode( 'sigma-mt-people-lists', 'sigma_mt_get_people_list' );
function sigma_mt_get_people_list($atts) {
    $content = '';
    $taxonomy = 'people-cat';
    $post_type = 'people-items';
    $post_id = $atts['post_id'];
    $posts_per_page = isset($atts['posts_per_page']) ? $atts['posts_per_page'] : '1';
    $speakers_text = get_field('speakers_text');
    $term_value = get_the_terms( $post_id, $taxonomy );
    $person_name       = $atts['person_name'];
    $person_image       = $atts['person_image'];
    $person_position    = $atts['person_position'];
    $person_company     = $atts['person_company'];
    $person_language     = $atts['person_language'];
    $person_email    = $atts['person_email'];
    $person_phone     = $atts['person_phone'];
    $person_skype     = $atts['person_skype'];
    $load_more = __( 'Load More', 'sigmaigaming' );
    $exhibit_text = __( 'Exhibit', 'sigmaigaming' );
    if($term_value[0]->name === $exhibit_text) {
        $main_class = 'contact-us';
        $sub_class = 'all-person';
        $single_class = 'single-person';
        $heading = __( 'CONTACT US', 'sigmaigaming' );
        $button = '';
    } else {
        $main_class = 'speakers';
        $sub_class = 'all-speakers';
        $single_class = 'single-speaker';
        $heading = $speakers_text['speaker_title'];
        $button = '<div class="load-people"><button class="load-more" id="load-more">'.$load_more.'</button></div></div>';
    }
    $get_posts = array();
    if(!empty($term_value)) {
        foreach($term_value as $term) {
            $post_args = array(
              'posts_per_page' => $posts_per_page,
              'post_type' => $post_type,
              'orderby'        => 'DESC',
              'post_status'    => 'publish',
              'paged' => 1,
              'tax_query' => array(
                    'relation' => 'OR',
                    array(
                      'taxonomy' => $taxonomy,
                      'field' => 'term_id',
                      'terms' => $term->term_id,
                    )
                )
            );
            $get_posts = get_posts($post_args);
        }
    } else {
        $post_args = array(
          'posts_per_page' => $posts_per_page,
          'post_type' => $post_type,
          'orderby'        => 'DESC',
          'post_status'    => 'publish',
          'paged' => 1
        );
        $get_posts = get_posts($post_args);
    }
    if(!empty($get_posts)) {
        $content .= '<section class="'.$main_class.'">
                        <div class="container">
                            <div class="about-section-title">
                                <h2>'.$heading.'</h2>
                                <p>'. (isset($speakers_text['speaker_text']) ? $speakers_text['speaker_text'] : '') .'</p>
                            </div>
                            <div class="'.$sub_class.'">';
                                foreach($get_posts as $k => $post) {
                                    $title = $post->post_title;
                                    $people_icon = get_field('image_icon', $post->ID);
                                    $people_designation = get_field('designation', $post->ID);
                                    $people_company = get_field('company', $post->ID);
                                    $person_email_val = get_field('email', $post->ID);
                                    $person_phone_no = get_field('telephone_number', $post->ID);
                                    $person_skype_id = get_field('skype_id', $post->ID);
                                    $language_icon = get_field('language_icon', $post->ID);
                                    $content .= '<div class="'.$single_class.'">';
                                        if($person_image === 'yes' && !empty($people_icon)) { $content .= '<img src="'. $people_icon .'" alt="">'; }
                                        if($person_name === 'yes' && !empty($title)) { $content .= '<h3>'.$post->post_title.'</h3>'; }
                                        if($person_position === 'yes' && !empty($people_designation)) { $content .= '<p>'. $people_designation .'</p>'; }
                                        if($person_company === 'yes' && !empty($people_company)) { $content .= '<p>'. $people_company->post_title .'</p>'; }
                                        if($person_language === 'yes' && !empty($language_icon)) { 
                                            $content .= '<div class="lang">';
                                                            foreach($language_icon as $icon) {
                                                                $content .= '<img src="'.$icon.'" alt="">';
                                                            }
                                                        $content .= '</div>'; 
                                        }
                                        $content .= '<div class="person-social">';
                                                        if($person_email === 'yes' && !empty($person_email_val)) { $content .= '<p>E: <a href="mailto:'.$person_email_val.'">'.$person_email_val.'</a></p>'; }
                                                        if($person_phone === 'yes' && !empty($person_phone_no)) { $content .= '<p>T: <a href="tel:'.$person_phone_no.'">'.$person_phone_no.'</a></p>'; }
                                                        if($person_skype === 'yes' && !empty($person_skype_id)) { $content .= '<p>S: <a href="skype:'.$person_skype_id.'?call">'.$person_skype_id.'</a></p>'; }
                                                    $content .= '</div>';
                                    $content .= '</div>';
                                }
                            $content .= '</div>
                            <input type="hidden" value="'.$post_id.'" id="postID">
                            <input type="hidden" value="'.$posts_per_page.'" id="posts_per_page">
                            <input type="hidden" value="'.$person_image.'" id="person_image">
                            <input type="hidden" value="'.$person_name.'" id="person_name">
                            <input type="hidden" value="'.$person_position.'" id="person_position">
                            <input type="hidden" value="'.$person_company.'" id="person_company">
                            '.$button.'
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
    $post_id            = $_POST['post_id'];
    $posts_per_page     = $_POST['posts_per_page'];
    $person_name        = $_POST['person_name'];
    $person_image       = $_POST['person_image'];
    $person_position    = $_POST['person_position'];
    $person_company     = $_POST['person_company'];
    $term_value = get_the_terms( $post_id, $taxonomy );
    $get_posts = array();
    foreach($term_value as $term) {
        $post_args = array(
          'posts_per_page' => $posts_per_page,
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
                if($person_image === 'yes') { $content .= '<img src="'. $people_icon .'" alt="">'; }
                if($person_name === 'yes') { $content .= '<h3>'.$post->post_title.'</h3>'; }
                if($person_position === 'yes') { $content .= '<h4>'. $people_designation .'</h4>'; }
                if($person_company === 'yes') { $content .= '<p>'. $people_company->post_title .'</p>'; }
            $content .= '</div>';
            echo $content;
        }
    }
    wp_die();
}

//function to get videos.
function sigma_mt_get_videos($term_id, $posts_per_page) {
    $taxonomy = 'videos-cat';
    $post_type = 'video-items';
    $post_args = array(
      'posts_per_page' => $posts_per_page,
      'post_type' => $post_type,
      'orderby'        => 'ASC',
      'post_status'    => 'publish',
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

//Shortcode to get videos.
add_shortcode( 'sigma-mt-about-videos', 'sigma_mt_get_about_videos' );
function sigma_mt_get_about_videos($atts) {
    $value = shortcode_atts( array(
        'video_id'       => $atts['video_id'],
        'posts_per_page' => $atts['posts_per_page']
    ), $atts );
    $content = '';
    $term_id = $value['video_id'];
    $posts_per_page = $value['posts_per_page'];
    $get_videos = sigma_mt_get_videos($term_id, $posts_per_page);
    if(!empty($get_videos)) {
        foreach($get_videos as $k => $video) {
            $youtube_video_link = get_field('youtube_video_link',  $video->ID);
            if(!empty($youtube_video_link)) {
                $content .= '<iframe src="'.$youtube_video_link.'"></iframe>';
            }            
        }
    }
    return $content;
}

//function to get company term name
function sigma_mt_get_company_term($page_id) {
    $supported_by = array();
    $our_exhibitors_partners = array();
    $supported_by['Supported'] = get_field('supported_by', $page_id);
    $our_exhibitors_partners['Exabits'] = get_field('our_exhibitors_partners', $page_id);
    $result_array = array_merge($supported_by, $our_exhibitors_partners);
    /*$taxonomy = 'company-cat';
    $term_value = get_the_terms( $page_id, $taxonomy );*/
    return $result_array;
}

//Shortcode to get company.
add_shortcode( 'sigma-mt-company-lists', 'sigma_mt_get_company' );
function sigma_mt_get_company($atts) {
    $value = shortcode_atts( array(
        'term_id' => $atts
    ), $atts );
    $content = '';
    $taxonomy = 'company-cat';
    $post_type = 'company-items';
    $term_id = $value['term_id'];
    // Get term by id (''term_id'')
    $term_name = get_term_by('id', $term_id, $taxonomy);
    $supported_cat = __( 'Europe SUPPORTED', 'sigmaigaming' );
    $exibitors_cat = __( 'Exhibitors and Partners', 'sigmaigaming' );
    $sponsors_and_exhibitors = __( 'SPONSORS And EXHIBITORS', 'sigmaigaming' );
    $our_trusted_suppliers = get_field('our_trusted_suppliers');
    $our_trusted_suppliers_text = __( 'OUR TRUSTED SUPPLIERS', 'sigmaigaming' );
    if($term_name->name === $supported_cat) {
        $main_class = 'supported';
        $sub_class = 'supported-logo';
        $single_class = 'supported-single';
        $category_title = __( 'SUPPORTED BY', 'sigmaigaming' );
    } else if($term_name->name === $exibitors_cat) {
        $main_class = 'exhibitors';
        $sub_class = 'all-exhibitors';
        $single_class = 'single-exhibitor';
        $category_title = __( 'OUR EXHIBITORS & PARTNERS', 'sigmaigaming' );
    } else if($term_name->name === $sponsors_and_exhibitors) {
        $main_class = 'exhibitors';
        $sub_class = 'all-exhibitors';
        $single_class = 'single-exhibitor';
        $category_title = __( 'OUR SPONSORS & EXHIBITORS', 'sigmaigaming' );
    } else {
        $main_class = 'suppliers';
        $sub_class = 'supplier-logo';
        $single_class = 'supplier-single';
        $category_title = __( 'OUR TRUSTED SUPPLIERS', 'sigmaigaming' );
    }
    $post_args = array(
      'posts_per_page' => 10,
      'post_type' => $post_type,
      'orderby'        => 'DESC',
      'post_status'    => 'publish',
      'tax_query' => array(
              array(
                  'taxonomy' => $taxonomy,
                  'field' => 'term_id',
                  'terms' => $term_id,
              )
          )
    );
    $get_posts = get_posts($post_args);
    if(!empty($get_posts)) {
        $content .= '<section class="'.$main_class.'">
                        <div class="container">
                            <div class="about-section-title">
                                <h2>'. $category_title .'</h2>
                            </div>';
                            if(!empty($our_trusted_suppliers['trusted_splliers_text'])) {
                                $content .= '<div class="suplier-txt">
                                    <p>'.$our_trusted_suppliers['trusted_splliers_text'].'</p>
                                </div>';
                            }
                            $content .= '<div class="'.$sub_class.'">';
                                foreach($get_posts as $k => $post) {
                                    $company_details = get_field('company_details', $post->ID);
                                    $url = isset($company_details['company_url']['url']) ? $company_details['company_url']['url'] :'';
                                    $description = isset($company_details['description']) ? $company_details['description'] : '';
                                    //echo '<pre>'; print_r($company_details['description']); echo '</pre>';
                                    if(empty($description)) {
                                        $content .= '<div class="'.$single_class.'">';
                                            if(!empty($company_details)) { $content .= '<a href="'.$url.'" target="_blank"><img src="'. $company_details['company_logo'] .'"></a>'; }
                                        $content .= '</div>';
                                    }
                                }
                            $content .= '</div>';
                            if($term_name->name === $our_trusted_suppliers_text ) {
                                $content .= '<div class="single-logo-supply">';
                                    foreach($get_posts as $k => $post) {
                                        $company_details = get_field('company_details', $post->ID);
                                        $url = isset($company_details['company_url']['url']) ? $company_details['company_url']['url'] :'';
                                        $description = isset($company_details['description']) ? $company_details['description'] : '';
                                        if(!empty($description)) {
                                            $content .= '<div class="single-logo-supply">
                                                            <div class="single-supply">
                                                                <div class="supply-txt">
                                                                    <p>'.$description.'</p>
                                                                </div>
                                                                <div class="supplier-single">
                                                                    <a href="'.$url.'" target="_blank"><img src="'. $company_details['company_logo'] .'"></a>
                                                                </div>
                                                            </div>
                                                        </div>';
                                        }
                                    }
                                $content .= '</div>';
                            }
                    $content .= '</section>';
    }
    return $content;
}

//function to get sponsoring-items tags.
function sigma_mt_get_sponsoring_tags_data($tag_id, $taxonomy, $count) {
    $tag_data = array();
    $post_data = array();
    $tag_category = get_term_by('id', $tag_id, $taxonomy);
    if(isset($tag_id) && !empty($tag_id)) {
        $post_tag_args = array(
          'posts_per_page' => $count,
          'post_type' => 'sponsoring-items',
          'tax_query' => array(
              array(
                  'taxonomy' => $taxonomy,
                  'field' => 'term_id',
                  'terms' => $tag_id,
              )
          )
        );
    } else {
        $post_tag_args = array(
          'posts_per_page' => $count,
          'post_type' => 'sponsoring-items',
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

//Shortcode to get sponsoring-items top tab.
add_shortcode( 'sigma-mt-sponsors-top-tabs', 'sigma_mt_get_sponsors_top_tabs_data' );
function sigma_mt_get_sponsors_top_tabs_data($atts) {
    $content = '';
    $tag_data = array();
    $post_data = array();
    $tag_id = isset($atts['tag_id']) ? $atts['tag_id'] : '';
    $taxonomy = isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
    $count = isset($atts['count']) ? $atts['count'] : '';
    $tag_category = get_term_by('id', $tag_id, $taxonomy);
    if(isset($tag_id) && !empty($tag_id)) {
        $post_tag_args = array(
          'posts_per_page' => $count,
          'post_type' => 'sponsoring-items',
          'tax_query' => array(
              array(
                  'taxonomy' => $taxonomy,
                  'field' => 'term_id',
                  'terms' => $tag_id,
              )
          )
        );
    } else {
        $post_tag_args = array(
          'posts_per_page' => $count,
          'post_type' => 'sponsoring-items',
          'orderby'        => 'rand',
          'post_status'    => 'publish'
        );
    }
    $get_posts = get_posts($post_tag_args);
    if(!empty($get_posts)) {
        $content .= '<div class="wrapper">
                        <div class="toggle">
                            <h3>'.$tag_category->name.'</h3>
                            <div class="all-sell">
                                <p class="sell">
                                    <span style="color:#44c156;"><i class="fa fa-bookmark" aria-hidden="true"></i> '. __( 'Available', 'sigmaigaming' ).'</span>
                                    <span style="color:#ed1a3b;"><i class="fa fa-bookmark" aria-hidden="true"></i>  '.__( 'Sold Out', 'sigmaigaming' ).'</span>
                                </p>
                                <i class="fas fa-plus icon"></i>
                            </div>
                        </div>
                        <div class="content">
                            <div class="sponsor-boxes">';
                                foreach($get_posts as $k => $sponsoring) {
                                    $exhibit_details = get_field('exhibit_details', $sponsoring->ID);
                                    $sponsors_logo = isset($exhibit_details['sponsers_icon']) ? $exhibit_details['sponsers_icon'] : '';
                                    $sponsors_amount = isset($exhibit_details['amount']) ? $exhibit_details['amount'] : '';
                                    $sponsors_count = isset($exhibit_details['sponsors_count']) ? $exhibit_details['sponsors_count'] : '';
                                    $term_obj_list = get_the_terms( $sponsoring->ID, 'sponsoring-tag' );
                                    $sponsors_status = $term_obj_list[0]->name;                                    
                                    $available = __( 'Available', 'sigmaigaming' );
                                    $sold_out = __( 'Sold Out', 'sigmaigaming' );
                                    if($sponsors_status === $sold_out) {
                                        $class = 'sold';
                                        $image = '<img src="'.CHILD_DIR.'/exhibit/images/SOLD-OUTv1.png" alt="" class="soldout">';
                                    } else {
                                        $image = '';
                                        $class = '';
                                    }
                                    $content .= '<div class="single-sponsor" id="sponsorPopup'.$sponsoring->ID.'" onclick="openModal(\'sponsorPopup'.$sponsoring->ID.'\', \'sponsorContent'.$sponsoring->ID.'\', \'closeSponsor'.$sponsoring->ID.'\')">
                                                      <div class="top">
                                                        <img src='.$sponsors_logo.' alt="">
                                                        '.$image.'
                                                        <h4>'.$sponsoring->post_title.'</h4>
                                                      </div>
                                                      <div class="bottom '.$class.'">
                                                        <span class="prcie">'.$sponsors_amount.'</span>
                                                        <span class="status">'.$sponsors_count.'</span>
                                                      </div>
                                                </div>
                                                <!-- The Modal -->
                                                <div id="sponsorContent'.$sponsoring->ID.'" class="modal">
                                                    <!-- Modal content -->
                                                    <div class="modal-content">
                                                        <span class="close" id="closeSponsor'.$sponsoring->ID.'">&times;</span>
                                                        <h4>'.$sponsoring->post_title.'</h4>';
                                                        $sponsors_gallery = $exhibit_details['sponsers_gallery'];
                                                        if(!empty($sponsors_gallery)) {
                                                            $content .= '<div class="sponsors_gallery">';
                                                                foreach($sponsors_gallery as $image) {
                                                                    $content .= '<img src="'.$image.'">';
                                                                }
                                                            $content .= '</div>';
                                                        }
                                                        if(!empty($sponsoring->post_content)) {
                                                            $content .='<div class="post_content">'.$sponsoring->post_content.'</div>';
                                                        }
                                                        if(!empty($sponsors_amount)) {
                                                            $content .='<div class="bottom '.$class.'">
                                                                <span class="prcie">'.$sponsors_amount.'</span>
                                                                <span class="status">'.$sponsors_count.'</span>
                                                            </div>';
                                                        }
                                                    $content .= '</div>
                                                </div>';
                                }
                            $content .= '</div>
                        </div>
                    </div>';
    }
    return $content;
}

//Shortcode to get sponsoring-items bottom tab.
add_shortcode( 'sigma-mt-sponsors-bottom-tabs', 'sigma_mt_get_sponsors_bottom_tabs_data' );
function sigma_mt_get_sponsors_bottom_tabs_data($atts) {
    ob_start();
    $content = '';
    $tag_data = array();
    $post_data = array();
    $tag_id = isset($atts['tag_id']) ? $atts['tag_id'] : '';
    $taxonomy = isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
    $count = isset($atts['count']) ? $atts['count'] : '';
    $tag_category = get_term_by('id', $tag_id, $taxonomy);
    $split_text = explode(" ", $tag_category->name);
    if(isset($tag_id) && !empty($tag_id)) {
        $post_tag_args = array(
          'posts_per_page' => $count,
          'post_type' => 'sponsoring-items',
          'tax_query' => array(
              array(
                  'taxonomy' => $taxonomy,
                  'field' => 'term_id',
                  'terms' => $tag_id,
              )
          )
        );
    } else {
        $post_tag_args = array(
          'posts_per_page' => $count,
          'post_type' => 'sponsoring-items',
          'orderby'        => 'rand',
          'post_status'    => 'publish'
        );
    }
    $get_posts = get_posts($post_tag_args);
    if(!empty($get_posts)) {
        $content .= '<div class="wrapper">
                        <div class="toggle">
                            <h3>'.$tag_category->name.'</h3>
                            <div class="all-sell">
                                <p class="sell">
                                    <span style="color:#44c156;"><i class="fa fa-bookmark" aria-hidden="true"></i> '. __( 'Available', 'sigmaigaming' ).'</span>
                                    <span style="color:#ed1a3b;"><i class="fa fa-bookmark" aria-hidden="true"></i>  '.__( 'Sold Out', 'sigmaigaming' ).'</span>
                                </p>
                                <i class="fas fa-plus icon"></i>
                            </div>
                        </div>
                        <div class="content">
                            <div class="all-workshops">';
                                $counter = 0;
                                $total_sponsors = count($get_posts);
                                foreach($get_posts as $k => $sponsoring) {
                                    $exhibit_details = get_field('exhibit_details', $sponsoring->ID);
                                    $sponsors_logo = isset($exhibit_details['sponsers_icon']) ? $exhibit_details['sponsers_icon'] : '';
                                    $sponsors_amount = isset($exhibit_details['amount']) ? $exhibit_details['amount'] : '';
                                    $sponsors_count = isset($exhibit_details['sponsors_count']) ? $exhibit_details['sponsors_count'] : '';
                                    $sponsors_gallery = isset($exhibit_details['sponsers_gallery']) ? $exhibit_details['sponsers_gallery'] : '';
                                    $term_obj_list = get_the_terms( $sponsoring->ID, 'sponsoring-tag' );
                                    $sponsors_status = isset($term_obj_list[0]->name) ? $term_obj_list[0]->name : '';
                                    $available = __( 'Available', 'sigmaigaming' );
                                    $sold_out = __( 'Sold Out', 'sigmaigaming' );
                                    if($sponsors_status === $sold_out) {
                                        $class = 'disable';
                                    } else {
                                        $class = 'active';
                                    }
                                    $counter++;
                                    if ($total_sponsors % 2 == 0)  {
                                        $class = 'double-line';
                                    }
                                    $content .= '<div class="double-line">
                                                    <div class="single-workshop" id="sponsorPopup'.$sponsoring->ID.'" onclick="openModal(\'sponsorPopup'.$sponsoring->ID.'\', \'sponsorContent'.$sponsoring->ID.'\', \'closeSponsor'.$sponsoring->ID.'\')">
                                                        <div class="label">
                                                            <span>'.$split_text[0].'</span>
                                                        </div>
                                                        <div class="work-content">
                                                            <h5>'.$sponsoring->post_title.'</h5>
                                                            <div class="amount">
                                                                <h3>'.$sponsors_amount.'</h3>
                                                                <span class="status">'.$sponsors_count.'</span>
                                                            </div>
                                                        </div>
                                                        <div class="pop-icons">
                                                            <div class="ribbon '.$class.'">
                                                                <i class="fa fa-bookmark" aria-hidden="true"></i>
                                                            </div>
                                                            <div class="open-arrow">
                                                                <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- The Modal -->
                                                <div id="sponsorContent'.$sponsoring->ID.'" class="modal">
                                                    <!-- Modal content -->
                                                    <div class="modal-content">
                                                        <span class="close" id="closeSponsor'.$sponsoring->ID.'">&times;</span>
                                                        <h4>'.$sponsoring->post_title.'</h4>';
                                                        if(!empty($sponsors_gallery)) {
                                                            $content .= '<div class="sponsors_gallery">';
                                                                foreach($sponsors_gallery as $image) {
                                                                    $content .= '<img src="'.$image.'">';
                                                                }
                                                            $content .= '</div>';
                                                        }
                                                        if(!empty($sponsoring->post_content)) {
                                                            $content .='<div class="post_content">'.$sponsoring->post_content.'</div>';
                                                        }
                                                        if(!empty($sponsors_amount)) {
                                                            $content .='<div class="bottom '.$class.'">
                                                                <span class="prcie">'.$sponsors_amount.'</span>
                                                                <span class="status">'.$sponsors_count.'</span>
                                                            </div>';
                                                        }
                                                    $content .='</div>
                                                </div>
                                                <!-- The Modal End -->';

                                }
                            $content .= '</div>
                        </div>
                    </div>';
    }
    $content .= ob_get_clean();
    return $content;
}