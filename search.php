<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();

$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$search_string = get_search_query();
$currentPage = get_query_var('paged');
$args = array(
	        's' => $search_string,
	        'posts_per_page' => 10,
	        'paged' => $currentPage,

	    );
    // The Query
$wp_query = new WP_Query( $args );
?>

<section class="search-page">
	<div class="container">
		<div class="search-page-title">
			<h2>SEARCH RESULTS</h2>
		</div>
		<div class="search-content">
			<?php if ( $wp_query->have_posts() ) { ?>
				<ul>
					<?php while ( $wp_query->have_posts() ) {
				        $wp_query->the_post(); ?>
	                    <li>
	                        <a class="search-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	                        <p class="search-disc"><?php the_excerpt(); ?></p>
	                    </li>
				    <?php } ?>
				</ul>
				<div class="pagination">
					<!-- Add the pagination functions here. -->
					<div class="search-pagination alignLeft"><?php next_posts_link( 'Next page >' ); ?></div>
					<div class="search-pagination alignRight"><?php previous_posts_link( '< Previous page' ); ?></div>	
				</div>
		    <?php } else { ?>
		    	<div class="search-page-title">
					<h2>Nothing Found</h2>
		    		<div class="alert alert-info">
		        		<p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>
		       		</div>
		       	</div>
			<?php } ?>
		</div>
	</div>	
</section>
<?php get_footer();
