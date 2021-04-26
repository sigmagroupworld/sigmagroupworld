<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles',PHP_INT_MAX);
function my_theme_enqueue_styles() {
    $parent_style = 'adforest-style'; // This is 'adforest-style' for the AdForest theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
	
	/*custom JS*/
	wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
	wp_enqueue_script( 'header-js', get_stylesheet_directory_uri().'/assets/js/custom-header.js');
	
}

include get_stylesheet_directory().'/cpt-functions.php';

// change permalink for Custom post type
/*add_filter( 'post_type_link', 'sigma_mt_show_permalinks', 1, 2 );
function sigma_mt_show_permalinks( $post_link, $post ){
    if ( is_object( $post ) && $post->post_type == 'news-items' ){
        $terms = wp_get_object_terms( $post->ID, 'news-tag' );
        if( $terms ){
            return str_replace( '%news-tag%' , $terms[0]->slug , $post_link );
        }
    }
    return $post_link;
}*/



function upcoming_event_shortcode(){
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
add_shortcode('upcoming-event', 'upcoming_event_shortcode');