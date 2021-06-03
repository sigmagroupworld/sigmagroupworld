<?php
/**
 * Template Name: SigmaMT About Page Layout
 * Created By: Rinkal Petersen
 * Created at: 22 May 2021
 */
/* About template css */
wp_enqueue_style('directory', get_stylesheet_directory_uri().'/about/css/about.css'); 
get_header();
?>
<div class="about-template">
<?php ob_start(); $about_banner = get_field('banner');
if ($about_banner){ ?>
	<?php if( !empty( $about_banner['europe_logo'] ) ){ ?>
		<!-- About Banner Start -->
		<section class="about-banner">
			<div class="paral" id="parallax">
		  		<div class="parallax-content">
				    <div class="paraLogo">
				    	<?php if( !empty( $about_banner['europe_logo'] ) ){ ?>
					    	<img src="<?php echo $about_banner['europe_logo']['url']; ?>" alt="<?php echo $about_banner['europe_logo']['alt']; ?>">
						<?php } ?>
				    </div>
		    		<div class="paraAbout">
		      			<div class="paralocate">
		      				<?php echo $about_banner['event_date']; ?>
		      			</div>
		      			<div class="parabtn">
		        			<a href="<?php echo $about_banner['register_button_link']; ?>" style="background-color:<?php echo $about_banner['register_color']; ?>"><?php echo $about_banner['register_button_text']; ?></a>
		      			</div>
		    		</div>
		  		</div>
		  		<div class="paral_layer parallax" id="paral-0" data-speed="2" style="background-image: url(<?php echo $about_banner['banner_parellax_image_one']; ?>);"></div><!-- 00.0 -->
		  		<div class="paral_layer parallax settor" id="paral-1" data-speed="11" style="background-image: url(<?php echo $about_banner['banner_parellax_image_two']; ?>);"></div><!-- 12.5 -->
		  		<div class="paral_layer parallax settor" id="paral-2" data-speed="26" style="background-image: url(<?php echo $about_banner['banner_parellax_image_three']; ?>);"></div><!-- 25.0 -->
		  		<div class="paral_layer parallax settor" id="paral-3" data-speed="49" style="background-image: url(<?php echo $about_banner['banner_parellax_image_four']; ?>);"></div><!-- 37.5 -->
		  		<div class="paral_layer settor" id="paral-4" data-speed="100" style="background-image: url(<?php echo $about_banner['banner_parellax_image_five']; ?>);"></div><!-- 50.0 -->
			</div>
		</section>
		<!-- About Banner End -->
	<?php } ?>
<?php
}
?>

<?php ob_start(); $why_sigma = get_field('why_sigma');
if ($why_sigma){ ?>
	<?php if( !empty( $why_sigma['why_sigma_title'] ) ){ ?>
		<!-- Why Sigma start -->
		<section class="why-sigma" style="background-color: <?php echo $about_banner['register_color']; ?>;">
		  	<div class="container">
			    <div class="about-title">
			      	<h2><?php echo $why_sigma['why_sigma_title']; ?></h2>
			    </div>
			    <div class="about-sigma-content">
			      	<div class="sigma-about-txt">
			      		<?php echo $why_sigma['why_sigma_sub_text']; ?>
			      	</div>
			      	<div class="sigma-about-video">
			        	<?php 
			        	/*if(is_page('europe')) {
			        		$term_id = '1161';
			        	} else {
			        		$term_id = '1161';
			        	}
			        	$videos = sigma_mt_get_videos(1161);
			        	$youtube_video_title = get_field('video_title', $videos[0]->ID);
			        	foreach($videos as $k => $video) {
			        		$youtube_video_link = get_field('youtube_video_link',  $video->ID);
			        	?>
			        		<iframe src="<?php echo $youtube_video_link; ?>" width="560" height="315">
			        	<?php }*/ ?>
			      	</div>
			    </div>
		  	</div>
		</section>
		<!-- Why Sigma End -->
	<?php } ?>
<?php
}
?>

<?php ob_start(); $for_advertisement = get_field('add_banner');
if ($for_advertisement){ ?>
	<?php if( !empty( $for_advertisement['add_banner_image'] ) ){ ?>
		<!-- News Image slider start -->
		<?php echo do_shortcode( '[sigma-mt-banner-adds banner_add = '.$for_advertisement["add_banner_image"].' banner_url = '.$for_advertisement["add_banner_link"].' ]' ); ?>
		<!-- News Image slider end -->
	<?php } ?>
<?php
}
?>

<?php ob_start(); $attendees = get_field('attendees');
if ($attendees){ ?>
	<!-- Attendees Section Start -->
	<?php if( !empty( $attendees['attendees_title'] ) ){ ?>
		<section class="attendees">
		  	<div class="container">
			    <div class="about-section-title">
			      	<h2 style="color:<?php echo $about_banner['register_color']; ?>"><?php echo $attendees['attendees_title']; ?></h2>
			    </div>
			    <div class="attendees-content">
			    	<?php if( !empty( $attendees['attendees_image_for_desktop'] ) ){ ?>
				    	<img src="<?php echo $attendees['attendees_image_for_desktop']['url']; ?>" alt="<?php echo $attendees['attendees_image_for_desktop']['alt']; ?>" class="for-desktop">
					<?php } ?>
					<?php if( !empty( $attendees['attendees_image_for_mobile'] ) ){ ?>
				    	<img src="<?php echo $attendees['attendees_image_for_mobile']['url']; ?>" alt="<?php echo $attendees['attendees_image_for_mobile']['alt']; ?>" class="for-mobile">
					<?php } ?>
			    </div>
		  	</div>
		</section>
	<?php } ?>
	<!-- Attendees Section End -->
<?php
}
?>

<!-- Speakers Section Start -->
<?php
$post_data = $wp_query->get_queried_object();
$post_id = $post_data->ID;
$people_list = do_shortcode( '[sigma-mt-people-lists post_id = '.$post_id.' person_lname = "pname" person_phone = "phone" person_image = "person_image" person_position = "designation" person_company = "company" person_language = ""]');
echo $people_list ;
?>
<!-- Speakers Section End -->

<?php ob_start(); $floor_plan = get_field('floor_plan');
if ($floor_plan){ ?>
	<?php if( !empty( $floor_plan['floor_plan_title'] ) ){ ?>
		<!-- Floor Plan Section Strat -->
		<section class="floor-plan">
		  	<div class="container">
			    <div class="about-section-title">
			    	<h2 style="color:<?php echo $about_banner['register_color']; ?>"><?php echo $floor_plan['floor_plan_title']; ?></h2>
			    </div>
			    <div class="iframe-plan">
			    	<?php echo $floor_plan['floor_plan_iframe']; ?>
			    </div>
		  	</div>
		</section>
		<!-- Floor Plan Section End -->
	<?php } ?>
<?php
}
?>

<?php ob_start(); $explore_all = get_field('explore_all');
if ($explore_all){ ?>
	<?php if( !empty( $explore_all['explore_some_pages'] ) ){ ?>
		<!-- Explore All Section Strat -->
		<section class="explore-all">
			<div class="container">
				<div class="some-explore"> 
			    	<?php
					foreach ($explore_all['explore_some_pages'] as $key => $value) { ?>
				      	<div class="single-explore">
					        <?php if( !empty( $value['explore_logo'] ) ){ ?>
				    			<div class="explore-img">
					    			<img src="<?php echo $value['explore_logo']['url']; ?>" alt="<?php echo $value['explore_logo']['alt']; ?>" class="for-mobile">
					    		</div>
							<?php } ?>
							<div class="about-section-title">
						    	<h2 style="color:<?php echo $about_banner['register_color']; ?>"><?php echo $value['explore_title']; ?></h2>
						    </div>
					        <div class="explore-sub-txt">
					        	<?php echo $value['explore_sub_text']; ?>
					        </div>
					        <div class="explore-btns">
					        	<?php if( !empty( $value['explore_button_one'] ) ){ ?>
						        	<span>
							        	<a href="<?php echo $value['explore_button_one_link']; ?>"><?php echo $value['explore_button_one']; ?></a>
							        </span>
						        <?php } ?>
						        <?php if( !empty( $value['explore_button_two'] ) ){ ?>
							        <span>
							          	<a href="<?php echo $value['explore_button_two_link']; ?>"><?php echo $value['explore_button_two']; ?></a>
							        </span>
						        <?php } ?>
					        </div>
				      	</div>
			      	<?php } ?>
			    </div>
			</div>
		</section>
		<!-- Explore All Section End -->
	<?php } ?>
<?php
}
?>

<?php ob_start(); $our_attendees = get_field('what_our_attendees');
if ($our_attendees){ ?>
	<?php if( !empty( $our_attendees['attendees_title'] ) ){ ?>
		<!-- What Our Attendees section start -->
		<section class="our-attendees">
			<div class="container">
				<div class="about-section-title">
			    	<h2 style="color:<?php echo $about_banner['register_color']; ?>"><?php echo $our_attendees['attendees_title']; ?></h2>
			    </div>
				<div class="attendees-video">
					<?php echo $our_attendees['attendees_video']; ?>
				</div>
			</div>
		</section>
		<!-- What Our Attendees section end -->
	<?php } ?>
<?php
}
?>
</div>

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
