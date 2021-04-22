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
	<script src="https://kit.fontawesome.com/59bd8e2ce9.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri();?>/home/css/style.css">
</head>
<body>
<?php
ob_start();
$desktop_b = get_field('desktop_banner');
//echo '<pre>';print_r($desktop_b);
if ($desktop_b){
?>
<section class="home-banner">
	<div class="banner-container">
		<div class="desktop-banner">
			<div class="labelwrapmap">
	 	  		<span>	
	 	    		<img src="<?php echo $desktop_b['desktop_featured_image']; ?>" alt="Title">
	 	  		</span>
	 		</div>
			<div class="sigmaBannerWrapper">
		 		<div class="bannerInnerWrapper">
		 			<div class="bannermapwrapper bannermapwrap-left">
		 				<div class="inneranimate">
		 					<div class="americaele2"></div>
		 					<div class="americaele"></div>
		 				</div>
		 		    </div>
		 		    <div class="bannermapwrapper bannermapwrap-middle">
		 		      	<div class="inneranimate">
		 		      		<div class="asiaele3"></div>
		 		      		<div class="asiaele2"></div>
		 					<div class="asiaele"></div>
		 					<div class="africaele"></div>
		 					<div class="europeele"></div>
		 					<div class="europeele2"></div>
		 		      	</div>
		 		    </div>
		 			<div class="bannermapwrapper bannermapwrap-right">
		 				<div class="inneranimate">
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
		<div class="mobile-banner">
			<div class="mobilelabelmap">
				<span>
					<img src="images/Homepage-Mobile-Title.png" alt="Title">
				</span>
			</div>
			<div class="events-wrapper">
				<div class="all-country europe">
					<div class="event-box">
						<a href="#">
							<span class="img">
								<img src="images/SiGMA-Europe-EN.png" alt="">
							</span>
						</a>
					</div>
				</div>
				<div class="all-country asia">
					<div class="event-box">
						<a href="#">
							<span class="img">
								<img src="images/SiGMA-Asia-May-Homepage-Button-English.png" alt="">
							</span>
						</a>
					</div>
				</div>
				<div class="all-country africa">
					<div class="event-box">
						<a href="#">
							<span class="img">  
								<img src="images/SiGMA 2021_Africa_label_Inner.png" alt="">
							</span>
						</a>
					</div>
				</div>
				<div class="all-country americas">
					<div class="event-box">
						<a href="#">
							<span class="img">
								<img src="images/SiGMA-Americas-September-Homepage-Button-English.png" alt="">
							</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
}

	get_footer();
?>
</body>
</html>