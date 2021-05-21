<?php 

// Update posts slug
add_action( 'init', 'sigma_mt_update_posts_slug' );
function sigma_mt_update_posts_slug() {
    $posts = get_posts( array (  'numberposts' => -1, 'post_type'   => array('news-items', 'post', 'page')) );
    foreach ( $posts as $post ) {
        // check the slug and run an update if necessary 
        $new_slug = sanitize_title( $post->post_title );
        if ( $post->post_name != $new_slug ) {
            wp_update_post(
                array (
                    'ID'        => $post->ID,
                    'post_name' => $new_slug
                )
            );
        }
    }
}

// create widgets for sidebar
add_action( 'widgets_init', 'sigma_mt_widgets_init' );
function sigma_mt_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Post Page Sidebar', 'sigmaigaming' ),
        'id' => 'news-posts-sidebar',
        'description' => __( 'The main sidebar appears on the right on each post page template', 'sigmaigaming' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
}

// Register and load the widget
add_action( 'widgets_init', 'sigma_mt_load_widget' );
function sigma_mt_load_widget() {
    register_widget( 'sigma_mt_widget' );
}

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
		'rewrite' => array('slug' => 'news'),		
		'supports' => array('title', 'thumbnail', 'editor', 'comments', 'page-attributes'),
	));
}

// create a Custom post taxonomy for news post
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
			'label'         => __('News Tags', 'sigmaigaming'),
			'singular_name' => __('News Tag', 'sigmaigaming'),
			'rewrite'       => [
				'slug' => 'tags',
				'with_front' => false
			],
			'show_tagcloud' => true,
			'query_var'     => true
		)
	);
}

// create a Custom post type events
add_action('init', 'sigma_mt_events_custom_posts');
function sigma_mt_events_custom_posts(){
	register_post_type('event-items', array(
		'labels' => array(
			'name' => __('Events', 'sigmaigaming'),
			'singular_name' => __('Events', 'sigmaigaming'),
			'menu_name' => __('Events', 'sigmaigaming'),
			'add_new' => __('Add New Event', 'sigmaigaming'),
			'add_new_item' => __('Add New Event', 'sigmaigaming'),
			'edit_item' => __('Edit Event', 'sigmaigaming'),
			'new_item' => __('New Event', 'sigmaigaming'),
			'view_item' => __('View Event', 'sigmaigaming'),
			'search_items' => __('Search Events', 'sigmaigaming'),
			'not_found' => __('No Events found', 'sigmaigaming'),
			'not_found_in_trash' => __('No Events found in Trash', 'sigmaigaming'),
		),
		'public' => true,
		'publicly_queryable' => false,
		'rewrite' => array('slug' => 'event-items'),
		'supports' => array('title', 'thumbnail', 'editor', 'revisions'),
	));
}

// create a categories for events
add_action( 'init', 'sigma_mt_events_categories', 0 );
function sigma_mt_events_categories(){
	register_taxonomy('event-category', array('event-items'), array(
		'hierarchical' => true,
		'labels' => array(
			'name' => __('Event Categories', 'sigmaigaming'),
			'singular_name' => __('Event Category', 'sigmaigaming'),
			'search_items' => __('Search Event Category', 'sigmaigaming'),
			'all_items' => __('All Event Categories', 'sigmaigaming'),
			'parent_item' => __('Parent Event Category', 'sigmaigaming'),
			'parent_item_colon' => __('Parent Event Category:', 'sigmaigaming'),
			'edit_item' => __('Edit Event Category', 'sigmaigaming'),
			'update_item' => __('Refresh Event Category', 'sigmaigaming'),
			'add_new_item' => __('Add new Event Category', 'sigmaigaming'),
			'new_item_name' => __('New Event Category', 'sigmaigaming')
		),
		'show_ui' => true,
		'rewrite' => array( 'slug' => 'event-category', 'hierarchical' => true ),
	   )
	);
}

// create taxonomy years for events
add_action( 'init', 'sigma_mt_events_years', 0 );
function sigma_mt_events_years(){
	register_taxonomy('event-years', array('event-items'), array(
		'hierarchical' => true,
		'labels' => array(
			'name' => __('Event Years', 'sigmaigaming'),
			'singular_name' => __('Event Year', 'sigmaigaming'),
			'search_items' => __('Search Event Years', 'sigmaigaming'),
			'all_items' => __('All Event Years', 'sigmaigaming'),
			'parent_item' => __('Parent Event Years', 'sigmaigaming'),
			'parent_item_colon' => __('Parent Event Years:', 'sigmaigaming'),
			'edit_item' => __('Edit Event Years', 'sigmaigaming'),
			'update_item' => __('Refresh Event Years', 'sigmaigaming'),
			'add_new_item' => __('Add new Event Years', 'sigmaigaming'),
			'new_item_name' => __('New Event Years', 'sigmaigaming')
		),
		'show_ui' => true,
		'publicly_queryable' => false,
		'rewrite' => array( 'slug' => 'event-years', 'hierarchical' => true ),
	   )
	);
}

//
add_action( 'init', 'sigma_mt_events_editions', 0 );
function sigma_mt_events_editions(){
	register_taxonomy('event-editions', array('event-items'), array(
			'hierarchical' => true,
			'labels' => array(
				'name' => __('SiGMA Editions', 'sigmaigaming'),
				'singular_name' => __('SiGMA Editions', 'sigmaigaming'),
				'search_items' => __('Search SiGMA Editions', 'sigmaigaming'),
				'all_items' => __('All SiGMA Editions', 'sigmaigaming'),
				'parent_item' => __('Parent SiGMA Editions', 'sigmaigaming'),
				'parent_item_colon' => __('Parent SiGMA Editions:', 'sigmaigaming'),
				'edit_item' => __('Edit SiGMA Editions', 'sigmaigaming'),
				'update_item' => __('Refresh SiGMA Editions', 'sigmaigaming'),
				'add_new_item' => __('Add new SiGMA Edition', 'sigmaigaming'),
				'new_item_name' => __('New SiGMA Edition', 'sigmaigaming')
			),
			'public' => true,
			'show_ui' => true,
			'publicly_queryable' => false,
			'rewrite' => array( 'slug' => 'event-editions', 'hierarchical' => true ),
		)
	);
}

// Create CPT for authors
add_action('init', 'sigma_mt_author_custom_posts');
function sigma_mt_author_custom_posts(){
	register_post_type('authors', array(
		'labels' => array(
			'name' => __('Authors', 'sigmaigaming'),
			'singular_name' => __('Author', 'sigmaigaming'),
			'menu_name' => __('Authors', 'sigmaigaming'),
			'add_new' => __('Add an Author', 'sigmaigaming'),
			'add_new_item' => __('Add an Author', 'sigmaigaming'),
			'edit_item' => __('Edit an Authors', 'sigmaigaming'),
			'new_item' => __('Authors', 'sigmaigaming'),
			'view_item' => __('View Authors', 'sigmaigaming'),
			'search_items' => __('Search Authors', 'sigmaigaming'),
			'not_found' => __('No Authors found', 'sigmaigaming'),
			'not_found_in_trash' => __('No Authors found in Trash', 'sigmaigaming'),
		),
		'public' => TRUE,
		'rewrite' => array('slug' => 'authors', 'with_front' => false),
		'supports' => array('title', 'thumbnail', 'editor')
	));
}

// create a Custom post type videos
add_action('init', 'sigma_mt_videos_custom_posts');
function sigma_mt_videos_custom_posts() {
	register_post_type('video-items', array(
		'labels' => array(
			'name' => __('Sigma Videos', 'sigmaigaming'),
			'singular_name' => __('Sigma Video', 'sigmaigaming'),
			'menu_name' => __('Sigma Videos', 'sigmaigaming'),
			'add_new' => __('Add Video Item', 'sigmaigaming'),
			'add_new_item' => __('Add Videos Item', 'sigmaigaming'),
			'edit_item' => __('Edit Videos Item', 'sigmaigaming'),
			'new_item' => __('Videos Items', 'sigmaigaming'),
			'view_item' => __('View Videos Items', 'sigmaigaming'),
			'search_items' => __('Search Videos Items', 'sigmaigaming'),
			'not_found' => __('No Videos Items found', 'sigmaigaming'),
			'not_found_in_trash' => __('No Videos Items found in Trash', 'sigmaigaming'),
		),
		'public' => TRUE,
		'rewrite' => array('slug' => 'sigma-videos'),		
		'supports' => array('title', 'thumbnail', 'editor', 'comments'),
	));
}

// create a Custom post taxonomy for news post
add_action( 'init', 'sigma_mt_taxonomies_videos', 0 );
function sigma_mt_taxonomies_videos(){
	register_taxonomy('videos-cat', array('video-items'), array('hierarchical' => true,
			'labels' => array(
				'name' => __('Video Categories', 'sigmaigaming'),
				'singular_name' => __('Video Category', 'sigmaigaming'),
				'search_items' => __('Search Video Category', 'sigmaigaming'),
				'all_items' => __('All Video Categories', 'sigmaigaming'),
				'parent_item' => __('Parent Videos Category', 'sigmaigaming'),
				'parent_item_colon' => __('Parent Videos Category:', 'sigmaigaming'),
				'edit_item' => __('Edit Videos Category', 'sigmaigaming'),
				'update_item' => __('Refresh Videos Category', 'sigmaigaming'),
				'add_new_item' => __('Add Videos Category', 'sigmaigaming'),
				'new_item_name' => __('New Videos Category', 'sigmaigaming')
			),
			'show_ui' => true,
			'rewrite' => array('slug' => 'sm-videos')
		)
	);
}

// create a Custom post type testimonial
add_action('init', 'sigma_mt_testimonial_custom_posts');
function sigma_mt_testimonial_custom_posts() {
	register_post_type('testimonial-items', array(
		'labels' => array(
			'name' => __('Sigma Testimonial', 'sigmaigaming'),
			'singular_name' => __('Sigma Testimonial', 'sigmaigaming'),
			'menu_name' => __('Sigma Testimonials', 'sigmaigaming'),
			'add_new' => __('Add Testimonial Item', 'sigmaigaming'),
			'add_new_item' => __('Add Testimonials Item', 'sigmaigaming'),
			'edit_item' => __('Edit Testimonials Item', 'sigmaigaming'),
			'new_item' => __('Testimonias Items', 'sigmaigaming'),
			'view_item' => __('View Testimonias Items', 'sigmaigaming'),
			'search_items' => __('Search Testimonials Items', 'sigmaigaming'),
			'not_found' => __('No Testimonial Items found', 'sigmaigaming'),
			'not_found_in_trash' => __('No Testimonial Items found in Trash', 'sigmaigaming'),
		),
		'public' => TRUE,
		'rewrite' => array('slug' => 'sigma-testimonial'),		
		'supports' => array('title', 'thumbnail', 'editor', 'comments'),
	));
}

// create a Custom post taxonomy for news post
add_action( 'init', 'sigma_mt_taxonomies_testimonial', 0 );
function sigma_mt_taxonomies_testimonial(){
	register_taxonomy('videos-cat', array('testimonial-items'), array('hierarchical' => true,
			'labels' => array(
				'name' => __('Testimonial Categories', 'sigmaigaming'),
				'singular_name' => __('Testimonial Category', 'sigmaigaming'),
				'search_items' => __('Search Testimonial Category', 'sigmaigaming'),
				'all_items' => __('All Ttestimonial Categories', 'sigmaigaming'),
				'parent_item' => __('Parent Testimonials Category', 'sigmaigaming'),
				'parent_item_colon' => __('Parent Testimonials Category:', 'sigmaigaming'),
				'edit_item' => __('Edit Testimonials Category', 'sigmaigaming'),
				'update_item' => __('Refresh Testimonials Category', 'sigmaigaming'),
				'add_new_item' => __('Add Testimonials Category', 'sigmaigaming'),
				'new_item_name' => __('New Testimonials Category', 'sigmaigaming')
			),
			'show_ui' => true,
			'rewrite' => array('slug' => 'sm-videos')
		)
	);
}

// create a Custom post type magazines
add_action('init', 'sigma_mt_magazine_custom_posts');
function sigma_mt_magazine_custom_posts() {
	register_post_type('magazine-items', array(
		'labels' => array(
			'name' => __('Sigma Magazines', 'sigmaigaming'),
			'singular_name' => __('Sigma Magazine', 'sigmaigaming'),
			'menu_name' => __('Sigma Magazines', 'sigmaigaming'),
			'add_new' => __('Add Magazine Item', 'sigmaigaming'),
			'add_new_item' => __('Add Magazine Item', 'sigmaigaming'),
			'edit_item' => __('Edit Magazine Item', 'sigmaigaming'),
			'new_item' => __('Magazines Items', 'sigmaigaming'),
			'view_item' => __('View Magazine Item', 'sigmaigaming'),
			'search_items' => __('Search Magazines Items', 'sigmaigaming'),
			'not_found' => __('No Magazines Items found', 'sigmaigaming'),
			'not_found_in_trash' => __('No Magazines Items found in Trash', 'sigmaigaming'),
		),
		'public' => TRUE,
		'rewrite' => array('slug' => 'magazines'),		
		'supports' => array('title', 'thumbnail', 'editor', 'comments'),
	));
}

// create a Custom post taxonomy for magazines
add_action( 'init', 'sigma_mt_taxonomies_magazines', 0 );
function sigma_mt_taxonomies_magazines(){
	register_taxonomy('magazines-cat', array('magazine-items'), array('hierarchical' => true,
			'labels' => array(
				'name' => __('Magazine Categories', 'sigmaigaming'),
				'singular_name' => __('Magazine Category', 'sigmaigaming'),
				'search_items' => __('Search Magazine Category', 'sigmaigaming'),
				'all_items' => __('All Magazine Categories', 'sigmaigaming'),
				'parent_item' => __('Parent Magazine Category', 'sigmaigaming'),
				'parent_item_colon' => __('Parent Magazine Category:', 'sigmaigaming'),
				'edit_item' => __('Edit Magazine Category', 'sigmaigaming'),
				'update_item' => __('Refresh Magazine Category', 'sigmaigaming'),
				'add_new_item' => __('Add Magazine Category', 'sigmaigaming'),
				'new_item_name' => __('New Magazine Category', 'sigmaigaming')
			),
			'show_ui' => true,
			'rewrite' => array('slug' => 'magazines-cat')
		)
	);
}

// create a Custom post type casino
add_action('init', 'sigma_mt_casinos_custom_posts');
function sigma_mt_casinos_custom_posts() {
	register_post_type('casinos-items', array(
		'labels' => array(
			'name' => __('Casinos', 'sigmaigaming'),
			'singular_name' => __('Casinos', 'sigmaigaming'),
			'menu_name' => __('Casino Provider', 'sigmaigaming'),
			'add_new' => __('Add Casinos Item', 'sigmaigaming'),
			'add_new_item' => __('Add Casinos Item', 'sigmaigaming'),
			'edit_item' => __('Edit Casinos Item', 'sigmaigaming'),
			'new_item' => __('Casinos Items', 'sigmaigaming'),
			'view_item' => __('View Casinos Items', 'sigmaigaming'),
			'search_items' => __('Search Casinos Items', 'sigmaigaming'),
			'not_found' => __('No Casinos Items found', 'sigmaigaming'),
			'not_found_in_trash' => __('No Casinos Items found in Trash', 'sigmaigaming'),
		),
		'public' => TRUE,
		'rewrite' => array('slug' => 'casinos'),		
		'supports' => array('title', 'thumbnail', 'editor', 'comments', 'page-attributes'),
	));
}

// create a Custom post taxonomy for casinos post
add_action( 'init', 'sigma_mt_taxonomies_casinos', 0 );
function sigma_mt_taxonomies_casinos(){
	register_taxonomy('casinos-cat', array('casinos-items'), array('hierarchical' => true,
			'labels' => array(
				'name' => __('Casinos Categories', 'sigmaigaming'),
				'singular_name' => __('Casinos Category', 'sigmaigaming'),
				'search_items' => __('Search Casinos Category', 'sigmaigaming'),
				'all_items' => __('All Casinos Categories', 'sigmaigaming'),
				'parent_item' => __('Parent Casinos Category', 'sigmaigaming'),
				'parent_item_colon' => __('Parent Casinos Category:', 'sigmaigaming'),
				'edit_item' => __('Edit Casinos Category', 'sigmaigaming'),
				'update_item' => __('Refresh Casinos Category', 'sigmaigaming'),
				'add_new_item' => __('Add Casinos Category', 'sigmaigaming'),
				'new_item_name' => __('New Casinos Category', 'sigmaigaming')
			),
			'show_ui' => true,
			'rewrite' => array('slug' => 'latest-casinos')
		)
	);
}