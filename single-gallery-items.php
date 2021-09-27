<?php
/**
 * The template for displaying single gallery
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since 1.0.0
 */

get_header();
$gallery_album = get_field('images_album', get_the_ID());
$video_gallery_album = get_field('video_album', get_the_ID());
?>

<section>
	<div class="gallery-album">
		<div class="container">
			<div class="gallery-header">
				<div class="left">
					<h3><?php echo get_the_title(); ?></h3>
				</div>
				<div class="right">
					<a class="back-btn" href="<?php echo site_url(); ?>/gallery/">Back to galleries</a>
				</div>
			</div>
			<div class="gallery">
				<?php
				if(!empty($gallery_album)) {
					foreach($gallery_album as $gallery) { 
						foreach($gallery['gallery_images'] as $image) { ?>
							<div class="single-gallery">
	                            <div class="featured-image img-gallery">
	                                <a href="#" class="wplightbox"><img src="<?php echo $image; ?>" alt=""></a>
	                            </div>
	                        </div>
					<?php }
					}
				}
				
				if(isset($video_gallery_album) && $video_gallery_album) {
					foreach($video_gallery_album as $video) { //echo '<pre>'; print_r($video); echo '</pre>'; ?>
						<div class="single-gallery">
                            <div class="featured-image img-gallery">
                                <a href="#" class="wplightbox"><?php echo $video['video_gallery']; ?></a>
                            </div>
                        </div>
					<?php
					}
				}
				?>
			</div>
			<div style="text-align: center;">
				<div class="back-button-bottom">
					<a class="back-btn" href="<?php echo site_url(); ?>/gallery/">Back to galleries</a>
				</div>
			</div>
		</div>
	</div>
	<!-- News page main section end -->
</section>

<?php echo do_shortcode('[sigma-mt-newsletter]'); ?>

<?php get_footer(); ?>
