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
										    $ecopays = __( 'Ecopays', 'sigmaigaming' );
										    $entropay = __( 'Entropay', 'sigmaigaming' );
										    $webpay =__( 'Webpay', 'sigmaigaming' );
										    $epay = __( 'Epay', 'sigmaigaming' );
										    $trustpay =__( 'Trustpay', 'sigmaigaming' );
										    $payeer = __( 'Payeer', 'sigmaigaming' );
											?>
											<div class="method-single-img">
												<?php if($value === $visa) echo '<img src="'. CHILD_DIR . '/online-casinos/images/VISA-new-logo.png">'; ?>
												<?php if($value === $mastercard) echo '<img src="'. CHILD_DIR . '/online-casinos/images/mastercard.png">'; ?>
												<?php if($value === $neteller) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Neteller.png">'; ?>
												<?php if($value === $payeer) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Payeer.png">'; ?>
												<?php if($value === $bitcoin) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Bitcoin.png">'; ?>
												<?php if($value === $ecopays) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Ecopayz.png">'; ?>
												<?php if($value === $webpay) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Webpay logo.png">'; ?>
												<?php if($value === $epay) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Epay logo.png">'; ?>
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
												<?php if($value === $visa) echo '<img src="'. CHILD_DIR . '/online-casinos/images/VISA-new-logo.png">'; ?>
												<?php if($value === $mastercard) echo '<img src="'. CHILD_DIR . '/online-casinos/images/mastercard.png">'; ?>
												<?php if($value === $neteller) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Neteller.png">'; ?>
												<?php if($value === $payeer) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Payeer.png">'; ?>
												<?php if($value === $bitcoin) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Bitcoin.png">'; ?>
												<?php if($value === $ecopays) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Ecopayz.png">'; ?>
												<?php if($value === $webpay) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Webpay logo.png">'; ?>
												<?php if($value === $epay) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Epay logo.png">'; ?>
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
		  					<div class="casino-title games">
		  						<h2><?php _e( 'Casino Games', 'sigmaigaming' ); ?></h2>
		  					</div>
		  					<div class="every-detail for-games">
								<?php if(isset($casino_provider['casino_games'])) {
									foreach($casino_provider['casino_games'] as $value) {
										$slots = __( 'Slots', 'sigmaigaming' );
									    $roulette = __( 'Roulette', 'sigmaigaming' );
									    $live_games =__( 'Live Games', 'sigmaigaming' );
									    $baccarat = __( 'Baccarat', 'sigmaigaming' );
									    $no_sports_betting = __( 'No Sports betting', 'sigmaigaming' );
										?>
										<div class="method-single-img">
											<?php if($value === $slots) { 
												$image_icon = '<img src="'. CHILD_DIR . '/online-casinos/images/slot-machine.png">'; 
											} else if($value === $roulette) {
												$image_icon = '<img src="'. CHILD_DIR . '/online-casinos/images/roulette.png">'; 
											} else if($value === $live_games) {
												$image_icon = '<img src="'. CHILD_DIR . '/online-casinos/images/live-games.png">'; 
											} else if($value === $baccarat) {
												$image_icon = '<img src="'. CHILD_DIR . '/online-casinos/images/baccarat.png">'; 
											} else if($value === $no_sports_betting) {
												$image_icon = '<img src="'. CHILD_DIR . '/online-casinos/images/sport-betting.png">';
											}
											echo $image_icon . $value;
											?>

										</div>
								<?php }
								} ?>
		  					</div>
		  				</div>
		  				<div class="every-casino-detail">
		  					<div class="casino-title soft-providers">
		  						<h2><?php _e( 'Software Providers', 'sigmaigaming' ); ?></h2>
		  					</div>
		  					<div class="every-detail">
		  						<div class="method-single-img">
			  						<?php if(isset($casino_provider['software_providers'])) { 
			  							$value = implode(', ', $casino_provider['software_providers']);
			  							echo $value;
									} ?>
								</div>
		  					</div>
		  				</div>
					</div>
				</div>
			</div>
			<!-- Related Article Section -->
			<?php if(isset($casino_provider['news_articles']) && !empty($casino_provider['news_articles'])) { ?>
			    <div class="casino related-articles">
			    	<h3 class="related-title"><?php _e( 'Related article', 'sigmaigaming' ); ?></h3>
					<div class="articles-slide">
						<?php foreach($casino_provider['news_articles'] as $k => $item) {
							$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' ); ?>
							<a href="<?php echo get_permalink($item->ID); ?>"><div class="testimonial">
								<div class="testi-details">
									<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $item->post_title; ?>" />
									<div class="post-title">
										<h3><?php echo $item->post_title; ?></h3>
									</div>
								</div>
							</div></a>
						<?php } ?>
					</div>
			    </div>
			<?php } ?>
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