<?php
define( 'CHILD_DIR', get_theme_file_uri() );
define( 'PARENT_DIR', get_stylesheet_directory_uri() );
define( 'SITE_URL', site_url() );

require_once get_stylesheet_directory().'/cpt-functions.php';
require_once get_stylesheet_directory().'/class/class-custom-widget.php';

add_action( 'wp_enqueue_scripts', 'sigma_mt_enqueue_styles', PHP_INT_MAX);
function sigma_mt_enqueue_styles() {
    $parent_style = 'adforest-style'; // This is 'adforest-style' for the AdForest theme.
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );   
    wp_enqueue_style('sigmamt-responsive', CHILD_DIR . '/assets/css/responsive.css');
    wp_enqueue_style('sigmamt-slick', CHILD_DIR . '/assets/css/slick.css');
    wp_enqueue_style('sigmamt-slick-theme', CHILD_DIR . '/assets/css/slick-theme.css');
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
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
  	wp_enqueue_script( 'jquery-ui-datepicker' );    
    wp_enqueue_script('sigmamt-main-script', CHILD_DIR . '/assets/js/custom.js', array(), '1.0.0', true );    
    wp_enqueue_script('sigmamt-slick-script', CHILD_DIR . '/assets/js/slick.min.js', array(), '1.0.0', true );

    /****Autocomplete script ****/
    /*wp_enqueue_script('autocomplete-search', get_stylesheet_directory_uri() . '/assets/js/autocomplete.js', 
        ['jquery', 'jquery-ui-autocomplete'], null, true);*/
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

//Shortcode to newsletter
add_shortcode( 'sigma-mt-newsletter', 'sigma_mt_newsletter' );
function sigma_mt_newsletter() {
    $output = '';
    $bg_image = get_field('newsletter_background_image', 'option');
    $newsletter_form_id = get_field('newsletter_form_shortcode', 'option');
    $shortcode = do_shortcode( '[wpforms id = '.$newsletter_form_id.']' );
    $output .='<div class="newsletter" style="background: url('.$bg_image.')">
                <div class="container">
                    <div class="newsletter-inner">
                        <h4>'.get_field('newsletter_title', 'option').'</h4>
                        <div class="newsletter-form">';
                            //$output .= '[wpforms id = "'.$newsletter_form_id.'"]
                        $output .= $shortcode;
                        $output .= '</div>
                        <p>'.get_field('newsletter_sub_text', 'option').'</p>
                    </div>
                </div>
            </div>';
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
        $sorting_order_asia     = 0;
        $sorting_order_europe   = 1;
        $sorting_order_americas = 2;
        $sorting_order_africa   = 3;
    } elseif ($continents === $europe ) {
        $sorting_order_europe   = 0;
        $sorting_order_asia     = 1;
        $sorting_order_americas = 2;
        $sorting_order_africa   = 3;
    } elseif ($continents === $americas) {
        $sorting_order_americas = 0;
        $sorting_order_europe   = 1;
        $sorting_order_asia     = 2;
        $sorting_order_africa   = 3;
    } elseif ($continents === $africa) {
        $sorting_order_africa   = 0;
        $sorting_order_americas = 1;
        $sorting_order_europe   = 2;
        $sorting_order_asia     = 3;
    } else {
        $sorting_order_europe   = 0;
        $sorting_order_asia     = 1;
        $sorting_order_americas = 2;
        $sorting_order_africa   = 3;
    }
    $order = require_once get_stylesheet_directory().'/home/home-news.php';
    return $order;
}

//function to get news tags.
function sigma_mt_get_casino_provider_data($term_id = "", $posts_per_page = "") {
    if(!empty($term_id)) {
        $post_tag_args = array(
            'posts_per_page' => $posts_per_page,
            'post_type' => 'casinos-items',
            'orderby'        => 'DESC',
            'post_status'    => '',
            'paged'          => 1,
            'tax_query' => array(
                array(
                  'taxonomy' => 'casinos-cat',
                  'field' => 'term_id',
                  'terms' => $term_id,
                )
            )
        );
    } else {
        $post_tag_args = array(
          'posts_per_page' => 10,
          'post_type' => 'casinos-items',
          'orderby'        => 'ASC',
        );
    }
    $get_posts = get_posts($post_tag_args);
    return $get_posts;
}

// Shortcode for casino providers
add_shortcode( 'sigma-mt-casino-providers', 'sigma_mt_casino_providers' );
function sigma_mt_casino_providers($atts) {
    $content = '';
    $term_id = isset($atts['term_id']) ? $atts['term_id'] : '';
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : '';
    $appearance = isset($atts['appearance']) ? $atts['appearance'] : '';
    $results =  sigma_mt_get_casino_provider_data($term_id, $count);
    if(!empty($results)) {
        $content .= '<div class="all-casinos '.$appearance.'">';
                        foreach($results as $k => $post) {
                            setup_postdata( $post );
                            $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                            $casino_provider = get_field('casino_details', $post->ID);
                            $content .= '<div class="single-casino">
                                            <div class="casino-logo">
                                                <img src="'.$casino_provider['casino_logo'].'" alt="">
                                            </div>
                                            <div class="casino-star-rating">
                                                <div class="start-rating">';
                                                    if(isset($casino_provider['star_rating_count']) && !empty($casino_provider['star_rating_count'])) {
                                                        $count = $casino_provider['star_rating_count'];
                                                    } else {
                                                        $count = '3';
                                                    }
                                                    $args = array(
                                                       'rating' => $count,
                                                       'type' => 'rating',
                                                       'number' => 12345,
                                                    );
                                                    $rating = wp_star_rating($args);
                                                    $content .= $rating;
                                    $content .= '</div>
                                            </div>
                                            <div class="casino-bonus">
                                                <img src="'. CHILD_DIR . '/online-casinos/images/Icon-Present.png" alt="">
                                                <p>'.$casino_provider['exclusive_bonus'].'</p>
                                            </div>
                                            <div class="casino-bonus-details">
                                                <ul>';
                                                    if(isset($casino_provider['online_casino_bonus_detail'])) { 
                                                        foreach($casino_provider['online_casino_bonus_detail'] as $value) {
                                                            $content .= '<li>'.$value['bonus_details'].'</li>';
                                                        }
                                                    }
                                                $content .= '</ul>
                                            </div>
                                            <div class="casino-buttons">
                                                <a href="#" class="play">'.__( 'Play', 'sigmaigaming' ).'</a>
                                                <a href="'.get_permalink( $post->ID ).'" class="review">'. __( 'Review', 'sigmaigaming' ).'</a>
                                            </div>
                                            <div class="payment-options">';
                                                if(isset($casino_provider['payment_options'])) { 
                                                    foreach($casino_provider['payment_options'] as $value) {
                                                        $visa = __( 'Visa', 'sigmaigaming' );
                                                        $mastercard = __( 'Mastercard', 'sigmaigaming' );
                                                        $neteller =__( 'Neteller', 'sigmaigaming' );
                                                        $skrill = __( 'Skrill', 'sigmaigaming' );
                                                        $mestrocard = __( 'Mestrocard', 'sigmaigaming' );
                                                        $paypal = __( 'Paypal', 'sigmaigaming' );
                                                        $bitcoin =__( 'Bitcoin', 'sigmaigaming' );
                                                        $ecopayz = __( 'Ecopayz', 'sigmaigaming' );
                                                        $content .= '<div class="single-option">';
                                                            if($value === $visa) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/VISA-new-logo.png">';
                                                            if($value === $mastercard) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/mastercard.png">';
                                                            if($value === $neteller) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/Neteller.png">';
                                                            //if($value === $payeer) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/Payeer.png">';
                                                            if($value === $bitcoin) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/Bitcoin.png">';
                                                            //if($value === $ecopays) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/Ecopayz.png">';
                                                            //if($value === $webpay) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/Webpay logo.png">';
                                                            //if($value === $epay) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/Epay logo.png">';
                                                        $content .= '</div>';
                                                    }
                                                }
                                            $content .= '</div>
                                        </div>';
                        }
                    $content .= '</div>';
    }
    return $content;
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
    $term_id = $atts['term_id'];
    $appearance = $atts['appearance'];
    $posts_per_page = isset($atts['posts_per_page']) ? $atts['posts_per_page'] : '-1';
    $colorClass = isset($atts['color']) ? $atts['color'] : '';
    $sort_order = isset($atts['sort_order']) ? $atts['sort_order'] : '';
    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
    $speakers_text = get_field('speakers_text');
    $appearance         = isset($atts['appearance']) ? $atts['appearance'] : __( 'Default', 'sigmaigaming' );
    $person_name        = isset($atts['person_name']) ? $atts['person_name'] : NULL;
    $person_image       = isset($atts['person_image']) ? $atts['person_image'] : NULL;
    $person_position    = isset($atts['person_position']) ? $atts['person_position'] : NULL;
    $person_company     = isset($atts['person_company']) ? $atts['person_company'] : NULL;
    $person_language    = isset($atts['person_language']) ? $atts['person_language'] : NULL;
    $person_email       = isset($atts['person_email']) ? $atts['person_email'] : NULL;
    $person_phone       = isset($atts['person_phone']) ? $atts['person_phone'] : NULL;
    $person_skype       = isset($atts['person_skype']) ? $atts['person_skype'] : NULL;
    $telegram       = isset($atts['telegram']) ? $atts['telegram'] : 'no';
    $fullclass          = isset($atts['fullclass']) ? $atts['fullclass'] : '';
    $load_more = __( 'Load More', 'sigmaigaming' );
    $tag_category = get_term_by('id', $term_id, $taxonomy);
    $term_name = $tag_category->name;
    $hosts = get_field('hosts');
    $judges = get_field('judges');
    $our_experts = get_field('our_experts');
    
    $appearanceExhibit = __( 'Exhibit', 'sigmaigaming' );
    $appearanceRegular = __( 'Regular', 'sigmaigaming' );
    $appearanceHost = __( 'Host', 'sigmaigaming' );
    $appearanceJudge = __( 'Judge', 'sigmaigaming' );
    $appearanceHostJudge = __( 'Hosts and Judges', 'sigmaigaming' );
    $appearanceExperts = __( 'Experts', 'sigmaigaming' );
    $appearanceInvestors = __( 'Investors', 'sigmaigaming' );
    $appearanceSponsorsExhabitors = __( 'SponsorsExhabitors', 'sigmaigaming' );
    $appearanceDefault = __( 'Default', 'sigmaigaming' );
    
    //if ( is_page( array( 'exhibit') ) ) {
        
    // Exhibit Appearance
    if($appearance == $appearanceExhibit){
        $main_class = 'contact-us';
        $sub_class = 'all-person';
        $single_class = 'single-person';
        $heading = __( 'CONTACT US', 'sigmaigaming' );
        $button = '';
        $desc = '';
        
    //} else if($appearance === $appearanceVal) {
    // Regular Appearance
    } else if($appearance == $appearanceRegular){
        $main_class = 'speakers';
        $sub_class = 'all-speakers';
        $single_class = 'single-speaker';
        $heading = isset($speakers_text['speaker_title']) ? $speakers_text['speaker_title'] : '';
        $button = '<div class="load-people"><button class="load-more" id="load-more">'.$load_more.'</button></div></div>';
        $desc = isset($speakers_text['speaker_text']) ? $speakers_text['speaker_text'] : '';
    //} else if (!empty($hosts['title']) && $term_name === $hosts['title'] || $appearance === $appearanceHJVal) {
    // Host Appearance
    } else if($appearance == $appearanceHost ||$appearance == $appearanceHostJudge){
        $main_class = 'hosts';        
        $heading = isset($hosts['title']) ? $hosts['title'] : '';
        $sub_class = 'person-item';
        $button = '';
        $desc = '';
    //} else if (!empty($our_experts['title']) && $term_name === $our_experts['title']) {
    // Experts Appearance
    } else if($appearance == $appearanceExperts){
        $main_class = 'our-experts';        
        $heading = $our_experts['title'];
        $sub_class = 'all-experts expert-slider';
        $button = '';
        $desc = '';
    // } else if($term_id === '1191') {
    // Investors Appearance
    } else if($appearance == $appearanceInvestors){
        $main_class = 'meet-investor';        
        $heading = '';
        $sub_class = 'all-experts investor-slider';
        $single_class = 'investor-slide';
        $button = '';
        $desc = '';
    // Judge Appearance
    } else if($appearance == $appearanceJudge){
        $main_class = 'judges';        
        $heading = isset($judges['title']) ? $judges['title'] : '';
        $sub_class = 'all-judges';
        $button = '';
        $desc = isset($judges['description']) ? $judges['description'] : '';
    // Default Appearance
    } else if($appearance == $appearanceDefault){
        $main_class = 'judges';        
        $heading = isset($judges['title']) ? $judges['title'] : '';
        $sub_class = 'all-judges';
        $button = '';
        $desc = isset($judges['description']) ? $judges['description'] : '';
    } else if($appearance == $appearanceSponsorsExhabitors){
        $main_class = 'sponsors-and-exibitors-wrapper';        
        $heading = '';
        $sub_class = 'db-items-wrapper';
        $button = '';
        $desc = '';
    }

    if($fullclass === 'YES') {
        $fullclass = 'full';
    } else {
        $fullclass = '';
    }

    $get_posts = array();
    //$term_id = explode(',', $term_id);
    if(!empty($term_id)) {
        $post_args = array(
            'posts_per_page' => $posts_per_page,
            'post_type' => $post_type,
            'orderby'        => 'DESC',
            'post_status'    => '',
            'paged'          => 1,
            'tax_query' => array(
                array(
                  'taxonomy' => $taxonomy,
                  'field' => 'term_id',
                  'terms' => explode(',', $term_id),
                )
            ),
            'order'   => $sort_order,
            'orderby'        => $orderby,
        );
        $get_posts = get_posts($post_args);
    } else {
        $post_args = array(
          'posts_per_page' => $posts_per_page,
          'post_type' => $post_type,
          'orderby'        => 'DESC',
          'post_status'    => 'publish',
          'paged' => 1,
          'order'   => $sort_order,
          'orderby'        => $orderby,
        );
        $get_posts = get_posts($get_posts);
    }
    //echo '<pre>'; print_r($post_args); echo '</pre>';
    if(!empty($get_posts)) {
        $content .= '<section class="'.$main_class.' '.$colorClass.'"">
                        <div class="container">
                            <div class="about-section-title">
                                <h2>'.$heading.'</h2>
                                <p>'.$desc.'</p>
                            </div>
                            <div class="'.$sub_class.'">';
        foreach($get_posts as $k => $post) {
            $title = $post->post_title;
            $people_icon = get_field('image_icon', $post->ID);
            $people_designation = get_field('designation', $post->ID);
            $person_email_val = get_field('email', $post->ID);
            $person_phone_no = get_field('telephone_number', $post->ID);
            $person_skype_id = get_field('skype_id', $post->ID);
            $person_telgram = get_field('telegram', $post->ID);
            $person_website = get_field('website', $post->ID);
            $language_icon = get_field('language_icon', $post->ID);
            $people_company = $companyObjectID = get_field('company', $post->ID);
            $companyLogo = get_field('company_details', $companyObjectID);
            if(!empty($companyLogo)) {
                $companyLogo = $companyLogo['company_logo'];
            } else {
                $companyLogo = '';
            }
            if($appearance === $appearanceRegular) {
                $content .= '<div class="'.$single_class.'">';
                    if($person_image === 'YES' && !empty($people_icon)) { $content .= '<img src="'. $people_icon .'" alt="">'; }
                    if($person_name === 'YES' && !empty($title)) { $content .= '<h3>'.$post->post_title.'</h3>'; }
                    if($person_position === 'YES' && !empty($people_designation)) { $content .= '<p class="designation">'. $people_designation .'</p>'; }
                    if($person_company === 'YES' && !empty($people_company)) { $content .= '<p>'. get_the_title($companyObjectID) .'</p>'; }
                    if($person_language === 'YES' && !empty($language_icon)) { 
                        $content .= '<div class="lang">';
                                        foreach($language_icon as $icon) {
                                            $content .= '<img src="'.$icon.'" alt="">';
                                        }
                                    $content .= '</div>'; 
                    }
                    $content .= '<div class="person-social">';
                                    if($person_email === 'YES' && !empty($person_email_val)) { $content .= '<p><span>E:</span> <a href="mailto:'.$person_email_val.'"><i class="fa fa-envelope" aria-hidden="true"></i>'.$person_email_val.'</a></p>'; }
                                    if($person_phone === 'YES' && !empty($person_phone_no)) { $content .= '<p><span>T:</span> <a href="tel:'.$person_phone_no.'"><i class="fa fa-phone" aria-hidden="true"></i>'.$person_phone_no.'</a></p>'; }
                                    if($person_skype === 'YES' && !empty($person_skype_id)) { $content .= '<p><span>S:</span> <a href="skype:'.$person_skype_id.'?call"><i class="fab fa-skype"></i>'.$person_skype_id.'</a></p>'; }
                                    if($telegram === 'YES' && !empty($person_telgram)) { $content .= '<p><span>Telegram:</span> <a href="skype:'.$person_telgram.'?call"><i class="fab fa-telegram" aria-hidden="true"></i>'.$person_telgram.'</a></p>'; }
                                $content .= '</div>';
                $content .= '</div>';
            } else if ($appearance === $appearanceHost) {
                $content .= '<div id="item'.$post->ID.'" class="person-item-inner">
                                <div class="person-left">
                                     <div class="person-avatar-img">';
                                        if($person_image === 'YES' && !empty($people_icon)) { $content .= '<img src="'. $people_icon .'" alt="">'; }
                                        if(!empty($post->post_content)) {
                                            $content .= '<div class="person-btn" onclick="openHostsDiv(\'item'.$post->ID.'\')">
                                                            <div></div>
                                                        </div>';
                                        }
                                    $content .= '</div>
                                    <div class="person-detail">
                                        <h3>'.$post->post_title.'</h3>
                                        <h4>'.$people_designation.'</h4>
                                    </div>
                                </div>
                                <div class="person-right">
                                    <p>'.$post->post_content.'</p>
                                </div>
                            </div>';
            } else if ($appearance === $appearanceExperts) {
                $content .= '<div class="expert-slide">
                                <div class="expert-box">
                                    <div class="expert-img">';
                                        if($person_image === 'YES' && !empty($people_icon)) { $content .= '<img src="'. $people_icon .'" alt="">'; }
                                    $content .= '</div>
                                    <div class="expert-info">
                                        <div class="expert-info">';
                                            if(!empty($companyLogo)) {
                                                $content .= '<div class="expert-logo">
                                                    <img src="'.$companyLogo.'" alt="">
                                                </div>';
                                            }
                                            $content .= '<h2>'.$post->post_title.'</h2>
                                            <h3>'.$people_designation.'</h3>
                                        </div>';
                                    $content .= '</div>
                                </div>
                            </div>';
            } else if($appearance === $appearanceHostJudge) {
                $content .= '<div id="item'.$post->ID.'" class="person-item-inner">
                                <div class="person-left">
                                     <div class="person-avatar-img">';
                                        if($person_image === 'YES' && !empty($people_icon)) { $content .= '<img src="'. $people_icon .'" alt="">'; }
                                        if(!empty($post->post_content)) {
                                            $content .= '<div class="person-btn" onclick="openHostsDiv(\'item'.$post->ID.'\')">
                                                            <div></div>
                                                        </div>';
                                        }
                                    $content .= '</div>
                                    <div class="person-detail">
                                        <h3>'.$post->post_title.'</h3>
                                        <h4>'.$people_designation.'</h4>
                                    </div>
                                </div>
                                <div class="person-right">
                                    <p>'.$post->post_content.'</p>
                                </div>
                            </div>';
            } else if($appearance == $appearanceInvestors) {
                $content .= '<div class="investor-slide"><div class="investor-box">
                                <div class="investor-img">';
                                    if($person_image === 'YES' && !empty($people_icon)) { $content .= '<img src="'. $people_icon .'" alt="">'; }
                                $content .= '</div>
                                <div class="investor-info">';
                                    if(!empty($companyLogo)) {
                                        $content .= '<div class="investor-logo">
                                            <img src="'.$companyLogo.'" alt="">
                                        </div>';
                                    }
                                    $content .= '<h2>'.$post->post_title.'</h2>';
                                    if($person_position === 'YES' && !empty($people_designation)) { 
                                        $content .= '<div class="desc"><h3>'. $people_designation .'</h3></div>'; 
                                    }
                                $content .= '</div></div>
                            </div>';
            } else if($appearance == $appearanceDefault || $appearance == $appearanceExhibit || $appearance == $appearanceJudge) {
                $content .= '<div class="judge-box">
                                <div class="judge-img">';
                                    if($person_image === 'YES' && !empty($people_icon)) { $content .= '<img src="'. $people_icon .'" alt="">'; }
                                $content .= '</div>
                                <div class="judge-info">';
                                    if(!empty($companyLogo)) {
                                        $content .= '<div class="expert-logo">
                                            <img src="'.$companyLogo.'" alt="">
                                        </div>';
                                    }
                                    $content .= '<h2>'.$post->post_title.'</h2>';
                                    if($person_company === 'YES' && !empty($people_company)) { 
                                        $content .= '<div class="desc">
                                        <p>'. get_the_title($companyObjectID) .'</p>'; 
                                    }
                                    if($person_position === 'YES' && !empty($people_designation)) { 
                                        $content .= '<h3>'. $people_designation .'</h3>'; 
                                    }
                                $content .= '</div></div>
                            </div>';
            } else if($appearance == $appearanceSponsorsExhabitors) {
                $content .= '<div id="" class="single-sponsors-exhibitors'.$post->ID.' item '.$fullclass.'">';
                                if($fullclass === '') {
                                    $content .= '<div class="btn" onclick="openSponsorsExhibitors(\'single-sponsors-exhibitors'.$post->ID.'\')">
                                                    <div></div>
                                                </div>';
                                }
                                $content .= '<div class="left">';
                                    if(!empty($companyLogo)) {
                                        $content .= '<div class="img-wrapper">
                                            <img src="'.$companyLogo.'" alt="">
                                        </div>';
                                    }
                                    if($person_image === 'YES' && !empty($people_icon)) { 
                                            $content .= '<div class="avatar" style="background-image: url('.$people_icon.')"></div>                                                                    <h4>'.get_the_title($people_company).'</h4>';
                                    }
                                $content .= '</div>';
                                $content .= '<div class="right">
                                    <div class="top">
                                        <div class="website">
                                            <span>Website</span>
                                            <a href="'.$person_website.'" target="_blank">'.$person_website.'</a>
                                        </div>';
                                        if($person_email === 'YES' && !empty($person_email_val)) { 
                                            $content .= '<div class="emial">
                                                            <span>Email</span>
                                                            <a href="mailto:'.$person_email_val.'" target="_blank">'.$person_email_val.'</a>
                                                        </div>'; 
                                        }
                                    $content .= '</div>
                                    <div class="widget-type-rich_text">
                                         <p>'.$post->post_content.'</p>
                                    </div>
                                </div>
                            </div>';
            }
        }
    $content .= '</div>
    <input type="hidden" value="'.$term_id.'" id="termID">
    <input type="hidden" value="'.$posts_per_page.'" id="posts_per_page">
    <input type="hidden" value="'.$person_image.'" id="person_image">
    <input type="hidden" value="'.$person_name.'" id="person_name">
    <input type="hidden" value="'.$person_position.'" id="person_position">
    <input type="hidden" value="'.$person_company.'" id="person_company">';
    if ( is_page( array( 'europe') ) ) {
        $content .= ''.$button.'';
    }
    $content .= '</section>';
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
    $term_id            = $_POST['term_id'];
    $posts_per_page     = $_POST['posts_per_page'];
    $person_name        = $_POST['person_name'];
    $person_image       = $_POST['person_image'];
    $person_position    = $_POST['person_position'];
    $person_company     = $_POST['person_company'];
    $get_posts = array();
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
                  'terms' => $term_id
              )
          )
    );
    $get_posts = get_posts($post_args);
    if(!empty($get_posts)) {
        foreach($get_posts as $k => $post) {
            $title = $post->post_title;
            $people_icon = get_field('image_icon', $post->ID);
            $people_designation = get_field('designation', $post->ID);
            $people_company = get_field('company', $post->ID);
            $content .= '<div class="single-speaker">';
                if($person_image === 'YES') { $content .= '<img src="'. $people_icon .'" alt="">'; }
                if($person_name === 'YES') { $content .= '<h3>'.$post->post_title.'</h3>'; }
                if($person_position === 'YES') { $content .= '<h4>'. $people_designation .'</h4>'; }
                if($person_company === 'YES') { $content .= '<p>'. get_the_title($people_company) .'</p>'; }
            $content .= '</div>';
            echo $content;
        }
    }
    wp_die();
}

//function to get videos.
function sigma_mt_get_videos($term_id, $posts_per_page, $appearance = '') {
    $taxonomy = 'videos-cat';
    $post_type = 'video-items';
    if(!empty($term_id)){
        if(!empty($appearance)) {
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
        } else {
            $post_args = array( 
                'posts_per_page' => $posts_per_page,
                'post_type' => $post_type,
                'orderby'        => 'DESC',
                'post_status'    => 'publish',
            );
            $get_posts = get_posts($post_args);
        }
    } else {
        if(!empty($appearance)) {
            if($appearance === 'SIGMATV' ) {
                $post_args = array( 
                    'posts_per_page' => $posts_per_page,
                    'post_type' => $post_type,
                    'orderby'        => 'DESC',
                    'post_status'    => 'publish',
                );
                $get_posts = new WP_Query($post_args);
            } else {
                $post_args = array( 
                    'posts_per_page' => $posts_per_page,
                    'post_type' => $post_type,
                    'orderby'        => 'DESC',
                    'post_status'    => 'publish',
                );
                $get_posts = get_posts($post_args);
            }
        }
    }
    return $get_posts;
}

//Shortcode to get videos.
add_shortcode( 'sigma-mt-about-videos', 'sigma_mt_get_about_videos' );
function sigma_mt_get_about_videos($atts) {
    $value = shortcode_atts( array(
        'term_id'       => isset($atts['term_id']) ? $atts['term_id'] : '',
        'posts_per_page' => isset($atts['posts_per_page']) ? $atts['posts_per_page'] : '10',
        'appearance' => isset($atts['appearance']) ? $atts['appearance'] : '',
    ), $atts );
    $content = '';
    $appearanceVal = __( 'Grid', 'sigmaigaming' );
    $term_id = $value['term_id'];
    $posts_per_page = $value['posts_per_page'];
    $posts_by_year = [];
    $get_videos = sigma_mt_get_videos($term_id, $posts_per_page, $value['appearance']);
    if(!empty($get_videos)) {
        if($value['appearance'] === 'SIGMATV') {
            if ($get_videos->have_posts()) {
                while ($get_videos->have_posts()) {
                    $get_videos->the_post();
                    $year = get_the_date('Y');
                    $youtube_video_link = get_field('youtube_video_link',  get_the_ID());
                    $year = get_the_date('Y');
                    $posts_by_year[$year][] = ['ID' => get_the_ID(), 'title' => get_the_title(), 'link' => get_the_permalink(), 'Year' => $year,];
                }
            }
            foreach($posts_by_year as $posts) {
                $content .= '<h2 class="elementor-heading-title sigma-tv-page">SIGMA TV '.$posts[0]['Year'].'</h2>';
                foreach($posts as $post) {
                    $youtube_video_link = get_field('youtube_video_link',  $post['ID']);
                    $content .= '<div class="video-grid">
                                    <h3 class="">'.$post['title'].'</h3>
                                    <iframe src="'.$youtube_video_link.'"></iframe>
                                </div>';
                }
            }
        } else if($value['appearance'] === 'slider') {
            $content .= '<section class="video slider">
                            <div class="container">
                                <div class="video-slider">';
                                    foreach($get_videos as $k => $video) {
                                        $youtube_video_link = get_field('youtube_video_link',  $video->ID);
                                         $content .= '<div class="video-single">
                                                        <iframe src="'.$youtube_video_link.'" width="560" height="315" data-service="youtube" allowfullscreen="1"></iframe>
                                                      </div>';     
                                    }
                                $content .= '</div>
                            </div>
                        </section>';
        } else {
            foreach($get_videos as $k => $video) {
                $youtube_video_link = get_field('youtube_video_link',  $video->ID);
                if(!empty($value['appearance']) && $value['appearance'] === $appearanceVal) {
                    
                    $content .= '<div class="video-grid">
                                    <h3 class="">'.$video->post_title.'</h3>
                                    <iframe src="'.$youtube_video_link.'"></iframe>
                                </div>';
                } else {
                    if(!empty($youtube_video_link)) {
                        $content .= '<iframe src="'.$youtube_video_link.'"></iframe>';
                    }
                }      
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
    $our_exhibitors_partners['Exhibits'] = get_field('our_exhibitors_partners', $page_id);
    $result_array = array_merge($supported_by, $our_exhibitors_partners);
    /*$taxonomy = 'company-cat';
    $term_value = get_the_terms( $page_id, $taxonomy );*/
    return $result_array;
}

//Shortcode to get company.
add_shortcode( 'sigma-mt-company-lists', 'sigma_mt_get_company' );
function sigma_mt_get_company($atts) {
    $content = '';
    $taxonomy = 'company-cat';
    $post_type = 'company-items';
    $term_id = $atts['term_id'];
    $appearance = isset($atts['appearance']) ? $atts['appearance'] : __( 'Default', 'sigmaigaming' );
    $posts_per_page = isset($atts['posts_per_page']) ? $atts['posts_per_page'] : -1;
    $colorClass = isset($atts['color']) ? $atts['color'] : '';
    $sort_order = isset($atts['sort_order']) ? $atts['sort_order'] : '';
    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
    $term_name = get_term_by('id', $term_id, $taxonomy);
    
    $supported_cat = get_field('supported_by');
    $supported_asia_cat = get_field('supported_by_asia');
    $exhibitors_cat = get_field('our_exhibitors_partners');
    $sponsors_and_exhibitors = get_field('our_sponsors_and_exhibitors');
    $our_trusted_suppliers = get_field('our_trusted_suppliers');
    $meet_the_past_winners = get_field('meet_the_past_winners');
    $partners = get_field('our_partners');
    
    // $fallback = false;
    
    $appearanceSupported = __( 'SUPPORTED', 'sigmaigaming' );
    $appearancePartners = __( 'PARTNER', 'sigmaigaming' );
    $appearanceIgaming = __( 'IGAMING', 'sigmaigaming' );
    $appearanceExhibitors = __( 'EXHIBITORS', 'sigmaigaming' );
    $appearanceSponsorsExhibitors = __( 'SPONSORS AND EXHIBITORS', 'sigmaigaming' );
    $appearancePastWinners = __( 'PAST WINNERS', 'sigmaigaming' );
    $appearanceTrustedSuppliers = __( 'TRUSTED SUPPLIERS', 'sigmaigaming' );
    $appearanceLogos = __( 'Logos', 'sigmaigaming' );
    $appearanceDefault = __( 'Default', 'sigmaigaming' );
    
    
    //if( !empty($supported_cat['category_name'][0]) && str_starts_with($term_name->name, $supported_cat['category_name'][0]) ) {
    if($appearance == $appearanceSupported){
        $main_class = 'supported';
        $sub_class = 'supported-logo';
        $single_class = 'supported-single';
        $category_title = $supported_cat['supported_by_title'];
    //} else if(!empty($exhibitors_cat['category_name'][0]) && str_starts_with($term_name->name, $exhibitors_cat['category_name'][0])) {
    } else if($appearance == $appearanceExhibitors){
        $main_class = 'exhibitors';
        $sub_class = 'all-exhibitors';
        $single_class = 'single-exhibitor';
        $category_title = $exhibitors_cat['our_exhibitors_partners_title'];
    //} else if(!empty($sponsors_and_exhibitors['category_name'][0]) && str_starts_with($term_name->name, $sponsors_and_exhibitors['category_name'][0])) {
    } else if($appearance == $appearanceSponsorsExhibitors){
        $main_class = 'exhibitors';
        $sub_class = 'all-exhibitors';
        $single_class = 'single-exhibitor';
        $category_title = isset($sponsors_and_exhibitors['title']) ? $sponsors_and_exhibitors['title'] : '';
    //} else if(!empty($partners['category_name'][0]) && $term_name->name === $partners['category_name'][0]) {
    } else if($appearance == $appearancePartners){
        $main_class = 'our-partner';
        $sub_class = 'all-partners';
        $single_class = 'single-partner';
        //$category_title = $partners['title'];
    } else if($appearance == $appearancePastWinners){
        $main_class = 'suppliers';
        $sub_class = 'supplier-logo';
        $single_class = 'supplier-single';
    } else if($appearance == $appearanceTrustedSuppliers){
        $main_class = 'suppliers';
        $sub_class = 'supplier-logo';
        $single_class = 'supplier-single';
        $category_title = isset($our_trusted_suppliers['title']) ? $our_trusted_suppliers['title'] : '';
    } else if($appearance == $appearanceDefault){
        $main_class = 'suppliers';
        $sub_class = 'supplier-logo';
        $single_class = 'supplier-single';
        $category_title = $partners ? $partners['title'] : '';
    }
    
        
    $post_args = array(
      'posts_per_page' => $posts_per_page,
      'post_type' => $post_type,
      'order'   => $sort_order,
      'orderby'        => $orderby,
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
        //if(!empty($meet_the_past_winners['category_title']) && $meet_the_past_winners['category_title'] === $term_name->name) {
        if($appearance == $appearancePastWinners){
            $year = $atts['year'];
            //echo '<pre>'; print_r(); 
            $args = array( 
                    //'date_query' => array( array( 'before' => '-1 year' ) ),    
                    'posts_per_page' => $posts_per_page,
                    'post_type' => $post_type,
                    'orderby'        => 'DESC',
                    'post_status'    => 'publish',
                    'tax_query' => array(
                          array(
                              'taxonomy' => $taxonomy,
                              'field' => 'term_id',
                              'terms' => $term_id,
                          )
                    ),
                    'date_query' => array(
                        array(
                            'after'     => 'January 1st, '.$year.'',
                            'before'    => 'December 31st, '.$year.'',
                            'inclusive' => true,
                        ),
                    ),
            );
            $get_posts = get_posts($args);
            if(!empty($get_posts)) {
                $content .= '<div class="all-winners">';
                                foreach($get_posts as $k => $post) {
                                    $company_details = get_field('company_details', $post->ID);
                                    $content .= '<div class="single-winner">
                                                    <h3>'.$post->post_title.'</h3>
                                                    <div class="winner-img">
                                                        <img src="'.$company_details['company_logo'].'" alt="nomination logo">
                                                    </div>
                                                </div>';
                                }
                            $content .= '</div>';
            } else {
                $content .= '';
            }
        } else if($appearance === 'PARTNER' ) {
            $content .= '<section class="all-winner '.$colorClass.'"">
                            <div class="container">
                                <div class="winner-slider">';
                                    foreach($get_posts as $k => $post) {
                                        $post_date = explode('-', $post->post_date);
                                        $year = $post_date[0];
                                        $company_details = get_field('company_details', $post->ID);
                                        $url = isset($company_details['company_url']['url']) ? $company_details['company_url']['url'] :'';
                                        $content .= '<div class="winer-slide"><div class="winner-single-slide">
                                                        <div class="winner-label">WINNER '.$year.'</div>
                                                        <div class="winner-content">';
                                                            if(!empty($company_details)) { $content .= '<div class="winner-logo"><a href="'.$url.'" target="_blank"><img src="'. $company_details['company_logo'] .'"></a></div>'; }
                                                            if(!empty($company_details)) { $content .= '<div class="winner-disc"><p>'.$post->post_content.'</p></div>'; }
                                                    $content .= '</div></div>
                                                </div>';
                                    }
                                $content .= '</div>
                            </div>
                        </section>';
        } else if($appearance === 'IGAMING' ) {
            $content .= '<section class="igaming-lists '.$colorClass.'"">
                            <div class="container">';
                                foreach($get_posts as $k => $post) {
                                    $company_details = get_field('company_details', $post->ID);
                                    $url = isset($company_details['company_url']['url']) ? $company_details['company_url']['url'] :'';
                                    $content .= '<div class="igaming-single">
                                                    <div class="igaming-box">
                                                        <div class="expert-img">';
                                                            if(!empty($company_details)) { $content .= '<div class="winner-logo"><a href="'.$url.'" target="_blank"><img src="'. $company_details['company_logo'] .'"></a></div>'; }
                                                        $content .= '</div>
                                                        <div class="expert-info">';
                                                            $content .= '<h2>'.$post->post_title.'</h2>';
                                                            $content .= '<a href="'.$url.'">'.__( 'Visit Website', 'sigmaigaming' ).'</a>';
                                                        $content .= '</div>
                                                    </div>
                                                </div>';
                                }
                            $content .= '</div>
                        </section>';
        } else if($appearance === 'Default' ) {
            $content .= '<section class="'.$main_class.' '.$colorClass.'">
                            <div class="container">';
                                if(!empty($category_title)) {
                                    $content .= '<div class="about-section-title">
                                                    <h2>'. $category_title .'</h2>
                                                </div>';
                                }
                                if(!empty($our_trusted_suppliers['trusted_splliers_text'])) {
                                    $content .= '<div class="supplier-txt">
                                        <p>'.$our_trusted_suppliers['trusted_splliers_text'].'</p>
                                    </div>';
                                }
                                $content .= '<div class="'.$sub_class.'">';
                                    foreach($get_posts as $k => $post) {
                                        $company_details = get_field('company_details', $post->ID);
                                        $url = isset($company_details['company_url']['url']) ? $company_details['company_url']['url'] :'';
                                        if(!empty($company_details['company_logo'])) {
                                            $content .= '<div class="'.$single_class.'">';
                                            $content .= '<a href="'.$url.'" target="_blank"><img src="'. $company_details['company_logo'] .'"></a>';
                                        }
                                        $content .= '</div>';
                                    }
                                $content .= '</div>';
                                if(!empty($our_trusted_suppliers['single_company_shortcode'])) {
                                    foreach($our_trusted_suppliers['single_company_shortcode'] as $k => $value) {
                                        $shortcode = do_shortcode($value['shortcode']);
                                        $content .= $shortcode;
                                    }
                                }
            $content .= '</section>';            
        } else {
            $content .= '<section class="'.$main_class.' '.$colorClass.'"">
                            <div class="container">';
                                if(!empty($category_title)) {
                                    $content .= '<div class="about-section-title">
                                                    <h2>'. $category_title .'</h2>
                                                </div>';
                                }
                                if(!empty($our_trusted_suppliers['trusted_splliers_text'])) {
                                    $content .= '<div class="supplier-txt">
                                        <p>'.$our_trusted_suppliers['trusted_splliers_text'].'</p>
                                    </div>';
                                }
                                $content .= '<div class="'.$sub_class.'">';
                                    foreach($get_posts as $k => $post) {
                                        $company_details = get_field('company_details', $post->ID);
                                        $url = isset($company_details['company_url']['url']) ? $company_details['company_url']['url'] :'';
                                        if(!empty($company_details['company_logo'])) {
                                            $content .= '<div class="'.$single_class.'">';
                                            $content .= '<a href="'.$url.'" target="_blank"><img src="'. $company_details['company_logo'] .'"></a>';
                                        }
                                        $content .= '</div>';
                                    }
                                $content .= '</div>';
                                if(!empty($our_trusted_suppliers['single_company_shortcode'])) {
                                    foreach($our_trusted_suppliers['single_company_shortcode'] as $k => $value) {
                                        $shortcode = do_shortcode($value['shortcode']);
                                        $content .= $shortcode;
                                    }
                                }
            $content .= '</div></section>';            
        }


    }
    return $content;
}

//Shortcode to get company.
add_shortcode( 'sigma-mt-single-company-row', 'sigma_mt_get_single_company_row' );
function sigma_mt_get_single_company_row($atts) {
    $atts = shortcode_atts( array(
        'company_desc_id' => $atts['company_desc_id'],
        'company_logo_id' => ['company_logo_id']
    ), $atts );
    $content = '';
    $taxonomy = 'company-cat';
    $post_type = 'company-items';
    $company_desc_id = $atts['company_desc_id'];
    $company_logo_id = $atts['company_logo_id'];
    // split image id parameter on the comma
    $logos = explode(",", $atts['company_logo_id']);
    $arrlength = count($logos);
    if(!empty($arrlength)) {
            $content .= '<div class="single-logo-supply">';
                            $company_details = get_field('company_details', $company_desc_id);
                            $url = isset($company_details['company_url']['url']) ? $company_details['company_url']['url'] :'';
                            $description = isset($company_details['description']) ? $company_details['description'] : '';
                            if(!empty($description)) {
                                $content .= '<div class="every-single-supply">
                                                <div class="supply-txt">
                                                    <p>'.$description.'</p>
                                                </div>';
                                                foreach($logos as $k => $logoID) {
                                                    $company_details = get_field('company_details', $logoID);
                                                    $content .= '<div class="supplier-single">
                                                        <a href="'.$url.'" target="_blank"><img src="'. $company_details['company_logo'] .'"></a>
                                                    </div>';
                                                }
                                            $content .= '</div>';
                            }
            $content .= '</div>';
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

//Shortcode to get sponsoring  available-sold text.
add_shortcode( 'sigma-mt-available-sold-text', 'sigma_mt_get_available_sold_text' );
function sigma_mt_get_available_sold_text() {
    $content = '';
    $content .= '<div class="all-sell">
                    <p class="sell">
                        <span style="color:#44c156;"><i class="fa fa-bookmark" aria-hidden="true"></i> '. __( 'Available', 'sigmaigaming' ).'</span>
                        <span style="color:#ed1a3b;"><i class="fa fa-bookmark" aria-hidden="true"></i>  '.__( 'Sold Out', 'sigmaigaming' ).'</span>
                    </p>
                    <i class="fas fa-plus icon"></i>
                </div>';
    return $content;
}

//Shortcode to get sponsoring-items top tab.
add_shortcode( 'sigma-mt-sponsors-accordian-tabs', 'sigma_mt_get_sponsors_accordian_tabs_data' );
function sigma_mt_get_sponsors_accordian_tabs_data($atts) {
    $content = '';
    $tag_data = array();
    $post_data = array();
    $tag_id = isset($atts['tag_id']) ? $atts['tag_id'] : '';
    $taxonomy = 'sponsoring-cat';
    $count = isset($atts['count']) ? $atts['count'] : '';
    $tag_category = get_term_by('id', $tag_id, $taxonomy);
    $split_text = explode(" ", $tag_category->name);
    $field = get_field('accordian_section');
    $exhibit_category = isset($field['exhibiting_opportunities']['title']) ? $field['exhibiting_opportunities']['title'] : '';
    $roadshow_category = isset($field['roadshow_opportunities']['title']) ? $field['roadshow_opportunities']['title'] : '';
    $sponsorship_category = isset($field['sponsorship_opportunities']['title']) ? $field['sponsorship_opportunities']['title'] : '';
    $workshop_category = isset($field['workshop_opportunities']['title']) ? $field['workshop_opportunities']['title'] : '';
    $appearance = $atts['appearance'];
    $appearanceName = __( 'ColorPackage', 'sigmaigaming' );
    $appearanceReg = __( 'Regular', 'sigmaigaming' );
    $appearanceWork = __( 'Workshop', 'sigmaigaming' );
    if($tag_category->name === $workshop_category) {
        $main_class = 'all-workshops';
    } else if($tag_category->name === $exhibit_category) {
        $main_class = 'all-packages';
    } else {
        $main_class = 'sponsor-boxes';
    }
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
    $aval_sold = do_shortcode( '[sigma-mt-available-sold-text]' );
    if(!empty($get_posts)) {
        $content .= '<div class="wrapper">
                        <div class="toggle">
                            <h3>'.$tag_category->name.'</h3>
                            '.$aval_sold.'
                        </div>
                        <div class="content">
                            <div class="'.$main_class.'">';
                                $counter = 0;
                                $total_sponsors = count($get_posts);
                                foreach($get_posts as $k => $sponsoring) {
                                    $exhibit_details = get_field('exhibit_details', $sponsoring->ID);
                                    $sponsors_logo = isset($exhibit_details['sponsers_icon']) ? $exhibit_details['sponsers_icon'] : '';
                                    $sponsors_amount = isset($exhibit_details['amount']) ? $exhibit_details['amount'] : '';
                                    $sponsors_count = isset($exhibit_details['sponsors_count']) ? $exhibit_details['sponsors_count'] : '';
                                    $term_obj_list = get_the_terms( $sponsoring->ID, 'sponsoring-tag' );
                                    $sponsors_gallery = isset($exhibit_details['sponsers_gallery']) ? $exhibit_details['sponsers_gallery'] : '';
                                    $sponsors_status = isset($term_obj_list[0]->name) ? $term_obj_list[0]->name : '';
                                    $package = isset($exhibit_details['package']) ? $exhibit_details['package'] : '';
                                    $package_status = isset($exhibit_details['package_status']) ? $exhibit_details['package_status'] : '';
                                    $available = __( 'Available', 'sigmaigaming' );
                                    $sold_out = __( 'Sold Out', 'sigmaigaming' );
                                    $gold_pkg = __( 'Gold Package', 'sigmaigaming' );
                                    $outdoor_pkg = __( 'Outdoor Platinum', 'sigmaigaming' );
                                    $silver_pkg = __( 'Silver Package', 'sigmaigaming' );
                                    $platinum_pkg = __( 'Platinum Package', 'sigmaigaming' );
                                    $bronze_pkg = __( 'Bronze Package', 'sigmaigaming' );
                                    $meeting_pkg = __( 'Meeting Room Package', 'sigmaigaming' );
                                    if($sponsors_status === $sold_out) {
                                        $class = 'sold';
                                        $image = '<img src="'.CHILD_DIR.'/exhibit/images/SOLD-OUTv1.png" alt="" class="soldout">';
                                    } else {
                                        $image = '';
                                        $class = '';
                                    }
                                    $counter++;
                                    if ($total_sponsors-1 % 4  == 0)  {
                                        $sec_division = 'double-line';
                                    }
                                    if($appearance === $appearanceReg ) {
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
                                                    </div>';

                                    }
                                    if($appearance === $appearanceWork) {
                                        if($sponsors_status === $sold_out) {
                                            $class = 'disable';
                                        } else {
                                            $class = 'active';
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
                                                    </div>';
                                    }
                                    if($appearance === $appearanceName ) {
                                        if($package === $gold_pkg) {
                                            $class = 'gold';
                                            $image = '<img src="'.CHILD_DIR.'/exhibit/images/gold-package-icon.png" alt="" class="soldout">';
                                        } else if($package === $outdoor_pkg || $package === $platinum_pkg) {
                                            $class = 'platinum';
                                            $image = '<img src="'.CHILD_DIR.'/exhibit/images/platinum-package-blue-icon-1.png" alt="" class="soldout">';
                                        } else if($package === $silver_pkg) {
                                            $class = 'silver';
                                            $image = '<img src="'.CHILD_DIR.'/exhibit/images/silver-package-icon.png" alt="" class="soldout">';
                                        } else {
                                            $class = '';
                                            $image = '';
                                        }
                                        $content .= '<div class="single-package '.$class.'" id="sponsorPopup'.$sponsoring->ID.'" onclick="openModal(\'sponsorPopup'.$sponsoring->ID.'\', \'sponsorContent'.$sponsoring->ID.'\', \'closeSponsor'.$sponsoring->ID.'\')">
                                                        <div class="top">
                                                            <h3>'.$package.'</h3>
                                                            <div class="package-icon">'.$image.'</div>
                                                        </div>
                                                        <div class="mid">
                                                            <div class="prize-wrapper">
                                                                <h3>'.$sponsors_amount.'</h3>
                                                            </div>
                                                        </div>
                                                        <div class="bottom">
                                                            <span class="open-btn">'.$package_status.'</span>
                                                        </div>
                                                    </div>';
                                    }
                                    $content .= '<!-- The Modal -->
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

// book flight shortcode
add_shortcode( 'sigma-mt-book-flight-form', 'sigma_mt_book_flight_form' );
function sigma_mt_book_flight_form() {
    $content = '';
    $content .= '<div class="airline_reg_form_row" id="register">
      
        <div class="airline_reg_form_fields">
            <form name="airlineRegistrationForm" id="airlineRegForm" method="post" action="">
           
                <div class="airline_form_field_rows">
                    <div class="airline_form_field_row">
                        <div class="airline_title_row_left">
                            <h4>Flights</h4>
                        </div>
                        <div class="airline_title_row_right">
                        
                        </div>
                    </div>
                    <div class="airline_form_field_row">
                        <div class="airline_dropdown_row take_off_source">
                            <select name="origin" class="journeyPlace1" required="">
                              <option value="select"> --Select Origin-- </option>
                              <option value="AUH"> Abu Dhabi International </option>
                              <option value="AMS"> Amsterdam </option>
                              <option value="AOI"> Ancona </option>
                              <option value="ATH"> Athens Eleftherios Venizelos </option>
                              <option value="BCN"> Barcelona</option>
                              <option value="BRI"> Bari </option>
                              <option value="BSL"> Bari </option>
                              <option value="BEG"> Belgrade </option>
                              <option value="BGO"> Bergen </option>
                              <option value="TXL"> Berlin Tegel </option>
                              <option value="BLQ"> Bologna </option>
                              <option value="KBP"> Kiev Borispol </option>
                              <option value="BTS"> Bratislava </option>
                              <option value="BRE"> Bremen </option>
                              <option value="BDS"> Brindisi </option>
                              <option value="BRU"> Brussels National </option>
                              <option value="OTP"> Bucharest Otopeni </option>
                              <option value="BUD"> Budapest Ferihegy </option>
                              <option value="CAG"> Cagliari elmas Mario Mameli </option>
                              <option value="CAI"> Cario International </option>
                              <option value="CMN"> Casablanca Mohammed V Int. Airport </option>
                              <option value="CTA"> Catania Fontanarossa </option>
                              <option value="CGN"> Cologne </option>
                              <option value="CPH"> CologneCopenhagen Airport Kastrup </option>
                              <option value="DOH"> Doha </option>
                              <option value="DTM"> Dortmund </option>
                              <option value="DRS"> Dresden </option>
                              <option value="DUB"> Dublin </option>
                              <option value="DBV"> Dubrovnik </option>
                              <option value="DUS"> Dusseldorf </option>
                              <option value="EDI"> Edinburgh </option>
                              <option value="FLR"> Florence </option>
                              <option value="FRA"> Frankfurt International </option>
                              <option value="GDN"> Gdansk </option>
                              <option value="GVA"> Geneva International </option>
                              <option value="GOA"> Genoa </option>
                              <option value="GOT"> Gothenburg </option>
                              <option value="GRZ"> Graz </option>
                              <option value="HAM"> Hamburg </option>
                              <option value="HAJ"> Hannover </option>
                              <option value="HEL"> Helsinki </option>
                              <option value="IBZ"> Ibiza </option>
                              <option value="IST"> Istanbul Airport </option>
                              <option value="KTW"> Katowice </option>
                              <option value="KRK"> Krakow </option>
                              <option value="SUF"> Lamezia Terme </option>
                              <option value="LCA"> Larnaca </option>
                              <option value="LEJ"> Leipzig </option>
                              <option value="LIS"> Lisbon </option>
                              <option value="LON"> London </option>
                              <option value="LGW"> London Gatwick </option>
                              <option value="LHR"> London Heathrow </option>
                              <option value="LUG"> Lugano </option>
                              <option value="LUX"> Luxembourg </option>
                              <option value="LYS"> Lyon Saint Exupery </option>
                              <option value="MAD"> Madrid </option>
                              <option value="AGP"> Malaga </option>
                              <option value="MLA"> Malta International Airport </option>
                              <option value="MAN"> Manchester </option>
                              <option value="MRS"> Marseille Provence </option>
                              <option value="LIN"> Milan Linate </option>
                              <option value="MXP"> Milan Malpensa </option>
                              <option value="SVO"> Moscow Sheremetyevo </option>
                              <option value="MUC"> Munich International </option>
                              <option value="NCE"> Nice </option>
                              <option value="OSL"> Oslo </option>
                              <option value="PMO"> Palermo </option>
                              <option value="PAR"> Paris </option>
                              <option value="CDG"> Paris Charles De Gaulle </option>
                              <option value="ORY"> Paris Orly </option>
                              <option value="OPO"> Porto </option>
                              <option value="PRG"> Prague Ruzyne </option>
                              <option value="REK"> Reykjavik </option>
                              <option value="RIX"> Riga </option>
                              <option value="FCO"> Rome Leonardo Da Vinci Fiumicino </option>
                              <option value="SZG"> Salzburg </option>
                              <option value="SOF"> Sofia International </option>
                              <option value="ARN"> Stockholm Arlanda </option>
                              <option value="STR"> Stuttgart </option>
                              <option value="TLL"> Tallinn </option>
                              <option value="TBS"> Tbilisi </option>
                              <option value="TLV"> Tel Aviv </option>
                              <option value="TUN"> Tunis Carthage International Airport </option>
                              <option value="VCE"> Venice </option>
                              <option value="VIE"> RiVienna Internationalga </option>
                              <option value="WAW"> Warsaw </option>
                              <option value="ZRH"> Zurich </option>
                          </select>                          
                        </div>
                    </div>
                    <div class="airline_form_field_row">
                        <div class="airline_dropdown_row take_off_destination">
                          <select name="destination" class="journeyPlace2" required="">
                              <option value="select"> --Select Destination-- </option>
                              <option value="AUH"> Abu Dhabi International </option>
                              <option value="AMS"> Amsterdam </option>
                              <option value="AOI"> Ancona </option>
                              <option value="ATH"> Athens Eleftherios Venizelos </option>
                              <option value="BCN"> Barcelona</option>
                              <option value="BRI"> Bari </option>
                              <option value="BSL"> Bari </option>
                              <option value="BEG"> Belgrade </option>
                              <option value="BGO"> Bergen </option>
                              <option value="TXL"> Berlin Tegel </option>
                              <option value="BLQ"> Bologna </option>
                              <option value="KBP"> Kiev Borispol </option>
                              <option value="BTS"> Bratislava </option>
                              <option value="BRE"> Bremen </option>
                              <option value="BDS"> Brindisi </option>
                              <option value="BRU"> Brussels National </option>
                              <option value="OTP"> Bucharest Otopeni </option>
                              <option value="BUD"> Budapest Ferihegy </option>
                              <option value="CAG"> Cagliari elmas Mario Mameli </option>
                              <option value="CAI"> Cario International </option>
                              <option value="CMN"> Casablanca Mohammed V Int. Airport </option>
                              <option value="CTA"> Catania Fontanarossa </option>
                              <option value="CGN"> Cologne </option>
                              <option value="CPH"> CologneCopenhagen Airport Kastrup </option>
                              <option value="DOH"> Doha </option>
                              <option value="DTM"> Dortmund </option>
                              <option value="DRS"> Dresden </option>
                              <option value="DUB"> Dublin </option>
                              <option value="DBV"> Dubrovnik </option>
                              <option value="DUS"> Dusseldorf </option>
                              <option value="EDI"> Edinburgh </option>
                              <option value="FLR"> Florence </option>
                              <option value="FRA"> Frankfurt International </option>
                              <option value="GDN"> Gdansk </option>
                              <option value="GVA"> Geneva International </option>
                              <option value="GOA"> Genoa </option>
                              <option value="GOT"> Gothenburg </option>
                              <option value="GRZ"> Graz </option>
                              <option value="HAM"> Hamburg </option>
                              <option value="HAJ"> Hannover </option>
                              <option value="HEL"> Helsinki </option>
                              <option value="IBZ"> Ibiza </option>
                              <option value="IST"> Istanbul Airport </option>
                              <option value="KTW"> Katowice </option>
                              <option value="KRK"> Krakow </option>
                              <option value="SUF"> Lamezia Terme </option>
                              <option value="LCA"> Larnaca </option>
                              <option value="LEJ"> Leipzig </option>
                              <option value="LIS"> Lisbon </option>
                              <option value="LON"> London </option>
                              <option value="LGW"> London Gatwick </option>
                              <option value="LHR"> London Heathrow </option>
                              <option value="LUG"> Lugano </option>
                              <option value="LUX"> Luxembourg </option>
                              <option value="LYS"> Lyon Saint Exupery </option>
                              <option value="MAD"> Madrid </option>
                              <option value="AGP"> Malaga </option>
                              <option value="MLA"> Malta International Airport </option>
                              <option value="MAN"> Manchester </option>
                              <option value="MRS"> Marseille Provence </option>
                              <option value="LIN"> Milan Linate </option>
                              <option value="MXP"> Milan Malpensa </option>
                              <option value="SVO"> Moscow Sheremetyevo </option>
                              <option value="MUC"> Munich International </option>
                              <option value="NCE"> Nice </option>
                              <option value="OSL"> Oslo </option>
                              <option value="PMO"> Palermo </option>
                              <option value="PAR"> Paris </option>
                              <option value="CDG"> Paris Charles De Gaulle </option>
                              <option value="ORY"> Paris Orly </option>
                              <option value="OPO"> Porto </option>
                              <option value="PRG"> Prague Ruzyne </option>
                              <option value="REK"> Reykjavik </option>
                              <option value="RIX"> Riga </option>
                              <option value="FCO"> Rome Leonardo Da Vinci Fiumicino </option>
                              <option value="SZG"> Salzburg </option>
                              <option value="SOF"> Sofia International </option>
                              <option value="ARN"> Stockholm Arlanda </option>
                              <option value="STR"> Stuttgart </option>
                              <option value="TLL"> Tallinn </option>
                              <option value="TBS"> Tbilisi </option>
                              <option value="TLV"> Tel Aviv </option>
                              <option value="TUN"> Tunis Carthage International Airport </option>
                              <option value="VCE"> Venice </option>
                              <option value="VIE"> RiVienna Internationalga </option>
                              <option value="WAW"> Warsaw </option>
                              <option value="ZRH"> Zurich </option>
                                 
                                </select>
                        </div>
                    </div>
                    <div class="airline_form_field_row">
                        <div class="airline_radiobtns_row">
                            <div class="user_way_option">
                                <input type="radio" name="journeyType" id="returnWay" value="round-trip" checked required> 
                                <label for="returnWay">Return</label>
                            </div>
                            <div class="user_way_option">
                                <input type="radio" name="journeyType" id="oneWay" value="one-way"> 
                                <label for="oneWay">One way</label>
                            </div>
                        </div>
                    </div>
                    <div class="airline_form_field_row">
                        <div class="airline_datepicker_left">
                            <div class="take_off_datepicker">
                                <input type="text" name="date" id="departuredate" placeholder="Departure Date" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="airline_datepicker_right">
                            <div class="return_datepicker">
                                <input type="text" name="date1" id="returndate" placeholder="Return Date" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="airline_form_field_row">
                        <div class="airline_radiobtns_row_left">
                            <div class="airline_flexible_check">
                                <input type="checkbox" name="flexible_date_check" id="flexible_date_check" checked="">
                                <label for="flexible_date_check">Flexible Dates</label>
                            </div>
                        </div>
                    
                        <div class="airline_radiobtns_row_right">
                            <div class="traveling_class">
                                <input type="radio" name="travellingClass" id="travellingClass1" value="Economy"  checked required> 
                                <label for="travellingClass1">Economy</label>
                            </div>
                            <div class="traveling_class">
                                <input type="radio" name="travellingClass" id="travellingClass2" value="Business"> 
                                <label for="travellingClass2">Business</label>
                            </div>
                        </div>
                    </div>
                    <div class="airline_form_field_row">
                            <div class="airline_person_selection">
                                <div class="person_age_select">
                                    <label>Adults</label>
                                    <input type="number" name="ADT" id="adult" value="1">
                                </div>
                            </div>
                            <div class="airline_person_selection">
                                <div class="person_age_select">
                                    <label>Children(2-11yrs)</label>
                                    <input type="number" name="CHD" id="child" value="0">
                                </div>
                            </div>
                            <div class="airline_person_selection">
                                <div class="person_age_select">
                                    <label>Infants(0-2yrs)</label>
                                    <input type="number" name="INF" id="infan">
                                </div>
                            </div>
                    </div>
                </div>
                <div class="airline_reg_action_btns">
                    <div class="airline_form_action_btn">
                        <input type="submit" name="airlineRegFormProceedBtn" class="airlineRegFormProceedBtn" id="airlineRegFormProceedBtn" value="SUBMIT">
                    </div>
                </div>
                <div class="data_box"></div>
            </form>
        </div>
    </div>
	';
    return $content;
}

//shortcode to get hotels
add_shortcode( 'sigma-mt-get-hotels', 'sigma_mt_get_hotels' );
function sigma_mt_get_hotels($atts) {
    $content = '';
    $taxonomy = 'hotel-cat';
    $term_id = isset($atts['term_id']) ? $atts['term_id'] : '';
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : '';
    $tag_category = get_term_by('id', $term_id, $taxonomy);
    if(isset($term_id) && !empty($term_id)) {
        $post_tag_args = array(
          'posts_per_page' => $count,
          'post_type' => 'hotel-items',
          'tax_query' => array(
              array(
                  'taxonomy' => $taxonomy,
                  'field' => 'term_id',
                  'terms' => $term_id,
              )
          )
        );
    } else {
        $post_tag_args = array(
          'posts_per_page' => $count,
          'post_type' => 'hotel-items',
          'orderby'        => 'rand',
          'post_status'    => 'publish'
        );
    }
    $get_posts = get_posts($post_tag_args);
    $singleCountPost = count($get_posts);
    if(!empty($get_posts)) {
        $content .= '<div class="hotel-reviews">';
                        foreach($get_posts as $k => $post) {
                            $hotel_icon = get_field('hotel_icon', $post->ID);
                            $hotel_address = get_field('address', $post->ID);
                            $star_rating = get_field('star_ratings', $post->ID);
                            $hotel_gallery = get_field('hotel_gallery', $post->ID);
                            $book_button = get_field('book_button', $post->ID);
                            $args = array(
                               'rating' => $star_rating,
                               'type' => 'rating',
                               'number' => 12345,
                            );
                            if($singleCountPost == '1') {
                                $fullClass = 'full';
                                $openClass = 'open';
                            } else {
                                $fullClass = '';
                                $openClass = '';
                            }
                            $rating = wp_star_rating($args);
                            $content .= '<div id="single-hotel'.$post->ID.'" class="single-hotel '.$fullClass.'">
                                <div class="short">
                                    <div class="logo">
                                        <img src="'.$hotel_icon.'" alt="">
                                    </div>
                                    <div class="rate">';
                                        $content .= $rating;
                                    $content .= '</div>
                                    <button class="show-more" onclick="openHotel(\'single-hotel'.$post->ID.'\', \'long'.$post->ID.'\')">'.__('Our Special Rate', 'sigmaigaming').'</button>
                                </div>
                                <div id="long'.$post->ID.'" class="long '.$openClass.'">
                                    <div class="close" onclick="closeHotel(\'single-hotel'.$post->ID.'\', \'long'.$post->ID.'\')"></div>
                                    <div class="hotel-detail">
                                        <h3>'.$post->post_title.'</h3>
                                        <p>Vjal Portomaso St Julian’s PTM, 01</p>
                                        <p>'.$post->post_content.'</p>
                                    </div>
                                    <div class="img-gallery">';
                                    if(!empty($hotel_gallery)) {
                                        foreach($hotel_gallery as $img) {
                                            $content .= '<a href="#"><img src="'.$img["images"].'" alt=""></a>';
                                        }
                                    }
                                    $content .= '</div>
                                    <div class="buttons-wrapper"><a class="more" target="_blank" href="'.$book_button['link']['url'].'">'.$book_button['text'].'</a></div>
                                </div>
                            </div>';
                        }
                    $content .= '</div>';
    }
    return $content;
}

//shortcode to get Awards
add_shortcode( 'sigma-mt-get-awards', 'sigma_mt_get_awards' );
function sigma_mt_get_awards($atts) {
    $content = '';
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : '';
    $post_tag_args = array(
      'posts_per_page' => $count,
      'post_type' => 'award-items',
    );
    $get_posts = get_posts($post_tag_args);
    if(!empty($get_posts)) {
        $content .= '<div class="awards-wrapper">';
                        foreach($get_posts as $k => $post) {
                            $award_logo = get_field('award_logo', $post->ID);
                            $sponsored_logo = get_field('sponsored_logo', $post->ID);
                            $description = get_field('description', $post->ID);
                            $content .= '<div class="award-box" id="award-box'.$post->ID.'">
                                            <div class="box">
                                                <div class="top">
                                                    <img src="'.$award_logo.'" alt="">
                                                    <h5>BEST EU ONLINE CASINO</h5>
                                                    <div class="sponsored">
                                                        <p>'. __( 'Sponsored by', 'sigmaigaming' ).'</p>
                                                        <img src="'.$sponsored_logo.'" alt="">
                                                    </div>
                                                </div>
                                                <div class="bottom">
                                                    <span class="more" onclick="openAward(\'award-box'.$post->ID.'\')">'. __( 'Read More', 'sigmaigaming' ).'</span>
                                                    <span class="less" onclick="closeAward(\'award-box'.$post->ID.'\')">'. __( 'Read Less', 'sigmaigaming' ).'</span>
                                                </div>
                                            </div>
                                            <div class="discription">
                                                <p>'.$description.'</p>
                                            </div>
                                        </div>';
                        }
                    $content .= '</div>';
    }
    return $content;
}

// Shortcode for iGaming Gallery
add_shortcode( 'sigma-mt-igaming-gallery', 'sigma_mt_igaming_gallery' );
function sigma_mt_igaming_gallery($atts) {
    global $wp_query;
    $content = '';
    $posts_by_year = [];
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : '5';
    $term_id = isset($atts['term_id']) ? $atts['term_id'] : '';
    $page_id = $wp_query->get_queried_object()->ID;
    $post_args = array(
      'posts_per_page' => $count,
      'post_type' => 'gt3_gallery',
      'orderby'        => 'DESC',
      'post_status'    => 'publish',
      'tax_query' => array(
                array(
                    'taxonomy' => 'gt3_gallery_category',
                    'field'    => 'term_id',
                    'terms'    => $term_id,
                    'operator' => 'IN'
                ),
            ),
    );
    $gallery = new WP_Query($post_args);
    if(!empty($gallery)) {
        if ($gallery->have_posts()) {
        while ($gallery->have_posts()) {
            $gallery->the_post();
            $year = get_the_date('Y');
            $posts_by_year[$year][] = ['ID' => get_the_ID(), 'title' => get_the_title(), 'link' => get_the_permalink(), 'Year' => $year,];
        }
    }
    $content .= '<div class="directory-gallery">
                    <div class="all-gallery gallery-directories">';
                        foreach($posts_by_year as $posts) {
                            $content .= '<h2 class="elementor-heading-title">'.$posts[0]['Year'].'</h2>';
                            foreach($posts as $post) {
                                $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post['ID'] ), 'full' );
                                $content .= '<div class="single-gallery">
                                                <a href="'.get_permalink($post['ID']).'" target="_blank">
                                                    <h3>'.$post['title'].'</h3>
                                                    <div class="featured-image">
                                                        <img src="'.$featured_image[0].'" alt="">
                                                    </div>
                                                </a>
                                            </div>';
                            }
                        }
                    $content .= '</div>
                </div>';
    }
    return $content;
}

//shortcode to get jobs
add_shortcode( 'sigma-mt-get-jobs', 'sigma_mt_get_jobs' );
function sigma_mt_get_jobs($atts) {
    $content = '';
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : '10';

    $category = array();
    if( isset( $_GET['country'] ) ) {
        if( $_GET['country'] != 'country' ) {
            $category[] = $_GET['country'];
        }
    }
    if( isset( $_GET['department'] ) ) {
        if( $_GET['department'] != 'department' ) {
            $category[] = $_GET['department'];
        }
    }
    if( isset( $_GET['job-type'] ) ) {
        if( $_GET['job-type'] != 'job-type' ) {
            $category[] = $_GET['job-type'];
        }
    }

    if( !empty( $category ) ) {
        $post_tag_args = array(
          'posts_per_page' => $count,
          'post_type' => 'job-items',
          'orderby'        => 'rand',
          'post_status'    => 'publish',
          'tax_query' => array(
                array(
                    'taxonomy' => 'job-cat',
                    'field'    => 'slug',
                    'terms'    => $category,
                    'operator' => 'IN'
                ),
            ),
        );
    } else {
        $post_tag_args = array(
          'posts_per_page' => $count,
          'post_type' => 'job-items',
          'orderby'        => 'rand',
          'post_status'    => 'publish',
        );
    }
    $get_posts = get_posts($post_tag_args);

    $terms = get_terms( array(
        'taxonomy' => 'job-cat', // to make it simple I use default categories
        'orderby' => 'name',
        'post_type' => 'job-items',
        'parent' => 0,
        'hide_empty' => false,
    ) );

    if(!empty($get_posts)) {
        if( $terms ) {
            $content .= '<div class="vacancies-filter"><h3>All Vacancies</h3>';
            foreach( $terms as $cat ) {
                $parent_category_id = $cat->term_id;
                $parent_category_name = $cat->name;
                $parent_category_slug = $cat->slug;

                $child_arg = array( 'hide_empty' => false, 'parent' => $parent_category_id );
                $child_cat = get_terms( array(
                    'taxonomy' => 'job-cat', // to make it simple I use default categories
                    'orderby' => 'name',
                    'post_type' => 'job-items',
                    'parent' => $parent_category_id,
                    'hide_empty' => false,
                ) );
                
                $content .= '
                    <select id="filter-'.$parent_category_slug.'">
                        <option value="'.$parent_category_slug.'">'.$parent_category_name.'</option>';
                        if( $child_cat ) {
                            foreach( $child_cat as $child ) {
                                $child_cat_name = $child->name;
                                $child_cat_slug = $child->slug;
                                if( isset( $_GET[$parent_category_slug] ) ) {
                                    if( $_GET[$parent_category_slug] == $child_cat_slug ) {
                                        $selected = 'selected';
                                    } else {
                                        $selected = '';
                                    }
                                } else {
                                    $selected = '';
                                }
                                $content .= '<option value="'.$child_cat_slug.'" '.$selected.'>'.$child_cat_name.'</option>';
                            }
                        }
                $content .= '</select>';
            }
            $content .= '</div>';
        }
        $content .= '<div class="job-listing">';
                        foreach($get_posts as $k => $post) {
                            $job_desc = get_field('job_description', $post->ID);
                            $lang_logo = get_field('language_icon', $post->ID);
                            $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                            if(!empty($featured_image[0])) {
                                $image = $featured_image[0];
                            } else {
                                $image = ''.SITE_URL.'/wp-content/uploads/2021/07/frame-with-office-equipment-white-desk.png';
                            }
                            $content .= '<div id="" class="single-jobs">
                                            <div class="logo">
                                                <img src="'.$image.'" alt="" class="featured-image">
                                                <img src="'.$lang_logo.'" alt="" class="lang-image">
                                            </div>
                                            <div class="long">
                                                <div class="job-detail">
                                                    <h3>'.$post->post_title.'</h3>
                                                    <p class="descriptionSection">'.$job_desc.'</p>
                                                    <p class="short-descritpion">'.$post->post_content.'</p>
                                                </div>
                                                <div class="buttons-wrapper">
                                                    <a class="more" target="_blank" href="'.get_permalink( $post->ID ).'">'.__( 'Learn More', 'sigmaigaming' ).'</a>
                                                </div>
                                            </div>
                                        </div>';
                        }
                    $content .= '</div>';
    }
    return $content;
}

//Shortcode to get seating arrangments.
add_shortcode( 'sigma-mt-seating-arrangments', 'sigma_mt_seating_arrangments' );
function sigma_mt_seating_arrangments($atts) {
    $content = '';
    $are_you_sitting_down_info = get_field('are_you_sitting_down');
    //echo '<pre>'; print_r($atts['position']);
    if($atts['position'] === 'top') {
        $seat_id = 'seatTop';
        $table_id = 'tableTop';
        $award_id = 'awardTop';
        $sponsor_id = 'sponsorTop';
    } else {
        $seat_id = 'seatBottom';
        $table_id = 'tableBottom';
        $award_id = 'awardBottom';
        $sponsor_id = 'sponsorBottom';
    }
    if(!empty($are_you_sitting_down_info)) {
        $content .= '<div class="tab-buttons tab">
                        <div class="iconbtn" onclick="tabArrangments(event, \''.$seat_id.'\')">
                          <img src='.$are_you_sitting_down_info['arrangements']['one_seat']['images']['color_image'].' alt="" class="for-main">
                          <img src='.$are_you_sitting_down_info['arrangements']['one_seat']['images']['white_image'].' alt="" class="for-hover">
                          <span>'.$are_you_sitting_down_info['arrangements']['one_seat']['title'].'</span>
                        </div>
                        <div class="iconbtn" onclick="tabArrangments(event, \''.$table_id.'\')">
                          <img src='.$are_you_sitting_down_info['arrangements']['one_table']['images']['color_image'].' alt="" class="for-main">
                          <img src='.$are_you_sitting_down_info['arrangements']['one_table']['images']['white_image'].' alt="" class="for-hover">
                          <span>'.$are_you_sitting_down_info['arrangements']['one_table']['title'].'</span>
                        </div>
                        <div class="iconbtn" onclick="tabArrangments(event, \''.$award_id.'\')">
                          <img src='.$are_you_sitting_down_info['arrangements']['award_sponsor']['images']['color_image'].' alt="" class="for-main">
                          <img src='.$are_you_sitting_down_info['arrangements']['award_sponsor']['images']['white_image'].' alt="" class="for-hover">
                          <span>'.$are_you_sitting_down_info['arrangements']['award_sponsor']['title'].'</span>
                        </div>
                        <div class="iconbtn" onclick="tabArrangments(event, \''.$sponsor_id.'\')">
                          <img src='.$are_you_sitting_down_info['arrangements']['title_sponsor']['images']['color_image'].' alt="" class="for-main">
                          <img src='.$are_you_sitting_down_info['arrangements']['title_sponsor']['images']['white_image'].' alt="" class="for-hover">
                          <span>'.$are_you_sitting_down_info['arrangements']['title_sponsor']['title'].'</span>
                        </div>
                      </div>
                      <div class="tab-bodies">
                        <div class="itemcontent" id="'.$seat_id.'">
                          <p>'.$are_you_sitting_down_info['arrangements']['one_seat']['description'].'</p>
                        </div>
                        <div class="itemcontent" id="'.$table_id.'">
                          <p>'.$are_you_sitting_down_info['arrangements']['one_table']['description'].'</p>
                        </div>
                        <div class="itemcontent" id="'.$award_id.'">
                          <p>'.$are_you_sitting_down_info['arrangements']['award_sponsor']['description'].'</p>
                        </div>
                        <div class="itemcontent" id="'.$sponsor_id.'">
                          <p>'.$are_you_sitting_down_info['arrangements']['title_sponsor']['description'].'</p>
                        </div>
                      </div>';
    }
    return $content;
}

//shortcode to get Testimonial
add_shortcode( 'sigma-mt-get-testimonials', 'sigma_mt_get_testimonials' );
function sigma_mt_get_testimonials($atts) {
    $content = '';
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : '';
    $term_id = isset($atts['term_id']) ? $atts['term_id'] : '';
    $appearance = isset($atts['appearance']) ? $atts['appearance'] : '';
    $colorClass = isset($atts['color']) ? $atts['color'] : '';
    if(isset($term_id) && !empty($term_id)) {
        $post_args = array(
          'posts_per_page' => $count,
          'post_type' => 'testimonial-items',
          'tax_query' => array(
              array(
                  'taxonomy' => 'testimonial-cat',
                  'field' => 'term_id',
                  'terms' => $term_id,
              )
          )
        );
    } else {
        $post_args = array(
          'posts_per_page' => $count,
          'post_type' => 'testimonial-items',
          'orderby'        => 'rand',
          'post_status'    => 'publish'
        );
    }
    $testimonials = get_posts($post_args);
    if(!empty($testimonials)) {
        if($appearance == 'full'){
            $content .= '<div class="testimonial-slider '.$colorClass.'">';
            foreach($testimonials as $k => $testimonial) {
                $company = get_field('testimonial_company', $testimonial->ID);
                $people = get_field('people_relationship', $testimonial->ID);
                //echo '<pre>'; print_r($people);
                $content .= '<div class="testi-slide">
                                <div class="testimonial-inner">
                                  <div class="client-image">';
                                    foreach($people as $id) {
                                        $people_icon = get_field('image_icon', $id);
                                        $content .= '<img src="'.$people_icon.'" alt="">';
                                    }
                                  $content .= '</div>
                                  <div class="client-txt">';
                                    foreach($people as $id) {
                                        $content .= '<h4 class="testimonial-title">'.get_the_title($id).'</h4>';
                                    }
                                    $content .= '<div class="testimonial-info">
                                      <h4 class="testimonial-company">'.$company.'</h4>
                                      <p>'.$testimonial->post_content.'</p>
                                    </div>
                                  </div>
                                </div>
                              </div>';
                            }
            $content .= '</div>';
        } else if($appearance == 'frontpage') {
            $content .= '<div class="testimonial-slide-home">';
            $r = 1;
            $total = count($testimonials);
            foreach($testimonials as $k => $testimonial) {
                $testimonial_value = $r . '/' . $total;
                $company_name = get_field( "testimonial_company", $testimonial->ID );
                $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $testimonial->ID ), 'thumbnail' );
                $content .= '<figure class="testimonial">
                    <img src="' . $featured_image[0] . '" alt="' . $testimonial->post_title . '" />
                    <div class="peopl">
                        <h3>' . $testimonial->post_title . '</h3>
                        <p class="company_name">' . $company_name . '</p>
                    </div>
                    <blockquote>' . $testimonial->post_content .
                        '<div class="btn"></div>
                    </blockquote>
                    <span>' . $testimonial_value . '</span>
                </figure>';
                $r++; 
            }
            $content .= '</div>';
        }
    }
    return $content;
}

// Shortcode for related articles
add_shortcode( 'sigma-mt-related-articles', 'sigma_mt_related_articles' );
function sigma_mt_related_articles($atts) {
    $content = '';
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : '';
    $term_id = isset($atts['term_id']) ? $atts['term_id'] : '';
    if(isset($term_id) && !empty($term_id)) {
        $post_args = array(
          'posts_per_page' => $count,
          'post_type' => 'news-items',
          'tax_query' => array(
              array(
                  'taxonomy' => 'news-cat',
                  'field' => 'term_id',
                  'terms' => $term_id,
              )
          )
        );
    } else {
        $post_args = array(
          'posts_per_page' => $count,
          'post_type' => 'news-items',
          'orderby'        => 'rand',
          'post_status'    => 'publish'
        );
    }
    $relatedArticles = get_posts($post_args);
    if(!empty($relatedArticles)) {
        $content .= '<!-- Related Article Section -->
                        <div class="pitch-articles related-articles">
                            <div class="articles-slide">';
                                foreach($relatedArticles as $k => $item) {
                                    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' );
                                    $content .= '<a href="'.get_permalink($item->ID).'"><div class="testimonial">
                                                    <div class="testi-details">
                                                        <img src="'.$featured_image[0].'" alt="'.$item->post_title.'" />
                                                        <div class="post-title">
                                                            <h3>'.$item->post_title.'</h3>
                                                        </div>
                                                    </div>
                                                </div></a>';
                                }
                            $content .= '</div>o
                        </div>
                    <!-- Related Article Section end -->';
    }
    return $content;
}

// Function to get casino 
function sigma_mt_get_all_company_lists_array($term_id, $count) {
    $taxonomy = 'company-cat';
    $post_type = 'company-items';
    if(!empty($term_id)) {
        $post_args = array(
          'posts_per_page' => $count,
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
    } else {
        $post_args = array(
          'posts_per_page' => $count,
          'post_type' => $post_type,
          'orderby'        => 'title',
          'order'       => 'ASC',
          'post_status'    => 'publish'
        );
    }
    $company = get_posts($post_args);
    return $company;
}

// Shortcode for 2020 Startup
add_shortcode( 'sigma-mt-logos', 'sigma_mt_get_logos' );
function sigma_mt_get_logos($atts) {
    $content = '';
    $term_id = isset($atts['term_id']) ? $atts['term_id'] : '';
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : '';
    $appearance = isset($atts['appearance']) ? $atts['appearance'] : '';
    $colorClass = isset($atts['color']) ? $atts['color'] : '';
    $companyLists =  sigma_mt_get_all_company_lists_array($term_id, $count);
    if(!empty($companyLists)) {
        $content .= '<div class="charity-items '.$colorClass.'">
                            <input type="hidden" value="'.$count.'" id="meet_startup_last_year">';
                            foreach($companyLists as $k => $item) {
                                if(!empty($company_details['company_logo'])) {
                                    $alt = $item->post_title;
                                    $logo = $company_details['company_logo'];
                                } else {
                                    $alt = 'No Image';
                                    $logo = '';
                                }
                                $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' );
                                $company_details = get_field('company_details', $item->ID);
                                $content .= '<div class="single-item" id="single-item'.$k.'" data-title="'.$item->post_title.'">';
                                if($appearance === 'link' ) {
                                    $content .= '<a href="'.get_permalink($item->ID).'" target="_blank"> 
                                                    <div class="btn">
                                                        <div></div>
                                                    </div>
                                                </a>';
                                } else {
                                    if(!empty($item->post_content)) {
                                        $content .= '<div class="btn" onclick="openCharityDiv(\'single-item'.$k.'\')">
                                                        <div></div>
                                                    </div>';
                                    }
                                }
                                $content .= '<div class="left">
                                                <div class="img-wrapper">
                                                    <img src="'.$logo.'" alt="'.$alt.'">
                                                </div>
                                            </div>';
                                if(!empty($item->post_content)) { $content .= '<div class="right"><p>'.$item->post_content.'</p></div>'; }
                                    
                                $content .= '</div>';
                            }  
                    $content .= '</div>';
    }
    return $content;
}

// Startup pitch slider shortcode
add_shortcode( 'sigma-mt-pitch-logo-slider', 'sigma_mt_pitch_logo_slider' );
function sigma_mt_pitch_logo_slider() {
    $content = '';
    $content .= '<div class="elementor-year-slider">
                    <ul>
                        <li id="slider_btn_2019" class="active">2019</li>
                        <li id="slider_btn_2018">2018</li>
                        <li id="slider_btn_2017">2017</li>
                    </ul>
                </div>';
    return $content;
}

// 2020 Startups filter shortcode
add_shortcode( 'sigma-mt-last-year-startups-filter', 'sigma_mt_last_year_startups_filter' );
function sigma_mt_last_year_startups_filter($atts) {
    $content = '';
    $colorClass = isset($atts['color']) ? $atts['color'] : '';
    $content .= '<div class="startup-filter-last-year align-center '.$colorClass.'">
                    <ul>
                        <li id="" class="active" data-regex="^[0-9a-gA-G].*">A - G</li>
                        <li id="" data-regex="^[h-nH-N].*">H - N</li>
                        <li id="" data-regex="^[o-zO-Z].*">O - Z</li>
                    </ul>
                </div>';
    return $content;
}

//Shortcode to display banner adds
add_shortcode( 'sigma-mt-magazines', 'sigma_mt_magazines' );
function sigma_mt_magazines($atts) {
    $content = '';
    $term_id = isset($atts['term_id']) ? $atts['term_id'] : '5';
    $post_per_page = isset($atts['post_per_page']) ? $atts['post_per_page'] : '10';
    $taxonomy = 'magazines-cat';
    $post_per_page = isset($post_per_page) ? $post_per_page : '';
    $category = get_term_by('id', $term_id, $taxonomy);
    $post_args = array(
      'posts_per_page' => $post_per_page,
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
    $getMagazines = get_posts($post_args);
    $content .='<section class="sigma-news">
                    <div class="container">';
                        foreach($getMagazines as $magazine) {
                            $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $magazine->ID ), 'full' );
                            $magazineLink = get_field('link', $magazine->ID);
                            $magazineLink = isset($magazineLink) ? $magazineLink : '#';
                            $content .= '<div class="magazine-widget">
                                            <a href="'.$magazineLink.'">
                                                <img src="'.$featured_image[0].'">
                                            </a>
                                        </div>';
                        }
                    $content .= '</div>
            </section>';
    return $content;
}

// Shortcode for game providers
add_shortcode( 'sigma-mt-game-providers', 'sigma_mt_game_providers' );
function sigma_mt_game_providers($atts) {
    global $wp_query;
    $content = '';
    $term_id = isset($atts['term_id']) ? $atts['term_id'] : '';
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : '';
    $appearance = isset($atts['appearance']) ? $atts['appearance'] : '';
    $image = isset($atts['logo']) ? $atts['logo'] : NULL;
    $game_title = isset($atts['game_title']) ? $atts['game_title'] : NULL;
    $discover = isset($atts['discover']) ? $atts['discover'] : NULL;
    $page_id = $wp_query->get_queried_object()->ID;
    $post_args = array(
      'posts_per_page' => $count,
      'post_type' => 'company-items',
      'orderby'        => 'DESC',
      'post_status'    => 'publish',
      'tax_query' => array(
              array(
                  'taxonomy' => 'company-cat',
                  'field' => 'term_id',
                  'terms' => $term_id,
              )
          )
    );
    $gameLists = get_posts($post_args);
    if(!empty($gameLists)) {
        $content .= '<div class="directory '.$appearance.'">
                        <div class="all-directory">';
                            foreach($gameLists as $game) {
                                $game_provider = get_field('company_details', $game->ID);
                                $link = esc_url( add_query_arg( 'page_id', $page_id, get_permalink($game->ID) ) );
                                $content .= '<div class="single-directory">
                                                <a href="'.$link.'" target="_blank">';
                                                    if(!empty($game_provider['company_logo']) && $image === 'YES') {
                                                        $content .= '<img src="'.$game_provider['company_logo'].'" alt="">';
                                                    }
                                                    if(!empty($game->post_title) && $game_title === 'YES' ) {
                                                        $content .= '<div class="provider-name">
                                                                        <h3>'.$game->post_title.'</h3>
                                                                    </div>';
                                                    }
                                                    if($discover === 'YES' ) {
                                                        $content .= '<div class="provider-btn">
                                                            <p>'.__( 'Discover Games', 'sigmaigaming' ).'</p>
                                                        </div>';
                                                    }
                                                $content .= '</a>
                                            </div>';
                            }
                        $content .= '</div>
                    </div>';
    }
    return $content;
}

// Shortcode for speakers
add_shortcode( 'sigma-mt-speakers', 'sigma_mt_speakers' );
function sigma_mt_speakers($atts) {
    global $post;
    $cat = get_terms('speaker-cat');
    $content = '';
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : -1;
    $content .= '<div class="call-for-speakers-db">';
        foreach ($cat as $k => $catVal) {
            $postArg = array(
                'post_type' => 'speaker-items',
                'posts_per_page' => $count,
                'order' => 'desc',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'speaker-cat',
                        'field' => 'term_id',
                        'terms' => $catVal->term_id
                )
            ));
            $getPost = new wp_query($postArg);
            $content .= '<div class="speaker-item" onclick="openSpeakersDiv(\'toggle-content'.$k.'\')">
                            <div class="title">
                                <h5>'.$catVal->name.'</h5>
                            </div>
                            <div class="toggle-content'.$k.'">';
                                if($getPost->have_posts()) {
                                    while ($getPost->have_posts()) {
                                        $getPost->the_post();
                                        $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                                        $content .= '<div class="body">
                                                        <div class="inner-wrapper">
                                                            <div class="single-speaker">
                                                                <div class="avatar" style="background-image:url(\''.$featured_image[0].'\');">
                                                                </div>
                                                                <div class="right widget_type_rich-text">
                                                                    <h4>'.$post->post_title.'</h4>
                                                                    <h6>WH Partners</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';
                                    }
                                }
                            $content .= '</div>
                        </div>';
    }
    $content .= '</div>';
    return $content;
}