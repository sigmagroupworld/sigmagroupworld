<?php
/**
 * Template Name: SigmaMT Single Post Layout
 * Created By: Rinkal Petersen
 * Created at: 03 May 2021
 */
/* News template css */
wp_enqueue_style('home', get_stylesheet_directory_uri().'/newsletter/css/newsletter.css'); 
get_header();

?>
<?php ob_start(); $newsletter = get_field('newsletter_section');

if ($newsletter){
?>
	<div class="newsletter" style="background: url(<?php echo $newsletter['newsletter_background_image']; ?>);">
		<div class="container">
			<div class="newsletter-inner">
				<h4><?php echo $newsletter['newsletter_title']; ?></h4>
				<div class="newsletter-form">
					<?php echo $newsletter['newsletter_form_shortcode']; ?>
				</div>
				<p><?php echo $newsletter['newsletter_sub_text']; ?></p>
			</div>
		</div>
	</div>
<?php
}
get_footer(); 
?>