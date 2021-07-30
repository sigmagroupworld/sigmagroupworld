<?php
/**
 * The template for displaying single post of casino 
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since 1.0.0
 */

get_header();

// get the current casino post
$post_id = get_the_ID();
$thumbnail = get_field('review_thumbnail', $post_id);
$review = get_field('review_content', $post_id);
$detail = get_field('detail_content', $post_id);
?>

<section class="single-casino-page">
	<div class="container">
		<div class="single-casino-banner">
	    	<img src="<?php echo $thumbnail; ?>">
	    </div>
	    <div class="casino-detail">
	    	<div class="tab">
  				<button class="tablinks active review" onclick="opendetails(event, 'casino-review')">
  					<?php (get_the_terms( $post_id, 'casinos-cat' )[0]->name  == 'Casino' ? _e( 'Casino Review', 'sigmaigaming' ) :  _e( 'Sports Betting Site Review', 'sigmaigaming' )); ?>
  				</button>
  				<button class="tablinks details" onclick="opendetails(event, 'casino-details')">
  					<?php (get_the_terms( $post_id, 'casinos-cat' )[0]->name == 'Casino' ? _e( 'Casino Details', 'sigmaigaming' ) :  _e( 'Sports Betting Site Details', 'sigmaigaming' )); ?>
  				</button>
			</div>
			<div class="casino-all">
				<div class="casino-tab-details">
					<div id="casino-review" class="tabcontent" style="display: block;">
		  				<?php echo $review; ?>
					</div>
					<div id="casino-details" class="tabcontent">
						<?php echo $detail; ?>
					</div>
				</div>
			</div>
			<!-- Related Article Section -->
			<div class="casino related-articles">
				<?php echo do_shortcode('[sigma-mt-related-articles term_name="'.get_the_title().'" post_per_page = 10]'); ?>
			</div>
		    <!-- Related Article Section end -->
		    <div class="tab-bottom-links">
		    	<div class="left">
		    		<a href="<?php echo SITE_URL . '/online-casinos'; ?>" onclick="goBack()"><?php _e( 'Back', 'sigmaigaming' ); ?></a>
		    	</div>
		    	<div class="left">
		    		<a href="<?php if(isset($casino_provider['play_link'])) { echo $casino_provider['play_link']; } ?>" target="_blank"><?php _e( 'Play', 'sigmaigaming' ); ?></a>
		    	</div>
		    </div>
	    </div>
	</div>
</section>

<?php get_footer(); ?>