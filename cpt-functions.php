<?php
// Update posts slug
/*
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
*/
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
		'supports' => array('title', 'thumbnail', 'editor', 'comments'),
	));
}

// create a Custom post taxonomy for news post
add_action( 'init', 'sigma_mt_taxonomies_news', 0 );
function sigma_mt_taxonomies_news(){
	register_taxonomy('news-cat', array('news-items', 'page'), array('hierarchical' => true,
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
			'show_in_nav_menus' => true,
			'show_in_rest' => true,
			'rewrite' => array('slug' => 'latest-news'),
        	'show_admin_column' => true
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
        	'show_admin_column' => true,
			'query_var'     => true
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

// create a Custom post taxonomy for videos
add_action( 'init', 'sigma_mt_taxonomies_videos', 0 );
function sigma_mt_taxonomies_videos(){
	register_taxonomy('videos-cat', array('video-items', 'page'), array('hierarchical' => true,
			'labels' => array(
				'name' => __('Video Categories', 'sigmaigaming'),
				'singular_name' => __('Video Category', 'sigmaigaming'),
				'search_items' => __('Search Video Category', 'sigmaigaming'),
				'all_items' => __('All Video Categories', 'sigmaigaming'),
				'parent_item' => __('Parent Video Category', 'sigmaigaming'),
				'parent_item_colon' => __('Parent Video Category:', 'sigmaigaming'),
				'edit_item' => __('Edit Video Category', 'sigmaigaming'),
				'update_item' => __('Refresh Video Category', 'sigmaigaming'),
				'add_new_item' => __('Add Video Category', 'sigmaigaming'),
				'new_item_name' => __('New Video Category', 'sigmaigaming')
			),
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'show_in_rest' => true,
        	'show_admin_column' => true,
			'rewrite' => array('slug' => 'sm-Video')
		)
	);
}

// create a Custom post type testimonial
add_action('init', 'sigma_mt_conference_custom_posts');
function sigma_mt_conference_custom_posts() {
	register_post_type('conference-items', array(
		'labels' => array(
			'name' => __('Conference', 'sigmaigaming'),
			'singular_name' => __('Conference', 'sigmaigaming'),
			'menu_name' => __('Conferences', 'sigmaigaming'),
			'add_new' => __('Add Conference', 'sigmaigaming'),
			'add_new_item' => __('Add Conference', 'sigmaigaming'),
			'edit_item' => __('Edit Conference', 'sigmaigaming'),
			'new_item' => __('Conferences', 'sigmaigaming'),
			'view_item' => __('View Conference', 'sigmaigaming'),
			'search_items' => __('Search Conferences', 'sigmaigaming'),
			'not_found' => __('No Conferences found', 'sigmaigaming'),
			'not_found_in_trash' => __('No Conferences found in Trash', 'sigmaigaming'),
		),
		'public' => TRUE,
		'rewrite' => array('slug' => 'sigma-conference'),		
		'supports' => array('title', 'thumbnail', 'editor', 'comments'),
	));
}

// create a Custom post taxonomy for testimonial
add_action( 'init', 'sigma_mt_taxonomies_conference', 0 );
function sigma_mt_taxonomies_conference(){
	register_taxonomy('conference-cat', array('conference-items'), array('hierarchical' => true,
			'labels' => array(
				'name' => __('Conference Categories', 'sigmaigaming'),
				'singular_name' => __('Conference Category', 'sigmaigaming'),
				'search_items' => __('Search Conference Category', 'sigmaigaming'),
				'all_items' => __('All Conference Categories', 'sigmaigaming'),
				'parent_item' => __('Parent Conference Category', 'sigmaigaming'),
				'parent_item_colon' => __('Parent Conference Category:', 'sigmaigaming'),
				'edit_item' => __('Edit Conference Category', 'sigmaigaming'),
				'update_item' => __('Refresh Conference Category', 'sigmaigaming'),
				'add_new_item' => __('Add Conference Category', 'sigmaigaming'),
				'new_item_name' => __('New Conference Category', 'sigmaigaming')
			),
			'show_ui' => true,
        	'show_admin_column' => true,
			'rewrite' => array('slug' => 'sm-conference')
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

// create a Custom post taxonomy for testimonial
add_action( 'init', 'sigma_mt_taxonomies_testimonial', 0 );
function sigma_mt_taxonomies_testimonial(){
	register_taxonomy('testimonial-cat', array('testimonial-items'), array('hierarchical' => true,
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
        	'show_admin_column' => true,
			'rewrite' => array('slug' => 'sm-testimonial')
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
        	'show_admin_column' => true,
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
		'supports' => array('title', 'thumbnail', 'editor', 'comments'),
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
        	'show_admin_column' => true,
			'rewrite' => array('slug' => 'latest-casinos')
		)
	);
}

// create a Custom post type jobs
add_action('init', 'sigma_mt_jobs_custom_posts');
function sigma_mt_jobs_custom_posts(){

	register_post_type('job-items', array(
		'labels' => array(
			'name' => __('Jobs', 'sigmaigaming'),
			'singular_name' => __('Job', 'sigmaigaming'),
			'menu_name' => __('Jobs', 'sigmaigaming'),
			'add_new' => __('Add Job', 'sigmaigaming'),
			'add_new_item' => __('Add Job', 'sigmaigaming'),
			'edit_item' => __('Edit Job', 'sigmaigaming'),
			'new_item' => __('News', 'sigmaigaming'),
			'view_item' => __('View Job', 'sigmaigaming'),
			'search_items' => __('Search Job', 'sigmaigaming'),
			'not_found' => __('No News found', 'sigmaigaming'),
			'not_found_in_trash' => __('No Job found in Trash', 'sigmaigaming'),
		),
		'public' => TRUE,
		'rewrite' => array('slug' => 'jobs'),		
		'supports' => array('title', 'thumbnail', 'editor', 'comments'),
	));
}

// create a categories for jobs
add_action( 'init', 'sigma_mt_jobs_categories', 0 );
function sigma_mt_jobs_categories(){
	register_taxonomy('job-cat', array('job-items'), array(
		'hierarchical' => true,
		'labels' => array(
			'name' => __('Job Categories', 'sigmaigaming'),
			'singular_name' => __('Job Category', 'sigmaigaming'),
			'search_items' => __('Search Job Category', 'sigmaigaming'),
			'all_items' => __('All Job Categories', 'sigmaigaming'),
			'parent_item' => __('Parent Job Category', 'sigmaigaming'),
			'parent_item_colon' => __('Parent Job Category:', 'sigmaigaming'),
			'edit_item' => __('Edit Job Category', 'sigmaigaming'),
			'update_item' => __('Refresh Job Category', 'sigmaigaming'),
			'add_new_item' => __('Add new Job Category', 'sigmaigaming'),
			'new_item_name' => __('New Job Category', 'sigmaigaming')
		),
		'show_ui' => true,
		'show_admin_column' => true,
		'rewrite' => array('slug' => 'latest-jobs')
	   )
	);
}

// create a Custom post type speakers
add_action('init', 'sigma_mt_speakers_custom_posts');
function sigma_mt_speakers_custom_posts(){

	register_post_type('speaker-items', array(
		'labels' => array(
			'name' => __('Speakers', 'sigmaigaming'),
			'singular_name' => __('Speaker', 'sigmaigaming'),
			'menu_name' => __('Speakers', 'sigmaigaming'),
			'add_new' => __('Add Speaker', 'sigmaigaming'),
			'add_new_item' => __('Add Speaker', 'sigmaigaming'),
			'edit_item' => __('Edit Speaker', 'sigmaigaming'),
			'new_item' => __('Speaker', 'sigmaigaming'),
			'view_item' => __('View Speaker', 'sigmaigaming'),
			'search_items' => __('Search Speaker', 'sigmaigaming'),
			'not_found' => __('No Speaker found', 'sigmaigaming'),
			'not_found_in_trash' => __('No Speaker found in Trash', 'sigmaigaming'),
		),
		'public' => TRUE,
		'rewrite' => array('slug' => 'speakers'),		
		'supports' => array('title', 'thumbnail', 'editor', 'comments'),
	));
}

// create a categories for Speaker
add_action( 'init', 'sigma_mt_speaker_categories', 0 );
function sigma_mt_speaker_categories(){
	register_taxonomy('speaker-cat', array('speaker-items'), array(
		'hierarchical' => true,
		'labels' => array(
			'name' => __('Speaker Categories', 'sigmaigaming'),
			'singular_name' => __('Speaker Category', 'sigmaigaming'),
			'search_items' => __('Search Speaker Category', 'sigmaigaming'),
			'all_items' => __('All Speaker Categories', 'sigmaigaming'),
			'parent_item' => __('Parent Speaker Category', 'sigmaigaming'),
			'parent_item_colon' => __('Parent Speaker Category:', 'sigmaigaming'),
			'edit_item' => __('Edit Speaker Category', 'sigmaigaming'),
			'update_item' => __('Refresh Speaker Category', 'sigmaigaming'),
			'add_new_item' => __('Add new Speaker Category', 'sigmaigaming'),
			'new_item_name' => __('New Speaker Category', 'sigmaigaming')
		),
		'show_ui' => true,
		'show_admin_column' => true,
		'rewrite' => array('slug' => 'latest-speakers')
	   )
	);
}

//create a Custom post type People
add_action('init', 'sigma_mt_people_custom_posts');
function sigma_mt_people_custom_posts() {
	register_post_type('people-items', array(
		'labels' => array(
			'name' => __('People', 'sigmaigaming'),
			'singular_name' => __('People', 'sigmaigaming'),
			'menu_name' => __('People', 'sigmaigaming'),
			'add_new' => __('Add People Item', 'sigmaigaming'),
			'add_new_item' => __('Add People Item', 'sigmaigaming'),
			'edit_item' => __('Edit People Item', 'sigmaigaming'),
			'new_item' => __('People Items', 'sigmaigaming'),
			'view_item' => __('View People Items', 'sigmaigaming'),
			'search_items' => __('Search People Items', 'sigmaigaming'),
			'not_found' => __('No People Items found', 'sigmaigaming'),
			'not_found_in_trash' => __('No People Items found in Trash', 'sigmaigaming'),
		),
		'public' => TRUE,
		'rewrite' => array('slug' => 'people'),		
		'supports' => array('title', 'thumbnail', 'editor', 'comments'),
		
	));
}
// create a Custom post taxonomy for people post
add_action( 'init', 'sigma_mt_taxonomies_people', 0 );
function sigma_mt_taxonomies_people(){
	register_taxonomy('people-cat', array('people-items'), array(
		'hierarchical' => true,
			'labels' => array(
				'name' => __('People Categories', 'sigmaigaming'),
				'singular_name' => __('People Category', 'sigmaigaming'),
				'search_items' => __('Search People Category', 'sigmaigaming'),
				'all_items' => __('All People Categories', 'sigmaigaming'),
				'parent_item' => __('Parent People Category', 'sigmaigaming'),
				'parent_item_colon' => __('Parent People Category:', 'sigmaigaming'),
				'edit_item' => __('Edit People Category', 'sigmaigaming'),
				'update_item' => __('Refresh People Category', 'sigmaigaming'),
				'add_new_item' => __('Add People Category', 'sigmaigaming'),
				'new_item_name' => __('New People Category', 'sigmaigaming'),
			),
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'rewrite' => array('slug' => 'latest-people')
		)
	);
}

// create a Custom post type Company
add_action('init', 'sigma_mt_company_custom_posts');
function sigma_mt_company_custom_posts() {
	register_post_type('company-items', array(
		'labels' => array(
			'name' => __('Company', 'sigmaigaming'),
			'singular_name' => __('Companies', 'sigmaigaming'),
			'menu_name' => __('Company', 'sigmaigaming'),
			'add_new' => __('Add Company Item', 'sigmaigaming'),
			'add_new_item' => __('Add Company Item', 'sigmaigaming'),
			'edit_item' => __('Edit Company Item', 'sigmaigaming'),
			'new_item' => __('Company Items', 'sigmaigaming'),
			'view_item' => __('View Company Items', 'sigmaigaming'),
			'search_items' => __('Search Company Items', 'sigmaigaming'),
			'not_found' => __('No Company Items found', 'sigmaigaming'),
			'not_found_in_trash' => __('No Company Items found in Trash', 'sigmaigaming'),
		),
		'public' => TRUE,
		'rewrite' => array('slug' => 'company'),		
		'supports' => array('title', 'thumbnail', 'editor', 'comments'),
	));
}

// create a Custom post taxonomy for Company post
add_action( 'init', 'sigma_mt_taxonomies_company', 0 );
function sigma_mt_taxonomies_company(){
	register_taxonomy('company-cat', array('company-items'), array('hierarchical' => true,
			'labels' => array(
				'name' => __('Company Categories', 'sigmaigaming'),
				'singular_name' => __('Company Category', 'sigmaigaming'),
				'search_items' => __('Search Company Category', 'sigmaigaming'),
				'all_items' => __('All Company Categories', 'sigmaigaming'),
				'parent_item' => __('Parent Company Category', 'sigmaigaming'),
				'parent_item_colon' => __('Parent Company Category:', 'sigmaigaming'),
				'edit_item' => __('Edit Company Category', 'sigmaigaming'),
				'update_item' => __('Refresh Company Category', 'sigmaigaming'),
				'add_new_item' => __('Add Company Category', 'sigmaigaming'),
				'new_item_name' => __('New Company Category', 'sigmaigaming')
			),
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'rewrite' => array('slug' => 'latest-company')
		)
	);
}

// create a Custom post type Sponsoring
add_action('init', 'sigma_mt_sponsoring_custom_posts');
function sigma_mt_sponsoring_custom_posts() {
	register_post_type('sponsoring-items', array(
		'labels' => array(
			'name' => __('Sponsoring', 'sigmaigaming'),
			'singular_name' => __('Sponsoring', 'sigmaigaming'),
			'menu_name' => __('Sponsoring', 'sigmaigaming'),
			'add_new' => __('Add Sponsoring Item', 'sigmaigaming'),
			'add_new_item' => __('Add Sponsoring Item', 'sigmaigaming'),
			'edit_item' => __('Edit Sponsoring Item', 'sigmaigaming'),
			'new_item' => __('Sponsoring Items', 'sigmaigaming'),
			'view_item' => __('View Sponsoring Items', 'sigmaigaming'),
			'search_items' => __('Search Sponsoring Items', 'sigmaigaming'),
			'not_found' => __('No Sponsoring Items found', 'sigmaigaming'),
			'not_found_in_trash' => __('No Sponsoring Items found in Trash', 'sigmaigaming'),
		),
		'public' => TRUE,
		'rewrite' => array('slug' => 'sponsoring'),		
		'supports' => array('title', 'thumbnail', 'editor', 'comments'),
	));
}

// create a Custom post taxonomy for Sponsoring post
add_action( 'init', 'sigma_mt_taxonomies_sponsoring', 0 );
function sigma_mt_taxonomies_sponsoring(){
	register_taxonomy('sponsoring-cat', array('sponsoring-items'), array('hierarchical' => true,
			'labels' => array(
				'name' => __('Sponsoring Categories', 'sigmaigaming'),
				'singular_name' => __('Sponsoring Category', 'sigmaigaming'),
				'search_items' => __('Search Sponsoring Category', 'sigmaigaming'),
				'all_items' => __('All Sponsoring Categories', 'sigmaigaming'),
				'parent_item' => __('Parent Sponsoring Category', 'sigmaigaming'),
				'parent_item_colon' => __('Parent Sponsoring Category:', 'sigmaigaming'),
				'edit_item' => __('Edit Sponsoring Category', 'sigmaigaming'),
				'update_item' => __('Refresh Sponsoring Category', 'sigmaigaming'),
				'add_new_item' => __('Add Sponsoring Category', 'sigmaigaming'),
				'new_item_name' => __('New Sponsoring Category', 'sigmaigaming')
			),
			'show_ui' => true,
			'show_admin_column' => true,
			'rewrite' => array('slug' => 'latest-sponsoring')
		)
	);
}

// create a Custom post tags for sponsoring post
add_action( 'init', 'sigma_mt_tags_sponsoring', 0 );
function sigma_mt_tags_sponsoring(){
	register_taxonomy('sponsoring-tag','sponsoring-items',
		array(
			'hierarchical'  => true,
			'labels' => array(
				'add_new_item' => __('Add Sponsoring Tag', 'sigmaigaming'),
				'new_item_name' => __('Sponsoring Tag', 'sigmaigaming')
			),
			'label'         => __('Sponsoring Tags', 'sigmaigaming'),
			'singular_name' => __('Sponsoring Tag', 'sigmaigaming'),
			'rewrite'       => [
				'slug' => 'tags',
				'with_front' => false
			],
			'show_tagcloud' => true,
			'show_admin_column' => true,
			'query_var'     => true
		)
	);
}

// create a Custom post type Sidebar Element
add_action('init', 'sigma_mt_sidebar_element_custom_posts');
function sigma_mt_sidebar_element_custom_posts() {
	register_post_type('sidebar-elements', array(
		'labels' => array(
			'name' => __('Sidebar Element', 'sigmaigaming'),
			'singular_name' => __('Sidebar Element', 'sigmaigaming'),
			'menu_name' => __('Sidebar Element', 'sigmaigaming'),
			'add_new' => __('Add Sidebar Element', 'sigmaigaming'),
			'add_new_item' => __('Add Sidebar Element', 'sigmaigaming'),
			'edit_item' => __('Edit Sidebar Element', 'sigmaigaming'),
			'new_item' => __('Sidebar Elements', 'sigmaigaming'),
			'view_item' => __('View Sidebar Elements', 'sigmaigaming'),
			'search_items' => __('Search Sidebar Elements', 'sigmaigaming'),
			'not_found' => __('No Sidebar Elements found', 'sigmaigaming'),
			'not_found_in_trash' => __('No Sidebar Elements found in Trash', 'sigmaigaming'),
		),
		'public' => TRUE,
		'rewrite' => array('slug' => 'sidebar-elements'),		
		'supports' => array('title', 'thumbnail', 'editor', 'comments'),
	));
}

// create a Custom post taxonomy for Hotel post
add_action( 'init', 'sigma_mt_taxonomies_sidebar_elements', 0 );
function sigma_mt_taxonomies_sidebar_elements(){
	register_taxonomy('sidebar-elements-cat', array('sidebar-elements'), array('hierarchical' => true,
			'labels' => array(
				'name' => __('Sidebar Element Categories', 'sigmaigaming'),
				'singular_name' => __('Sidebar Element Category', 'sigmaigaming'),
				'search_items' => __('Search Sidebar Element Category', 'sigmaigaming'),
				'all_items' => __('All Sidebar Element Categories', 'sigmaigaming'),
				'parent_item' => __('Parent Sidebar Element Category', 'sigmaigaming'),
				'parent_item_colon' => __('Parent Sidebar Element Category:', 'sigmaigaming'),
				'edit_item' => __('Edit Sidebar Element Category', 'sigmaigaming'),
				'update_item' => __('Refresh Sidebar Element Category', 'sigmaigaming'),
				'add_new_item' => __('Add Sidebar Element Category', 'sigmaigaming'),
				'new_item_name' => __('New Sidebar Element Category', 'sigmaigaming')
			),
			'show_ui' => true,
			'rewrite' => array('slug' => 'latest-sidebar-elements'),
			'show_admin_column' => true
		)
	);
}

// create a Custom post type Hotel
add_action('init', 'sigma_mt_hotel_custom_posts');
function sigma_mt_hotel_custom_posts() {
	register_post_type('hotel-items', array(
		'labels' => array(
			'name' => __('Hotel', 'sigmaigaming'),
			'singular_name' => __('Hotel', 'sigmaigaming'),
			'menu_name' => __('Hotel', 'sigmaigaming'),
			'add_new' => __('Add Hotel Item', 'sigmaigaming'),
			'add_new_item' => __('Add Hotel Item', 'sigmaigaming'),
			'edit_item' => __('Edit Hotel Item', 'sigmaigaming'),
			'new_item' => __('Hotel Items', 'sigmaigaming'),
			'view_item' => __('View Hotel Items', 'sigmaigaming'),
			'search_items' => __('Search Hotel Items', 'sigmaigaming'),
			'not_found' => __('No Hotel Items found', 'sigmaigaming'),
			'not_found_in_trash' => __('No Hotel Items found in Trash', 'sigmaigaming'),
		),
		'public' => TRUE,
		'rewrite' => array('slug' => 'hotels'),		
		'supports' => array('title', 'thumbnail', 'editor', 'comments'),
	));
}

// create a Custom post taxonomy for Hotel post
add_action( 'init', 'sigma_mt_taxonomies_hotel', 0 );
function sigma_mt_taxonomies_hotel(){
	register_taxonomy('hotel-cat', array('hotel-items'), array('hierarchical' => true,
			'labels' => array(
				'name' => __('Hotel Categories', 'sigmaigaming'),
				'singular_name' => __('Hotel Category', 'sigmaigaming'),
				'search_items' => __('Search Hotel Category', 'sigmaigaming'),
				'all_items' => __('All Hotel Categories', 'sigmaigaming'),
				'parent_item' => __('Parent Hotel Category', 'sigmaigaming'),
				'parent_item_colon' => __('Parent Hotel Category:', 'sigmaigaming'),
				'edit_item' => __('Edit Hotel Category', 'sigmaigaming'),
				'update_item' => __('Refresh Hotel Category', 'sigmaigaming'),
				'add_new_item' => __('Add Hotel Category', 'sigmaigaming'),
				'new_item_name' => __('New Hotel Category', 'sigmaigaming')
			),
			'show_ui' => true,
			'show_admin_column' => true,
			'rewrite' => array('slug' => 'latest-hotel')
		)
	);
}

// create a Custom post type Awards
add_action('init', 'sigma_mt_awards_custom_posts');
function sigma_mt_awards_custom_posts() {
	register_post_type('award-items', array(
		'labels' => array(
			'name' => __('Awards', 'sigmaigaming'),
			'singular_name' => __('Award', 'sigmaigaming'),
			'menu_name' => __('Awards', 'sigmaigaming'),
			'add_new' => __('Add Award Item', 'sigmaigaming'),
			'add_new_item' => __('Add Award Item', 'sigmaigaming'),
			'edit_item' => __('Edit Award Item', 'sigmaigaming'),
			'new_item' => __('Award Items', 'sigmaigaming'),
			'view_item' => __('View Award Items', 'sigmaigaming'),
			'search_items' => __('Search Award Items', 'sigmaigaming'),
			'not_found' => __('No Award Items found', 'sigmaigaming'),
			'not_found_in_trash' => __('No Award Items found in Trash', 'sigmaigaming'),
		),
		'public' => TRUE,
		'rewrite' => array('slug' => 'awards'),		
		'supports' => array('title', 'thumbnail', 'editor', 'comments'),
	));
}

// create a Custom post taxonomy for Awards post
add_action( 'init', 'sigma_mt_taxonomies_award', 0 );
function sigma_mt_taxonomies_award(){
	register_taxonomy('award-cat', array('award-items'), array('hierarchical' => true,
			'labels' => array(
				'name' => __('Award Categories', 'sigmaigaming'),
				'singular_name' => __('Award Category', 'sigmaigaming'),
				'search_items' => __('Search Award Category', 'sigmaigaming'),
				'all_items' => __('All Award Categories', 'sigmaigaming'),
				'parent_item' => __('Parent Award Category', 'sigmaigaming'),
				'parent_item_colon' => __('Parent Award Category:', 'sigmaigaming'),
				'edit_item' => __('Edit Award Category', 'sigmaigaming'),
				'update_item' => __('Refresh Award Category', 'sigmaigaming'),
				'add_new_item' => __('Add Award Category', 'sigmaigaming'),
				'new_item_name' => __('New Award Category', 'sigmaigaming')
			),
			'show_ui' => true,
			'show_admin_column' => true,
			'rewrite' => array('slug' => 'latest-award')
		)
	);
}


// create a Custom post type Gallery
add_action('init', 'sigma_mt_gallery_custom_posts');
function sigma_mt_gallery_custom_posts() {
	register_post_type('gallery-items', array(
		'labels' => array(
			'name' => __('Gallery', 'sigmaigaming'),
			'singular_name' => __('Galleries', 'sigmaigaming'),
			'menu_name' => __('Gallery', 'sigmaigaming'),
			'add_new' => __('Add Gallery Item', 'sigmaigaming'),
			'add_new_item' => __('Add Gallery Item', 'sigmaigaming'),
			'edit_item' => __('Edit Gallery Item', 'sigmaigaming'),
			'new_item' => __('Gallery Items', 'sigmaigaming'),
			'view_item' => __('View Gallery Items', 'sigmaigaming'),
			'search_items' => __('Search Gallery Items', 'sigmaigaming'),
			'not_found' => __('No Gallery Items found', 'sigmaigaming'),
			'not_found_in_trash' => __('No Gallery Items found in Trash', 'sigmaigaming'),
		),
		'public' => TRUE,
		'rewrite' => array('slug' => 'gallery'),		
		'supports' => array( 'title', 'thumbnail', 'custom-fields' ),
	));
}

// create a Custom post taxonomy for Gallery post
add_action( 'init', 'sigma_mt_taxonomies_gallery', 0 );
function sigma_mt_taxonomies_gallery(){
	register_taxonomy('gallery-cat', array('gallery-items'), array('hierarchical' => true,
			'labels' => array(
				'name' => __('Gallery Categories', 'sigmaigaming'),
				'singular_name' => __('Gallery Category', 'sigmaigaming'),
				'search_items' => __('Search Gallery Category', 'sigmaigaming'),
				'all_items' => __('All Gallery Categories', 'sigmaigaming'),
				'parent_item' => __('Parent Gallery Category', 'sigmaigaming'),
				'parent_item_colon' => __('Parent Gallery Category:', 'sigmaigaming'),
				'edit_item' => __('Edit Gallery Category', 'sigmaigaming'),
				'update_item' => __('Refresh Gallery Category', 'sigmaigaming'),
				'add_new_item' => __('Add Gallery Category', 'sigmaigaming'),
				'new_item_name' => __('New Gallery Category', 'sigmaigaming')
			),
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'rewrite' => array('slug' => 'latest-gallery')
		)
	);
}

// create a Custom post type Gallery
add_action('init', 'sigma_mt_m_and_a_custom_posts');
function sigma_mt_m_and_a_custom_posts() {
	register_post_type('m-and-a-deals', array(
		'labels' => array(
			'name' => __('M&A Deals', 'sigmaigaming'),
			'singular_name' => __('M&A Deal', 'sigmaigaming'),
			'menu_name' => __('M&A Deals', 'sigmaigaming'),
			'add_new' => __('Add M&A Deal', 'sigmaigaming'),
			'add_new_item' => __('Add M&A Deals', 'sigmaigaming'),
			'edit_item' => __('Edit M&A Deal', 'sigmaigaming'),
			'new_item' => __('M&A Deals', 'sigmaigaming'),
			'view_item' => __('View M&A Deal', 'sigmaigaming'),
			'search_items' => __('Search M&A Deals', 'sigmaigaming'),
			'not_found' => __('No M&A Deals found', 'sigmaigaming'),
			'not_found_in_trash' => __('No M&A Deals found in Trash', 'sigmaigaming'),
		),
		'public' => TRUE,
		'rewrite' => array('slug' => 'm-and-a'),		
		'supports' => array( 'title', 'thumbnail', 'custom-fields' ),
	));
}

// Shortcode for iGaming Gallery
add_shortcode( 'sigma-mt-igaming-gallery-new', 'sigma_mt_igaming_gallery_new' );
function sigma_mt_igaming_gallery_new($atts) {
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
                        	$content .= '</div>	';
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

add_action('wp_ajax_load_gallery_by_ajax', 'load_gallery_by_ajax_callback');
add_action('wp_ajax_nopriv_load_gallery_by_ajax', 'load_gallery_by_ajax_callback');
function load_gallery_by_ajax_callback() {
    check_ajax_referer('load_more_gallery', 'gallerySecurity'); 
    echo '<pre>'; print_r($_POST); exit;
    $content = '';
    $taxonomy = 'people-cat';
    $post_type = 'people-items';
    $paged = $_POST['page'];
    $term_id            = $_POST['term_id'];
    $posts_per_page     = $_POST['posts_per_page'];
    $gallery_title        = $_POST['gallery_title'];
    $featured_image       = $_POST['featured_image'];
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
    
    if(!empty($gallery)) {
        if ($gallery->have_posts()) {
	        while ($gallery->have_posts()) {
	            $gallery->the_post();
	            $year = get_the_date('Y');
	            $posts_by_year[$year][] = ['ID' => get_the_ID(), 'title' => get_the_title(), 'link' => get_the_permalink(), 'Year' => $year,];
	        }
	    }
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
	        echo $content;
	    }
	    exit;
	}
}

function sigma_mt_disable_autoupdate_slug($post_ID, $post, $update)
{
    if ($post->post_type == 'news-items') {
        $disable_autoupdate = get_post_meta($post->ID, 'disable_autoupdate_slug', true);

        if (empty($disable_autoupdate)) {
            // check the slug and run an update if necessary
            $new_slug = sanitize_title($post->post_title);
            if ($post->post_name != $new_slug) {
                wp_update_post(
                    array(
                        'ID' => $post->ID,
                        'post_name' => $new_slug
                    )
                );
            }
        }
    }
}