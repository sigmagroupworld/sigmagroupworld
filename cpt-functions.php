<?php 
//
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

//
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

//
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
