<?php
/**
 * Template Name: SigmaMT Home Page Layout
 * Created By: Rinkal Petersen
 * Created at: 22 Apr 2021
 */
/* Directory template css */
wp_enqueue_style('home', get_stylesheet_directory_uri().'/home/css/style.css'); 
get_header();
?>

<?php ob_start(); $desktop_b = get_field('desktop_banner');

if ($desktop_b){
?>
<!-- Home page banner start -->
<section class="home-banner" style="background-image: url(<?php echo $desktop_b['banner_background_image']; ?>);">
	<div class="banner-container">
		<!-- Desktop banner start -->
		<div class="desktop-banner">
			<div class="labelwrapmap">
	 	  		<span>	
	 	    		<img src="<?php echo $desktop_b['desktop_featured_image']; ?>" alt="Title">
	 	  		</span>
	 		</div>
			<div class="sigmaBannerWrapper">
		 		<div class="bannerInnerWrapper">
		 			<div class="bannermapwrapper bannermapwrap-left">
		 				<div class="inneranimate" style="background-image: url(<?php echo $desktop_b['map_image_one']; ?>);">
		 					<div class="americaele2"></div>
		 					<div class="americaele"></div>
		 				</div>
		 		    </div>
		 		    <div class="bannermapwrapper bannermapwrap-middle">
		 		      	<div class="inneranimate" style="background-image: url(<?php echo $desktop_b['map_image_two']; ?>);">
		 		      		<div class="asiaele3"></div>
		 		      		<div class="asiaele2"></div>
		 					<div class="asiaele"></div>
		 					<div class="africaele"></div>
		 					<div class="europeele"></div>
		 					<div class="europeele2"></div>
		 		      	</div>
		 		    </div>
		 			<div class="bannermapwrapper bannermapwrap-right">
		 				<div class="inneranimate" style="background-image: url(<?php echo $desktop_b['map_image_three']; ?>);">
				 	        <div class="gamele"></div>
		 					<div class="gamele1"></div>
		 					<div class="gamele2"></div>
		 				</div>
		 		    </div>
		 		    <div class="maplabel">
		 		    	<div class="innermaplabel">
		 		    		<?php
							foreach($desktop_b['countries'] as $key => $value) { ?>
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
					<img src="<?php echo $desktop_b['mobile_featured_image']; ?>" alt="Title">
				</span>
			</div>
			<div class="events-wrapper">
				<?php
				foreach($desktop_b['countries'] as $key => $value) { ?>
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

<section class="home-blog">
	<div class="container">
		<?php
			/* Add your taxonomy. */
			/*$taxonomies = array( 
			    'news-tag',
			);


			$posts_array = get_posts(
			    array(
			        'posts_per_page' => -1,
			        'post_type' => 'fabric_building',
			        'tax_query' => array(
			            array(
			                'taxonomy' => 'fabric_building_types',
			                'field' => 'term_id',
			                'terms' => $cat->term_id,
			            )
			        )
			    )
			);

			$args = array(
			    'orderby'           => 'name', 
			    'order'             => 'ASC',
			    'hide_empty'        => true,
			    'exclude'           => array('816'), 
			    'exclude_tree'      => array(), 
			    'include'           => array(),
			    'number'            => '', 
			    'fields'            => 'all', 
			    'slug'              => '', 
			    'parent'            => '',
			    'hierarchical'      => true, 
			    'child_of'          => 0, 
			    'get'               => '', 
			    'name__like'        => '',
			    'description__like' => '',
			    'pad_counts'        => false, 
			    'offset'            => '', 
			    'search'            => '', 
			    'cache_domain'      => 'core'
			); 

			$terms = get_terms( $taxonomies, $args );
			foreach ( $terms as $term ) {
				// here's code for getting the posts for custom post type
				$posts_array = get_posts(
	                array( 'showposts' => -1,
	                    'post_type' => 'news-items',
	                    'tax_query' => array(
	                        array(
	                        'taxonomy' => 'news-tag',
	                        'field' => 'term_id',
	                        'terms' => $term->term_id,
	                        )
	                    )
	                )
	            );
		        foreach ( $posts_array as $k=>$post ) {
		        	$row = 0;
		            ?>
		            <div class="home-news">
						<div class="latest-news hp-left">
							<div class="h-title">
								<a href="#">
									<?php echo $term->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
								</a>
							</div>
							<div class="blog-listing-module">								
								<div class="post-item">
									<a href="#">
										<?php if($row === 0) { ?>
											<div class="thumb-img">
				                        		<img src="images/swedish-polic-money-laundry.jpg" alt="">
				                    		</div>
				                    	<?php } ?>
			                    		<h2<?php if($row === 0) { ?> class="big" <?php } ?>><?php echo $post->post_title; ?></h2>
									</a>
								</div>
							</div>
						</div>
						<div class="affiliate hp-center">
							<div class="h-title">
								<a href="#">
									Affiliate Grand Slam<i class="fa fa-angle-right" aria-hidden="true"></i>
								</a>
							</div>
							<div class="blog-listing-module">
								<div class="post-item">
									<a href="#">
										<div class="thumb-img">
			                        		<img src="images/swedish-polic-money-laundry.jpg" alt="">
			                    		</div>
			                    		<h2 class="big">Sweden is at its "highest threat level" of money laundering</h2>
									</a>
								</div>
								<div class="post-item">
									<a href="#">
										<div class="thumb-img">
			                        		<img src="images/swedish-polic-money-laundry.jpg" alt="">
			                    		</div>
			                    		<h2>Be unique and stop using templates in affiliate marketing" - Olessia Selitsky</h2>
									</a>
								</div>
								<div class="post-item">
									<a href="#">
										<div class="thumb-img">
			                        		<img src="images/swedish-polic-money-laundry.jpg" alt="">
			                    		</div>
			                    		<h2>Be unique and stop using templates in affiliate marketing" - Olessia Selitsky</h2>
									</a>
								</div>
								<div class="post-item">
									<a href="#">
										<div class="thumb-img">
			                        		<img src="images/swedish-polic-money-laundry.jpg" alt="">
			                    		</div>
			                    		<h2>Be unique and stop using templates in affiliate marketing" - Olessia Selitsky</h2>
									</a>
								</div>
								<div class="post-item">
									<a href="#">
										<div class="thumb-img">
			                        		<img src="images/swedish-polic-money-laundry.jpg" alt="">
			                    		</div>
			                    		<h2>Be unique and stop using templates in affiliate marketing" - Olessia Selitsky</h2>
									</a>
								</div>
							</div>
						</div>
						<div class="spotify hp-right">
							<div class="h-title">
								<a href="#">
									Watch/Spotify<i class="fa fa-angle-right" aria-hidden="true"></i>
								</a>
							</div>
							<div class="blog-listing-module">
								<div class="post-item">
									<a href="#">
										<div class="thumb-img">
			                        		<img src="images/swedish-polic-money-laundry.jpg" alt="">
			                    		</div>
			                    		<h2 class="big">Gibraltar's Gambling Regulation in the year ahead | SiGMA TV</h2>
									</a>
								</div>
								<div class="post-item">
									<a href="#">
										<div class="thumb-img">
			                        		<img src="images/swedish-polic-money-laundry.jpg" alt="">
			                    		</div>
			                    		<h2>Be unique and stop using templates in affiliate marketing" - Olessia Selitsky</h2>
									</a>
								</div>
								<div class="post-item">
									<a href="#">
										<div class="thumb-img">
			                        		<img src="images/swedish-polic-money-laundry.jpg" alt="">
			                    		</div>
			                    		<h2>Be unique and stop using templates in affiliate marketing" - Olessia Selitsky</h2>
									</a>
								</div>
								<div class="post-item">
									<a href="#">
										<div class="thumb-img">
			                        		<img src="images/swedish-polic-money-laundry.jpg" alt="">
			                    		</div>
			                    		<h2>Be unique and stop using templates in affiliate marketing" - Olessia Selitsky</h2>
									</a>
								</div>
								<div class="post-item">
									<a href="#">
										<div class="thumb-img">
			                        		<img src="images/swedish-polic-money-laundry.jpg" alt="">
			                    		</div>
			                    		<h2>Be unique and stop using templates in affiliate marketing" - Olessia Selitsky</h2>
									</a>
								</div>
							</div>
						</div>
					</div>
			<?php $row++; }
			} */ ?>
		
	</div>
</section>

<!-- News Image slider start -->
<!-- <section class="sigma-news">
	<div class="container">
		<div class="single-news">
		  	<div class="all-news">
		  		<a href="#">
		  			<img src="images/SIGMA-Europe-November.png" alt="">
		  		</a>
		  	</div>
		</div>
	</div>
</section> -->
<!-- News Image slider end -->

<?php
}

	get_footer();
?>
