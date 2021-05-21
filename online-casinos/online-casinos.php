<?php
/**
 * Template Name: SigmaMT Online Casinos Page Layout
 * Created By: Rinkal Petersen
 * Created at: 27 Apr 2021
 */
/* Directory template css */
wp_enqueue_style('directory', get_stylesheet_directory_uri().'/online-casinos/css/online-casinos.css'); 
get_header();
?>

<?php  ob_start(); $directory = get_field('directory_box'); ?>


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
					<div class="single-casino">
						<div class="casino-logo">
							<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/Logo/14%20red%20casino%20small%20banner.jpg" alt="">
						</div>
						<div class="casino-star-rating">
							<div class="start-rating">
								
							</div>
						</div>
						<div class="casino-bonus">
							<img src="https://www.sigma.com.mt/hubfs/Icon-Present.png" alt="">
							<p>200% up to €600 + 50 Free Spins</p>
						</div>
						<div class="casino-bonus-details">
							<ul>
								<li>Four tier VIP system</li>
								<li>Trusted payment methods</li>
							</ul>
						</div>
						<div class="casino-buttons">
							<a href="#" class="play">Play</a>
							<a href="#" class="review">Review</a>
						</div>
						<div class="payment-options">
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Ecopayz.png" alt="">
							</div>
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/VISA-new-logo.png" alt="">
							</div>
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/mastercard.jpg" alt="">
							</div>
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/Neteller.jpg" alt="">
							</div>
						</div>
					</div>
					<div class="single-casino">
						<div class="casino-logo">
							<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/Logo/14%20red%20casino%20small%20banner.jpg" alt="">
						</div>
						<div class="casino-star-rating">
							<div class="start-rating">
								
							</div>
						</div>
						<div class="casino-bonus">
							<img src="https://www.sigma.com.mt/hubfs/Icon-Present.png" alt="">
							<p>200% up to €600 + 50 Free Spins</p>
						</div>
						<div class="casino-bonus-details">
							<ul>
								<li>Four tier VIP system</li>
								<li>Trusted payment methods</li>
							</ul>
						</div>
						<div class="casino-buttons">
							<a href="#" class="play">Play</a>
							<a href="#" class="review">Review</a>
						</div>
						<div class="payment-options">
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Ecopayz.png" alt="">
							</div>
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/VISA-new-logo.png" alt="">
							</div>
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/mastercard.jpg" alt="">
							</div>
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/Neteller.jpg" alt="">
							</div>
						</div>
					</div>
					<div class="single-casino">
						<div class="casino-logo">
							<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/Logo/14%20red%20casino%20small%20banner.jpg" alt="">
						</div>
						<div class="casino-star-rating">
							<div class="start-rating">
								
							</div>
						</div>
						<div class="casino-bonus">
							<img src="https://www.sigma.com.mt/hubfs/Icon-Present.png" alt="">
							<p>200% up to €600 + 50 Free Spins</p>
						</div>
						<div class="casino-bonus-details">
							<ul>
								<li>Four tier VIP system</li>
								<li>Trusted payment methods</li>
							</ul>
						</div>
						<div class="casino-buttons">
							<a href="#" class="play">Play</a>
							<a href="#" class="review">Review</a>
						</div>
						<div class="payment-options">
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Ecopayz.png" alt="">
							</div>
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/VISA-new-logo.png" alt="">
							</div>
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/mastercard.jpg" alt="">
							</div>
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/Neteller.jpg" alt="">
							</div>
						</div>
					</div>
					<div class="single-casino">
						<div class="casino-logo">
							<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/Logo/14%20red%20casino%20small%20banner.jpg" alt="">
						</div>
						<div class="casino-star-rating">
							<div class="start-rating">
								
							</div>
						</div>
						<div class="casino-bonus">
							<img src="https://www.sigma.com.mt/hubfs/Icon-Present.png" alt="">
							<p>200% up to €600 + 50 Free Spins</p>
						</div>
						<div class="casino-bonus-details">
							<ul>
								<li>Four tier VIP system</li>
								<li>Trusted payment methods</li>
							</ul>
						</div>
						<div class="casino-buttons">
							<a href="#" class="play">Play</a>
							<a href="#" class="review">Review</a>
						</div>
						<div class="payment-options">
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Ecopayz.png" alt="">
							</div>
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/VISA-new-logo.png" alt="">
							</div>
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/mastercard.jpg" alt="">
							</div>
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/Neteller.jpg" alt="">
							</div>
						</div>
					</div>
					<div class="single-casino">
						<div class="casino-logo">
							<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/Logo/14%20red%20casino%20small%20banner.jpg" alt="">
						</div>
						<div class="casino-star-rating">
							<div class="start-rating">
								
							</div>
						</div>
						<div class="casino-bonus">
							<img src="https://www.sigma.com.mt/hubfs/Icon-Present.png" alt="">
							<p>200% up to €600 + 50 Free Spins</p>
						</div>
						<div class="casino-bonus-details">
							<ul>
								<li>Four tier VIP system</li>
								<li>Trusted payment methods</li>
							</ul>
						</div>
						<div class="casino-buttons">
							<a href="#" class="play">Play</a>
							<a href="#" class="review">Review</a>
						</div>
						<div class="payment-options">
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Ecopayz.png" alt="">
							</div>
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/VISA-new-logo.png" alt="">
							</div>
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/mastercard.jpg" alt="">
							</div>
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/Neteller.jpg" alt="">
							</div>
						</div>
					</div>
					<div class="single-casino">
						<div class="casino-logo">
							<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/Logo/14%20red%20casino%20small%20banner.jpg" alt="">
						</div>
						<div class="casino-star-rating">
							<div class="start-rating">
								
							</div>
						</div>
						<div class="casino-bonus">
							<img src="https://www.sigma.com.mt/hubfs/Icon-Present.png" alt="">
							<p>200% up to €600 + 50 Free Spins</p>
						</div>
						<div class="casino-bonus-details">
							<ul>
								<li>Four tier VIP system</li>
								<li>Trusted payment methods</li>
							</ul>
						</div>
						<div class="casino-buttons">
							<a href="#" class="play">Play</a>
							<a href="#" class="review">Review</a>
						</div>
						<div class="payment-options">
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Ecopayz.png" alt="">
							</div>
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/VISA-new-logo.png" alt="">
							</div>
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/mastercard.jpg" alt="">
							</div>
							<div class="single-option">
								<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/Neteller.jpg" alt="">
							</div>
						</div>
					</div>
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
