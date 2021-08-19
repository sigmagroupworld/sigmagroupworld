<?php
/**
 * Template Name: SigmaMT New Home Page Layout
 * Created By: Rinkal Petersen
 * Created at: 22 Apr 2021
 */
/* Directory template css */
wp_enqueue_style('sigmamt-home-style', CHILD_DIR .'/home/css/style.css'); 
wp_enqueue_style('sigmamt-modal-video-style', CHILD_DIR .'/home/css/modal-video.min.css'); 
wp_enqueue_script('sigmamt-home-script', CHILD_DIR .'/home/js/custom-home.js', array(), '1.0.0', true);
wp_enqueue_script('sigmamt-modal-video-script', CHILD_DIR .'/home/js/jquery-modal-video.min.js', array(), '1.0.0', true);
get_header();
?>

<?php ob_start(); $desktop_banner = get_field('desktop_banner');

//echo '<pre>'; print_r($desktop_banner);
$taxonomy = __( 'news-cat', 'sigmaigaming' );
$placeholder = wp_get_attachment_image_url(99850);
$placeholder_full = wp_get_attachment_image_url(99850, 'full');
$row = 0;
$page_id = $wp_query->get_queried_object()->ID;

if ($desktop_banner){ ?>
	<!-- Home page banner start -->
	<section class="home-banner home-new-banner" style="background-image: url(<?php echo $desktop_banner['banner_background_image']; ?>);">
		<div class="banner-container">
			<!-- Desktop banner start -->
			<div class="desktop-banner">
				<div class="label-wrap-map">
		 	  		<span>	
		 	  			<?php 
		 	    		if( !empty( $desktop_banner['desktop_featured_image'] ) ){ ?>
					    	<img src="<?php echo $desktop_banner['desktop_featured_image']['url']; ?>" alt="<?php echo $desktop_banner['desktop_featured_image']['alt']; ?>">
						<?php } ?>
		 	  		</span>
		 		</div>
				<div class="sigma-banner-wrapper">
			 		<div class="banner-inner-wrapper">
			 			<div class="banner-map-wrapper banner-map-wrap-left">
			 				<div class="inner-animate" style="background-image: url(<?php echo $desktop_banner['map_image_one']; ?>);">
			 					<div class="america-ele2"></div>
			 					<div class="america-ele"></div>
			 				</div>
			 		    </div>
			 		    <div class="banner-map-wrapper banner-map-wrap-middle">
			 		      	<div class="inner-animate" style="background-image: url(<?php echo $desktop_banner['map_image_two']; ?>);">
			 		      		<div class="asia-ele3"></div>
			 		      		<div class="asia-ele2"></div>
			 					<div class="asia-ele"></div>
			 					<div class="africa-ele"></div>
			 					<div class="europe-ele"></div>
			 					<div class="europe-ele2"></div>
			 		      	</div>
			 		    </div>
			 			<div class="banner-map-wrapper banner-map-wrap-right">
			 				<div class="inner-animate" style="background-image: url(<?php echo $desktop_banner['map_image_three']; ?>);">
					 	        <div class="game-le"></div>
			 					<div class="game-le1"></div>
			 					<div class="game-le2"></div>
			 				</div>
			 		    </div>
			 		    <div class="map-label">
			 		    	<div class="inner-map-label">
			 		    		<?php
								foreach($desktop_banner['countries'] as $key => $value) { ?>
									<a class="<?php echo $value['country_name']; ?>" href="<?php echo $value['country_link']; ?>" target="_blank">
										<?php 
						 	    		if( !empty( $value['country_logo'] ) ){ ?>
									    	<img src="<?php echo $value['country_logo']['url']; ?>" alt="<?php echo $value['country_logo']['alt']; ?>">
										<?php } ?>
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
				<div class="mobile-label-map">
					<span>
						<?php 
		 	    		if( !empty( $desktop_banner['mobile_featured_image'] ) ){ ?>
					    	<img src="<?php echo $desktop_banner['mobile_featured_image']['url']; ?>" alt="<?php echo $desktop_banner['mobile_featured_image']['alt']; ?>">
						<?php } ?>
					</span>
				</div>
				<div class="events-wrapper">
					<?php
					foreach($desktop_banner['countries'] as $key => $value) { ?>
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
	<!-- Home page banner End -->

	<div class="new-home-layout">
	    <!-- Latest blog section -->
	    <section class="home-blog latest-news">
	        <div class="page-container">
	            <div class="home-news">
	                <div class="left-sidebar">
	                	<div class="space menus">
							<?php echo do_shortcode('[sigma_mt_show_sidebar_sigma_directory]'); ?>
	                    </div>
	                    <div class="space">
	                    	<?php echo do_shortcode('[sigma_mt_show_sidebar_magazines term_id="1148"]'); ?>
							<?php echo do_shortcode('[sigma_mt_show_sidebar_magazines term_id="1149"]'); ?>
	                    </div>
						<div class="space">
							<a href="<?php echo site_url(); ?>/m-and-a-action/"><div class="sigma-college">
								<div class="top-img">
									<a href="<?php echo site_url(); ?>/m-and-a-action/"><img src="/wp-content/uploads/2021/08/New-Project.png"></a>
								</div>
								<div class="text-event">M & A</div>
								</div></a>
	                    </div>
	                    <?php /*<div class="space sigma-college">
	                    	<a href="<?php echo site_url(); ?>/sigma-college/"><img src="/wp-content/uploads/2021/08/sigma-college.png"></a>
	                    </div>*/ ?>
	                </div>

	                <div class="home-middle-content">
	                    <?php
						$news_tags = sigma_mt_get_news_tags_data('', $taxonomy, 5);
						?>
						<div class="h-title">
							<a href="#"><?php echo $desktop_banner["latest_posts_title"]; ?><i class="fa fa-angle-right" aria-hidden="true"></i></a>
						</div>
						<?php
		        		foreach ( $news_tags['term_data'] as $k => $post ) {
			        		setup_postdata( $post );
			        		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			        		if($row != 0) {
			        			$class = "half";
			        			$main_class = "section";
			        		} else {
			        			$class = '';
			        			$main_class = "";
			        		}
				            ?>
				            <div class="blog-listing-module <?php echo $main_class; ?>">								
								<div class="post-item <?php echo $class; ?>">
									<a href="<?php the_permalink(); ?>">
										<div class="thumb-img">
											<?php if(!empty($featured_image)){ ?>
			                        		    <img src="<?php echo $featured_image[0] ?>" alt="">
											<?php } else { ?>
                                                <img src="<?php echo $placeholder_full ?>" alt="">
                                            <?php } ?> 
			                    		</div>
			                    		<h2 <?php if($row === 0) { ?> class="big" <?php } ?> ><?php the_title(); ?></h2>
									</a>
									<?php if($row === 0) { ?> <p><?php the_excerpt(); ?></p><?php } ?>
								</div>
							</div>							
							<?php $row++; ?>
							<?php wp_reset_postdata();
						} ?>
					</div>

	                <div class="right-sidebar">
	                    <div class="space">
							<?php echo do_shortcode('[sigma_mt_show_sidebar_event appearance="NewLayout"]'); ?>
	                    </div>
	                    <div class="space sigma-multi-events">
	                    	<?php echo do_shortcode('[sigma-mt-sidebar-event-logos]'); ?>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </section>
	</div>
	<!-- Latest blog section end -->

	<script>
		jQuery('.blog-listing-module.section').wrapAll('<div class="blog-listing-bellow"></div>');
	</script>

<?php
}
?>

<div class="home-page popup close">
	<div class="popupinner">
		<img src="/wp-content/uploads/2021/08/Malta-Week-Pop-up-Banner.webp">
		<a href="https://sigmamalta.events/sigma-malta-2021" target="_blank" class="tl"></a>
		<a href="https://sigmamalta.events/aibc-europe" target="_blank" class="tr"></a>
		<a href="https://sigmamalta.events/malta-affiliate-grand-slam" target="_blank" class="bl"></a>
		<a href="https://sigmamalta.events/med-tech-europe" target="_blank" class="br"></a>
		<div class="close">
			<a class="close-popup">❌</a>
		</div>
	</div>
</div>

<?php echo do_shortcode('[sigma-mt-newsletter]'); ?>

<?php get_footer(); ?>
