<?php
/**
 * Template Name: Home Page
 * Created By: Rinkal Petersen
 * Created at: 22 Apr 2021
 */
get_header();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0" />
	<!-- <script src="https://kit.fontawesome.com/59bd8e2ce9.js" crossorigin="anonymous"></script> -->
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri();?>/assets/css/all.css">
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri();?>/home/css/style.css">
</head>
<body>
<?php
ob_start();
$desktop_b = get_field('desktop_banner');
//echo '<pre>';print_r($desktop_b);
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
		 		    		<a class="americalabel" href="<?php echo $desktop_b['america_link']; ?>">
		 		    			<img src="<?php echo $desktop_b['america_logo']; ?>" alt="">
		 		    		</a>
	 					  	<a class="europelabel" href="<?php echo $desktop_b['europe_link']; ?>">
	 					  		<img src="<?php echo $desktop_b['europe_logo']; ?>" alt="">
	 					  	</a>
		 					<a class="africalabel" href="<?php echo $desktop_b['africa_link']; ?>">
		 						<img src="<?php echo $desktop_b['africa_logo']; ?>" alt="">
		 					</a>
		 					<a class="asialabel" href="<?php echo $desktop_b['asia_link']; ?>">
		 						<img src="<?php echo $desktop_b['asia_logo']; ?>" alt="">
		 					</a>
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
				<div class="all-country europe">
					<div class="event-box">
						<a href="<?php echo $desktop_b['europe_link']; ?>">
							<span class="img">
								<img src="<?php echo $desktop_b['europe_logo']; ?>" alt="">
							</span>
						</a>
					</div>
				</div>
				<div class="all-country asia">
					<div class="event-box">
						<a href="<?php echo $desktop_b['asia_link']; ?>">
							<span class="img">
								<img src="<?php echo $desktop_b['asia_logo']; ?>" alt="">
							</span>
						</a>
					</div>
				</div>
				<div class="all-country africa">
					<div class="event-box">
						<a href="<?php echo $desktop_b['africa_link']; ?>">
							<span class="img">  
								<img src="<?php echo $desktop_b['africa_logo']; ?>" alt="">
							</span>
						</a>
					</div>
				</div>
				<div class="all-country americas">
					<div class="event-box">
						<a href="<?php echo $desktop_b['america_link']; ?>">
							<span class="img">
								<img src="<?php echo $desktop_b['america_logo']; ?>" alt="">
							</span>
						</a>
					</div>
				</div>
			</div>
		</div>
		<!-- Mobile banner end -->
	</div>
</section>
<!-- Home page banner End -->

<!-- <section class="home-blog">
	<div class="container">
		<div class="home-news">
			<div class="latest-news hp-left">
				<div class="h-title">
					<a href="#">
						Latest News<i class="fa fa-angle-right" aria-hidden="true"></i>
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
                    		<h2>Sweden is at its "highest threat level" of money laundering</h2>
						</a>
					</div>
					<div class="post-item">
						<a href="#">
                    		<h2>Sweden is at its "highest threat level" of money laundering</h2>
						</a>
					</div>
					<div class="post-item">
						<a href="#">
                    		<h2>Sweden is at its "highest threat level" of money laundering</h2>
						</a>
					</div>
					<div class="post-item">
						<a href="#">
                    		<h2>Sweden is at its "highest threat level" of money laundering</h2>
						</a>
					</div>
					<div class="post-item">
						<a href="#">
                    		<h2>Sweden is at its "highest threat level" of money laundering</h2>
						</a>
					</div>
					<div class="post-item">
						<a href="#">
                    		<h2>Sweden is at its "highest threat level" of money laundering</h2>
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
	</div>
</section> -->

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
</body>
</html>