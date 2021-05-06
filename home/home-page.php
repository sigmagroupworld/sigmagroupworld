<?php
/**
 * Template Name: SigmaMT Home Page Layout
 * Created By: Rinkal Petersen
 * Created at: 22 Apr 2021
 */
/* Directory template css */
wp_enqueue_style('home', get_stylesheet_directory_uri().'/home/css/style.css'); 
wp_enqueue_script('test', get_stylesheet_directory_uri().'/home/js/custom-home.js', array(), '1.0.0', true);
get_header();
?>

<?php #echo do_shortcode( '[scheduled_posts]' ); ?>

<?php ob_start(); $desktop_banner = get_field('desktop_banner');
$taxonomy = 'news-tag';
$row = 0;

if ($desktop_banner){ ?>
	<!-- Home page banner start -->
	<section class="home-banner" style="background-image: url(<?php echo $desktop_banner['banner_background_image']; ?>);">
		<div class="banner-container">
			<!-- Desktop banner start -->
			<div class="desktop-banner">
				<div class="labelwrapmap">
		 	  		<span>	
		 	    		<img src="<?php echo $desktop_banner['desktop_featured_image']; ?>" alt="Title">
		 	  		</span>
		 		</div>
				<div class="sigmaBannerWrapper">
			 		<div class="bannerInnerWrapper">
			 			<div class="bannermapwrapper bannermapwrap-left">
			 				<div class="inneranimate" style="background-image: url(<?php echo $desktop_banner['map_image_one']; ?>);">
			 					<div class="americaele2"></div>
			 					<div class="americaele"></div>
			 				</div>
			 		    </div>
			 		    <div class="bannermapwrapper bannermapwrap-middle">
			 		      	<div class="inneranimate" style="background-image: url(<?php echo $desktop_banner['map_image_two']; ?>);">
			 		      		<div class="asiaele3"></div>
			 		      		<div class="asiaele2"></div>
			 					<div class="asiaele"></div>
			 					<div class="africaele"></div>
			 					<div class="europeele"></div>
			 					<div class="europeele2"></div>
			 		      	</div>
			 		    </div>
			 			<div class="bannermapwrapper bannermapwrap-right">
			 				<div class="inneranimate" style="background-image: url(<?php echo $desktop_banner['map_image_three']; ?>);">
					 	        <div class="gamele"></div>
			 					<div class="gamele1"></div>
			 					<div class="gamele2"></div>
			 				</div>
			 		    </div>
			 		    <div class="maplabel">
			 		    	<div class="innermaplabel">
			 		    		<?php
								foreach($desktop_banner['countries'] as $key => $value) { ?>
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
				<div class="mobilelabelmap">
					<span>
						<img src="<?php echo $desktop_banner['mobile_featured_image']; ?>" alt="Title">
					</span>
				</div>
				<div class="events-wrapper">
					<?php
					foreach($desktop_banner['countries'] as $key => $value) { ?>
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
	<!-- Home page banner End -->
	<!-- News category menu start -->
	<section>
		<div class="container">
			<div class="home-news-menu">
				<div class="news-menu">
					<div class="mobile-pick">
						<ul>
							<li>All Categories</li>
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
						<a href="#">Latest News<i class="fa fa-angle-right" aria-hidden="true"></i></a>
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
						<a href="#">
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
					<div class="h-title">
						<a href="#">
							Watch/Spotify<i class="fa fa-angle-right" aria-hidden="true"></i>
						</a>
					</div>
					<?php
					$post_args = array(
			          'posts_per_page' => 10,
			          'post_type' => 'video-items',
			          'orderby'        => 'rand',
			          'post_status'    => 'publish'
			        );
			        $get_videos = get_posts($post_args);
			        $r = 0;
					?>
					<div class="blog-listing-module">
						<?php foreach ( $get_videos as $k => $video ) {
							$youtube_video_link = get_field('youtube_video_link',  $video->ID); ?>
							<div class="post-item">
								<?php if($r === 0) { ?>
									<a href="#">
										<div class="thumb-img">
			                        		<iframe src="<?php echo $youtube_video_link; ?>" scrolling="no" frameborder="1" height="100%" width="100%" allowfullscreen></iframe>
			                    		</div>
			                    		<h2 class="big"><?php echo $video->post_title; ?></h2>
									</a>
								<?php } else { ?>
									<a href="#">
										<div class="thumb-img">
			                        		<iframe src="<?php echo $youtube_video_link; ?>" scrolling="no" frameborder="1" height="100%" width="100%" allowfullscreen></iframe>
			                    		</div>
			                    		<h2><?php echo $video->post_title; ?></h2>
									</a>
								<?php } ?>
							</div>
						<?php $r++; } ?>
					</div>
					<div class="">
						<iframe src="https://open.spotify.com/embed-podcast/show/0PSwKvn79VuUYyALuUYUec" width="100%" height="232" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
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
			  	<div class="all-news">
			  		<a href="#">
			  			<img src="<?php echo $desktop_banner['sigma_upcoming_add']; ?>" alt="">
			  		</a>
			  	</div>
			</div>
		</div>
	</section>
	<!-- News Image slider end -->

	<!-- Asia news section -->
	<section class="home-blog">
		<div class="container">
			<div class="home-news">
				<?php
				$news_tags = sigma_mt_get_news_tags_data(1061, $taxonomy, 6); 
				?>					
				<div class="latest-news hp-left">
					<div class="h-title">
						<a href="#">
							<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
						</a>
					</div>
		       		<?php				
	        		foreach ( $news_tags['term_data'] as $k => $post ) {
		        		setup_postdata( $post );
		        		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
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
						<?php wp_reset_postdata(); ?>
					<?php } ?>
				</div>
				<div class="affiliate hp-center">
					<?php
					$news_tags = sigma_mt_get_news_tags_data(1062, $taxonomy, 6);
					?>
					<div class="h-title">
						<a href="#">
							<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
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
						<!-- Testomonial Section -->
						<div class="testimonial_slide">
							<?php $testimonials = sigma_mt_get_testimonial_data(); 
							foreach($testimonials as $k => $item) {
								$company_name = get_field( "testimonial_company", $item->ID );
								$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'thumbnail' ); ?>
								<figure class="testimonial">
									<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $item->post_title; ?>" />
									<div class="peopl">
										<h3><?php echo $item->post_title; ?></h3>
										<p class="company_name"><?php echo $company_name; ?></p>
									</div>
									<blockquote><?php echo $item->post_content; ?>
										<div class="btn"></div>
									</blockquote>
								</figure>
							<?php } ?>
						</div>
						<!-- Testomonial Section end -->
					</div>
				</div>
				<div class="spotify hp-right">
					<?php
					$news_tags = sigma_mt_get_news_tags_data(1055, $taxonomy, 12);
					?>
					<div class="h-title">
						<a href="#">
							<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
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
			                        		<img src="<?php echo $featured_image[0]; ?>" alt="">
			                    		</div>
		                    			<h2><?php the_title(); ?></h2>
									</a>
								</div>
							<?php } else { ?>
								<div class="post-item">
									<a href="<?php the_permalink(); ?>">
										<div class="thumb-img">
			                        		<img src="<?php echo $featured_image[0]; ?>" alt="">
			                    		</div>
			                    		<h2><?php the_title(); ?></h2>
									</a>
								</div>
							<?php } ?>
						<?php $row++; } ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Asia news section end-->

	<!-- News Image slider start -->
	<section class="sigma-news">
		<div class="container">
			<div class="single-news">
			  	<div class="all-news">
			  		<a href="#">
			  			<img src="<?php echo $desktop_banner['sigma_asia_add']; ?>" alt="">
			  		</a>
			  	</div>
			</div>
		</div>
	</section>
	<!-- News Image slider end -->

	<!-- Europe news section -->
	<section class="home-blog">
		<div class="container">
			<div class="home-news">
				<?php
				$news_tags = sigma_mt_get_news_tags_data(1054, $taxonomy, 9);
				?>					
				<div class="latest-news hp-left">
					<div class="h-title">
						<a href="#">
							<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
						</a>
					</div>
		       		<?php
	        		foreach ( $news_tags['term_data'] as $k => $post ) :
		        		setup_postdata( $post );
		        		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );?>
			            <div class="blog-listing-module">								
							<div class="post-item">
								<a href="<?php the_permalink(); ?>">
									<?php if($row === 0) { ?>
										<div class="thumb-img">
			                        		<img src="<?php echo $featured_image[0]; ?>" alt="">
			                    		</div>
			                    	<?php } ?>
		                    		<h2 <?php if($row === 0) { ?> class="big" <?php } ?> ><?php the_title(); ?></h2>
								</a>
							</div>
						</div>							
						<?php $row++; ?>
						<?php wp_reset_postdata();
					endforeach; ?>
				</div>
				<div class="affiliate hp-center">
					<?php
					$news_tags = sigma_mt_get_news_tags_data(1067, $taxonomy, 9);
					?>
					<div class="h-title">
						<a href="#">
							<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
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
			                        		<img src="<?php echo $featured_image[0]; ?>" alt="">
			                    		</div>
		                    			<h2><?php the_title(); ?></h2>
									</a>
								</div>
							<?php } else { ?>
								<div class="post-item">
									<a href="<?php the_permalink(); ?>">
										<div class="thumb-img">
			                        		<img src="<?php echo $featured_image[0]; ?>" alt="">
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
					$news_tags = sigma_mt_get_news_tags_data(1079, $taxonomy, 12);
					?>
					<div class="h-title">
						<a href="#">
							<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
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
			                        		<img src="<?php echo $featured_image[0]; ?>" alt="">
			                    		</div>
		                    			<h2><?php the_title(); ?></h2>
									</a>
								</div>
							<?php } else { ?>
								<div class="post-item">
									<a href="<?php the_permalink(); ?>">
										<div class="thumb-img">
			                        		<img src="<?php echo $featured_image[0]; ?>" alt="">
			                    		</div>
			                    		<h2><?php the_title(); ?></h2>
									</a>
								</div>
							<?php } ?>
						<?php $row++; } ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Europe news section end-->

	<!-- News Image slider start -->
	<section class="sigma-news">
		<div class="container">
			<div class="single-news">
			  	<div class="all-news">
			  		<a href="#">
			  			<img src="<?php echo $desktop_banner['sigma_europe_add']; ?>" alt="">
			  		</a>
			  	</div>
			</div>
		</div>
	</section>
	<!-- News Image slider end -->

	<!-- America news section -->
	<section class="home-blog">
		<div class="container">
			<div class="home-news">
				<?php
				$news_tags = sigma_mt_get_news_tags_data(1066, $taxonomy, 12);
				?>					
				<div class="latest-news hp-left">
					<div class="h-title">
						<a href="#">
							<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
						</a>
					</div>
		       		<?php
	        		foreach ( $news_tags['term_data'] as $k => $post ) :
		        		setup_postdata( $post );
		        		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
			            <div class="blog-listing-module">								
							<div class="post-item">
								<a href="<?php the_permalink(); ?>">
									<?php if($row === 0) { ?>
										<div class="thumb-img">
			                        		<img src="<?php echo $featured_image[0]; ?>" alt="">
			                    		</div>
			                    	<?php } ?>
		                    		<h2 <?php if($row === 0) { ?> class="big" <?php } ?> ><?php the_title(); ?></h2>
								</a>
							</div>
						</div>							
						<?php $row++; ?>
						<?php wp_reset_postdata();
					endforeach; ?>
				</div>
				<div class="affiliate hp-center">
					<?php
					$news_tags = sigma_mt_get_news_tags_data(1068, $taxonomy, 6);
					?>
					<div class="h-title">
						<a href="#">
							<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
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
			                        		<img src="<?php echo $featured_image[0]; ?>" alt="">
			                    		</div>
		                    			<h2><?php the_title(); ?></h2>
									</a>
								</div>
							<?php } else { ?>
								<div class="post-item">
									<a href="<?php the_permalink(); ?>">
										<div class="thumb-img">
			                        		<img src="<?php echo $featured_image[0]; ?>" alt="">
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
					$news_tags = sigma_mt_get_news_tags_data(854, $taxonomy, 12);
					?>
					<div class="h-title">
						<a href="#">
							<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
						</a>
					</div>
					<div class="blog-listing-module">
						<?php 
						$row = 0;
						foreach ( $news_tags['term_data'] as $k => $post ) {
				        	setup_postdata( $post );
				        	$featuredImage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); ?>
				        	<?php if($row === 0) { ?>
								<div class="post-item">
									<a href="<?php the_permalink(); ?>">
										<div class="thumb-img">
			                        		<img src="<?php echo $featuredImage[0] ?>" alt="">
			                    		</div>
		                    			<h2><?php the_title(); ?></h2>
									</a>
								</div>
							<?php } else { ?>
								<div class="post-item">
									<a href="<?php the_permalink(); ?>">
										<div class="thumb-img">
			                        		<img src="<?php echo $featuredImage[0] ?>" alt="">
			                    		</div>
			                    		<h2><?php the_title(); ?></h2>
									</a>
								</div>
							<?php } ?>
						<?php $row++; } ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- America news section end-->

	<!-- News Image slider start -->
	<section class="sigma-news">
		<div class="container">
			<div class="single-news">
			  	<div class="all-news">
			  		<a href="#">
			  			<img src="<?php echo $desktop_banner['sigma_americas_add']; ?>" alt="">
			  		</a>
			  	</div>
			</div>
		</div>
	</section>
	<!-- News Image slider end -->

	<!-- Africa news section -->
	<section class="home-blog">
		<div class="container">
			<div class="home-news">
				<?php
				$news_tags = sigma_mt_get_news_tags_data(1078, $taxonomy, 13);
				?>					
				<div class="latest-news hp-left">
					<div class="h-title">
						<a href="#">
							<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
						</a>
					</div>
		       		<?php
	        		foreach ( $news_tags['term_data'] as $k => $post ) :
		        		setup_postdata( $post );
		        		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
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
					endforeach; ?>
				</div>
				<div class="affiliate hp-center">
					<?php
					$news_tags = sigma_mt_get_news_tags_data(1070, $taxonomy, 12);
					?>
					<div class="h-title">
						<a href="#">
							<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
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
					$news_tags = sigma_mt_get_news_tags_data(1064, $taxonomy, 12);
					?>
					<div class="h-title">
						<a href="#">
							<?php  echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
						</a>
					</div>
					<div class="blog-listing-module">
						<?php
						foreach ( $news_tags['term_data'] as $k => $post ) {
				        	setup_postdata( $post );
				        	$featuredImage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); ?>
				        	<?php if($row === 0) { ?>
								<div class="post-item">
									<a href="<?php the_permalink(); ?>">
										<div class="thumb-img">
			                        		<img src="<?php echo $featuredImage[0] ?>" alt="">
			                    		</div>
		                    			<h2><?php the_title(); ?></h2>
									</a>
								</div>
							<?php } else { ?>
								<div class="post-item">
									<a href="<?php the_permalink(); ?>">
										<div class="thumb-img">
			                        		<img src="<?php echo $featuredImage[0] ?>" alt="">
			                    		</div>
			                    		<h2><?php the_title(); ?></h2>
									</a>
								</div>
							<?php } ?>
						<?php $row++; } ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Africa news section end-->

	<!-- News Image slider start -->
	<section class="sigma-news">
		<div class="container">
			<div class="single-news">
			  	<div class="all-news">
			  		<a href="#">
			  			<img src="<?php echo $desktop_banner['sigma_africa_add']; ?>" alt="">
			  		</a>
			  	</div>
			</div>
		</div>
	</section>
	<!-- News Image slider end -->
<?php
}
?>
<div class="newsletter" style="background: url(<?php the_field('newsletter_background_image', 'option'); ?>);">
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
