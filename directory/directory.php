<?php
/**
 * Template Name: SigmaMT Directory Page Layout
 * Created By: Rinkal Petersen
 * Created at: 27 Apr 2021
 */
/* Directory template css */
wp_enqueue_style('directory', get_stylesheet_directory_uri().'/directory/css/directory.css'); 
get_header();
?>

<?php  ob_start(); $directory = get_field('directory_box');

if ($directory){
?>
	<section class="directory-main">
		<div class="container">
			<div class="main-directory">
				<?php 
				foreach ($directory as $key => $value) { ?>
					<div class="directory" style="background-image: url(<?php echo $value['directory_image']; ?>)">
			  			<a href="<?php echo $value['directory_link']; ?>" class="<?php echo $value['country_name']; ?>">
			  				<div class="bottom-txt" style="background-color: <?php echo $value['directory_color']; ?>">
			    				<div class="txt-all">
			    					<?php if( !empty( $value['directory_icon'] ) ){ ?>
				      					<div class="icon">
									    	<img src="<?php echo $value['directory_icon']['url']; ?>" alt="<?php echo $value['directory_icon']['alt']; ?>" />
				        				</div>
				        			<?php } ?>
								    <h6><?php echo $value['directory_name']; ?></h6>
			    				</div>
			  				</div>
			  			</a>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>
<?php
}
?>
<div class="newsletter" style="background: url(<?php the_field('newsletter_background_image', 'option'); ?>);">
	<div class="container">
		<div class="newsletter-inner">
			<h4><?php the_field('newsletter_title', 'option'); ?></h4>
			<div class="newsletter-form">
				<?php
					$newsletter_form_id = get_field('newsletter_form_shortcode', 'option');
					echo do_shortcode( '[wpforms id="'.$newsletter_form_id.'"]' );     
                ?>
			</div>
			<p><?php the_field('newsletter_sub_text', 'option'); ?></p>
		</div>
	</div>
</div>
<?php get_footer(); ?>
