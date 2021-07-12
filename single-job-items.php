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
			<!-- Leftbar end -->

			<!-- Middle Detail News start -->
			<div class="job-details">
				<div class="featured-img">
					<?php the_post_thumbnail(); ?>
				</div>
				<div class="post-body">
					<div class="post-content">
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
			<!-- Rightbar end -->
		</div>
	</div>
	<!-- News page main section end -->
</section>

<?php echo do_shortcode('[sigma-mt-newsletter]'); ?>

<?php get_footer(); ?>
