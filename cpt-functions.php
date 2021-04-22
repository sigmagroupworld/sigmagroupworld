<?php 

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
		'has_archive' => false,
		'supports' => array('title','thumbnail','editor', 'revisions'),
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
		'query_var' => false,
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
		'query_var' => false,
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
			'query_var' => false,
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
		'has_archive' => true,
		'supports' => array('title','thumbnail','editor')
	));
}
