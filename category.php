<?php
/**
 * Template Name: Category Layout
 * Template Post Type: news-items
 * Created By: Rinkal Petersen
 * Created at: 15 Apr 2021
 */
/* Category Template */

get_header();

$featured_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
if ($featured_image_url) {
    $image_id = get_image_id_by_url($featured_image_url[0]);
    $image_info = wp_get_attachment_metadata($image_id);
    $image_title = get_the_title($image_id);
}

?>

<section>
	<!-- News Banner start -->
    <?php if ($featured_image_url) { ?>
        <div class="blog-banner">
            <a href="#">
                <img src="<?php echo $featured_image_url[0]; ?>" alt="<?php echo $image_title; ?>">
            </a>
        </div>
    <?php } ?>
	<!-- News Banner end -->

	<!-- News page main section start -->
	<div class="blog-content">
		<div class="page-container">
			<!-- Leftbar start -->
			<div class="blog-leftbar">
				<?php echo do_shortcode('[sigma_mt_show_sidebar elements="22817, 22581, 22553"]'); ?>
			</div>
			<!-- Leftbar end -->

			<!-- Middle Detail News start -->
			<div class="blog-details">
				<?php 
				// Check if there are any posts to display
				if ( have_posts() ) : ?>
				 
				<header class="archive-header">
				<?php
				// Since this template will only be used for Design category
				// we can add category title and description manually.
				// or even add images or change the layout
				?>
				 
				<h1 class="archive-title">Design Articles</h1>
				<div class="archive-meta">
				Articles and tutorials about design and the web.
				</div>
				</header>
				 
				<?php
				 
				// The Loop
				while ( have_posts() ) : the_post(); ?>
				<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				<small><?php the_time('F jS, Y'); ?> by <?php the_author_posts_link(); ?></small>
				 
				<div class="entry">
				<?php the_excerpt(); ?>
				 
				 <p class="postmetadata"><?php
				  comments_popup_link( 'No comments yet', '1 comment', '% comments', 'comments-link', 'Comments closed');
				?></p>
				</div>
				 
				<?php endwhile; // End Loop
				 
				else: ?>
				<p>Sorry, no posts matched your criteria.</p>
				<?php endif; ?>
				</div>
				</section>
			</div>
			<!-- Middle Detail News end -->

			<!-- Rightbar start -->
			<div class="blog-rightbar">
				<?php echo do_shortcode('[sigma_mt_show_sidebar elements="22578, 22577, 22582, 22549, 22583"]'); ?>
			</div>
			<!-- Rightbar end -->
		</div>
	</div>
	<!-- News page main section end -->
</section>

<?php get_footer(); ?>
