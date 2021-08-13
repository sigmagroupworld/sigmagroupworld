<?php
define( 'CHILD_DIR', get_theme_file_uri() );
define( 'PARENT_DIR', get_stylesheet_directory_uri() );
define( 'SITE_URL', site_url() );

require_once get_stylesheet_directory().'/cpt-functions.php';
require_once get_stylesheet_directory().'/class/class-custom-widget.php';

/*
function remove_css_js_version( $src ) {
    if( strpos( $src, '?ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'remove_css_js_version', 9999 );
add_filter( 'script_loader_src', 'remove_css_js_version', 9999 );
*/

add_action( 'init', 'stop_heartbeat', 1 );
function stop_heartbeat() {
wp_deregister_script('heartbeat');
}

add_action( 'wp_enqueue_scripts', 'sigma_mt_enqueue_styles', PHP_INT_MAX);
function sigma_mt_enqueue_styles() {
    $parent_style = 'adforest-style'; // This is 'adforest-style' for the AdForest theme.
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        time()
    );   
    wp_enqueue_style('sigmamt-responsive', CHILD_DIR . '/assets/css/responsive.css');
    wp_enqueue_style('sigmamt-slick', CHILD_DIR . '/assets/css/slick.css');
    wp_enqueue_style('sigmamt-slick-theme', CHILD_DIR . '/assets/css/slick-theme.css');
    wp_enqueue_style('sigmamt-slick-lightbox', CHILD_DIR . '/assets/css/slick-lightbox.css');
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
    wp_enqueue_style('home', CHILD_DIR .'/news/css/news.css', array(), time());
    wp_enqueue_style('sigmamt-regular-fontawesome', CHILD_DIR . '/assets/css/regular.css', array(), '1.0.0', true);
    wp_enqueue_script( 'jquery-ui-datepicker' );    
    wp_enqueue_script('sigmamt-main-script', CHILD_DIR . '/assets/js/custom.js', array(), '1.0.0', true );    
    wp_enqueue_script('sigmamt-slick-script', CHILD_DIR . '/assets/js/slick.min.js', array(), '1.0.0', true );
    wp_enqueue_script('sigmamt-slick-lightbox-script', CHILD_DIR . '/assets/js/slick-lightbox.js', array(), '1.0.0', true );

    /****Autocomplete script ****/
    wp_enqueue_script('autocomplete-search', get_stylesheet_directory_uri() . '/assets/js/autocomplete.js', 
        ['jquery', 'jquery-ui-autocomplete'], null, true);
    wp_localize_script('autocomplete-search', 'AjaxRequest', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'ajax_nonce' => wp_create_nonce('autocompleteSearchNonce'),
        'security' => wp_create_nonce( 'load_more_people' ),
        'gallerySecurity' => wp_create_nonce( 'load_more_gallery' ),
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

/**
 * Removes the "Trash" link on the individual post's "actions" row on the posts
 * edit page.
 */
add_filter( 'post_row_actions', 'remove_row_actions_post', 10, 2 );
function remove_row_actions_post( $actions, $post ) {
    /*$post_types = get_post_types([], 'objects');
    $posts = array();
    foreach ($post_types as $post_type) {
        $posts[] = $post_type->name;
    }
    echo '<pre>'; print_r($posts); echo '</pre>'; exit;*/
    if( $post->post_type === 'news-items' && !empty($_GET['lang']) && $_GET['lang'] !== 'en') {
        unset( $actions['clone'] );
        unset( $actions['trash'] );
    }
    return $actions;
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
    $banner_field = isset($atts['banner_add']) ? $atts['banner_add'] : '';
    $banner_image = isset($atts['banner_image']) ? $atts['banner_image'] : '';
    $banner_link = isset($atts['banner_link']) ? $atts['banner_link'] : '';
    $page_id = isset($atts['page_id']) ? $atts['page_id'] : '';
	$output = '';
	if($banner_image == '' && $banner_link == ''){
		$banners = get_field('desktop_banner', $page_id)[$banner_field];
		$output ='<section class="sigma-news">
					<div class="container">
						<div class="single-news">';
		if(!empty($banners)){
			foreach($banners as $banner) {
							$output .= '<div class="all-news">
								<a href="' . $banner['link'] . '" target="_blank" rel="noreferrer noopener">
									<img src="' . $banner['image'] . '" alt="">
								</a>
							</div>';
			}
		}
		$output .= '  </div>
					</div>
				</section>';
	} else {
		$output ='<section class="sigma-news">
					<div class="container">
						<div class="single-news">
							<div class="all-news">
								<a href="' . $banner_link . '" target="_blank" rel="noreferrer noopener">
									<img src="' . $banner_image . '" alt="">
								</a>
							</div>
						</div>
					</div>
				</section>';
	}
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
        /*$post_tag_args = array(
          'posts_per_page' => $count,
          'post_type' => 'news-items',
          'suppress_filters' => false,
          //'language' => 'en',
		  'post_status' => 'publish',
		  'orderby' => 'publish_date',
		  'order' => 'DESC',
          'tax_query' => array(
              array(
                  'taxonomy' => 'news-cat',
                  'field' => 'term_id',
                  'terms' => $tag_category->term_id,
              )
          )
        );*/
        $post_tag_args = array(
            'posts_per_page' => $count,
            'post_type' => 'news-items',
            'suppress_filters' => false,
            'language' => ICL_LANGUAGE_CODE,
            'post_status' => 'publish',
            'orderby' => 'publish_date',
            'order' => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'news-cat',
                    'field' => 'term_id',
                    'terms' => $tag_category->term_id,
                )
            )
        );
    } else {
        $post_tag_args = array(
          'posts_per_page' => $count,
          'post_type' => 'news-items',
          'suppress_filters' => false,
          //'language' => 'en',
          'orderby'        => 'rand',
          'post_status'    => 'publish',
		  'post_status' => 'publish',
		  'orderby' => 'publish_date',
		  'order' => 'DESC',
        );
    }
    $tag_data['term_value'] = $tag_category;
    $get_posts = get_posts($post_tag_args);
    $post_data['term_data'] = $get_posts;
    $result_array = array_merge($tag_data, $post_data);
    return $result_array;
}


// function to display order based on their continent
function sigma_mt_get_continent_order($page_id) {
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
    if ( is_page('home')) {
        $order = require_once get_stylesheet_directory().'/home/home-news.php';
    } else {
        $order = require_once get_stylesheet_directory().'/latest-news/latest-news.php';
    }
    //$order = require_once get_stylesheet_directory().'/home/home-news.php';
    return $order;
}

//function to get news tags.
function sigma_mt_get_casino_provider_data($term_id = "", $posts_per_page = "") {
    $posts_per_page = isset($posts_per_page) ? $posts_per_page : -1;
    if(!empty($term_id)) {
        $post_tag_args = array(
            'posts_per_page' => $posts_per_page,
            'post_type' => 'casinos-items',
            'orderby'        => 'title',
            'order'        => 'ASC',
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
          'posts_per_page' => $posts_per_page,
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
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : -1;
    $appearance = isset($atts['appearance']) ? $atts['appearance'] : '';
    $results =  sigma_mt_get_casino_provider_data($term_id, $count);
    if(!empty($results)) {
        $content .= '<div class="all-casinos '.$appearance.'">';
                        foreach($results as $k => $post) {
                            setup_postdata( $post );
                            $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                            $casino_provider = get_field('casino_details', $post->ID);
                            $content .= '<div class="single-casino">
                                            <div class="casino-logo">';
							if(!empty($featured_image)){
                                                $content .= '<img src="'.$featured_image[0].'" alt="">';
							}
							$content .= '</div>
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
                                                <p>'.(isset($casino_provider['exclusive_bonus']) ? $casino_provider['exclusive_bonus'] : '').'</p>
                                            </div>
                                            <div class="casino-bonus-details">
                                                <ul>';
                                                    if(!empty($casino_provider['online_casino_bonus_detail'])) { 
                                                        foreach($casino_provider['online_casino_bonus_detail'] as $value) {
                                                            $content .= '<li>'.$value['bonus_details'].'</li>';
                                                        }
                                                    }
                                                $content .= '</ul>
                                            </div>
                                            <div class="casino-buttons">
                                                <a href="'.(isset($casino_provider['play_link']) ? $casino_provider['play_link'] : '').'" class="play" target="_blank" rel="noopener noreferrer">'.__( 'Play', 'sigmaigaming' ).'</a>
                                                <a href="'.get_permalink($post->ID).'" class="review" target="_blank">'. __( 'Review', 'sigmaigaming' ).'</a>
                                            </div>
                                            <div class="payment-options">';
                                                if(isset($casino_provider['payment_options'])) { 
													$visa = __( 'Visa', 'sigmaigaming' );
													$mastercard = __( 'Mastercard', 'sigmaigaming' );
													$neteller =__( 'Neteller', 'sigmaigaming' );
													$skrill = __( 'Skrill', 'sigmaigaming' );
													$paypal = __( 'Paypal', 'sigmaigaming' );
													$bitcoin =__( 'Bitcoin', 'sigmaigaming' );
													$ecopayz = __( 'Ecopayz', 'sigmaigaming' );
													$muchbetter = __( 'MuchBetter', 'sigmaigaming' );
													$trustly = __( 'Trustly', 'sigmaigaming' );
													$paysafecard = __( 'Paysafecard', 'sigmaigaming' );
													$astropay = __( 'AstroPay', 'sigmaigaming' );
													$bankwire = __( 'BankWire', 'sigmaigaming' );
													$maestro = __( 'Maestro', 'sigmaigaming' );
													$ethereum = __( 'Ethereum', 'sigmaigaming' );
													$litecoin = __( 'Litecoin', 'sigmaigaming' );
													$applepay = __( 'ApplePay', 'sigmaigaming' );
                                                    foreach($casino_provider['payment_options'] as $value) {
                                                        $content .= '<div class="single-option">';
                                                            if($value === $visa) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/VISA-new-logo.png">';
                                                            if($value === $mastercard) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/mastercard.png">';
                                                            if($value === $neteller) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/Neteller.jpg">';
                                                            if($value === $skrill) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/Skrill.jpg">';
                                                            if($value === $bitcoin) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/Bitcoin.png">';
                                                            if($value === $paypal) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/Paypal.jpg">';
                                                            if($value === $ecopayz) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/Ecopayz.png">';
                                                            if($value === $muchbetter) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/MuchBetter.jpg">';
                                                            if($value === $trustly) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/Trustly.jpg">';
                                                            if($value === $paysafecard) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/Paysafecard.jpg">';
                                                            if($value === $astropay) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/Astropay.png">';
                                                            if($value === $bankwire) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/Bankwire.jpg">';
                                                            if($value === $maestro) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/Maestro.jpg">';
                                                            if($value === $ethereum) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/Ethereum.png">';
                                                            if($value === $litecoin) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/Litecoin.png">';
                                                            if($value === $applepay) $content .= '<img src="'. CHILD_DIR . '/online-casinos/images/Applepay.png">';
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

function orderby_company_title_custom_order($orderby_statement, $wp_query) {
    if ( $wp_query->get( 'orderby' ) != 'company_title_custom_order' ) {
        return $orderby_statement;
    }   
    global $wpdb;
    $orderby_statement = "company.post_title";
    return $orderby_statement;
}

function name_join($joins, $wp_query) {
    if ( $wp_query->get( 'orderby' ) != 'company_title_custom_order' ) {
        return $joins;
    }   
    global $wpdb;        
	$joins .= "  LEFT JOIN $wpdb->postmeta names ON names.post_id=$wpdb->posts.ID AND names.meta_key='company'" ;
	$joins .= "  LEFT JOIN $wpdb->posts company ON company.ID=names.meta_value";
    return $joins;
}

//Shortcode to get people lists
add_shortcode( 'sigma-mt-people-lists', 'sigma_mt_get_people_list' );
function sigma_mt_get_people_list($atts) {
    $content = '';
    $taxonomy = 'people-cat';
    $post_type = 'people-items';
    $term_id = $atts['term_id'];
	
    $posts_per_page = isset($atts['posts_per_page']) ? $atts['posts_per_page'] : '-1';
    $colorClass 		= isset($atts['color']) ? $atts['color'] : '';
    $sort_ordering 		= isset($atts['sort_ordering']) ? $atts['sort_ordering'] : 'DESC';
	$ordering_by 		= isset($atts['ordering_by']) ? $atts['ordering_by'] : 'publish_date';
	$order_custom_field	= isset($atts['order_custom_field']) ? $atts['order_custom_field'] : 'no';
    $speakers_text 		= get_field('speakers_text');
    $show_empty_box     = isset($atts['show_empty_box']) ? $atts['show_empty_box'] : '';
    $appearance         = isset($atts['appearance']) ? $atts['appearance'] : __( 'Default', 'sigmaigaming' );
	$affiliate_link		= isset($atts['affiliate_link']) ? $atts['affiliate_link'] : 'no';
    $person_name        = isset($atts['person_name']) ? $atts['person_name'] : 'no';
    $person_image       = isset($atts['person_image']) ? $atts['person_image'] : 'no';
    $person_position    = isset($atts['person_position']) ? $atts['person_position'] : 'no';
    $person_company     = isset($atts['person_company']) ? $atts['person_company'] : 'no';
    $person_company_logo= isset($atts['person_company_logo']) ? $atts['person_company_logo'] : 'no';
    $person_language    = isset($atts['person_language']) ? $atts['person_language'] : 'no';
    $person_email       = isset($atts['person_email']) ? $atts['person_email'] : 'no';
    $person_phone       = isset($atts['person_phone']) ? $atts['person_phone'] : 'no';
    $person_skype       = isset($atts['person_skype']) ? $atts['person_skype'] : 'no';
    $telegram           = isset($atts['telegram']) ? $atts['telegram'] : 'no';
    $fullclass          = isset($atts['fullclass']) ? $atts['fullclass'] : 'NO';
    $load_more = __( 'Load More', 'sigmaigaming' );
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
        
	$button = '';
	$desc = '';
    // Exhibit Appearance
    if($appearance == $appearanceExhibit){
        $main_class = 'contact-us';
        $sub_class = 'all-person';
        $single_class = 'single-person';
        $heading = __( 'CONTACT US', 'sigmaigaming' );   
    // Regular Appearance
    } else if($appearance == $appearanceRegular){
        $main_class = 'speakers';
        $sub_class = 'all-speakers';
        $single_class = 'single-speaker';
        $heading = isset($speakers_text['speaker_title']) ? $speakers_text['speaker_title'] : '';
        $button = '<div class="load-people"><button class="load-more" id="load-more">'.$load_more.'</button></div></div>';
        $desc = isset($speakers_text['speaker_text']) ? $speakers_text['speaker_text'] : '';
    // Host Appearance
    } else if($appearance == $appearanceHost ||$appearance == $appearanceHostJudge){
        $main_class = 'hosts';        
        $heading = isset($hosts['title']) ? $hosts['title'] : '';
        $sub_class = 'person-item';
    // Experts Appearance
    } else if($appearance == $appearanceExperts){
        $main_class = 'our-experts';        
        $heading = $our_experts['title'];
        $sub_class = 'all-experts expert-slider';
    // Investors Appearance
    } else if($appearance == $appearanceInvestors){
        $main_class = 'meet-investor';        
        $heading = '';
        $sub_class = 'all-experts investor-slider';
        $single_class = 'investor-slide';
    // Judge Appearance
    } else if($appearance == $appearanceJudge){
        $main_class = 'judges';        
        $heading = isset($judges['title']) ? $judges['title'] : '';
        $sub_class = 'all-judges';
        $desc = isset($judges['description']) ? $judges['description'] : '';
    // Default Appearance
    } else if($appearance == $appearanceDefault){
        $main_class = 'judges';        
        $heading = isset($judges['title']) ? $judges['title'] : '';
        $sub_class = 'all-judges';
        $desc = isset($judges['description']) ? $judges['description'] : '';
    } else if($appearance == $appearanceSponsorsExhabitors){
        $main_class = 'sponsors-and-exibitors-wrapper';        
        $heading = '';
        $sub_class = 'db-items-wrapper';
    }

    if($fullclass == 'YES') {
        $fullclass = 'full';
    } else {
        $fullclass = '';
    }
	
    $get_posts = array();
    //$term_id = explode(',', $term_id);
    if(!empty($term_id)) {
		if($appearance == $appearanceSponsorsExhabitors) {
			$post_args = array(
				'posts_per_page' => -1,
				'post_type' => $post_type,
				'post_status'    => '',
				'paged'          => 1,
				'orderby'		 => 'company_title_custom_order',
				'tax_query' => array(
					array(
						'taxonomy' => $taxonomy,
						'field' => 'term_id',
						'terms' => explode(',', $term_id),
					)
				)
			);
			add_filter('posts_join', 'name_join', 10, 2 );
			add_filter('posts_orderby', 'orderby_company_title_custom_order', 10, 2);
			$get_posts_pre = new WP_Query($post_args);
			$get_posts = $get_posts_pre->posts;
			remove_filter('posts_join', 'name_join', 10 );
			remove_filter('posts_orderby', 'orderby_company_title_custom_order', 10 );
		} else {
			if($order_custom_field == 'YES'){
				$post_args = array(
					'posts_per_page' => $posts_per_page,
					'post_type' => $post_type,
					'post_status'    => '',
					'paged'          => 1,
					'meta_key'			=> $ordering_by,
					'orderby'		 => 'meta_value',
					'order'   		 => $sort_ordering,
					'tax_query' => array(
						array(
							'taxonomy' => $taxonomy,
							'field' => 'term_id',
							'terms' => explode(',', $term_id),
						)
					)
				);
				$get_posts = get_posts($post_args);
			} else {
				$post_args = array(
					'posts_per_page' => $posts_per_page,
					'post_type' => $post_type,
					'post_status'    => '',
					'paged'          => 1,
					'orderby'		=> $ordering_by,
					'order'   		=> $sort_ordering,
					'tax_query' => array(
						array(
							'taxonomy' => $taxonomy,
							'field' => 'term_id',
							'terms' => explode(',', $term_id),
						)
					)
				);
				$get_posts = get_posts($post_args);
			}
		}
    } else {
        $post_args = array(
          'posts_per_page' => $posts_per_page,
          'post_type' => $post_type,
          'post_status'    => 'publish',
          'paged' => 1,
			'meta_key'			=> $ordering_by,
			'orderby'		 => 'meta_value',
            'order'   		 => $sort_ordering,
        );
        $get_posts = get_posts($post_args);
    }
    
	$content .= '<section class="'.$main_class.' '.$colorClass.'">
                        <div class="container">
                            <div class="about-section-title">
                                <h2>'.$heading.'</h2>
                                <p>'.$desc.'</p>
                            </div>
                            <div class="'.$sub_class.'">';
    if(!empty($get_posts)) {
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
            $people_company = get_field('company', $post->ID);
            $affiliate_link_url = get_field('affiliate_link', $post->ID);
			$companyLogo = ($people_company != '' && $people_company != NULL ? wp_get_attachment_image_src( get_post_thumbnail_id( $people_company ), 'full' ) : []);
            if($appearance === $appearanceRegular) {
                $content .= '<div class="'.$single_class.'"';
				if($affiliate_link == 'yes' && $affiliate_link_url != ''){
					$content .= ' onclick="window.open(' . "'" . $affiliate_link_url . "','mywindow');" . '" style="cursor:pointer;"' ;
				}
				$content .= '>';
                    if($person_image === 'YES' && !empty($people_icon)) { $content .= '<img src="'. $people_icon .'" alt="">'; }
                    if($person_name === 'YES' && !empty($title)) { $content .= '<h3>'.$post->post_title.'</h3>'; }
                    if($person_position === 'YES' && !empty($people_designation)) { $content .= '<p class="designation">'. $people_designation .'</p>'; }
                    if($person_company === 'YES' && !empty($people_company)) { $content .= '<p>'. get_the_title($people_company) .'</p>'; }
                    if($person_company_logo === 'YES' && !empty($people_company)) { 
						if(!empty($companyLogo)) {
							$content .= '<div class="expert-logo">
                                                    <img src="'.$companyLogo[0].'" alt="">
                                                </div>';
						}
					}
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
                $content .= '<div id="item'.$post->ID.'" class="person-item-inner item'.$post->ID.'">
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
                                                    <img src="'.$companyLogo[0].'" alt="">
                                                </div>';
                                            }
                                            $content .= '<h2>'.$post->post_title.'</h2>
                                            <h3>'.$people_designation.'</h3>
                                        </div>';
                                    $content .= '</div>
                                </div>
                            </div>';
            } else if($appearance === $appearanceHostJudge) {
                $content .= '<div id="item'.$post->ID.'" class="person-item-inner item'.$post->ID.'">
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
                                            <img src="'.$companyLogo[0].'" alt="">
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
									if($person_company_logo == 'yes'){
										if(!empty($companyLogo)) {
											$content .= '<div class="expert-logo">
												<img src="'.$companyLogo[0].'" alt="">
											</div>';
										}
									}
                                    $content .= '<h2>'.$post->post_title.'</h2>';
                                    if($person_company === 'YES' && !empty($people_company)) { 
                                        $content .= '<div class="desc">
                                        <p>'. get_the_title($people_company) .'</p>'; 
                                    }
                                    if($person_position === 'YES' && !empty($people_designation)) { 
                                        $content .= '<h3>'. $people_designation .'</h3>'; 
                                    }
                                $content .= '</div></div>
                            </div>';
            } else if($appearance == $appearanceSponsorsExhabitors) {
                //echo '<pre>'; print_r($fullclass); echo '</pre>';
                $content .= '<div id="" class="single-sponsors-exhibitors'.$post->ID.' item '.$fullclass.'">';
                                if($fullclass === '') {
                                    $content .= '<div class="btn" onclick="openSponsorsExhibitors(\'single-sponsors-exhibitors'.$post->ID.'\')">
                                                    <div></div>
                                                </div>';
                                }
                                $content .= '<div class="left">';
                                    if(!empty($companyLogo)) {
                                        $content .= '<div class="img-wrapper">
                                            <img src="'.$companyLogo[0].'" alt="">
                                        </div>';
                                    }
                                    if($person_image === 'YES' && !empty($people_icon)) { 
                                            $content .= '<div class="avatar" style="background-image: url(' . "'" .$people_icon."'" . ')"></div>';
                                    }
								$content .= 
									'<h3>'.(str_starts_with($post->post_title, 'No Name') ? '' : $post->post_title).'</h3>
									<h6>'.$people_designation.'</h6>
									<h4>'.get_the_title($people_company).'</h4>';
                                $content .= '</div>';
                                $content .= '<div class="right">
                                    <div class="top">
                                        <div class="website">
                                            <span>Website</span>
                                            <a href="'.$person_website.'" target="_blank" rel="noreferrer noopener">'.$person_website.'</a>
                                        </div>
										<div class="emial">
											<span>Email</span>
											<a href="mailto:'.$person_email_val.'" target="_blank">'.$person_email_val.'</a>
										</div>
                                    </div>
                                    <div class="widget-type-rich_text">
                                         <p>'.$post->post_content.'</p>
                                    </div>
                                </div>
                            </div>';
            }
        }
	}
		
	if($show_empty_box != null){
		if($show_empty_box == 'host-judge') {
			$content .= '<div class="person-item-inner">
                                <div class="person-left">
                                     <div class="person-avatar-img">
										<img src="' . SITE_URL.'/wp-content/uploads/2021/07/anonymous.png" alt="">
									</div>
                                    <div class="person-detail">
										<h3>' . __('Are you our next Judge?', 'sigmaigaming') . '</h3>
										<h4>' . __('Contact emily.d@sigma.world', 'sigmaigaming') . '</h4>
                                    </div>
                                </div>
                            </div>';
		} else if($show_empty_box = 'regular'){ 
			$content .= '<div class="'.$single_class.'">
					<h3>'.__('Would you like to be featured?', 'sigmaigaming').'</h3>
					<a class="hs-button" href="mailto:sophie@sigma.world">Apply</a>'; 
			$content .= '</div>';
		}
	}

	$content .= '</div></div>
        <input type="hidden" value="'.$term_id.'" id="termID">
        <input type="hidden" value="'.$posts_per_page.'" id="posts_per_page">
        <input type="hidden" value="'.$person_image.'" id="person_image">
        <input type="hidden" value="'.$person_name.'" id="person_name">
        <input type="hidden" value="'.$person_position.'" id="person_position">
        <input type="hidden" value="'.$person_company.'" id="person_company">';
	if ( is_page( array( 'europe', 'asia', 'africa', 'americas') ) ) {
		$content .= ''.$button.'';
	}
	$content .= '</section>';
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
        }
        echo $content;
    }
    exit;
}

//function to get videos.
function sigma_mt_get_videos($term_id, $posts_per_page, $appearance = '') {
    $taxonomy = 'videos-cat';
    $post_type = 'video-items';
    if(!empty($term_id)){
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
    $term_id       = isset($atts['term_id']) ? $atts['term_id'] : '';
    $posts_per_page = isset($atts['posts_per_page']) ? $atts['posts_per_page'] : '-1';
    $appearance = isset($atts['appearance']) ? $atts['appearance'] : '';
    $content = '';
    $appearanceVal = __( 'Grid', 'sigmaigaming' );
    $posts_by_year = [];
    $get_videos = sigma_mt_get_videos($term_id, $posts_per_page, $appearance);
    if(!empty($get_videos)) {
        if($appearance === 'SIGMATV') {
            foreach($get_videos as $k => $video) {
                    $year = date_format(new DateTime($video->post_date), 'Y');
                    $posts_by_year[$year][] = ['ID' => $video->ID, 'title' => $video->post_title, 'link' => get_field('youtube_video_link',  $video->ID), 'Year' => $year];
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
        } else if($appearance === 'slider') {
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
        } else if($appearance === 'MediaOpportunities') {
            $content .= '<section class="video slider media-opportunities-video">
                            <div class="container">
                                <div class="video-slider-mo">';
                                    foreach($get_videos as $k => $video) {
                                        $youtube_video_link = get_field('youtube_video_link',  $video->ID);
                                        $youtube_video_desc = get_field('description',  $video->ID);
                                         $content .= '<div class="video-single">
                                                        <h3 class="desc">'.$youtube_video_desc.'</h3>
                                                        <iframe src="'.$youtube_video_link.'" width="560" height="315" data-service="youtube" allowfullscreen="1"></iframe>
                                                      </div>';     
                                    }
                                $content .= '</div>
                            </div>
                        </section>';
        } else {
            foreach($get_videos as $k => $video) {
                $youtube_video_link = get_field('youtube_video_link',  $video->ID);
                if(!empty($appearance) && $appearance === $appearanceVal) {
                    
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

add_shortcode( 'sigma-mt-last-winners', 'sigma_mt_get_last_winners' );
function sigma_mt_get_last_winners($atts) {
    $elements = isset($atts['elements']) ? $atts['elements'] : '';
    $elementsArray = explode(", ", $elements);
    $descriptions = isset($atts['descriptions']) ? $atts['descriptions'] : '';
    $descriptionsArray = explode(", ", $descriptions);
	$content = '';
	if(count($elementsArray) == count($descriptionsArray)){
		 $content .= '<div class="all-winners">';
		 foreach($elementsArray as $k => $element) {
			 $content .= '<div class="single-winner">
                                                    <h3>'.$descriptionsArray[$k].'</h3>
                                                    <div class="winner-img">
                                                        <img src="'.wp_get_attachment_image_src( get_post_thumbnail_id( $element ), 'full' )[0].'" alt="nomination logo">
                                                    </div>
                                                </div>';
		 }
		$content .= '</div>';
	}
	return $content;
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
    $sort_order = isset($atts['sort_order']) ? $atts['sort_order'] : 'ASC';
    $orderby = isset($atts['orderby']) ? $atts['orderby'] : 'post_title';
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
        $exhibitorText = $exhibitors_cat['exhibitors_and_partners_text'];
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
      'orderby'   => $orderby,
      'order'        => $sort_order,
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
                                                        <img src="'.wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0].'" alt="nomination logo">
                                                    </div>
                                                </div>';
                                }
                            $content .= '</div>';
            } else {
                $content .= '';
            }
        } else if($appearance === 'PARTNER' ) {
            $content .= '<section class="all-winner '.$colorClass.'">
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
                                                            if(!empty($company_details)) { $content .= '<div class="winner-logo"><a href="'.$url.'" target="_blank" rel="noreferrer noopener"><img src="'. wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0] .'"></a></div>'; }
                                                            if(!empty($company_details)) { $content .= '<div class="winner-disc">&nbsp;<br /><p>'.$post->post_content.'</p></div>'; }
                                                    $content .= '</div></div>
                                                </div>';
                                    }
                                $content .= '</div>
                            </div>
                        </section>';
        } else if($appearance === 'IGAMING' ) {
            $content .= '<section class="igaming-lists '.$colorClass.'">
                            <div class="container">';
                                foreach($get_posts as $k => $post) {
                                    $company_details = get_field('company_details', $post->ID);
                                    $url = isset($company_details['company_url']['url']) ? $company_details['company_url']['url'] :'';
                                    $content .= '<div class="igaming-single">
                                                    <div class="igaming-box">
                                                        <div class="expert-img">';
                                                            if(!empty($company_details)) { $content .= '<div class="winner-logo"><a href="'.$url.'" target="_blank" rel="noreferrer noopener"><img src="'. wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0] .'"></a></div>'; }
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
                                if(!empty($exhibitorText)) {
                                    $content .= '<div class="about-section-text">
                                                    <p>'. $exhibitorText .'</p>
                                                </div>';
                                }
                                if(!empty($our_trusted_suppliers['trusted_splliers_text'])) {
                                    $content .= '<div class="supplier-txt">
                                        <p>'.$our_trusted_suppliers['trusted_splliers_text'].'</p>
                                    </div>';
                                }
                                if(!empty($get_posts)) {
                                    $content .= '<div class="'.$sub_class.'">';
                                        foreach($get_posts as $k => $post) {
                                            $company_details = get_field('company_details', $post->ID);
                                            $url = isset($company_details['company_url']['url']) ? $company_details['company_url']['url'] :'';
                                            if(!empty(wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0])) {
                                                $content .= '<div class="'.$single_class.'" >';
                                                $content .= '<a href="'.$url.'" target="_blank" rel="noreferrer noopener"><img src="'. wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0] .'"></a>';
                                            	$content .= '</div>';
                                            } else {
                                                $content .= '<div class="'.$single_class.'">';
                                                $content .= $post->ID . ': No image for ' . get_the_title($post->ID); 
                                            	$content .= '</div>';
											}
                                        }
                                    $content .= '</div>';
                                }
                                if(!empty($our_trusted_suppliers['single_company_shortcode'])) {
                                    foreach($our_trusted_suppliers['single_company_shortcode'] as $k => $value) {
                                        $shortcode = do_shortcode($value['shortcode']);
                                        $content .= $shortcode;
                                    }
                                }
            $content .= '</div></section>';            
        } else {
            $content .= '<section class="'.$main_class.' '.$colorClass.'">
                            <div class="container">';
                                if(!empty($category_title)) {
                                    $content .= '<div class="about-section-title">
                                                    <h2>'. $category_title .'</h2>
                                                </div>';
                                }
                                if(!empty($exhibitorText)) {
                                    $content .= '<div class="about-section-text">
                                                    <p>'. $exhibitorText .'</p>
                                                </div>';
                                }
                                if(!empty($our_trusted_suppliers['trusted_splliers_text'])) {
                                    $content .= '<div class="supplier-txt">
                                        <p>'.$our_trusted_suppliers['trusted_splliers_text'].'</p>
                                    </div>';
                                }
                                if(!empty($get_posts)) {
                                    $content .= '<div class="'.$sub_class.'">';
                                        foreach($get_posts as $k => $post) {
                                            $company_details = get_field('company_details', $post->ID);
                                            $url = isset($company_details['company_url']['url']) ? $company_details['company_url']['url'] :'';
                                            if(!empty(wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0])) {
                                                $content .= '<div class="'.$single_class.'">';
												if($url != '' && $url != '#'){
                                                	$content .= '<a href="'.$url.'" target="_blank" rel="noreferrer noopener">';
												}
												$content .= '<img src="'. wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0] .'">';
												if($url != '' && $url != '#'){
													$content .= '</a>';
												}
                                            	$content .= '</div>';
                                            } else {
                                                $content .= '<div class="'.$single_class.'">';
                                                $content .= $post->ID . ': No image for ' . get_the_title($post->ID); 
                                            	$content .= '</div>';
											}
                                        }
                                    $content .= '</div>';
                                }
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
		'company_logo_id' => $atts['company_logo_id'],
    ), $atts );
    $content = '';
    $taxonomy = 'company-cat';
    $post_type = 'company-items';
    $company_desc_id = $atts['company_desc_id'];
	$company_details = get_field('company_details', $company_desc_id);
	$logo_companies = explode(', ', $atts['company_logo_id']);
    // split image id parameter on the comma
	$content .= '<div class="container suppliers"><div class="single-logo-supply">';
	$description = isset($company_details['description']) ? $company_details['description'] : '';
	$content .= '<div class="every-single-supply">';
	if(!empty($description)) {
		$content .= '<div class="supply-txt">
                         <p>'.$description.'</p>
                     </div>';
	};
	
	if(!empty($logo_companies)){
		foreach($logo_companies as $k => $logo_company){
    		$logo = wp_get_attachment_image_src( get_post_thumbnail_id( $logo_company ), 'full' );
			$url = isset($company_details['company_url']['url']) ? $company_details['company_url']['url'] :'';
			if(!empty($logo)){
				$content .= '<div class="supplier-single">';
				if($url != '' && $url != '#'){
					$content .= '<a href="'.$url.'" target="_blank" rel="noreferrer noopener">';
				}
				$content .= '<img src="'. $logo[0] .'" style="max-height:60px;">';
				if($url != '' && $url != '#'){
					$content .= '</a>';
				}
				$content .= '</div>';
			}
		}
	}
	$content .= '</div></div></div>';
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
          'post_status'    => 'publish',
          'orderby'        => 'post_date',
		  'order'		   => 'DESC',
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
          'orderby'        => 'post_date',
		  'order'		   => 'DESC',
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
    $count = isset($atts['count']) ? $atts['count'] : -1;
    $order = isset($atts['order']) ? $atts['order'] : '';
    $orderby = isset($atts['orderby']) ? $atts['orderby'] : '';
    $ordercustomfield = isset($atts['ordercustom']) ? $atts['ordercustom'] : 'no';
    $ordernumeric = isset($atts['ordernumeric']) ? $atts['ordernumeric'] : 'no';
    $show_tab = isset($atts['show_tab']) ? $atts['show_tab'] : 'yes';
    $tag_category = get_term_by('id', $tag_id, $taxonomy);
    $split_text = explode(" ", $tag_category->name);
    $field = get_field('accordian_section');
    $exhibit_category = isset($field['exhibiting_opportunities']['title']) ? $field['exhibiting_opportunities']['title'] : '';
    $roadshow_category = isset($field['roadshow_opportunities']['title']) ? $field['roadshow_opportunities']['title'] : '';
    $sponsorship_category = isset($field['sponsorship_opportunities']['title']) ? $field['sponsorship_opportunities']['title'] : '';
    $workshop_category = isset($field['workshop_opportunities']['title']) ? $field['workshop_opportunities']['title'] : '';
    $appearance = $atts['appearance'];
    $style = isset($atts['style']) ? $atts['style'] : '';
    $appearanceName = __( 'ColorPackage', 'sigmaigaming' );
    $appearanceReg = __( 'Regular', 'sigmaigaming' );
    $appearanceWork = __( 'Workshop', 'sigmaigaming' );
    $appearanceTab = __( 'Tab', 'sigmaigaming' );
    $styleExpand = __( 'Expand', 'sigmaigaming' );

    if($tag_category->name === $workshop_category || $appearance === $appearanceWork) {
        $main_class = 'all-workshops';
    } else if($tag_category->name === $exhibit_category) {
        $main_class = 'all-packages';
    } else {
        $main_class = 'sponsor-boxes';
    }
    if(isset($tag_id) && !empty($tag_id)) {
		if($order != '' && $orderby != ''){
			if($ordercustomfield == 'yes'){
				if($ordernumeric == 'yes'){
					$post_tag_args = array(
					  'posts_per_page' => $count,
					  'post_type' 		=> 'sponsoring-items',
					'meta_key'			=> $orderby,
					'orderby'		 => 'meta_value_num',
					'order'   		 => $order,
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
					  'post_type' 		=> 'sponsoring-items',
					'meta_key'			=> $orderby,
					'orderby'		 => 'meta_value',
					'order'   		 => $order,
					  'tax_query' => array(
						  array(
							  'taxonomy' => $taxonomy,
							  'field' => 'term_id',
							  'terms' => $tag_id,
						  )
					  )
					);
				}
			} else {
				$post_tag_args = array(
				  'posts_per_page' => $count,
				  'post_type' 		=> 'sponsoring-items',
				  'orderby'        => $orderby,
				  'order'          => $order,
				  'tax_query' => array(
					  array(
						  'taxonomy' => $taxonomy,
						  'field' => 'term_id',
						  'terms' => $tag_id,
					  )
				  )
				);
			}
		} else {
			$post_tag_args = array(
			  'posts_per_page' => $count,
			  'post_type' => 'sponsoring-items',
			  'orderby'        => 'title',
			  'order'          => 'ASC',
			  'tax_query' => array(
				  array(
					  'taxonomy' => $taxonomy,
					  'field' => 'term_id',
					  'terms' => $tag_id,
				  )
			  )
			);
		}
    } else {
        $post_tag_args = array(
          'posts_per_page' => $count,
          'post_type' => 'sponsoring-items',
          'orderby'        => 'title',
          'order'          => 'ASC',
          'post_status'    => 'publish'
        );
    }
    $get_posts = get_posts($post_tag_args);
    $aval_sold = do_shortcode( '[sigma-mt-available-sold-text]' );
    $cat_title = $tag_category->name;
    $accordian_title = explode("(", $cat_title);
    if(!empty($get_posts)) {
        if($show_tab == 'yes'){
            $content .= '<div class="wrapper">
                            <div class="toggle">
                                <h3>'.$accordian_title[0].'</h3>
                                '.$aval_sold.'
                            </div>
                            <div class="content">';
        }
        $content .= '<div class="'.$main_class.'">';
            $counter = 0;
            $total_sponsors = count($get_posts);
            foreach($get_posts as $k => $sponsoring) {
                $exhibit_details = get_field('exhibit_details', $sponsoring->ID);
                $companies = isset($exhibit_details['sponsor_companies']) ? $exhibit_details['sponsor_companies'] : '';
                $sponsors_logo = isset($exhibit_details['sponsors_icon_upload']) ? $exhibit_details['sponsors_icon_upload'] : '';
				$sponsors_logo_url = isset($exhibit_details['sponsers_icon']) ? $exhibit_details['sponsers_icon'] : '';
                $sponsors_amount = isset($exhibit_details['amount']) ? $exhibit_details['amount'] : '';
                $sponsors_count = isset($exhibit_details['sponsors_count']) ? $exhibit_details['sponsors_count'] : '';
                $term_obj_list = get_the_terms( $sponsoring->ID, 'sponsoring-tag' );
                //$sponsors_status = isset($term_obj_list[0]->name) ? $term_obj_list[0]->name : '';
                $package = isset($exhibit_details['package']) ? $exhibit_details['package'] : '';
                $package_status = isset($exhibit_details['package_status']) ? $exhibit_details['package_status'] : '';
                $open = __( 'Open', 'sigmaigaming' );
                $sold_out = __( 'Closed', 'sigmaigaming' );
                $gold_pkg = __( 'Gold Package', 'sigmaigaming' );
                $outdoor_pkg = __( 'Outdoor Platinum', 'sigmaigaming' );
                $silver_pkg = __( 'Silver Package', 'sigmaigaming' );
                $platinum_outdoor_pkg = __( 'Outdoor Platinum Package', 'sigmaigaming' );
                $platinum_pkg = __( 'Platinum Package', 'sigmaigaming' );
                $bronze_pkg = __( 'Bronze Package', 'sigmaigaming' );
                $gold_pkg = __( 'Gold Package', 'sigmaigaming' );
                $meeting_room_pkg = __( 'Meeting Room Package', 'sigmaigaming' );
                $standard_pkg = __( 'Standard Package', 'sigmaigaming' );
                $branding_pkg = __( 'Branding Package', 'sigmaigaming' );
                $food_court_pkg = __( 'Food Court Sponsor', 'sigmaigaming' );
                $chillout_pkg = __( 'Chill Out Area', 'sigmaigaming' );
                if($package_status === $sold_out) {
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
                                        <img src='.($sponsors_logo != '' ? $sponsors_logo : $sponsors_logo_url).' alt="">
                                        '.$image.'
                                        <h4>'.$sponsoring->post_title.'</h4>
                                      </div>
                                      <div class="bottom '.$class.'">
                                        <span class="prcie">'.$sponsors_amount.'</span>
                                        <span class="sponsorCount">'.$sponsors_count.'</span>
                                      </div>
                                </div>';

                }
                if($appearance === $appearanceWork) {
                    if($package_status === $sold_out) {
                        $class = 'disable';
                    } else {
                        $class = 'active';
                    }
                    if($style === $styleExpand) {
                        $onclick = 'onclick="openExpanDiv(\'sponsorExpand'.$sponsoring->ID.'\', \'closeExpand'.$sponsoring->ID.'\')"';
                    } else {
                        $onclick = 'onclick="openModal(\'sponsorPopup'.$sponsoring->ID.'\', \'sponsorContent'.$sponsoring->ID.'\', \'closeSponsor'.$sponsoring->ID.'\')"';
                    }
                    $content .= '<div class="double-line">
                                    <div class="single-workshop" id="sponsorPopup'.$sponsoring->ID.'" '.$onclick.'>
										<div class="mainDiv">
											<div class="label">
												<span>'.$split_text[0].'</span>
											</div>
											<div class="work-content">
												<h5>'.$sponsoring->post_title.'</h5>
                                                <div class="description">';
                                                    if(!empty($style) && $style === $styleExpand) {
                                                        $content .= '<div id="sponsorExpand'.$sponsoring->ID.'" class="sponsor expandDiv">
                                                                    <div class="">
                                                                        <span class="close" id="closeSponsor'.$sponsoring->ID.'">&times;</span>';
                                                                        if(!empty($companies)){
                                                                            $content .= '<p class="ntw_item_main_title_row">';
                                                                            foreach($companies as $k => $companyid){
                                                                                $featured_image_company = wp_get_attachment_image_src( get_post_thumbnail_id( $companyid ), 'full' );
                                                                                if(!empty($featured_image_company)){
                                                                                    $content .= '<img class="igathering_img" src="'.$featured_image_company[0].'">';
                                                                                }
                                                                            }
                                                                            $content .= '</p>';
                                                                        }
                                                                        if(!empty($sponsoring->post_content)) {
                                                                            $content .='<div class="post_content">'.wpautop( $sponsoring->post_content, true ).'</div>';
                                                                        }
                                                                    $content .= '</div>
                                                                </div>';
                                                    }

												$content .= '</div><div class="amount">
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
                    } else if($package === $bronze_pkg) {
                        $class = 'bronze';
                        $image = '<img src="'.CHILD_DIR.'/exhibit/images/bronze-package-icon.png" alt="" class="soldout">';
                    } else if($package === $meeting_room_pkg) {
                        $class = 'meeting';
                        $image = '<img src="'.CHILD_DIR.'/exhibit/images/platinum-package-pink.png" alt="" class="soldout">';
                    } else if($package === $standard_pkg) {
                        $class = 'standard';
                        $image = '<img src="'.CHILD_DIR.'/exhibit/images/standard-package-icon.png" alt="" class="soldout">';
                    } else if($package === $branding_pkg) {
                        $class = 'branding';
                        $image = '<img src="'.CHILD_DIR.'/exhibit/images/branding-package-icon.png" alt="" class="soldout">';
                    } else if($package === $food_court_pkg) {
                        $class = 'food';
                        $image = '<img src="'.CHILD_DIR.'/exhibit/images/platinum-package-blue-icon-1.png" alt="" class="soldout">';
                    } else if($package === $chillout_pkg) {
                        $class = 'chillout';
                        $image = '<img src="'.CHILD_DIR.'/exhibit/images/platinum-package-pink.png" alt="" class="soldout">';
                    } else if($package === $platinum_outdoor_pkg) {
                        $class = 'outdoor';
                        $image = '<img src="'.CHILD_DIR.'/exhibit/images/platinum-outdoor-package-icon.png" alt="" class="soldout">';
                    } else {
                        $class = '';
                        $image = '';
                    }
                    $content .= '<div class="single-package '.$class.'" id="sponsorPopup'.$sponsoring->ID.'" onclick="openModal(\'sponsorPopup'.$sponsoring->ID.'\', \'sponsorContent'.$sponsoring->ID.'\', \'closeSponsor'.$sponsoring->ID.'\')">
                                    <div class="top">
                                        <h3>' . $package.'</h3>
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

                if ($appearance === $appearanceTab) {
                    $content .= '<div class="single-sponsor iconbtn" onclick="tabArrangments(event, \'sponsorTab'.$sponsoring->ID.'\')">
                                      <div class="top">
                                        <img src='.($sponsors_logo != '' ? $sponsors_logo : $sponsors_logo_url).' alt="">
                                        '.$image.'
                                        <h4>'.$sponsoring->post_title.'</h4>
                                      </div>
                                      <div class="bottom '.$class.'">
                                        <span class="prcie">'.$sponsors_amount.'</span>
                                        <span class="sponsorCount">'.$sponsors_count.'</span>
                                      </div>
                                </div>';

                    if ($total_sponsors-1 == $k) {
                        $content .= '</div><div>';
                    }
                }
				
                $content .= '<!-- The Modal -->
                            <div id="sponsorContent'.$sponsoring->ID.'" class="modal">
                                <!-- Modal content -->
                                <div class="modal-content">
                                    <span class="close" id="closeSponsor'.$sponsoring->ID.'">&times;</span>';
									if(!empty($companies)){
										$content .= '<p class="ntw_item_main_title_row">';
										foreach($companies as $k => $companyid){
											$featured_image_company = wp_get_attachment_image_src( get_post_thumbnail_id( $companyid ), 'full' );
											if(!empty($featured_image_company)){
												$content .= '<img class="igathering_img" src="'.$featured_image_company[0].'">';
											}
										}
										$content .= '</p>';
									}
                                    $content .= '<h4>'.$sponsoring->post_title.'</h4>';
                                    if(!empty($sponsoring->post_content)) {
                                        $content .='<div class="post_content">'.wpautop( $sponsoring->post_content, true ).'</div>';
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
        $content .= '</div>';

            if ($appearance == $appearanceTab) {
                foreach($get_posts as $k => $sponsoring) {
                    $content .= '<!-- The Tab Content -->
                    <div id="sponsorTab'.$sponsoring->ID.'" class="itemcontent">
                        <!-- The Tab Content -->
                        <h4>'.$sponsoring->post_title.'</h4>';
                                        if(!empty($sponsoring->post_content)) {
                                            $content .='<div class="post_content">'.wpautop( $sponsoring->post_content, true ).'</div>';
                                        }
                                        if(!empty($sponsors_amount)) {
                                            $content .='<div class="bottom '.$class.'">
                            <span class="prcie">'.$sponsors_amount.'</span>
                            <span class="status">'.$sponsors_count.'</span>
                        </div>';
                                        }
                    $content .= '</div>';
                }
                }
        if($show_tab == 'yes'){
            $content .= '</div>
                    </div>';
        }
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
                                <!--input type="checkbox" name="flexible_date_check" id="flexible_date_check" checked="">
                                <label for="flexible_date_check">Flexible Dates</label-->
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
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : -1;
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
                            //$hotel_icon = get_field('hotel_icon', $post->ID);
                            $hotel_icon = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
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
                                    <div class="logo">';
										if(!empty($hotel_icon)){
                                        	$content .= '<img src="'.$hotel_icon[0].'" alt="">';
										}
                                    $content .= '</div>
                                    <div class="rate">';
                                        $content .= $rating;
                                    $content .= '</div>
                                    <button class="show-more" onclick="openHotel(\'single-hotel'.$post->ID.'\', \'long'.$post->ID.'\')">'.__('Our Special Rate', 'sigmaigaming').'</button>
                                </div>
                                <div id="long'.$post->ID.'" class="long '.$openClass.'">
                                    <div class="close" onclick="closeHotel(\'single-hotel'.$post->ID.'\', \'long'.$post->ID.'\')"></div>
                                    <div class="hotel-detail">
                                        <h3>'.$post->post_title.'</h3>
                                        <p>'.$hotel_address.'</p>
                                        <p>'.$post->post_content.'</p>
                                    </div>
                                    <div class="img-gallery">';
                                    if(!empty($hotel_gallery)) {
                                        foreach($hotel_gallery as $img) {
                                            $content .= '<a href="#" class="wplightbox"><img src="'.$img["images"].'" alt=""></a>';
                                        }
                                    }
                                    $content .= '</div>';
									if(!empty($book_button) && isset($book_button['link']) && isset($book_button['link']['url']) && isset($book_button['text'])){
                                    	$content .= '<div class="buttons-wrapper"><a class="more" target="_blank" href="'.$book_button['link']['url'].'">'.$book_button['text'].'</a></div>';
									}
                                $content .= '</div>
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
    $term_id = $atts['term_id'];
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : -1;
    $show_fallback = isset($atts['show_fallback']) ? $atts['show_fallback'] : 'no';
    $post_tag_args = array(
      	'posts_per_page' 	=> $count,
      	'post_type' 		=> 'award-items',
        'orderby'        	=> 'post-date',
        'order'       		=> 'ASC',
		'tax_query' 		=> array(
			array(
				'taxonomy' => 'award-cat',
				'field' => 'term_id',
				'terms' => $term_id,
			)
		)
    );
    $get_posts = get_posts($post_tag_args);
    if(!empty($get_posts)) {
        $content .= '<div class="awards-wrapper">';
                        foreach($get_posts as $k => $post) {
                            $award_logo = get_field('award_logo', $post->ID);
                            //$sponsored_logo = get_field('sponsored_logo', $post->ID);
                            $company_logo = !empty(get_field('related_company', $post->ID)) ? wp_get_attachment_image_src( get_post_thumbnail_id( get_field('related_company', $post->ID) ), 'full' ) : [];
                            $description = get_field('description', $post->ID);
                            $content .= '<div class="award-box" id="award-box'.$post->ID.'" onclick="openAward(\'award-box'.$post->ID.'\')">
                                            <div class="box">
                                                <div class="top">
                                                    <img src="'.$award_logo.'" alt="">
                                                    <h5>'.$post->post_title.'</h5>
                                                    <div class="sponsored">';
														if($show_fallback == 'yes') {
                                                        	$content .= '<p>'. __( 'Sponsored by', 'sigmaigaming' ).'</p>';
														}
														if(!empty($company_logo)){
															$content .= '<img src="'.$company_logo[0].'" alt="">';
														} else if($show_fallback == 'yes') {
															$content .= '<img src="/fileadmin/fallback.png" alt="">';
														}
                                                    $content .= '</div>
                                                </div>
                                                <div class="bottom">
                                                    <span class="more">'. __( 'Read More', 'sigmaigaming' ).'</span>
                                                    <span class="less">'. __( 'Read Less', 'sigmaigaming' ).'</span>
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
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : -1;
    $term_id = isset($atts['term_id']) ? $atts['term_id'] : '';
    $page_id = $wp_query->get_queried_object()->ID;
    $post_args = array(
      'posts_per_page' => $count,
      'post_type' => 'gallery-items',
      'order'        => 'DESC',
      'post_status'    => 'publish',
      'tax_query' => array(
                array(
                    'taxonomy' => 'gallery-cat',
                    'field'    => 'term_id',
                    'terms'    => $term_id,
                    'operator' => 'IN'
                ),
            ),
    );
    $gallery = new WP_Query($post_args);
    //echo '<pre>'; print_r($gallery);
    if(!empty($gallery)) {
        if ($gallery->have_posts()) {
        while ($gallery->have_posts()) {
            $gallery->the_post();
            $year = get_the_date('Y');
            $posts_by_year[$year][] = ['ID' => get_the_ID(), 'title' => get_the_title(), 'link' => get_the_permalink(), 'Year' => $year,];
        }
    }
    $counter = 0; 
    $content .= '<div class="directory-gallery">
                    <div class="all-gallery gallery-directories">';
                        foreach($posts_by_year as $posts) {
                            ( $counter > 0 ) ? $style = 'display: none;' : $style = '';
                            $content .= '<div style="'.$style.'" data-div-term-id="'.$term_id.'" data-year='.$posts[0]['Year'].'>';
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
                            $counter++;
                            $content .= '</div> ';
                        }
                        $content .= '<input type="hidden" value="'.$term_id.'" id="termID">
                        <input type="hidden" value="'.$count.'" id="posts_per_page">
                        <input type="hidden" value="'.$post['title'].'" id="gallery_title">
                        <input type="hidden" value="'.$featured_image[0].'" id="featured_image">';
                    $content .= '<div class="load-gallery"><button class="load-more gallery-load-more" id="gallery-load-more" data-button-term-id="'.$term_id.'">Load More</button></div></div></div>
                </div>';
    }
    return $content;
}

// Shortcode for M and A Action
add_shortcode( 'sigma-mt-m-and-a-deals', 'sigma_mt_a_and_a_deals' );
function sigma_mt_a_and_a_deals($atts) {
    $content = '';
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : -1;
    $post_tag_args = array(
        'posts_per_page'    => $count,
        'post_type'         => 'm-and-a-deals',
        'orderby'           => 'post-date',
        'order'             => 'DESC',
    );
    $get_posts = get_posts($post_tag_args);
    if(!empty($get_posts)) {
        $content .= '<section class="m-and-a-action">
                        <div class="container nw-slider">';
                            foreach($get_posts as $post) { 
                                $biz_type = get_field('biz_type', $post->ID);
                                $market = get_field('market', $post->ID);
                                $valuation = get_field('valuation', $post->ID);
                                $closed = get_field('closed', $post->ID);
                                $broker = get_field('broker', $post->ID);
                                $reference_number = get_field('reference_number', $post->ID);
                                //echo '<pre>'; print_r($closed); echo '</pre>';
                                if($closed[0] == 'TRUE') {
                                    $class = "card-closed";
                                } else {
                                    $class = "";
                                }
                                $content .= '<div class="card-item '.$class.'">
                                                <a class="card-inneritem" href="mailto:eman@sigma.world">';
                                                    $image_icon = get_field('image_icon', $broker->ID);
                                                    $email = get_field('email', $broker->ID);
                                                    $content .= '<div class="profile-card">
                                                        <div class="leftinner"> 
                                                            <div class="left">
                                                                <h5 class="dealtitle">BROKER:</h5>
                                                                <div class="picture">
                                                                    <img src="'.$image_icon.'">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="rightinner">
                                                            <div class="right">
                                                                <div class="imgblk">
                                                                    <img src="/wp-content/uploads/2021/08/Mockup-sigma-logo.png">
                                                                </div>
                                                                <p class="dealstext dealer-name">'.$broker->post_title.'</p>';
                                                                if(!empty($email)) { $content .= '<p class="dealstext deal-email">'.$email.'</p>'; }
                                                            $content .= '</div>
                                                        </div>
                                                        <div class="reference-id">'.$reference_number.'</div>
                                                    </div>';
                                                    $content .= '<div class="infoSection">
                                                        <div class="info">
                                                            <div class="biz">
                                                                <img class="icon" src="/wp-content/uploads/2021/08/Biz-Type-09.png">
                                                                <p class="desc">
                                                                    <span>BIZ TYPE:</span> 
                                                                    <span class="operator-type">'.$biz_type.'</span> 
                                                                </p>
                                                            </div>
                                                            <div class="biz">
                                                                <img class="icon" src="/wp-content/uploads/2021/08/Market.webp">
                                                                <p class="desc">
                                                                    <span>MARKET</span> 
                                                                    <span class="operator-type">'.$market.'</span> 
                                                                </p>
                                                            </div>
                                                            <div class="biz">
                                                                <img class="icon" src="/wp-content/uploads/2021/08/Valuation.webp">
                                                                <p class="desc">
                                                                    <span>VALUATION</span> 
                                                                    <span class="operator-type">'.$valuation.'</span> 
                                                                </p>
                                                            </div>          
                                                        </div>
                                                    </div>
                                                </a>';
                                                if($closed[0] == 'TRUE') {
                                                    $content .= '<div class="container-close" data-ribbon="Closed" style="--d:8px;--c:red"></div>';
                                                }                                        
                                            $content .= '</div>';
                            }
                        $content .= '</div>
                    </section>';
    }
    return $content;
}

// Shortcode for M and A Action
add_shortcode( 'sigma-mt-m-and-a-brokers', 'sigma_mt_a_and_a_brokers' );
function sigma_mt_a_and_a_brokers($atts) {
    $content = '';
    $term_id = $atts['term_id'];
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : -1;
    $post_tag_args = array(
        'posts_per_page'    => $count,
        'post_type'         => 'company-items',
        'tax_query'         => array(
            array(
                'taxonomy' => 'company-cat',
                'field' => 'term_id',
                'terms' => $term_id,
            )
        )
    );
    $get_posts = get_posts($post_tag_args);
    if(!empty($get_posts)) {
        $content .= '<section class="m-and-a-action">
                        <div class="container broker-slider">';
                            foreach($get_posts as $post) { 
                                $company_details = get_field('company_details', $post->ID);
                                $url = isset($company_details['company_url']['url']) ? $company_details['company_url']['url'] :'';
                                $single_thumbnail = get_field('single_thumbnail', $post->ID);
                                $content .= '<div class="brokerItem">
                                              <div class="brokerItemInner">
                                                
                                                <a class="btn" target="_blank" href="'.$url.'" tabindex="0"><div> </div> </a>
                                                
                                                <div class="brokerImg">
                                                  <img src="'.$single_thumbnail.'">
                                                </div>
                                                <div class="brokerDescription">
                                                  <p>'.$post->post_content.'</p>
                                                </div>
                                              </div>
                                            </div>';
                            }
                        $content .= '</div>
                    </section>';
    }
    return $content;
}

//shortcode to get jobs
add_shortcode( 'sigma-mt-get-jobs', 'sigma_mt_get_jobs' );
function sigma_mt_get_jobs($atts) {
    $content = '';
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : -1;

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
    if(!empty($get_posts)) {
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
    } else {
        $content .= '<div class="job-listing">';
        $content .= '<div id="" class="single-jobs">
            <div class="logo">
            </div>
            <div class="long">
                <div class="job-detail">
                    <h3>No Record Found!</h3>
                </div>
                <div class="buttons-wrapper">
                </div>
            </div>
        </div>';
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
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : -1;
    $term_id = isset($atts['term_id']) ? $atts['term_id'] : '';
    $appearance = isset($atts['appearance']) ? $atts['appearance'] : '';
    $colorClass = isset($atts['color']) ? $atts['color'] : '';
    if(isset($term_id) && !empty($term_id)) {
        $post_args = array(
          'posts_per_page' => $count,
          'post_type' => 'testimonial-items',
            'orderby' => 'date',
            'order'   => 'ASC',
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
                                    //$people_icon = get_field('image_icon', $people->ID);
                					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $people->ID ), 'thumbnail' );
									if(!empty($featured_image)){
                                    	$content .= '<img src="'.$featured_image[0].'" alt="">';
									}
                                  $content .= '</div>
                                  <div class="client-txt">';
                                    $content .= '<h4 class="testimonial-title">'.get_the_title($people->ID).'</h4>';
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
                $people = get_field('people_relationship', $testimonial->ID);
                $testimonial_value = $r . '/' . $total;
                $company_name = get_field( "testimonial_company", $testimonial->ID );
                $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $people->ID ), 'thumbnail' );
                if(!empty($featured_image[0])) {
                    $featured_image = $featured_image[0];
                    $featured_title = $testimonial->post_title;
                } else {
                    $featured_image = '';
                    $featured_title = 'No Image Available';
                }
                $content .= '<figure class="testimonial">
                    <img src="' . $featured_image . '" alt="' . $featured_title . '" />
                    <div class="peopl">
                        <h3>' . $testimonial->post_title . '</h3>
                        <p class="company_name">' . $company_name . '</p>
                    </div>
                    <blockquote>' . wp_trim_words($testimonial->post_content, 20) .
                        '<div class="btn"></div>
                    </blockquote>
                    <span>' . $testimonial_value . '</span>
                </figure>';
                $r++; 
            }
            $content .= '</div>';
        } elseif ($appearance == 'broker') {
            $content .= '<div class="testimonial-slide-home broker-slide">';
            $r = 1;
            foreach($testimonials as $k => $testimonial) {
                $broker = get_field('broker_name', $testimonial->ID);
                $broker_email = get_field('broker_email', $testimonial->ID);
                $biz_type = get_field( "biz_type", $testimonial->ID );
                $market = get_field( "market", $testimonial->ID );
                $valuation = get_field( "valuation", $testimonial->ID );
                $closed = get_post_meta($testimonial->ID, 'closed', true);
                $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $testimonial->ID ), 'thumbnail' );
                if(!empty($featured_image[0])) {
                    $featured_image = $featured_image[0];
                    $featured_title = $testimonial->post_title;
                } else {
                    $featured_image = '';
                    $featured_title = 'No Image Available';
                }
                $content .= '<div><figure class="testimonial broker-testimonials">
                    <div>';
                if (is_array($closed) && in_array('closed', $closed)) {
                    $content .= '<img src="' . get_stylesheet_directory_uri() . '/assets/CLOSED_Ribbon-01.svg" class="closed">';
                }
                    $content .= '<h3 class="broker-title">BROKER:</h3>
                    <div class="broker-img">
                    <a href="mailto:' . $broker_email . '">
                    <img src="' . $featured_image . '" alt="' . $featured_title . '" /></a>
                    </div>
                    <div class="peopl">
                        <img src="' . get_stylesheet_directory_uri() .'/assets/envelope-regular.svg" id="mailIcon">
                        <a href="mailto:' . $broker_email . '">' . $broker . '</a>
                    </div>
                    <blockquote>
                    <p>BIZ TYPE: <span>' . $biz_type . '</span></p>
                    <p>MARKET: <span>'. $market . '</span></p>
                    <p>VALUATION: <span>'. $valuation . '</span></p>
                    </blockquote>
                     <span>REF000' . $r . '</span>
                </div></figure></div>';
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
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : -1;
    $author_id = isset($atts['author_id']) ? $atts['author_id'] : '';
    $term_id = isset($atts['term_id']) ? $atts['term_id'] : '';
    $term_name = isset($atts['term_name']) ? $atts['term_name'] : '';
    if(isset($author_id) && $author_id != '') {
        $post_args = array(
          'posts_per_page' => -1,
          'post_type' => 'news-items',
          'orderby'        => 'publish_date',
		  'order'          => 'DESC',
          'meta_query' => array(
				array(
					'key'	  	=> 'author',
					'value'	  	=> $author_id,
					'compare' 	=> '=',
				),
			),
        );
    } else if(isset($term_id) && $term_id != '') {
        $post_args = array(
          'posts_per_page' => $count,
          'post_type' => 'news-items',
          'orderby'        => 'publish_date',
		  'order'          => 'DESC',
          'tax_query' => array(
              array(
                  'taxonomy' => 'news-cat',
                  'field' => 'term_id',
                  'terms' => $term_id,
              )
          )
        );
    } else if(isset($term_name) && $term_name != '') {
        $post_args = array(
          'posts_per_page' => $count,
          'post_type' => 'news-items',
          'orderby'        => 'publish_date',
		  'order'          => 'DESC',
          'tax_query' => array(
              array(
                  'taxonomy' => 'news-cat',
                  'field' => 'slug',
                  'terms' => $term_name,
              )
          )
        );
    } else {
        $post_args = array(
          'posts_per_page' => $count,
          'post_type' => 'news-items',
          'orderby'        => 'publish_date',
		  'order'          => 'DESC',
          'post_status'    => 'publish'
        );
    }
    $relatedArticles = get_posts($post_args);
    if(!empty($relatedArticles)) {
		if(isset($author_id) && $author_id != '') {
			foreach($relatedArticles as $k => $item) {
				$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' );
				$content .= 
							'<div class="item item--post">
								<a class="more" href="' . get_permalink($item->ID); 
				if(!empty($featured_image)){
					$content .= '" style="background-image:url(' . "'" . $featured_image[0] . "'" . ')"';
				}
				$content .= 'target="_blank">
									<div class="post-desc">
										<h2>' . $item->post_title . '</h2>
									</div>
								</a>
							</div>';
			}
		} else {
			$content .= '<!-- Related Article Section -->
							<div class="pitch-articles related-articles">
								<div class="articles-slide">';
									foreach($relatedArticles as $k => $item) {
										$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' );
										if(!empty($featured_image[0])) {
											$featured_image = $featured_image[0];
											$featured_title = $item->post_title;
										} else {
											$featured_image = '';
											$featured_title = 'No Image Available';
										}
										$content .= '<a href="'.get_permalink($item->ID).'"><div class="testimonial">
														<div class="testi-details">
															<img src="'.$featured_image.'" alt="'.$featured_title.'" />
															<div class="post-title">
																<h3>'.$item->post_title.'</h3>
															</div>
														</div>
													</div></a>';
									}
								$content .= '</div>
							</div>
						<!-- Related Article Section end -->';
		}
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
          'orderby'        => 'title',
          'order'        => 'ASC',
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
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : -1;
    $appearance = isset($atts['appearance']) ? $atts['appearance'] : '';
    $colorClass = isset($atts['color']) ? $atts['color'] : '';
    $companyLists =  sigma_mt_get_all_company_lists_array($term_id, $count);
    if(!empty($companyLists)) {
        $content .= '<div class="charity-items '.$colorClass.'">
                            <input type="hidden" value="'.$count.'" id="meet_startup_last_year">';
                            foreach($companyLists as $k => $item) {
                                $logo_list = wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' );
                                //print_r($logo_list);
                                $logo = '';
                                $alt = __('No Image Available', 'sigmaigaming');
                                if(!empty($logo_list[0])) {
                                    $logo = $logo_list[0];
                                    $alt = $item->post_title;
                                }
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
                        <li id="" class="a_to_g active" data-regex="^[0-9a-gA-G].*">A - G</li>
                        <li id="" class="h_to_n" data-regex="^[h-nH-N].*">H - N</li>
                        <li id="" class="o_to_z" data-regex="^[o-zO-Z].*">O - Z</li>
                    </ul>
                </div>';
    return $content;
}

//Shortcode to display banner adds
add_shortcode( 'sigma-mt-magazines', 'sigma_mt_magazines' );
function sigma_mt_magazines($atts) {
    $content = '';
    $term_id = isset($atts['term_id']) ? $atts['term_id'] : '5';
    $post_per_page = isset($atts['post_per_page']) ? $atts['post_per_page'] : -1;
    $appearance = isset($atts['appearance']) ? $atts['appearance'] : '';
    $taxonomy = 'magazines-cat';
    $category = get_term_by('id', $term_id, $taxonomy);
    $post_args = array(
      'posts_per_page' => $post_per_page,
      'post_type' => 'magazine-items',
      'orderby'   => 'post_date',
      'order' => 'DESC',
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
    if ($appearance == 'latest-news') {
        $magazine_link = get_the_permalink(18372);
        $content .= '<div class="magazines-news"><div class="testimonial-slide-home">';
        $i = 1;
        foreach ($getMagazines as $magazine) {
            $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($magazine->ID), 'full');
            $content .= '<figure class="testimonial">
                            <a href="' . $magazine_link . '">';
            if ($i == 1) {
                $content .= '<img class="latest" src="' . get_stylesheet_directory_uri() . '/assets/LATEST_Banner.svg">';
            }
            $content .= '<div class="image-holder"><img src="' . $featured_image[0] . '" alt=""></div>
                                <div class="title">
                                    <h5>' . get_field('title', $magazine->ID) .'</h5>
                                    <h6>' . get_field('subtitle', $magazine->ID) .'</h6>
                                </div>
                            </a>
						</figure>';
            $i++;
        }
        if (isset($term_id) && $term_id == 1149) {
            $content .= '<figure class="testimonial">
                            <a href="' . $magazine_link . '">
                                <img src="' . get_stylesheet_directory_uri() .'/assets/Sigma-magazine-view-more.webp" alt="">
                                <div class="title">
                                    <h5><b>View All <br>Our Magazines</b></h5>
                                </div>
                            </a>
						</figure>';
        } elseif (isset($term_id) && $term_id == 1148) {
            $content .= '<figure class="testimonial block-section">
                            <a href="'. $magazine_link .'">
                                <img src="' . get_stylesheet_directory_uri() .'/assets/Blockchain-View-all-our-magazines.webp" alt="">
                                <div class="title">
                                    <h5><b>View All <br>Our Magazines</b></h5>
                                </div>
                            </a>
						</figure>';
        }
        $content .= '</div></div>';

    } else {
        $content .= '<section class="sigma-news">
                    <div class="container">';
        foreach ($getMagazines as $magazine) {
            $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id($magazine->ID), 'full');
            $magazineLink = get_field('link', $magazine->ID);
            $magazineLink = isset($magazineLink) ? $magazineLink : '#';
            $content .= '<div class="magazine-widget">
                                            <a href="' . $magazineLink . '" rel="noopener noreferrer">
                                                <img src="' . $featured_image[0] . '">
                                            </a>
                                        </div>';
        }
        $content .= '</div>
            </section>';
    }
    return $content;
}

// Shortcode for game providers
add_shortcode( 'sigma-mt-game-providers', 'sigma_mt_game_providers' );
function sigma_mt_game_providers($atts) {
    global $wp_query;
    $content = '';
    $link = isset($atts['link']) ? $atts['link'] : 'YES';
    $text = isset($atts['text']) ? $atts['text'] : '';
    $term_id = isset($atts['term_id']) ? $atts['term_id'] : '';
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : -1;
    $appearance = isset($atts['appearance']) ? $atts['appearance'] : '';
    $image = isset($atts['logo']) ? $atts['logo'] : NULL;
    $game_title = isset($atts['game_title']) ? $atts['game_title'] : NULL;
    $discover = isset($atts['discover']) ? $atts['discover'] : NULL;
    //$page_id = $wp_query->get_queried_object() ? $wp_query->get_queried_object()->ID : null;
    $post_args = array(
      'posts_per_page' => $count,
      'post_type'	   => 'company-items',
      'order'          => 'ASC',
      'orderby'        => 'title',
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
								$logo = wp_get_attachment_image_src( get_post_thumbnail_id( $game->ID ), 'full' );
                                $content .= '<div class="single-directory">';
								if($link != 'NO'){
                                	//$link = get_permalink($game->ID);
                                    $link = esc_url( add_query_arg( 'appearance', $appearance, get_permalink($game->ID) ) );
									$content .= '<a href="'.$link.'" target="_blank">';
								} else {
									$content .= '<a href="#">';
								}
								if(!empty($logo) && $image === 'YES') {
									$content .= '<img src="'.$logo[0].'" alt="">';
								}
								if(!empty($game->post_title) && $game_title === 'YES' ) {
									$content .= '<div class="provider-name">
                                                                        <h3>'.$game->post_title.'</h3>
                                                                    </div>';
								}
								if($discover === 'YES' ) {
									$content .= '<div class="provider-btn">
                                                            <p>'.__( 'Discover ' . $text, 'sigmaigaming' ).'</p>
                                                        </div>';
								}
								$content .= '</a>';
								$content .= '</div>';
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


// Shortcode for an upcoming event
add_shortcode( 'sigma_mt_show_sidebar_event', 'sigma_mt_show_sidebar_event' );
function sigma_mt_show_sidebar_event($atts) {
    
    $taxonomy = 'tribe_events_cat';
    $post_args = array(
        'posts_per_page' => 1,
        'post_type' => 'tribe_events',
        'orderby' => 'meta_value',
        'meta_key' => '_EventStartDate',
        'meta_value' => date('Y-m-d h:i'),
        'meta_compare' => '>=',
        'order' => 'ASC',
        'post_status'    => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy,
                'field' => 'term_id',
                'terms' => 1360
            )
        )
    );
    $get_posts = get_posts($post_args);
    if(!empty($get_posts)) {
        foreach($get_posts as $k => $post) {
            $event_data =   '<div class="calendar-event">
                                <h5>'.$post->post_title.'</h5> 
                                <div class="date">'.date_format(new DateTime(get_field('_EventStartDate', $post->ID)), 'F d, Y').'</div>
                                <div class="widget_type_rich-text">
                                    <p>
                                        <span>'.(strlen($post->post_content) < 200 ? $post->post_content : (substr($post->post_content, 0, 200). '...')).'</span>
                                    </p>
                                </div>
                                <a class="eventbtn" href="'.get_permalink($post->ID).'" target="_blank">'.__('REGISTER FREE', 'sigmaigaming').'</a>
                            </div>';
            return $event_data;
        }
    }
}

// Shortcode for the casino part of the sidebar
add_shortcode( 'sigma_mt_show_sidebar_casinos', 'sigma_mt_show_sidebar_casinos' );
function sigma_mt_show_sidebar_casinos($atts) {
    $content = '';
    $term_id = '1378';
    $count = -1;
    $results =  sigma_mt_get_casino_provider_data($term_id, $count);
    if(!empty($results)) {
        $content .= '<div class="offerwrap">';
        foreach($results as $k => $post) {
            setup_postdata( $post );
            $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
            $casino_provider = get_field('casino_details', $post->ID);
            $content .= '<div class="offeritem">
                            <div class="imgwrap">';
							if(!empty($featured_image)){
                              $content .= '<img src="'.$featured_image[0].'" alt="offer">';
							}
                            $content .= '</div>
                            <div class="linkwrap">
                              <a class="playbtn" target="_blank" rel="noreferrer noopener" href="'.(isset($casino_provider["play_link"]) ? $casino_provider["play_link"] : '#').'">'.__('*Play now', 'sigmaigaming').'</a>
                              <a class="tnclink" href="'.(isset($casino_provider["tc_url"]) ? $casino_provider["tc_url"] : '#').'">'.__('*T&amp;C Apply', 'sigmaigaming').'</a>
                            </div>
                          </div>';
        }
        $content .= '</div>';
    }
    return $content;
}

// Shortcode for the entire sidebar
add_shortcode( 'sigma_mt_show_sidebar', 'sigma_mt_show_sidebar' );
function sigma_mt_show_sidebar($atts) {
    $content = '<div class="sidebar">';
    $headerClass = isset($atts['header-class']) ? $atts['header-class'] : '';
    $elements = isset($atts['elements']) ? $atts['elements'] : '';
    $elementsArray = explode(", ", $elements);
    if(isset($elementsArray) && !empty($elementsArray)) {
        $post_tag_args = array(
            'posts_per_page' => -1,
            'post_type' => 'sidebar-elements',
            'post__in' => $elementsArray,
            'orderby' => 'post__in'
        );
    }
    $get_posts = get_posts($post_tag_args);
    if(!empty($get_posts)) {
        foreach($get_posts as $k => $post) {
            $title = get_field('title', $post->ID);
            $html = get_field('html', $post->ID);
            $shortcode = get_field('shortcode', $post->ID);
            $linked_images = get_field('linked_images', $post->ID);
            if($title != ''){
                $content .= '<div class="blog-sub-title ' . $headerClass . '">';
                $content .= '<h3>' . $title . '</h3>';
                $content .= '</div>';
                $content .= '<br />';
            }
            if($html != ''){
                $content .= $html;
                $content .= '<br /><br />';
            }
            if($shortcode != ''){
                $content .= do_shortcode($shortcode);
                $content .= '<br /><br />';
            }
            if(!empty($linked_images)) {
                foreach($linked_images as $l => $linked_image) {
                    if(isset($linked_image["link"]) && isset($linked_image["link"]["url"])){
                        $content .= '<a href="' . $linked_image["link"]["url"] . '" target="_blank">';
                        $content .= '<img class="sidebar-image" src="' . $linked_image["image"]["url"] . '" width="100%" />';
                        $content .= '</a>';
                    } else {
                        $content .= '<img src="' . $linked_image["image"]["url"] . '" width="100%" />';
                    }
                }
                $content .= '<br /><br />';
            }
        }
    }
    $content .= "</div>";
    return $content;
}


// Shortcode for the entire sidebar
add_shortcode( 'sigma_mt_show_affiliates_sidebar', 'sigma_mt_show_affiliates_sidebar' );
function sigma_mt_show_affiliates_sidebar($atts) {
    $content = '<div class="sidebar">';
    $term_id = isset($atts['term_id']) ? $atts['term_id'] : '';
    $posts_per_page = isset($atts['posts_per_page']) ? $atts['posts_per_page'] : '';
    $post_args = array(
      'posts_per_page' => $posts_per_page,
      'post_type' => 'company-items',
      'order'        => 'DESC',
      'post_status'    => 'publish',
      'tax_query' => array(
              array(
                  'taxonomy' => 'company-cat',
                  'field' => 'term_id',
                  'terms' => $term_id,
              )
          )
    );
    $get_posts = get_posts($post_args);
    if(!empty($get_posts)) {
        foreach($get_posts as $k => $post) {
            $content .= '<div class="affiliates-single">
                            <article class="" style="margin-bottom:15px;">
                                <a href="'.get_permalink($post->ID).'">
                                    <div class="thumb2">
                                        <img src="'. wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0] .'">
                                    </div>
                                    <div>
                                        <h2 class="big">'.$post->post_title.'</h2>
                                    </div>
                                </a>
                            </article>
                        </div>';
        }
    }
    $content .= "</div>";
    return $content;
}

// Shortcode for calendar subentries (intra-day events)
add_shortcode( 'sigma-mt-calendar-subentries', 'sigma_mt_calendar_subentries' );
function sigma_mt_calendar_subentries($atts) { 
    // parent="2345"  style="tabular" (or timeline)
    $parent = isset($atts['parent']) ? explode(', ', $atts['parent']) : [];
    $style = isset($atts['style']) ? $atts['style'] : '';
    $showHeader = isset($atts['show-header']) ? $atts['show-header'] : 'yes';
    $taxonomy = 'tribe_events_cat';
	if(!empty($parent)){
		$post_args = array(
			'posts_per_page' => -1,
			'post_type' => 'tribe_events',
			'orderby' => 'meta_value',
			'meta_key' => '_EventStartDate',
			'order' => 'ASC',
			'post_status'    => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => $taxonomy,
					'field' => 'term_id',
					'terms' => $parent
				)
			)
		);
		$return_data = '';
		$get_posts = get_posts($post_args);
		if(!empty($get_posts)) {
			$posts_by_day = [];
			foreach($get_posts as $k => $post) {
				$startDateTime = new DateTime(get_field('_EventStartDate', $post->ID));
				$startDate = $startDateTime->format('d M');
				$posts_by_day[$startDate][] = $post;
			}


			if($style == 'timeline'){
				$event_data = '';
				$header_data = '<ul class="agenda-submenu" role="menu">';
				$i = 0;
				foreach($posts_by_day as $day => $posts) {
					$header_data .= '<li class="hs-menu-item hs-menu-depth-1 agenda-header-link'.($i > 0 ? '' : ' active').'" data-target="'.$i.'"><a href="#">'.($i > 0 ? (__('Day', 'sigmaigaming') . ' ' . $i . '<br />') : '') .$day.'</a></li>';
					$event_data .= '<div class="dailyWrapper" data-element="'.$i . '"';
					if($i > 0){
						$event_data .= ' style="display: none;"';
					}
					$event_data .= '>';
					foreach($posts as $index => $post) {
						$startDateTime = new DateTime(get_field('_EventStartDate', $post->ID));
						$endDateTime = new DateTime(get_field('_EventEndDate', $post->ID));
						$event_data .=   '<div class="agendaiteminnerwrap">
											<div class="agendaitemleft">
											  <div class="agendatimestart">
												<span>' . $startDateTime->format('H:i') . '</span>  
											  </div>
											</div>
											<div class="agendaitemright">
											  <div class="agendaitemrightinner">
												<h4>'.$post->post_title.'</h4>
												<h5>
												  <span>' . $startDateTime->format('H:i') . ' - ' . $endDateTime->format('H:i') . '</span>';
						if(!empty(get_field('_EventVenueID', $post->ID) )){
							$venueId = get_field('_EventVenueID', $post->ID);
							$event_data .= '<span> | <a href="'.tribe_get_map_link( $post->ID ).'" target="_blank">'.get_the_title($venueId).'</a></span>';
						}
						$event_data .= '</h5>
													<h6>
													  '.$post->post_content.'
													</h6>';

						// get top items related to event and group them by room
						$conference_args = array(
							'posts_per_page'    => -1,
							'post_type'         => 'conference-items',
							'orderby' 			=> 'meta_value',
							'meta_key' 			=> 'start',
							'order'             => 'ASC',
							'meta_query'         => array(
								array(
									'key'		=> 'event',
									'value'		=> $post->ID,
									'compare'	=> '='
								),
							)
						);
						$conferences = get_posts($conference_args);
						$conferences_by_rooms = [];
						foreach($conferences as $key => $conference ){
							$room = get_field('room', $conference->ID);
							$conferences_by_rooms[$room][] = $conference;
						}
						// if has rooms 
						if(!empty($conferences_by_rooms)){
							$event_data .= '<div class="roomsection">';
							// foreach room
							foreach($conferences_by_rooms as $room => $confs){
								$event_data .= '<div class="conferenceroomdetail room-group" style="flex-basis: 48%;">
															  <h3 class="roomtitle">' . $room . '</h3>
															  <div class="roomdetail">';
								// Foreach top level conference
								foreach($confs as $confkey => $conf){
									$start_time = get_field('start', $conf->ID);
									$end_time = get_field('end', $conf->ID);
									$event_data .= '<div class="single-conf">
																		<div class="conf-name action-expand"><span class="time">' . date_format(new DateTime($start_time), 'H:i') . ' - ' . date_format(new DateTime($end_time), 'H:i') . '</span>
																		   <span class="title">' . $conf->post_title. '</span>
																		</div>';
									// RETRIEVE SUBAGENDAS
									$subconfs_args = array(
										'posts_per_page'    => -1,
										'post_type'         => 'conference-items',
										'orderby' 			=> 'meta_value',
										'meta_key' 			=> 'start',
										'order'             => 'ASC',
										'meta_query'         => array(
											array(
												'key'		=> 'parent_conference',
												'value'		=> $conf->ID,
												'compare'	=> '='
											),
										)
									);
									$subconfs = get_posts($subconfs_args);
									// IF HAS SUBAGENDAS
									if(!empty($subconfs)){
										$event_data .= '<div class="confdedtails">
															<div class="conferencechair"></div>
															<div class="conf_desc_wrap"></div>
															<div class="agenda-wrapper">';
										// foreach subagenda
										foreach($subconfs as $subconfkey => $subconf){
											$start_time_sub = get_field('start', $subconf->ID);
											$end_time_sub = get_field('end', $subconf->ID);
											$speakers = get_field('speakers', $subconf->ID);
											
											$event_data .= '<div class="single-agenda">
																<div class="leftagenda">' . date_format(new DateTime($start_time_sub), 'H:i') . '<br />' . date_format(new DateTime($end_time_sub), 'H:i') . '</div>
																<div class="rightagenda">
																		<div class="title">' . $subconf->post_title . '</div>
																		<div class="desc"></div>';
											if(!empty($speakers)){
												foreach($speakers as $speakerkey => $speaker){
													if(isset($speaker["speaker"]) && $speaker["speaker"] != ''){
														$speaker_id = $speaker["speaker"];
														$company = get_field('company', $speaker_id);
														$person_image = get_field('image_icon', $speaker_id);
														$designation = get_field('designation', $speaker_id);
														$event_data .= '<div class="speaker-wrapper">
																		<div class="person">
																			<div class="avatar"><img src="' . $person_image . '" /></div>
																			<div class="persondetail">
																				<h4>' . get_the_title($speaker_id) .'</h4>
																				<h5>' . $designation .'</h5>
																				<h6>' . get_the_title($company) .'</h6>
																			</div>
																		</div>
																		</div>';
													}
												}
											}
											// ENDIF HAS SPEAKERS
											$event_data .= '</div></div>';
										}
										// end foreach subagenda
										$event_data .= '</div></div>';
									} else {
										$event_data .= '<div class="confdedtails">
															<p>' . __('No Schedule yet.', 'sigmaigaming') . '</p>
														</div>';
									}
									// END IF HAS SUBAGENDAS
									$event_data .= '</div>';
								}
								// end foreach toplevel conference
								$event_data .= '</div></div>';
							}
							// end foreach room
							$event_data .= '</div>';
						}
						// endif has rooms 
						$event_data .= '</div>
								</div>
							</div>';
					}
					$event_data .= '
							</div>';
					$i++;
				}
				$header_data .= '</ul>';
				$return_data = $showHeader == 'yes' ? $header_data . $event_data : $event_data;
			} else if($style == 'tabular') {
				$event_data = '';
				$header_data = '<div class="agenda-roadshow-menu agendamenu"><ul role="menu">
				  <li class="hs-menu-item hs-menu-depth-1" role="none" style="color: grey;"><a href="javascript:void(0)" role="menuitem" target="_self" style="border-color: grey;">3rd March<br>Ukraine</a></li>
				  <li class="hs-menu-item hs-menu-depth-1" role="none" style="color: grey;"><a href="javascript:void(0)" role="menuitem" target="_self" style="border-color: grey;">7th April<br>Las Vegas</span></a></li>
				  <li class="hs-menu-item hs-menu-depth-1" role="none" style="color: grey;"><a href="javascript:void(0)" role="menuitem" target="_self" style="border-color: grey;">5th May<br>Manila</a></li>
				  <li class="hs-menu-item hs-menu-depth-1" role="none" style="color: grey;"><a href="javascript:void(0)" role="menuitem" target="_self" style="border-color: grey;">16th June<br>Germany</a></li>
				  <li class="hs-menu-item hs-menu-depth-1" role="none" style="color: grey;"><a href="javascript:void(0)" role="menuitem" target="_self" style="border-color: grey;">7th July<br>Nigeria</a></li>';
				$i = 0;
				$colors = ['04 Aug' => 'rgb(3, 77, 140)', '13 Sep' => 'rgb(33, 178, 92)', '14 Sep' => 'rgb(33, 178, 92)'];
				$titles = ['04 Aug' => 'Nordics &amp;<br />Netherlands', '13 Sep' => 'North<br />Americas', '14 Sep' => 'South<br />Americas'];
				foreach($posts_by_day as $day => $posts) {
					$i++;
					$header_data .=  '<li class="hs-menu-item hs-menu-depth-1 agenda-header-link" data-target="'.$i.'" role="none" style="color: '.$colors[$day].';"><a href="javascript:void(0)" role="menuitem" target="_self" class="active" style="border-color: '.$colors[$day].'; color: '.$colors[$day].';">'.$day.'<br>'.$titles[$day].'</span></a></li>';
					$event_data .= '<div class="sim-single-conf dailyWrapper" data-element="'.$i . '"';
					if($i > 1){
						$event_data .= ' style="display: none;"';
					}
					$event_data .= '><div class="sim-confdedtails"><div class="sim-agenda-wrapper">';
					foreach($posts as $index => $post) {
						$startDateTime = new DateTime(get_field('_EventStartDate', $post->ID));
						$endDateTime = new DateTime(get_field('_EventEndDate', $post->ID));
						$event_data .=   '<div class="sim-single-agenda">
                          <div class="sim-leftagenda">
                             <span>' . $startDateTime->format('H:i') . ' - ' . $endDateTime->format('H:i') . ' ' . $endDateTime->getTimezone()->getName() . '</span>
                          </div>
                          <div class="sim-rightagenda">
                            <div class="title">
                              	'.$post->post_title.'
                            </div>
                            <div class="desc">
								'.$post->post_content.'
                            </div>
                            <div class="sim-speaker-wrapper">';
						
						$people_args = array(
							'post_type'		=> 'people-items',
							'meta_query'	=> array(
							  array(
								'key' => 'events',
								'value' => '"'.$post->ID.'"',
								'compare' => 'LIKE'
							  )
							)
						);
						$people = get_posts($people_args);
						if(!empty($people)){
							foreach($people as $k => $person){
								$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $person->ID ), 'full' );
								$event_data .= '<div class="person">';
								if(!empty($featured_image)){
									$event_data .= '<div class="avatar"><img src="'.$featured_image[0].'"></div>';
								}
								$event_data .= '<div class="persondetail">
												  <h4>'.$person->post_title.'</h4>
												  <h5>'.get_field('designation', $person->ID).' </h5>
												  <h6>'.get_the_title(get_field('company', $person->ID)).'</h6>
												</div>
											  </div>';
							}
						}
						$event_data .= '</div>
                          </div>
                        </div>';
					}
					$event_data .= '</div></div></div>';
				}
				$header_data .= '</ul></div>';
				$return_data = $showHeader == 'yes' ? $header_data . $event_data : $event_data;
			}
		}
		return $return_data;
	}
	return '';
}

// Shortcode for calendar entries (day-long events)
add_shortcode( 'sigma-mt-calendar-buttons', 'sigma_mt_calendar_buttons' );
function sigma_mt_calendar_buttons($atts) {
	return '<div class="navigations-wrapper">
		<div class="display-type-year">
			<ul>        
				<li class="list calendarswitcher active" data-target="all">ALL EVENTS</li>
				<li class="list calendarswitcher" data-target="affiliate">GAMING AFFILIATE RELATED EVENTS</li>
				<li class="list calendarswitcher" data-target="b2b">B2B</li>
				<li class="list calendarswitcher" data-target="networking">NETWORKING AND AWARDS</li>
				<li class="list calendarswitcher" data-target="regulatory">REGULATORY</li>
				<li class="list calendarswitcher" data-target="landbased">LAND-BASED</li>
				<li class="list calendarswitcher" data-target="online">ONLINE</li>
				<li class="list calendarswitcher" data-target="other">ALL OTHER AFFILIATE RELATED EVENTS</li> 
			</ul>
		</div>
	  </div>';
}
// Shortcode for calendar entries (day-long events)
add_shortcode( 'sigma-mt-calendar-entries', 'sigma_mt_calendar_entries' );
function sigma_mt_calendar_entries($atts) {
	
    $type = isset($atts['type']) ? $atts['type'] : '';
    $range = isset($atts['range']) ? $atts['range'] : '';
    $annualHeaders = isset($atts['annualheaders']) ? $atts['annualheaders'] : "false";
    $hide = isset($atts['hide']) ? $atts['hide'] : "false";
    $className = isset($atts['classname']) ? $atts['classname'] : "default";
    $term_id = isset($atts['term_id']) ? $atts['term_id'] : '';
    $firstActive = isset($atts['firstActive']) ? $atts['firstActive'] : "false";
    $sort = isset($atts['sort']) ? $atts['sort'] : 'DESC';
    //  type="igathering" range="future" annualHeaders="false" showFilters="false" firstActive="false" sort="asc"
    $taxonomy = 'tribe_events_cat';
    $post_args = [];
	
	$term = '';
	if($term_id != ''){
		$term = $term_id;
	} else if($type == 'igathering'){
		$term = '1364';
	} else {
		$term = '1360';
	}
	
    if($range == 'future'){
        $post_args = array(
            'posts_per_page' => -1,
            'post_type' => 'tribe_events',
            'orderby' => 'meta_value',
            'meta_key' => '_EventStartDate',
            'meta_value' => date('Y-m-d h:i'),
            'meta_compare' => '>=',
            'order' => $sort,
            'post_status'    => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $term
                )
            )
        );
    } else if($range == 'past'){
        $post_args = array(
            'posts_per_page' => -1,
            'post_type' => 'tribe_events',
            'orderby' => 'meta_value',
            'meta_key' => '_EventStartDate',
            'meta_value' => date('Y-m-d h:i'),
            'meta_compare' => '<',
            'order' => $sort,
            'post_status'    => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $term
                )
            )
        );
    } else {
        $post_args = array(
            'posts_per_page' => -1,
            'post_type' => 'tribe_events',
            'orderby' => 'meta_value',
            'meta_key' => '_EventStartDate',
            'order' => $sort,
            'post_status'    => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $term
                )
            )
        );
    } 
    $get_posts = get_posts($post_args);
	$event_data =   '<section class="date-outerbox box_' . $className . '"';
	if($hide == 'true'){
		$event_data .= ' style="display: none;"';
	}
	$event_data .= '>';
    if(!empty($get_posts)) {	
		if($annualHeaders == "true"){			
			$posts_by_year = [];
			foreach($get_posts as $k => $post) {
				$startDateTime = new DateTime(get_field('_EventStartDate', $post->ID));
				$startYear = $startDateTime->format('Y');
				$posts_by_year[$startYear][] = $post;
			}
			foreach($posts_by_year as $yr => $posts){
				$event_data .= '<h2 class="year">'.$yr.'</h2>';
				foreach($posts as $k => $post) {
					$venueId = get_field('_EventVenueID', $post->ID);
					$startDateTime = new DateTime(get_field('_EventStartDate', $post->ID));
					$event_data .=   '<div class="date-box">
						<div class="row-top">
						  <div class="date">
							<span class="day">'.$startDateTime->format('d').'</span>
							<span class="month">'.$startDateTime->format('M').'</span>
							<span class="year">'.$startDateTime->format('Y').'</span>
						  </div>
						  <div class="title">
							<div class="wrapper">
								<div class="col col--1">'
								.
								$post->post_title
								.
								'</div>
								<div class="col col--2">
								  '.get_the_title($venueId).'
								</div>
							</div>
						  </div>
						</div>
						<div class="row-bottom show">

						  <div class="description">
							<div>

								<div class="hs_cos_wrapper_type_inline_rich_text">  
									'.$post->post_content.'
								</div>
							</div>


						  </div>

						</div>
					  </div>';
				}
			}
		} else if($type == 'igathering'){
			$event_data .= '<div class="wrapper">
								<div class="toggle">
									<h3 style="color:#ED1A3B!important;">'.($range == 'future' ? __('Host the next iGathering', 'sigmaigaming') : __('Past iGatherings', 'sigmaigaming')).'</h3>
									<div class="all-sell">';
			if($range == 'future'){
										$event_data .= '<p class="sell">
											<span style="color:#44c156;"><i class="fa fa-bookmark" aria-hidden="true"></i> Available</span>
											<span style="color:#ed1a3b;"><i class="fa fa-bookmark" aria-hidden="true"></i>  Sold Out</span>
										</p>';
			}
			$event_data .= '			<i class="fas fa-plus icon"style="color:#ED1A3B!important;"></i>
									</div>
								</div>
								<div class="content"><br />';
			foreach($get_posts as $k => $post) {
				$venueId = get_field('_EventVenueID', $post->ID);
				$startDateTime = new DateTime(get_field('_EventStartDate', $post->ID));
				$companies = get_field('companies', $post->ID);
				$event_data .=   '<div class="date-box">
					<div class="row-top">
					  <div class="date">
						<span class="day">'.$startDateTime->format('d').'</span>
						<span class="month">'.$startDateTime->format('M').'</span>
						<span class="year">'.$startDateTime->format('Y').'</span>
					  </div>
					  <div class="title">
						<div class="wrapper">
							<div class="col col--1">'
							.
							$post->post_title
							.
							'</div>
							<div class="col col--2">
							  '.get_field('price', $post->ID).'
							</div>';
							if($range != 'past'){
							  if(get_field('fully_booked', $post->ID) == true){
								  $event_data .= '<div class="ribbon inactive "><i class="fa fa-bookmark" aria-hidden="true"></i></div>';
							  } else {
								  $event_data .= '<div class="ribbon active "><i class="fa fa-bookmark" aria-hidden="true"></i></div>';
							  }
							}
							$event_data .= '
						</div>
					  </div>
					</div>
					<div class="row-bottom show">

					  <div class="description">
						<div>';
							if(!empty($companies)){
								$event_data .= '<p class="ntw_item_main_title_row">';
								foreach($companies as $k => $companyid){
									$featured_image_company = wp_get_attachment_image_src( get_post_thumbnail_id( $companyid ), 'full' );
									if(!empty($featured_image_company)){
										$event_data .= '<img class="igathering_img" src="'.$featured_image_company[0].'">';
									}
								}
								$event_data .= '</p>';
							}
							$event_data .= '<div class="hs_cos_wrapper_type_inline_rich_text">  
								<p><strong>' . $post->post_title . '</strong></p>
								<p><strong>' . __('Date', 'sigmaigaming'). ': ' . $startDateTime->format('d M Y') . '</strong></p>';
							if($venueId != ''){
								$event_data .= '<p><strong>' . __('Venue', 'sigmaigaming'). ': ' . get_the_title($venueId) . '</strong></p>';
							}
							$event_data .= wpautop( $post->post_content, true ).'
							</div>


							<div class="bot">
								<span class="prcie">'.get_field('price', $post->ID).'</span>
								<span class="sponsorship '. (get_field('fully_booked', $post->ID) == true ? '' : 'inactive') .'">'.get_field('status', $post->ID).'</span>

							</div>
						</div>


					  </div>

					</div>
				  </div>';
			}
			$event_data .= '</div></div>';
        }
    }
	$event_data .= '</section>';
	return $event_data;
}
// Shortcode for calendar entries (day-long events)
add_shortcode( 'sigma_mt_latest_news', 'sigma_mt_latest_news' );
function sigma_mt_latest_news($atts) {
    $content = '<div class="recent-posts-wrapper">';
    $the_query = new WP_Query( array(
        'post_type' => 'news-items',
        'posts_per_page' => 10,
    )); 
    if ( $the_query->have_posts() ){
    
        while ( $the_query->have_posts() ) : $the_query->the_post();
            $content .= '<div class="post-item">
                <span style="margin-bottom: 0px;"> <a class="more-link" href="' . get_permalink() . '">' . get_the_title() . '</a></span>
                <div class="info">
                    <div>
                        <strong>';
            $categories = wp_get_post_terms( get_the_ID(),array( 'news-cat' ) );
            foreach($categories as $c){ 
                $cat = get_category( $c );
                $content .= '<a style="text-decoration: none;color:#e21735;" class="topic-link" href="' . get_term_link($cat) . '"> ' . $cat->name . '<span>,</span></a>';
            }
            $content .= '</strong> 
                    </div>
                </div>
            </div>';    
        endwhile;
        wp_reset_postdata();
    } else {
        $content .= '<p>' . __('No News') . '</p>';
    }
    $content .= '</div>';
    return $content;
}

//shortcode to get Awards
add_shortcode( 'sigma-mt-deep-tech-insights', 'sigma_mt_deep_tech_insights' );
function sigma_mt_deep_tech_insights($atts) {
    $content = '';
    $term_id = $atts['term_id'];
    $count = isset($atts['post_per_page']) ? $atts['post_per_page'] : -1;
    $post_tag_args = array(
        'posts_per_page'    => $count,
        'post_type'         => 'news-items',
        'orderby'           => 'post-date',
        'order'             => 'DESC',
        'tax_query'         => array(
            array(
                'taxonomy' => 'news-cat',
                'field' => 'term_id',
                'terms' => $term_id,
            )
        )
    );
    $get_posts = get_posts($post_tag_args);
    if(!empty($get_posts)) {
        $deep_tech_insights = get_field('deep_tech_insights');
        $content .= '<section class="deep-insights">
                        <div class="container">';
                            if(!empty($deep_tech_insights['title'])) {
                                $content .= '<div class="page-title">
                                                <h2>'.$deep_tech_insights['title'].'</h2>
                                            </div>';
                            }
                            $content .= '<div class="deep-insights-slider1">';
                                foreach($get_posts as $post) { 
                                    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                                    $content .= '<div class="insights-slide">
                                                    <div class="insight-box">
                                                        <a href="'.get_permalink($post->ID).'"><div class="insight-img">
                                                            <img src="'.$featured_image[0].'" alt="">
                                                        </div>
                                                        <div class="insight-txt">
                                                            <h3>'.$post->post_title.'</h3>
                                                        </div></a>
                                                    </div>
                                                </div>';
                                }
                            $content .= '</div>
                        </div>
                    </section>';
    }
    return $content;
}

add_shortcode( 'podcast-custom-popup', 'podcast_custom_popup_content' );
function podcast_custom_popup_content() {
    echo '<div class="podcast-popup">
        <div class="podcast-popupinner">
            <iframe width="1366" height="800" src="https://www.youtube.com/embed/SCm76e0lPPA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>';
}

add_action( 'save_post', 'sigma_mt_disable_autoupdate_slug', 10, 3 );

function get_attachment_id($url)
{
    $attachment_id = 0;

    $dir = wp_upload_dir();

    if (false !== strpos($url, $dir['baseurl'] . '/')) { // Is URL in uploads directory?

        $file = basename($url);

        $query_args = array(
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'fields' => 'ids',
            'meta_query' => array(
                array(
                    'value' => $file,
                    'compare' => 'LIKE',
                    'key' => '_wp_attachment_metadata',
                ),
            )
        );

        $query = new WP_Query($query_args);

        if ($query->have_posts()) {

            foreach ($query->posts as $post_id) {

                $meta = wp_get_attachment_metadata($post_id);

                $original_file = basename($meta['file']);
                $cropped_image_files = wp_list_pluck($meta['sizes'], 'file');

                if ($original_file === $file || in_array($file, $cropped_image_files)) {
                    $attachment_id = $post_id;
                    break;
                }
            }
        }
    }
    return $attachment_id;
}

function check_if_media_exists($filename)
{
    global $wpdb;
    $query = "SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE meta_value LIKE '%/$filename'";
    return ($wpdb->get_var($query) > 0);
}

function set_post_thumbnail_from_content()
{
    global $post, $posts;
    ob_start();
    ob_end_clean();

    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    if (!get_the_post_thumbnail($post->ID)) {
        preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

        $image_url = $matches[1][0];

        $media_file = check_if_media_exists($image_url);

        if (!$media_file) {
            $image_id = media_sideload_image($image_url, $post->ID, '', 'id');
        } else {
            $image_id = attachment_url_to_postid($image_url);

            if (empty($image_id)) {
                $image_id = get_attachment_id($image_url);
            }
        }

        return set_post_thumbnail($post->ID, $image_id);
    }
}