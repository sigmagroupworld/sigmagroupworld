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
}
/*add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}*/

include(get_stylesheet_directory_uri() . '/cpt-functions.php');

// create a Custom post type news
add_action('init', 'sigma_mt_news_custom_posts');
function sigma_mt_news_custom_posts() {
	register_post_type('news-items', array(
		'labels' => array(
			'name' => __('News', 'sigmaigaming'),
			'singular_name' => __('News', 'sigmaigaming'),
			'menu_name' => __('News', 'sigmaigaming'),
			'add_new' => __('Add News Item', 'sigmaigaming'),
			'add_new_item' => __('Add News Item', 'sigmaigaming'),
			'edit_item' => __('Edit News Item', 'sigmaigaming'),
			'new_item' => __('News Items', 'sigmaigaming'),
			'view_item' => __('View News Items', 'sigmaigaming'),
			'search_items' => __('Search News Items', 'sigmaigaming'),
			'not_found' => __('No News Items found', 'sigmaigaming'),
			'not_found_in_trash' => __('No News Items found in Trash', 'sigmaigaming'),
		),
		'public' => TRUE,
		'rewrite' => array('slug' => 'news/%news-tag%'),
		'has_archive' => false,
		
		'supports' => array('title','thumbnail', 'editor', 'comments'),
	));
}

// create a Custom post texonomies for news post
add_action( 'init', 'sigma_mt_taxonomies_news', 0 );
function sigma_mt_taxonomies_news(){
	register_taxonomy('news-cat', array('news-items'), array('hierarchical' => true,
			'labels' => array(
				'name' => __('News Categories', 'sigmaigaming'),
				'singular_name' => __('News Category', 'sigmaigaming'),
				'search_items' => __('Search News Category', 'sigmaigaming'),
				'all_items' => __('All News Categories', 'sigmaigaming'),
				'parent_item' => __('Parent News Category', 'sigmaigaming'),
				'parent_item_colon' => __('Parent News Category:', 'sigmaigaming'),
				'edit_item' => __('Edit News Category', 'sigmaigaming'),
				'update_item' => __('Refresh News Category', 'sigmaigaming'),
				'add_new_item' => __('Add News Category', 'sigmaigaming'),
				'new_item_name' => __('New News Category', 'sigmaigaming')
			),
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'latest-news')
		)
	);
}

// create a Custom post tags for news post
add_action( 'init', 'sigma_mt_tags_news', 0 );
function sigma_mt_tags_news(){
	register_taxonomy('news-tag','news-items',
		array(
			'hierarchical'  => true,
			'labels' => array(
				'add_new_item' => __('Add New Tag', 'sigmaigaming'),
				'new_item_name' => __('New Tag', 'sigmaigaming')
			),
			'label'         => __('Tags', 'sigmaigaming'),
			'singular_name' => __('Tag', 'sigmaigaming'),
			'rewrite'       => [
				'slug' => 'tags',
				"with_front" => false
			],
			'show_tagcloud' => true,
			'query_var'     => true
		)
	);
}

// change permalink for Custom post type
add_filter( 'post_type_link', 'sigma_mt_show_permalinks', 1, 2 );
function sigma_mt_show_permalinks( $post_link, $post ){
    if ( is_object( $post ) && $post->post_type == 'news-items' ){
        $terms = wp_get_object_terms( $post->ID, 'news-tag' );
        if( $terms ){
            return str_replace( '%news-tag%' , $terms[0]->slug , $post_link );
        }
    }
    return $post_link;
}



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