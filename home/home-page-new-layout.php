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
	<section class="home-banner rrr home-new-banner new-layout" style="background-image: url(<?php echo $desktop_banner['banner_background_image']; ?>);">
		<div class="banner-container">
			<!-- Desktop banner start -->
			<div class="desktop-banner">
				<div class="label-wrap-map">
		 	  		<span>	
		 	  			<?php 
		 	    		//if( !empty( $desktop_banner['desktop_featured_image'] ) ){ ?>
					    	<img src="https://sigma.world/wp-content/uploads/2021/08/SiGMA-2021-Homepage-Title1.png" alt="">
						<?php //} ?>
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
		 	    		//if( !empty( $desktop_banner['mobile_featured_image'] ) ){ ?>
					    	<img src="https://sigma.world/wp-content/uploads/2021/08/Homepage-Mobile-Title-300x19-1.png&nocache=1" alt="">
						<?php //} ?>
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
							<?php echo do_shortcode('[sigma_mt_show_sidebar elements="122119"]'); 
					 			  //echo do_shortcode('[sigma_mt_show_sidebar_sigma_directory]'); ?>
	                    </div>
	                    <div class="space desktop-magazine">
	                    	<?php echo do_shortcode('[sigma_mt_show_sidebar_magazines]'); ?>
							<?php //echo do_shortcode('[sigma_mt_show_sidebar_magazines term_id="1149"]'); ?>
	                    </div>
						<div class="space">
							<a href="<?php echo site_url(); ?>/m-and-a-action/">
								<div class="sigma-college">
									<div class="top-img">
										<img src="/wp-content/uploads/2021/08/SiGMA-MA-Tab.png">
									</div>
								</div>
							</a>
	                    </div>
	                    <div class="space mobile-magazine">
	                    	<?php //echo do_shortcode('[sigma_mt_show_sidebar_magazines]'); ?>
							<?php //echo do_shortcode('[sigma_mt_show_sidebar_magazines term_id="1149"]'); ?>
	                    </div>
	                </div>

	                <div class="home-middle-content">
	                    <?php
						$news_tags = sigma_mt_get_news_tags_data('', $taxonomy, 7);
						?>
						<div class="h-title">
							<a href="<?php echo site_url(); ?>/news"><?php echo $desktop_banner["latest_posts_title"]; ?></a>
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
									<div class="thumb-img" style="">
										<div class="post-alignment">
											<a href="<?php the_permalink(); ?>">
												<?php if(!empty($featured_image)){ ?>
				                        		    <img src="<?php echo $featured_image[0]; ?>" alt="">
												<?php } else { ?>
	                                                <img src="<?php echo $placeholder_full; ?>" alt="">
	                                            <?php } ?>
	                                            <div class="wi-WidgetOverlay"></div>
	                                            <div class="news-content">										
						                    		<h2 <?php if($row === 0) { ?> class="big" <?php } ?> >
						                    			<?php echo $post->post_title; //the_title(); ?>
						                    		</h2>
						                    		<div class="category-lists">
						                    			<?php $i = 0; 
						                    			$categories = wp_get_post_terms( get_the_ID(),array( 'news-cat' ) );
						                    			foreach($categories as $c) { 
															$cat = get_category( $c );
															?>
														<a class="topic-link" href="<?php echo get_term_link($cat);?>"><?php echo $cat->name; ?></a>
														<?php $i++;
														if($i==3) break;
													} ?>
						                    		</div>
						                    	</div>
						                    </a>								
										</div>
									</div>
									<?php if($row === 0) { ?> <div class="excerpt-content"><?php the_excerpt(); ?></div><?php } ?>
								</div>
							</div>							
							<?php $row++; ?>
							<?php wp_reset_postdata();
						} ?>
						<div class="load-articles"><a class="load-more-articles" href="<?php echo SITE_URL . '/news'; ?>" target="_blank">Show More</a></div>
					</div>

	                <div class="right-sidebar">
	                    <div class="space sigma-multi-events">
	                    	<?php echo do_shortcode('[sigma_mt_show_sidebar elements="206684"]');
	                    		//echo do_shortcode('[sigma-mt-sidebar-event-logos]'); ?>
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
		<img src="/wp-content/uploads/2021/08/Malta-Week-Pop-up-Banner.png">
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

<style>
.new-layout.home-banner.home-new-banner .sigma-banner-wrapper {
    height: calc( 70vh - 100px );
}
new-layout.home-banner.home-new-banner .maplabel a:hover img, new-layout.home-banner.home-new-banner .maplabel a:hover::before {
    height: 150px;
    width: 150px;
    transition: width 0.5s ease, height 0.5s ease;
}
.new-layout.home-banner.home-new-banner .inner-animate, .inner-map-label {
    /*width: 600px;
	height: 370px;
	background-size: 600px 360px;*/
	width: 750px;
	height: 400px;
	background-size: 750px 400px;
}
.new-home-layout.home-banner.home-new-banner .map-label a::before, .new-home-layout.home-banner.home-new-banner .map-label a img {
	width: 60px;
	height: 60px;
}
.new-home-layout.home-banner.home-new-banner .label-wrap-map {
    position: relative;
    height: 30px;
}
.home-banner.home-new-banner {
    min-height: calc(80vh - 100px);
	padding-bottom: 0;
}
.home-banner.home-new-banner .label-wrap-map {
	position: relative;
	height: 60px;
}
.new-home-layout .home-news {
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-flex-wrap: wrap;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    width: -webkit-calc(100% + 40px);
    width: -moz-calc(100% + 40px);
    width: calc(100% + 40px);
    margin-left: -20px !important;
}
.home-news .left-sidebar {
    width: -webkit-calc(25% - 40px);
    width: -moz-calc(25% - 40px);
    width: calc(25% - 40px);
    padding-left: 20px;
}
.home-news .home-middle-content {
    width: -webkit-calc(50% - 40px);
    width: -moz-calc(50% - 40px);
    width: calc(50% - 40px);
}
.home-news .home-middle-content .right-sidebar {
    width: -webkit-calc(25% - 40px);
    width: -moz-calc(25% - 40px);
    width: calc(25% - 40px);
    margin-right:  0;
}
.home-news .left-sidebar, .home-news .home-middle-content, .home-news .right-sidebar {
    margin: 10px 15px;
    margin-top: 0;
}
.new-home-layout .blog-listing-module h2 {
    font-size: 20px;
    font-weight: bold;
    font-family: "Montserrat";
    margin:  0 20px;
    color:  #ffffff;
}
.new-home-layout .blog-listing-module.section {
    width: calc(50% - 10px);
}
.new-home-layout .blog-listing-module.section h2 { 
    font-weight: 600;
    margin-top: 15px;
    margin:  0 20px;
    color:  #ffffff;
    font-size: 22px;
}
.new-home-layout .blog-listing-module.section:nth-child(odd) {
    margin-right: 20px;
}
.new-home-layout .blog-listing-module .post-item a {
    margin-bottom: 0;
}
.left-sidebar .casino-menu-lists a {
    display: flex;
}
.left-sidebar .casino-menu-lists h2 img {
    background-color: #eee;
    margin-right: 10px;
    min-width: 40px;
    width: 40px;
    height: 30px;
    display: flex;
}
.new-home-layout .left-sidebar .h-title a {
    margin-bottom: 0;
}
.casino-menu-lists {
    padding: 20px;
	background: #eeeeee;
}
.casino-menu-lists article {
    margin-bottom:  15px;
}
.casino-menu-lists .title {
    align-items: center;
    align-content: center;
    display: flex;
}
.left-sidebar .casino-menu-lists a h2 {
    font-size: 14px;
    line-height: 1.31;
    color: #e21735;
    font-weight: 600;
    transition: .3s all;
    margin-top: 5px;
    text-transform: uppercase;
}
.new-home-layout .left-sidebar .space, .new-home-layout .right-sidebar .space {
	margin-bottom: 20px;
}
.new-home-layout .space .sigma-event {
    text-align: center;
	padding: 20px;
	background: #fdeed4;
}
.sigma-multi-events .sigma-event-logo {
    padding: 0;
	width: 80%;
	margin: 0 auto;
}
.new-home-layout .text-event {
    text-transform: uppercase;
    font-size: 22px;
    font-weight: 600;
}
.new-home-layout .space.sigma-print {
    background: #e21735;
    padding: 50px;
}
.new-home-layout .space.sigma-multi-events {
    text-align: center;
}
.new-home-layout .right-sidebar .space .h-title a {
	margin-bottom: 0;
}
.new-home-layout .space .sigma-event {
    text-align: center;
    padding: 20px;
    background: #fdeed4;
}
.right-sidebar .space.sigma-multi-events .h-title {
    margin-bottom: 10px;
}
.sigma-multi-events .sigma-event-logo {
    padding: 0;
    width: auto;
    margin: 0 auto;
}
.new-home-layout .sigma-college .text-event {
    text-transform: uppercase;
    font-size: 26px;
    font-weight: 600;
}
.new-home-layout .sigma-print .text-event {
    text-transform: uppercase;
    font-size: 20px;
    font-weight: 600;
    text-align: center;
}
.new-home-layout .text-event {
    text-transform: uppercase;
    font-size: 22px;
    font-weight: 600;
}
.new-home-layout .sigma-print .top-img {
    margin-top: 0;
    margin-bottom: 0;
}
.home-sidebar-magazines.testimonial-slide-home {
    background-color: #eee;
    padding: 10px;
    border-radius: 20px;
    /*width: 78%;*/
    margin: 0 auto;
}
.home-sidebar-magazines.testimonial-slide-home .slick-prev, .home-sidebar-magazines.testimonial-slide-home .slick-arrow.slick-next {
    top: 50%;
}
.home-sidebar-magazines.testimonial-slide-home .slick-prev::before, .home-sidebar-magazines.testimonial-slide-home .slick-arrow.slick-next::before {
    border-radius: 5px;
}
.new-home-layout .space .sigma-college {
    background-color: #eee;
    border-radius: 20px;
    /*width: 78%;*/
    margin: 0 auto;
    text-align: center;
}
.home-sidebar-magazines.testimonial-slide-home .slick-slide img {
    display: inline-block;
}
.home-sidebar-magazines .sigma-print  {
    min-height: 250px;
    color: #fff;
	text-align: center;
    background-size: cover;
    background-repeat: no-repeat;
}
.new-home-layout .right-sidebar .space .h-title a {
    margin-bottom: 0;
}
.left-sidebar .casino-menu-lists h2 img {
    background-color: #eee;
    margin-right: 10px;
    min-width: 40px;
    width: 40px;
    height: 30px;
    display: inline-block;
}
/*.new-home-layout {
    margin-top: 15px;
}*/
.new-home-layout .category-lists .topic-link {
    display: inline-block;
    border: 1px solid #fff;
    color: #fff;
    padding-left: 5px;
    padding-right: 5px;
    background-color: #131313;
	border: 1px solid #4d4d4d;
	color: #fff;
}
.sigma-multi-events .sigma-event-logo img {
    padding: 10px;
}
.new-home-layout .blog-listing-module .post-item .post-alignment .category-lists a {
    margin-bottom: 0;
}
.new-home-layout .blog-listing-bellow .blog-listing-bellow {
    display: flex;
    flex-wrap: wrap;
}
.new-home-layout .wi-WidgetOverlay {
    background-image: linear-gradient(180deg,transparent,#000);
    bottom: 0;
    height: 160px;
    position: absolute;
    width: 100%;
    z-index: 1;
}
.new-home-layout .blog-listing-module .thumb-img img {
    height: 100%;
    object-fit: cover;
    position: absolute;
    width: 100%;
}
.new-home-layout .blog-listing-module .thumb-img .news-content {
    bottom: 0;
    position: absolute;
    width: 100%;
    z-index: 2;
}
.new-home-layout .blog-listing-module .post-alignment {
	height: 400px;
	position: relative;
}
.new-home-layout .blog-listing-bellow .blog-listing-module .post-alignment {
	height: 180px;
	position: relative;
}
.new-home-layout .blog-listing-module .category-lists {
    margin: 10px 20px;
}
.new-home-layout .blog-listing-module .post-item {
    border-bottom: 2px solid #e21735;
    margin-bottom: 20px;
}
.new-home-layout .blog-listing-module .post-item .excerpt-content {
	margin-bottom: 10px;
	margin-top: 10px;
}
.new-home-layout .blog-listing-bellow .post-item {
    border-bottom: none;
}

.home-middle-content .load-articles {
    text-align: center;
	display: inline-block;
	width: 100%;
	margin-top: 10px;
}
.home-middle-content .load-more-articles:hover {
    background: linear-gradient(45deg,#57cc00 0%,#96f020 35%,#96f020 65%,#57cc00 100%);
}
.home-middle-content .load-more-articles {
    background: #ed1a3b;
    border-color: #ed1a3b;
    padding: 10px 28px;
    border-radius: 5px;
    color: #fff;
    font-weight: 400;
    line-height: 1.2;
    transition: .3s all;
    cursor: pointer;
    font-family: "Montserrat";
    font-size: 14px;
}
.new-layout .banner-map-wrap-left .inner-animate::before {
    content: '';
    position: absolute;
    /*left: -40px;
    top: 73px;*/
    background-image: url(/wp-content/uploads/2021/08/Lighthouse-Light.png);
    background-repeat: no-repeat;
    background-size: contain;
    width: 120px;
    height: 25px;
    z-index: 2;
    animation: spinHorizontal 8s infinite linear;
    left: -35px;
	top: 76px;
}
.new-layout .banner-map-wrap-left .inner-animate::after {
    left: 68px;
    top: 117px;
    width: 35px;
    height: 45px;
}
.new-layout .banner-map-wrap-left .america-ele2::before {
    /*width: 20px;
    height: 20px;
    left: 148px;
    top: 133px;*/
    width: 25px;
	height: 25px;
	left: 186px;
	top: 142px
}
.new-layout .banner-map-wrap-left .america-ele2::after {
    /*left: 188px;
    bottom: 123px;
    width: 20px;
    height: 15px;*/
    left: 233px;
	bottom: 124px;
	width: 25px;
	height: 20px;
}
.new-layout .banner-map-wrap-left .america-ele::before {
    left: 163px;
    bottom: 78px;
    width: 20px;
    height: 40px;
}
.banner-map-wrap-middle .europe-ele::before { 
	width: 15px;
	height: 15px;
}
.banner-map-wrap-middle .europe-ele2::before {
    left: 41%;
    top: 45%;
    width: 75px;
    height: 10px;
}
.new-layout .map-label a::before, .new-layout .map-label a img {
    width: 100px;
    height: 100px;
}
.mobile-magazine {
	display: none;
}
.newsletter .newsletter-form .hbspt-form form .hs-submit .actions input[type="submit"] {
	background: #0093c8;
	color: #000;
	font-weight: bold;
}
.newsletter .newsletter-form .hbspt-form form .hs-submit .actions input::placeholder {
  color: red;
}
.new-home-layout .home-blog.latest-news .blog-sub-title {
	background-color: #e21735;
	color: #fff;
	text-decoration: none;
	margin-bottom: 0;
	padding: 13px 15px;
}
.new-home-layout .home-blog.latest-news .blog-sub-title h3 {
	text-decoration: none;
	position: relative;
	display: flex;
	align-items: center;
	justify-content: space-between;
	font-size: 18px;
	font-weight: 600;
	background-color: #e21735;
	color: #fff;
	margin: 0;
	width: 100%;
}
.new-home-layout .home-blog.latest-news .blog-sub-title::after, .new-home-layout .home-blog.latest-news .sidebar br {
	display: none;
}

@media (min-width: 1600px) {
	.new-layout .map-label a::before, .new-layout .map-label a img {
	    width: 110px;
	    height: 110px;
	}
	.new-layout .map-label a:hover img, .new-layout .map-label a:hover::before {
	    height: 150px;
	    width: 150px;
	    transition: width .5s ease,height .5s ease;
	}
	.new-layout.home-banner.home-new-banner .inner-animate, .inner-map-label {
	    width: 900px;
	    height: 500px;
	    background-size: 900px 500px;
	}
	.new-layout .banner-map-wrap-left .inner-animate::before {
	    left: -32px;
		top: 99px;
	}
	.new-layout .banner-map-wrap-left .america-ele2::before {
	    width: 30px;
	    height: 30px;
	    left: 223px;
	    top: 175px;
	}
	.new-layout .banner-map-wrap-left .america-ele2::after {
	    left: 278px;
	    bottom: 157px;
	    width: 30px;
	    height: 25px;
	}
	.new-layout .banner-map-wrap-left .inner-animate::after {
	    left: 76px;
	    top: 140px;
	    width: 40px;
	    height: 50px;
	}
}
@media (min-width: 580px) and (max-width: 850px) {
	.new-home-layout .home-news .left-sidebar, .new-home-layout .home-news .right-sidebar {
		width: 40%;
	}
	.new-home-layout .blog-listing-module.section {
	    width: 100%;
	}
	.new-home-layout .blog-listing-module.section:nth-child(2n+1) {
	    margin-right: 0;
	}
	.home-sidebar-magazines .sigma-print {
		background-size: 100% 100%;
	}
}
@media (min-width: 200px) and (max-width: 579px) {
	.new-home-layout .blog-listing-bellow .blog-listing-bellow .wi-WidgetOverlay {
		background-image: none;
	}
	.new-home-layout .blog-listing-bellow .blog-listing-bellow .thumb-img img {
		height: 90px;
		object-fit: cover;
		position: relative;
		width: 120px;
		min-width: 120px;
	}
	.new-home-layout .blog-listing-bellow .blog-listing-bellow .post-alignment .news-content {
		position: relative;
	}
	.new-home-layout .blog-listing-module .post-item {
		height: auto;
	}
	.new-home-layout .blog-listing-bellow .blog-listing-bellow .post-item {
		height: 160px;
	}
	.new-home-layout .blog-listing-bellow .blog-listing-bellow .category-lists {
		display: none;
	}
	.new-home-layout .home-news .left-sidebar, .new-home-layout .home-news .right-sidebar {
		width: 100%;
		padding: 20px;
	}
	.new-home-layout .home-news .home-middle-content {
		width: 100%;
		padding: 20px;
	}
	.home-news .left-sidebar, .home-news .home-middle-content, .home-news .right-sidebar {
		width: 100%;
		padding: 20px;
		margin: 0;
	}
	.new-home-layout .blog-listing-module .post-item {
	    padding: 10px;
		border-bottom: none;
		margin-bottom: 0;
	}
	.new-home-layout .blog-listing-bellow .blog-listing-module .post-item {
	    height: auto;
	    padding: 0;
		border-bottom: none;
		margin-bottom: 0;
	}
	.new-home-layout .blog-listing-module .thumb-img .news-content {
	    bottom: 0;
	    box-sizing: border-box;
	    display: flex;
	    flex-direction: column;
	    flex-grow: 1;
	    justify-content: start;
	}
	.new-home-layout .blog-listing-module .thumb-img {
	    display: block;
	}
	.new-home-layout .blog-listing-module.section {
	    width: 100%;
	}
	.new-home-layout .blog-listing-module.section h2 {
	    color: #131313;
	}
	.wi-WidgetOverlay {
	    background-image: none;
	    bottom: 0;
	    height: auto;
	    position: relative;
	    width: 100%;
	    z-index: 1;
	}
	.new-home-layout .blog-listing-module.section:nth-child(2n+1) {
	    margin-right: 0;
	}
	.new-home-layout .blog-listing-bellow .blog-listing-module.section {
	    margin-bottom: 0;
	    padding: 0 10px;
	}
	.new-home-layout .blog-listing-bellow .blog-listing-module .thumb-img .news-content h2 {
	    color: #000;
	    font-size: 14px;
	    padding-left: 8px;
	    margin:  0;
	    display: block;
		line-height: 20px;
	}
	.new-home-layout .blog-listing-bellow .blog-listing-module .post-item {
		margin-bottom: 10px;
	}
	.new-home-layout .blog-listing-module .excerpt-content {
		display:  none;
	}
	.new-home-layout .home-middle-content .blog-listing-module .post-alignment {
	    display: flex;
	    height: 150px;
	    position: relative;
	}
	.new-home-layout .home-middle-content .blog-listing-bellow .blog-listing-module .post-alignment {
        display: flex;
        height: 100px;
        border-bottom: 1px solid #e21735;
        position: relative;
    }
    .desktop-magazine {
    	display:  none;
    }
    .mobile-magazine {
    	display:  block;
    }
    .home-banner.home-new-banner {
    	min-height: auto;
    }
}
@media (min-width: 200px) and (max-width: 400px) {
	.home-news .left-sidebar, .home-news .home-middle-content, .home-news .right-sidebar {
		width: 100%;
		padding: 20px;
		margin: 0;
	}
}
</style>

<?php get_footer(); ?>
