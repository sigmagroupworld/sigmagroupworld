<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();
?>

	<section>
		<!-- News page main section start -->
		<div class="not-found-page">
			<div class="page-container">
				<div class="page-content">
					<h3 style="text-align: center; margin-top: 120px; margin-bottom: -30px; font-size: 20px;">ERROR</h3>
					<h1 style="text-align: center; margin-top: 0px; font-size: 160px;">404</h1>
					<p style="text-align: center;"><?php esc_html_e( 'Sorry, the page you were looking for at this URL was not found.', 'twentytwentyone' ); ?></p>
				</div><!-- .page-content -->
			</div>
		</div>
	</section>

<?php
get_footer();
