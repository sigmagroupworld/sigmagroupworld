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
$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' ); 
$image_id = get_image_id_by_url($featured_image);
$image_info = wp_get_attachment_metadata($image_id);
$image_title = get_the_title($image_id);
$casino_provider = get_field('casino_details', $post_id);
?>

<section class="single-casino-page">
	<div class="container">
		<div class="single-casino-banner">
	    	<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $image_title; ?>">
	    </div>
	    <div class="casino-detail">
	    	<div class="tab">
  				<button class="tablinks active review" onclick="opendetails(event, 'casino-review')">
  					<?php _e( 'CASINO REVIEW', 'sigmaigaming' ); ?>
  				</button>
  				<button class="tablinks details" onclick="opendetails(event, 'casino-details')">
  					<?php _e( 'casino details', 'sigmaigaming' ); ?>
  				</button>
			</div>
			<div class="casino-all">
				<div class="casino-tab-details">
					<div id="casino-review" class="tabcontent" style="display: block;">
		  				<?php the_content(); ?>
					</div>
					<div id="casino-details" class="tabcontent">
		  				<div class="every-casino-detail">
		  					<div class="casino-title licences">
		  						<h2><?php _e( 'Licences', 'sigmaigaming' ); ?></h2>
		  					</div>
		  					<div class="every-detail">
		  						<p><?php if(isset($casino_provider['licences'])) { echo $casino_provider['licences']; } ?></p>
		  					</div>
		  				</div>
		  				<div class="every-casino-detail">
		  					<div class="casino-title countries">
		  						<h2><?php _e( 'Restricted Countries', 'sigmaigaming' ); ?></h2>
		  					</div>
		  					<div class="every-detail">
		  						<p><?php if(isset($casino_provider['restricted_countries'])) { echo $casino_provider['restricted_countries']; } ?></p>
		  					</div>
		  				</div>
		  				<div class="every-casino-detail">
		  					<div class="casino-title d-method">
		  						<h2><?php _e( 'Deposit Methods', 'sigmaigaming' ); ?></h2>
		  					</div>
		  					<div class="every-detail">
		  						<div class="method-all-imgs">
		  							<?php if(isset($casino_provider['deposit_methods'])) { 
										foreach($casino_provider['deposit_methods'] as $value) {
											$visa = __( 'Visa', 'sigmaigaming' );
										    $mastercard = __( 'Mastercard', 'sigmaigaming' );
										    $neteller =__( 'Neteller', 'sigmaigaming' );
										    $skrill = __( 'Skrill', 'sigmaigaming' );
										    $mestrocard = __( 'Mestrocard', 'sigmaigaming' );
										    $paypal = __( 'Paypal', 'sigmaigaming' );
										    $bitcoin =__( 'Bitcoin', 'sigmaigaming' );
										    $ecopayz = __( 'Ecopayz', 'sigmaigaming' );
											?>
											<div class="method-single-img">
												<?php if($value === $visa) echo '<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/VISA-new-logo.png">'; ?>
												<?php if($value === $mastercard) echo '<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/Payments%20Logo/Maestro-1.jpg">'; ?>
												<?php if($value === $neteller) echo '<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/Neteller.jpg">'; ?>
												<?php if($value === $skrill) echo '<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/Skrill%20.jpg">'; ?>
											</div>
									<?php }
									} ?>
		  						</div>
		  					</div>
		  				</div>
		  				<div class="every-casino-detail">
		  					<div class="casino-title d-method">
		  						<h2><?php _e( 'Withdrawal Methods', 'sigmaigaming' ); ?></h2>
		  					</div>
		  					<div class="every-detail">
		  						<div class="method-all-imgs">
		  							<?php if(isset($casino_provider['withdrawal_methods'])) { 
										foreach($casino_provider['withdrawal_methods'] as $value) {
											$visa = __( 'Visa', 'sigmaigaming' );
										    $mastercard = __( 'Mastercard', 'sigmaigaming' );
										    $neteller =__( 'Neteller', 'sigmaigaming' );
										    $skrill = __( 'Skrill', 'sigmaigaming' );
										    $mestrocard = __( 'Mestrocard', 'sigmaigaming' );
										    $paypal = __( 'Paypal', 'sigmaigaming' );
										    $bitcoin =__( 'Bitcoin', 'sigmaigaming' );
										    $ecopayz = __( 'Ecopayz', 'sigmaigaming' );
											?>
											<div class="method-single-img">
												<?php if($value === $visa) echo '<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/VISA-new-logo.png">'; ?>
												<?php if($value === $mastercard) echo '<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/Payments%20Logo/Maestro-1.jpg">'; ?>
												<?php if($value === $neteller) echo '<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/Neteller.jpg">'; ?>
												<?php if($value === $skrill) echo '<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/Skrill%20.jpg">'; ?>
											</div>
									<?php }
									} ?>
		  						</div>
		  					</div>
		  				</div>
		  				<div class="every-casino-detail">
		  					<div class="casino-title limits">
		  						<h2><?php _e( 'Withdrawal Limit', 'sigmaigaming' ); ?></h2>
		  					</div>
		  					<div class="every-detail">
		  						<p><?php if(isset($casino_provider['withdrawal_limit'])) { 
		  								echo $casino_provider['withdrawal_limit']; 
		  							} else {
		  								_e( 'No Limits', 'sigmaigaming' );
		  							} ?></p>
		  					</div>
		  				</div>
		  				<div class="every-casino-detail">
		  					<div class="casino-title limits">
		  						<h2><?php _e( 'Casino Games', 'sigmaigaming' ); ?></h2>
		  					</div>
		  					<div class="every-detail">
		  						<?php if(isset($casino_provider['casino_games'])) { 
									foreach($casino_provider['casino_games'] as $value) { ?>
										<div class="method-single-img">
											<?php echo  $value; ?>
										</div>
								<?php }
								} ?>
		  					</div>
		  				</div>
					</div>
				</div>
			</div>
	    </div>
	    <!-- Related Article Section -->
	    <div class="related-articles">
	    	<h3><?php _e( 'Related article', 'sigmaigaming' ); ?></h3>
			<div class="articles-slide">
				<?php foreach($casino_provider['news_articles'] as $k => $item) {
					$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' ); ?>
					<figure class="testimonial">
						<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $item->post_title; ?>" />
						<div class="post-title">
							<h3><?php echo $item->post_title; ?></h3>
						</div>
					</figure>
				<?php } ?>
			</div>
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
</section>

<?php get_footer(); ?>