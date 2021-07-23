<?php
/**
 * Template Name: SigmaMT Home Page Layout
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
$taxonomy = __( 'news-tag', 'sigmaigaming' );
$row = 0;
$page_id = $wp_query->get_queried_object()->ID;
$post_count = '10';

if ($desktop_banner){ ?>
	<!-- Home page banner start -->
	<section class="home-banner" style="background-image: url(<?php echo $desktop_banner['banner_background_image']; ?>);">
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
									<a class="<?php echo $value['country_name']; ?>" href="<?php echo $value['country_link']; ?>">
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
								<a href="<?php echo $value['country_link']; ?>">
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
	<!-- News category menu start -->
	<section>
		<div class="container">
			<div class="home-news-menu">
				<div class="news-menu">
					<div class="mobile-pick">
						<ul>
							<li><?php echo $desktop_banner["all_categories_title"]; ?></li>
						</ul>
						<div class="btn">
							<div>
								<span></span>
								<span></span>
								<span></span>
								<span></span>
							</div>
						</div>
					</div>
					<?php
					$menu_name = sigma_mt_get_tags_menu();
					?>
					<ul>
						<?php foreach ( $menu_name as $k => $tag ) { ?>
			  				<li>
			  					<a href="<?php echo $tag->url; ?>"><?php echo $tag->title; ?></a>
			  				</li>
			  			<?php } ?>
		 			</ul>
				</div>
				<div class="news-search">
					<?php echo do_shortcode( '[sigma-mt-wpbsearch]' ); ?>
				</div>
			</div>
		</div>
	</section>
	<!-- News category menu end -->
	<!-- Latest blog section -->
	<section class="home-blog">
		<div class="container">
			<div class="home-news">
				<div class="latest-news hp-left">
					<?php
					$news_tags = sigma_mt_get_news_tags_data('', $taxonomy, 14);
					?>
					<div class="h-title">
						<a href="#"><?php echo $desktop_banner["latest_posts_title"]; ?><i class="fa fa-angle-right" aria-hidden="true"></i></a>
					</div>
		       		<?php
	        		foreach ( $news_tags['term_data'] as $k => $post ) {
		        		setup_postdata( $post );
		        		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			            ?>
			            <div class="blog-listing-module">								
							<div class="post-item">
								<a href="<?php the_permalink(); ?>">
									<?php if($row === 0) { ?>
										<div class="thumb-img">
			                        		<img src="<?php echo $featured_image[0] ?>" alt="">
			                    		</div>
			                    	<?php } ?>
		                    		<h2 <?php if($row === 0) { ?> class="big" <?php } ?> ><?php the_title(); ?></h2>
								</a>
							</div>
						</div>							
						<?php $row++; ?>
						<?php wp_reset_postdata();
					} ?>
				</div>
				<div class="affiliate hp-center">
					<?php
					$news_tags = sigma_mt_get_news_tags_data(1060, $taxonomy, 12);
					?>
					<div class="h-title">
						<a href="<?php echo get_tag_link($news_tags['term_value']->term_id); ?>">
							<?php if(isset($news_tags['term_value']->name)) {
								echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
							<?php } ?>
						</a>
					</div>
					<div class="blog-listing-module">
						<?php
						foreach ( $news_tags['term_data'] as $k => $post ) {
				        	setup_postdata( $post );
				        	$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); ?>
				        	<?php if($row === 0) { ?>
								<div class="post-item">
									<a href="<?php the_permalink(); ?>">
										<div class="thumb-img">
			                        		<img src="<?php echo $featured_image[0] ?>" alt="">
			                    		</div>
		                    			<h2><?php the_title(); ?></h2>
									</a>
								</div>
							<?php } else { ?>
								<div class="post-item">
									<a href="<?php the_permalink(); ?>">
										<div class="thumb-img">
			                        		<img src="<?php echo $featured_image[0] ?>" alt="">
			                    		</div>
			                    		<h2><?php the_title(); ?></h2>
									</a>
								</div>
							<?php } ?>
						<?php $row++; } ?>
					</div>
				</div>
				<div class="spotify hp-right">
					<?php
					$video_cat = sigma_mt_get_video_term($page_id);
			      	$term_id = $video_cat[0]->term_id;
					$videos = sigma_mt_get_videos($term_id, $post_count);
			        $youtube_video_title = get_field('video_title', $videos[0]->ID);
			        $r = 0;
					?>

					<div class="h-title">
						<a href="#">
							<?php echo $desktop_banner["watch_spotify_title"]; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
						</a>
					</div>
					<div class="blog-listing-module">
						<?php foreach ( $videos as $k => $video ) {
							$youtube_video_link = get_field('youtube_video_link',  $video->ID);
							$split_link = explode("/",$youtube_video_link);
							$split_video_ink = $split_link[4];
							$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $video->ID ), 'full' ); ?>
							<div class="post-item">
								<?php if($r === 0) { ?>
									<a href="<?php echo $youtube_video_link; ?>" data-video-id='<?php echo $split_video_ink; ?>' class="js-video-button" id="video_player">
										<div class="thumb-img">
											<div class="top" style="background-image: url('<?php echo $featured_image[0] ?>')">
												<div class="play-btn"></div>
												<div id="meta"></div>
												<span><?php _e( '21.45', 'sigmaigaming' ); ?></span>
											</div>
			                    		</div>
			                    		<h2 class="big"><?php echo $video->post_title; ?></h2>
									</a>
								<?php } else { ?>
									<a href="<?php echo $youtube_video_link; ?>" data-video-id='<?php echo $split_video_ink; ?>' class="js-video-button" id="video_player">
										<div class="thumb-img">
			                        		<div class="top" style="background-image: url('<?php echo $featured_image[0] ?>')">
												<div class="play-btn"></div>
											</div>
			                    		</div>
			                    		<h2><?php echo $video->post_title; ?></h2>
									</a>
								<?php } ?>
							</div>
						<?php $r++; } ?>
					</div>
					<div class="">
						<?php echo $desktop_banner["executive_interview"]; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Latest blog section end -->

	<!-- News Image slider start -->
	<section class="sigma-news">
        <div class="container">
        	<div class="single-news">
	        	<?php foreach($desktop_banner["sigma_upcoming_add"] as $value) { ?>
	                <div class="all-news">
	                    <a href="#">
	                        <img src="<?php echo $value['latest_news_bottom_image']; ?>" alt="">
	                    </a>
	                </div>
		        <?php } ?>
	    	</div>
        </div>
    </section>
	<!-- News Image slider end -->

	<?php sigma_mt_get_continent_order(); ?>

<?php
}
?>

<?php echo do_shortcode('[sigma-mt-newsletter]'); ?>

<?php get_footer(); ?>
