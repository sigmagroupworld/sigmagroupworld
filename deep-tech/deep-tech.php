<?php
/**
 * Template Name: SigmaMT Deep Tech Page Layout
 * Created By: Rinkal Petersen
 * Created at: 18 June 2021
 */
/* Europe Gaming Awards template css */
wp_enqueue_style('home', get_stylesheet_directory_uri().'/deep-tech/css/deep-tech.css');
get_header();
$page_id = $wp_query->get_queried_object()->ID;
$deep_tech_banner = get_field('banner', $page_id);
$about_sigma_deep_tech = get_field('about_sigma_deep_tech', $page_id);
$deep_tech_insights = get_field('deep_tech_insights', $page_id);
$agenda = get_field('deep_tech_agenda', $page_id);
$our_partners = get_field('our_partners', $page_id);
$our_experts = get_field('our_experts', $page_id);
//echo '<pre>'; print_r($our_partners); exit;
$testimonials = get_field('testimonials', $page_id);
?>
<div class="deep-tech-template">
	<!-- banner section start -->
	<section class="deep-tech-banner">
	  <div class="container">
	    <div class="deep-banner-img">
	      <img src="<?php echo $deep_tech_banner['banner_image']; ?>" alt="">
	    </div>
	  </div>
	</section>
	<!-- banner section end -->

	<!-- contact links section start -->
	<section class="contact-links">
	  <div class="container">
	    <div class="all-links">
	      <a href="<?php echo $deep_tech_banner['buttons']['book_a_pass']['link']; ?>"><?php echo $deep_tech_banner['buttons']['book_a_pass']['label']; ?></a>
	      <a href="<?php echo $deep_tech_banner['buttons']['be_a_speaker']['link']; ?>"><?php echo $deep_tech_banner['buttons']['be_a_speaker']['label']; ?></a>
	      <a href="<?php echo $deep_tech_banner['buttons']['agenda']['link']; ?>"><?php echo $deep_tech_banner['buttons']['agenda']['label']; ?></a>
	    </div>
	  </div>
	</section>
	<!-- contact links section end -->

	<!-- about deep tech section start -->
	<section class="about-deep">
	  <div class="container">
	    <div class="page-title">
	      <h2><?php echo $about_sigma_deep_tech['title']; ?></h2>
	      <div class="sub-txt">
	        <p><?php echo $about_sigma_deep_tech['description']; ?></p>
	      </div>
	    </div>
	    <div class="icon-box">
	    	<?php foreach($about_sigma_deep_tech['icon_lists'] as $icon) { ?>
				<div class="icon-box-inner">
					<div class="icon-img">
						<img src="<?php echo $icon['icon']; ?>" alt="">
					</div>
					<div class="icon-txt">
						<p><?php echo $icon['description']; ?></p>
					</div>
				</div>
			<?php } ?>
		</div>
	  </div>
	</section>
	<!-- about deep tech section end -->

	<!-- deep tech insights section start -->
	<?php echo do_shortcode($deep_tech_insights['deep_tech_insights_shortcode']); ?>
	<?php /*<section class="deep-insights">
	  <div class="container">
	    <div class="page-title">
	      <h2><?php echo $deep_tech_insights['title']; ?></h2>
	    </div>
	    <div class="deep-insights-slider1">
	    	<?php foreach($deep_tech_insights['slider'] as $slide) { 
	    		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $slide->ID ), 'full' ); ?>
				<div class="insights-slide">
					<div class="insight-box">
						<div class="insight-img">
							<img src="<?php echo $featured_image[0]; ?>" alt="">
						</div>
						<div class="insight-txt">
							<h3><?php echo $slide->post_title; ?></h3>
						</div>
					</div>
				</div>
			<?php } ?>
	    </div>
	  </div>
	</section>*/ ?>
	<!-- deep tech insights section start -->

	<!-- agenda section start -->
	<?php if(!empty($agenda)) { ?>
	<div id="deeptechagenda"></div>
	<br />
	<section class="our-partner">
	  <div class="container">
	    <div class="page-title">
	      <h2><?php echo $agenda['title']; ?></h2>
	    </div>
	    <?php echo do_shortcode($agenda['shortcode']); ?>
	  </div>
	</section>
	<?php } ?>
	<!-- agenda section end -->

	<!-- our experts section start -->
	<?php echo do_shortcode($our_experts['shortcode']); ?>
	<!-- our experts section end -->

	<!-- our partners section start -->
	<div class="deep-tech-partners">
		<?php echo do_shortcode($our_partners['shortcode']); ?>
	</div>
	<!-- our partners section end -->

	<!-- Testimonial section start --> 
	<section class="testimonial">
	  <div class="container">
	    <div class="page-title">
	      <h2><?php echo $testimonials['title']; ?></h2>
	    </div>
	    <?php echo do_shortcode($testimonials['shortcode']); ?>
	  </div>
	</section>
	<!-- Testimonial section end --> 

</div>

<?php echo do_shortcode('[sigma-mt-newsletter]'); ?>

<script>

  //testimonial slider start
  $('.testimonial-slider').slick({
      infinite: true,
  });
  //testimonial slider end
 </script>

<?php get_footer(); ?>