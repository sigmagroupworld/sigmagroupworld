<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since 1.0.0
 */

get_header();
$description = get_the_archive_description();
// get the current taxonomy term
$term = get_queried_object();
$term_image = get_field('taxonomy_image', $term);
$term_url = get_field('texonomy_link', $term);
$tag_url = get_tag_link($term);
$image_id = get_image_id_by_url($term_image);
$image_info = wp_get_attachment_metadata($image_id);
$image_title = get_the_title($image_id);

if(isset($term_url) && !empty($term_url)) {
	$link = $term_url;
} else {
	$link = $tag_url;
}
?>

<section class="texonomy-page">
	<!-- News Banner section start -->
	<div class="blog-banner texonomy-banner">
		<a href="<?php echo $term_url; ?>">
			<img src="<?php echo $term_image; ?>" alt="<?php echo $image_title; ?>">
		</a>
	</div>
	<!-- News Banner section start -->

	<!-- News Content section start -->
	<div class="blog-content">
		<div class="page-container">
			<div class="blog-leftbar">
			<div class="blog-leftbar">
				<?php echo do_shortcode('[sigma_mt_show_sidebar elements="22554, 22581, 22553"]'); ?>
			</div>
			<div class="blog-details">
				<div class="blog-listing-wrapper">
					<?php if ( have_posts() ) {
						while ( have_posts() ) {
							the_post();
							$featured_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
							$image_id = get_image_id_by_url($featured_image_url[0]);
							$image_info = wp_get_attachment_metadata($image_id);
							$image_title = get_the_title($image_id); ?>
							<div class="list-single-item">
								<a href="<?php echo get_permalink(); ?>">
									<div class="post-desc">
										<img src="<?php echo $featured_image_url[0]; ?>" alt="<?php echo $image_title; ?>">
										<h3><?php the_title(); ?></h3>
									</div>
								</a>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
				<?php the_posts_pagination(); ?>
			</div>
			<?php /*if ( is_active_sidebar( 'news-posts-sidebar' ) ) : ?>
			    <div id="secondary" class="widget-area" role="complementary">
			    <?php dynamic_sidebar( 'news-posts-sidebar' ); ?>
			    </div>
			<?php endif;*/ ?>
			<div class="blog-rightbar">
				<?php echo do_shortcode('[sigma_mt_show_sidebar elements="22578, 22577, 22582, 22549, 22583"]'); ?>
			</div>
		</div>
	</div>
	<!-- News Content section End -->
</section>

<?php get_footer(); ?>
