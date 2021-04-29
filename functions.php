<?php

define( 'CHILD_DIR', get_theme_file_uri() );

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles',PHP_INT_MAX);
function my_theme_enqueue_styles() {
    $parent_style = 'adforest-style'; // This is 'adforest-style' for the AdForest theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
	
}

// load js files in footer & style in header start

function sigma_mt_scripts() {
    /*wp_enqueue_script('sigmamt-main-script', get_template_directory_uri() . '/assets/js/custom12.js', array(), false, true);
    wp_enqueue_style('sigmamt-fontawesome', get_stylesheet_uri() . '/assets/js/all.css', null, false);*/
    wp_enqueue_script('jquery');
    wp_enqueue_style('sigmamt-fontawesome', CHILD_DIR . '/assets/css/all.css', array(), '1.0.0', true);
    wp_enqueue_script( 'sigmamt-main-script', CHILD_DIR . '/assets/js/custom.js', array(), '1.0.0', true );
}
add_action('wp_enqueue_scripts', 'sigma_mt_scripts');

// load js files in footer & style in header end

include get_stylesheet_directory().'/cpt-functions.php';

// For upcoming news
function sigma_mt_upcoming_event_shortcode(){
    ob_start();
    $upcomingevent = get_field('upcoming_event', 'option');
    if(is_array($upcomingevent) && !empty($upcomingevent)){
    ?>
		<div class="upcomingeventsection">
			<div class="upcomingeventheading">
				<h2><?php echo $upcomingevent['title']; ?></h2>
			</div>
			<div class="upcomingeventintro">
				<h3><?php echo $upcomingevent['event_name']; ?></h3>
				<h4><?php echo $upcomingevent['event_date']; ?></h4>
				<p><?php echo $upcomingevent['event_description']; ?></p>
				<a href="<?php echo $upcomingevent['button_link']; ?>"><?php echo $upcomingevent['button_text']; ?></a>
			</div>
		</div>    
    <?php
    }
    return ob_get_clean();
}
add_shortcode('upcoming-event', 'sigma_mt_upcoming_event_shortcode');



// Shortcode for search form
function wpbsearchform( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="search-form" action="' . home_url( '/' ) . '" >
    <div><label class="" for="s"><i aria-hidden="true" class="fa fa-search"></i></label>
    <input type="text" class="search-field" value="' . get_search_query() . '" name="s" id="s" />
    <input type="submit" class="search-submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
    </div>
    </form>';
    return $form;
}
add_shortcode('wpbsearch', 'wpbsearchform');

add_action( 'after_setup_theme', 'my_theme_setup' );
function my_theme_setup(){
  load_theme_textdomain( 'wpml_theme', get_template_directory() . '/languages' );
}