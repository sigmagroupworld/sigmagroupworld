<?php
/**
 * The template for displaying single post of company 
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since 1.0.0
 */

get_header();

$thumbnail = get_field('single_thumbnail', get_the_ID());
$content = get_field('company_content', get_the_ID());
?>

<section>
	<!-- News page main section start -->
	<div class="blog-content">
		<div class="page-container">
			<!-- Leftbar start -->
			<div class="blog-leftbar">
				<?php echo do_shortcode('[sigma_mt_show_sidebar elements="96567, 22553"]'); ?>
			</div>
			<!-- Leftbar end -->

			<!-- Middle Detail News start -->
			<div class="blog-details">
				<div class="featured-img">
					<?php echo '<img src="' . $thumbnail . '">'; ?>
				</div>
				<div class="post-body">
					<div class="post-content">
						<?php echo $content; ?>
					</div>
				</div>
				<div class="releted-post">
					<br />
					<?php echo do_shortcode('[sigma-mt-related-articles term_name="'.get_the_title().'" post_per_page = 10]'); ?>
				</div>
			</div>
			<!-- Middle Detail News end -->

			<!-- Rightbar start -->
			<div class="blog-rightbar">
				<?php echo do_shortcode('[sigma_mt_show_sidebar elements="22579, 22586, 22549, 22583"]'); ?>
			</div>
			<!-- Rightbar end -->
		</div>
	</div>
	<!-- News page main section end -->
</section>

<?php echo do_shortcode('[sigma-mt-newsletter]'); ?>

<?php get_footer(); ?>
