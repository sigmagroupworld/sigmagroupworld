<?php
/**
 * Template Name: SigmaMT Exhibit Choose Edition Page Layout
 * Created By: Rinkal Petersen
 * Created at: 5 May 2021
 */
/* Directory template css */
wp_enqueue_style('exhibit', get_stylesheet_directory_uri().'/exhibit-choose-edition/css/exhibit.css'); 
get_header();
?>
<?php  ob_start(); $exhibit = get_field('exhibit_banner');
if ($exhibit){
?>
	<!-- Exhibit Choose Edition banner start -->
	<section class="home-banner" style="background-image: url(<?php echo $exhibit['exhibit_background_image']; ?>);">
		<div class="banner-container">
			<!-- Desktop banner start -->
			<div class="desktop-banner">
				<div class="labelwrapmap exhibit">
		 	  		<span>	
		 	    		<img src="<?php echo $exhibit['desktop_featured_image']; ?>" alt="Title">
		 	  		</span>
		 	  		<div class="desktopmedialabel">
	  					<a href="<?php echo $exhibit['explore_section']['explore_media_link']; ?>">
		      				<img src="<?php echo $exhibit['explore_section']['explore_media']; ?>" alt="SiGMA-media_Mob">
	  					</a>
					</div>
		 		</div>
				<div class="sigmaBannerWrapper">
			 		<div class="bannerInnerWrapper">
			 			<div class="bannermapwrapper bannermapwrap-left">
			 				<div class="inneranimate" style="background-image: url(<?php echo $exhibit['map_image_one']; ?>);">
			 					<div class="americaele2"></div>
			 					<div class="americaele"></div>
			 				</div>
			 		    </div>
			 		    <div class="bannermapwrapper bannermapwrap-middle">
			 		      	<div class="inneranimate" style="background-image: url(<?php echo $exhibit['map_image_two']; ?>);">
			 		      		<div class="asiaele3"></div>
			 		      		<div class="asiaele2"></div>
			 					<div class="asiaele"></div>
			 					<div class="africaele"></div>
			 					<div class="europeele"></div>
			 					<div class="europeele2"></div>
			 		      	</div>
			 		    </div>
			 			<div class="bannermapwrapper bannermapwrap-right">
			 				<div class="inneranimate" style="background-image: url(<?php echo $exhibit['map_image_three']; ?>);">
			 	        		<div class="gamele"></div>
			 					<div class="gamele1"></div>
			 					<div class="gamele2"></div>
			 				</div>
			 		    </div>
			 		    <div class="maplabel">
			 		    	<div class="innermaplabel">
			 		    		<?php
								foreach($exhibit['countries'] as $key => $value) { ?>
									<a class="<?php echo $value['country_name']; ?>" href="<?php echo $value['country_link']; ?>">
		 					  			<img src="<?php echo $value['country_logo']; ?>" alt="">
		 					  		</a>
								<?php  } ?>
			 		    	</div>
				 		</div>
			 		</div>
			 	</div>
			</div>
			<!-- Desktop banner end -->
			<!-- Mobile banner start -->
			<div class="mobile-banner">
				<div class="mobilelabelmap exhibit">
					<div class="event-box">
	  					<a href="<?php echo $exhibit['mobile_featured_section']['mobile_featured_image_link']; ?>">
	  						<div class="img">
		      					<img src="<?php echo $exhibit['mobile_featured_section']['mobile_featured_image']; ?>" alt="SiGMA-media_Mob">
		      				</div>
	  					</a>
					</div>
					<div class="event-box explore">
	  					<a href="<?php echo $exhibit['explore_section']['explore_media_link']; ?>">
	  						<div class="img">
		      					<img src="<?php echo $exhibit['explore_section']['explore_media']; ?>" alt="SiGMA-media_Mob">
		      				</div>
	  					</a>
					</div>
				</div>
				<div class="events-wrapper">
					<?php
					foreach($exhibit['countries'] as $key => $value) { ?>
						<div class="all-country <?php echo $value['country_name']; ?>">
							<div class="event-box">
								<a href="<?php echo $value['country_link']; ?>">
									<span class="img">
										<img src="<?php echo $value['country_logo']; ?>" alt="">
									</span>
								</a>
							</div>
						</div>
					<?php  } ?>
				</div>
			</div>
			<!-- Mobile banner end -->
		</div>
	</section>
	<!-- Exhibit Choose Edition banner end -->
<?php
}
?>
<div class="newsletter exhibit-news" style="background: url(<?php the_field('newsletter_background_image', 'option'); ?>);">
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
