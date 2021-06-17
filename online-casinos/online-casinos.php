<?php
/**
 * Template Name: SigmaMT Online Casinos Page Layout
 * Created By: Rinkal Petersen
 * Created at: 27 May 2021
 */
/* Directory template css */
get_header();
?>

<?php  ob_start();
$results = sigma_mt_get_casino_provider_data(); ?>

<section>
	<!-- Casino Content section start -->
	<div class="blog-content">
		<div class="page-container">
			<div class="blog-leftbar">
				<div class="single-banner-advert bottom-border">
					<a href="#" target="_blank">
                    	<img src="https://www.sigma.com.mt/hubfs/6M%20Sigma%20Files/Banners/Sold%20Banners/AGS-PM-Affiliate-Program-Left-Banner.png" alt="">       
    				</a>
				</div>
				<div class="affiliates bottom-border">
					<div class="blog-sub-title">
						<h3>Affiliates</h3>
					</div>
					<!-- Affliates blog -->
				</div>
				<div class="malta bottom-border">
					<div class="blog-sub-title">
						<h3>WHY MALTA?</h3>
					</div>
					<!-- video -->
				</div>
			</div>

			<!-- All Casinos Section start -->
			<div class="blog-details">
				<div class="casino-featured">
					<?php if ( has_post_thumbnail()) : ?>
					    <?php the_post_thumbnail(); ?>
					<?php endif; ?>
				</div>
				<div class="casinos-txt">
					<p><?php the_content(); ?></p>
				</div>
				<div class="all-casinos">
					<?php foreach($results as $k => $post) {
						setup_postdata( $post );
		        		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); 

		        		$casino_provider = get_field('casino_details', $post->ID);
		        		?>
						<div class="single-casino">
							<div class="casino-logo">
								<img src="<?php if(isset($casino_provider['casino_logo'])) { echo $casino_provider['casino_logo']; } ?>" alt="">
							</div>
							<div class="casino-star-rating">
								<div class="start-rating">
									<?php 
									if(isset($casino_provider['star_rating_count']) && !empty($casino_provider['star_rating_count'])) {
										$count = $casino_provider['star_rating_count'];
									} else {
										$count = '3';
									}
									$args = array(
									   'rating' => $count,
									   'type' => 'rating',
									   'number' => 12345,
									);
									wp_star_rating( $args ); ?>
								</div>
							</div>
							<div class="casino-bonus">
								<img src="https://www.sigma.com.mt/hubfs/Icon-Present.png" alt="">
								<p><?php if(isset($casino_provider['exclusive_bonus'])) { echo $casino_provider['exclusive_bonus']; } ?></p>
							</div>
							<div class="casino-bonus-details">
								<ul>
									<?php if(isset($casino_provider['online_casino_bonus_detail'])) { 
										foreach($casino_provider['online_casino_bonus_detail'] as $value) { ?>
											<li><?php echo $value['bonus_details']; ?></li>
									<?php }
									} ?>
								</ul>
							</div>
							<div class="casino-buttons">
								<a href="#" class="play"><?php _e( 'Play', 'sigmaigaming' ); ?></a>
								<a href="<?php echo get_permalink( $post->ID ); ?>" class="review"><?php _e( 'Review', 'sigmaigaming' ); ?></a>
							</div>
							<div class="payment-options">
								<?php if(isset($casino_provider['payment_options'])) { 
									foreach($casino_provider['payment_options'] as $value) {
										$visa = __( 'Visa', 'sigmaigaming' );
									    $mastercard = __( 'Mastercard', 'sigmaigaming' );
									    $neteller =__( 'Neteller', 'sigmaigaming' );
									    $skrill = __( 'Skrill', 'sigmaigaming' );
									    $mestrocard = __( 'Mestrocard', 'sigmaigaming' );
									    $paypal = __( 'Paypal', 'sigmaigaming' );
									    $bitcoin =__( 'Bitcoin', 'sigmaigaming' );
									    $ecopayz = __( 'Ecopayz', 'sigmaigaming' );
										?>
										<div class="single-option">
											<?php if($value === $visa) echo '<img src="'. CHILD_DIR . '/online-casinos/images/VISA-new-logo.png">'; ?>
											<?php if($value === $mastercard) echo '<img src="'. CHILD_DIR . '/online-casinos/images/mastercard.png">'; ?>
											<?php if($value === $neteller) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Neteller.png">'; ?>
											<?php //if($value === $payeer) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Payeer.png">'; ?>
											<?php if($value === $bitcoin) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Bitcoin.png">'; ?>
											<?php //if($value === $ecopays) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Ecopayz.png">'; ?>
											<?php //if($value === $webpay) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Webpay logo.png">'; ?>
											<?php //if($value === $epay) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Epay logo.png">'; ?>
										</div>
								<?php }
								} ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			<!-- All Casinos Section end -->

			<div class="blog-rightbar">
				<div class="magazine-widget bottom-border">
					<div class="blog-sub-title">
						<h3>Latest Magazines</h3>
					</div>
  					<a href="#" target="_blank">
    					<img src="https://www.sigma.com.mt/hubfs/6M%20Sigma%20Files/Magazine/Magazine%20covers/Sigma%2013%20for%20web-1.png" alt="magazine"/>
  					</a>
				</div>
				<div class="offers-wrapper">
					<div class="blog-sub-title">
						<h3>Casino Offers</h3>
					</div>
					<div class="offer-wrap">
						<div class="offer-item">
							<div class="img-wrap">
          						<img src="https://www.sigma.com.mt/hubfs/1xbet-1.png" alt="offer"/>
        					</div>
        					<div class="link-wrap">
        						<a class="play-btn" target="_blank" href="#">Play Now</a>
        						<a class="tnc-link" href="#">*T&amp;C Apply</a>
        					</div>
						</div>
						<div class="offer-item">
							<div class="img-wrap">
          						<img src="https://www.sigma.com.mt/hubfs/1xbet-1.png" alt="offer"/>
        					</div>
        					<div class="link-wrap">
        						<a class="play-btn" target="_blank" href="#">Play Now</a>
        						<a class="tnc-link" href="#">*T&amp;C Apply</a>
        					</div>
						</div>
						<div class="offer-item">
							<div class="img-wrap">
          						<img src="https://www.sigma.com.mt/hubfs/1xbet-1.png" alt="offer"/>
        					</div>
        					<div class="link-wrap">
        						<a class="play-btn" target="_blank" href="#">Play Now</a>
        						<a class="tnc-link" href="#">*T&amp;C Apply</a>
        					</div>
						</div>
						<div class="offer-item">
							<div class="img-wrap">
          						<img src="https://www.sigma.com.mt/hubfs/1xbet-1.png" alt="offer"/>
        					</div>
        					<div class="link-wrap">
        						<a class="play-btn" target="_blank" href="#">Play Now</a>
        						<a class="tnc-link" href="#">*T&amp;C Apply</a>
        					</div>
						</div>
						<div class="offeritem">
							<div class="img-wrap">
          						<img src="https://www.sigma.com.mt/hubfs/1xbet-1.png" alt="offer"/>
        					</div>
        					<div class="link-wrap">
        						<a class="play-btn" target="_blank" href="#">Play Now</a>
        						<a class="tnc-link" href="#">*T&amp;C Apply</a>
        					</div>
						</div>
					</div>
				</div>
				<div class="latest-news bottom-border">
					<div class="blog-sub-title">
						<h3>Latest News</h3>
					</div>
					<!-- Latest news blog -->
				</div>
				<div class="after-movie bottom-border">
					<div class="blog-sub-title">
						<h3>SiGMA 2019 Aftermovie</h3>
					</div>
					<!-- Video -->
				</div>
				<div class="upcoming-event">
					<div class="blog-sub-title">
						<h3>Upcoming Events</h3>
					</div>
					<div class="calendar-event ">
						<h5>SiGMA Europe (Malta)</h5> 
    					<div class="date">  
      						November 16, 2021
    					</div>
    					<div class="widget_type_rich-text">
     						<p>Following the UK's December 2020 release of the Pfizer BioNTech vaccine, SIGMA Group will move its April event to November. SIGMA Europe, which will be based...</p>
    					</div>
    					<a class="eventbtn" href="#" target="_blank">REGISTER FREE</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Casino Content section End -->
</section>


<?php get_footer(); ?>
