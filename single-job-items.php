<?php
/**
 * The template for displaying single post of job 
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since 1.0.0
 */

get_header();
$requirements_section = get_field('requirements_section', get_the_ID());
$responsibilities_section = get_field('responsibilities_section', get_the_ID());
?>

<section>
	<!-- News page main section start -->
	<div class="blog-content">
		<div class="page-container">
			<!-- Leftbar start -->
			<div class="blog-leftbar">
				<?php echo do_shortcode('[sigma_mt_show_sidebar elements="22554, 22581, 22553"]'); ?>
			</div>
			<!-- Leftbar end -->

			<!-- Middle Detail News start -->
			<div class="job-details">
				<div class="featured-img">
					<?php the_post_thumbnail(); ?>
				</div>
				<div class="post-body">
					<div class="post-content">
						<?php the_content(); ?>
						<?php if(!empty($responsibilities_section['responsibilities'])) { ?>
							<div class="requirements">
								<h3><?php echo $responsibilities_section['title']; ?></h3>
								<div class="require-content">
									<?php echo $responsibilities_section['responsibilities']; ?>
								</div>
							</div>
						<?php } ?>
						<?php if(!empty($requirements_section['requirements'])) { ?>
							<div class="requirements">
								<h3><?php echo $requirements_section['title']; ?></h3>
								<div class="require-content">
									<?php echo $requirements_section['requirements']; ?>
								</div>
							</div>
						<?php } ?>
						<div class="vacancy-application">
							<h3><?php echo __( 'Vacancies Application', 'sigmaigaming' ) ?></h3>
							<?php echo do_shortcode('[wpforms id="19915"]'); ?>
						</div>
					</div>
				</div>
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

<?php echo do_shortcode('[sigma-mt-newsletter]'); ?>

<?php get_footer(); ?>
