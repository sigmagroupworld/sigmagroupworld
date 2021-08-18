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
global $post;
//set_featured_image_from_custom_fields($post->ID);

if ($exhibit){
?>
	<!-- Exhibit Choose Edition banner start -->
	<section class="home-banner <?php echo $post->post_name; ?>" style="background-image: url(<?php echo $exhibit['exhibit_background_image']; ?>);">
		<div class="banner-container">
			<!-- Desktop banner start -->
			<div class="desktop-banner">
				<div class="label-wrap-map exhibit">
		 	  		<span>	
		 	    		<?php 
		 	    		if( !empty( $exhibit['desktop_featured_image'] ) ){ ?>
					    	<img src="<?php echo $exhibit['desktop_featured_image']['url']; ?>" alt="<?php echo $exhibit['desktop_featured_image']['alt']; ?>">
						<?php } ?>
		 	  		</span>
		 	  		<?php if( !empty( $exhibit['explore_section']['explore_media'] ) ) { ?>
			 	  		<div class="desktop-media-label">
		  					<a href="<?php echo $exhibit['explore_section']['explore_media_link']; ?>" target="_blank">
							    <img src="<?php echo $exhibit['explore_section']['explore_media']['url']; ?>" alt="<?php echo $exhibit['explore_section']['explore_media']['alt']; ?>">
		  					</a>
						</div>
					<?php } ?>
		 		</div>
				<div class="sigma-banner-wrapper">
			 		<div class="banner-inner-wrapper">
			 			<div class="banner-map-wrapper banner-map-wrap-left">
			 				<div class="inner-animate" style="background-image: url(<?php echo $exhibit['map_image_one']; ?>);">
			 					<div class="america-ele2"></div>
			 					<div class="america-ele"></div>
			 				</div>
			 		    </div>
			 		    <div class="banner-map-wrapper banner-map-wrap-middle">
			 		      	<div class="inner-animate" style="background-image: url(<?php echo $exhibit['map_image_two']; ?>);">
			 		      		<div class="asia-ele3"></div>
			 		      		<div class="asia-ele2"></div>
			 					<div class="asia-ele"></div>
			 					<div class="africa-ele"></div>
			 					<div class="europe-ele"></div>
			 					<div class="europe-ele2"></div>
			 		      	</div>
			 		    </div>
			 			<div class="banner-map-wrapper banner-map-wrap-right">
			 				<div class="inner-animate" style="background-image: url(<?php echo $exhibit['map_image_three']; ?>);">
			 	        		<div class="game-le"></div>
			 					<div class="game-le1"></div>
			 					<div class="game-le2"></div>
			 				</div>
			 		    </div>
			 		    <div class="map-label <?php echo $post->post_name; ?>">
			 		    	<div class="inner-map-label">
			 		    		<?php
			 		    		if(!empty($exhibit['countries'])) {
									foreach($exhibit['countries'] as $key => $value) { 
										//echo '<pre>'; print_r($value); echo '</pre>'; ?>
										<a class="<?php echo $value['country_name']; ?>" href="<?php echo $value['country_link']; ?>" target="_blank">
											<?php 
							 	    		if( !empty( $value['country_logo'] ) ){ ?>
										    	<img src="<?php echo $value['country_logo']['url']; ?>" alt="<?php echo $value['country_logo']['alt']; ?>">
											<?php } ?>
			 					  		</a>
								<?php  } } ?>
			 		    	</div>
				 		</div>
			 		</div>
			 	</div>
			</div>
			<!-- Desktop banner end -->
			<!-- Mobile banner start -->
			<div class="mobile-banner">
				<div class="mobile-label-map exhibit">
					<div class="event-box">
	  					<a href="<?php echo $exhibit['mobile_featured_section']['mobile_featured_image_link']; ?>" target="_blank">
	  						<div class="img">
	  							<?php 
				 	    		if( !empty( $exhibit['mobile_featured_section']['mobile_featured_image'] ) ){ ?>
							    	<img src="<?php echo $exhibit['mobile_featured_section']['mobile_featured_image']['url']; ?>" alt="<?php echo $exhibit['mobile_featured_section']['mobile_featured_image']['alt']; ?>">
								<?php } ?>
		      				</div>
	  					</a>
					</div>
					<?php if( !empty( $exhibit['explore_section']['explore_media'] ) ) { ?>
			 	  		<div class="event-box explore">
		  					<a href="<?php echo $exhibit['explore_section']['explore_media_link']; ?>" target="_blank">
		  						<div class="img">
		  							<?php 
					 	    		if( !empty( $exhibit['explore_section'] ) ){ ?>
								    	<img src="<?php echo $exhibit['explore_section']['explore_media']['url']; ?>" alt="<?php echo $exhibit['explore_section']['explore_media']['alt']; ?>">
									<?php } ?>
			      				</div>
		  					</a>
						</div>
					<?php } ?>
				</div>
				<div class="events-wrapper">
					<?php
					foreach($exhibit['countries'] as $key => $value) { ?>
						<div class="all-country <?php echo $value['country_name']; ?>">
							<div class="event-box">
								<a href="<?php echo $value['country_link']; ?>" target="_blank">
									<span class="img">
										<?php 
						 	    		if( !empty( $value['country_logo'] ) ){ ?>
									    	<img src="<?php echo $value['country_logo']['url']; ?>" alt="<?php echo $value['country_logo']['alt']; ?>">
										<?php } ?>
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

<?php echo do_shortcode('[sigma-mt-newsletter]'); ?>

<?php get_footer(); ?>
