<?php
/**
 * Template Name: SigmaMT Europe Gaming Awards Page Layout
 * Created By: Rinkal Petersen
 * Created at: 16 June 2021
 */
/* Europe Gaming Awards template css */
wp_enqueue_style('home', get_stylesheet_directory_uri().'/europe-gaming-awards/css/europe-gaming-awards.css'); 
get_header();
$page_id = $wp_query->get_queried_object()->ID;
$gaming_awards_banner = get_field('banner', $page_id);
$are_you_sitting_down_info = get_field('are_you_sitting_down', $page_id);
$awards = get_field('awards', $page_id);
$hosts = get_field('hosts', $page_id);
$judges = get_field('judges', $page_id);
$charity_auction_items = get_field('charity_auction_items', $page_id);
$faq = get_field('faq', $page_id);
$meet_the_past_winners = get_field('meet_the_past_winners', $page_id);
$testimonials = get_field('testimonials', $page_id);
?>
<div class="europe-gaming-awards-template">
	<!-- banner section start -->
	<section class="gaming-awards-banner">
	  <div class="container">
	    <div class="banner-img">
	      <img src="<?php echo $gaming_awards_banner['banner_image']; ?>" alt="">
	    </div>
	    <div class="gaming-sub-txt">
	      <p><?php echo $gaming_awards_banner['description']; ?></p>
	    </div>
	    <div class="awards-night-img">
	      <img src="<?php echo $gaming_awards_banner['nomination_lists_image']['desktop_image']; ?>" alt="" class="for-desktop">
	      <img src="<?php echo $gaming_awards_banner['nomination_lists_image']['mobile_image']; ?>" alt="" class="for-mobile">
	    </div>
	    <br />
	    <br />
	  </div>
	</section>
	<!-- banner section end -->

	<!-- Sitting Down section start -->
	<section class="sitting-down">
	  <div class="container">
	    <div class="page-title">
	      <h2 style="color: #13375b;"><?php echo $are_you_sitting_down_info['title']; ?></h2>
	      <div class="sub-txt">
	        <p><?php echo $are_you_sitting_down_info['text']; ?></p>
	      </div>
	    </div>
	    <div class="four-tab-panels">
	    	<?php echo do_shortcode('[sigma-mt-seating-arrangments position="top"]'); ?>
	    </div>
	  </div>
	</section>
	<!-- Sitting Down section end -->

	<!-- award section start -->
	<section class="awards">
	  <div class="container">
	    <div class="page-title">
	      <h2 style="color: #13375b;"><?php echo $awards['title']; ?></h2>
	      <div class="sub-txt">
	        <p><?php echo $awards['description']; ?></p>
	      </div>
	    </div>
	    <div class="page-btn">
	      <a href="<?php echo $awards['nominate_button']['link']; ?>" style="background: #19548c;"><?php echo $awards['nominate_button']['title']; ?></a>
	    </div>
	    
	    <!-- Awards Listing -->
		<?php echo do_shortcode($awards['awards_shortcode']); ?>
		<!-- Awards Listing end -->

	  </div>
	</section>
	<!-- award section end -->

	<!-- hosts section start -->
	<?php echo do_shortcode($hosts['shortcode']); ?>
	<!-- hosts section end -->

	<!-- judges section start -->
	<?php echo do_shortcode($judges['shortcode']); ?>
	<!-- judges section end -->

	<!-- charity auction section start -->
	<section class="judges">
	  <div class="container">
	    <div class="page-title">
	      <h2 style="color: #13375b;"><?php echo $charity_auction_items['title']; ?></h2>
	    </div>
	    <div class="charity-items">
	    	<?php if(!empty($charity_auction_items['all_items'])) { 
	    		foreach($charity_auction_items['all_items'] as $k => $item) { ?>
					<div class="single-item" id="single-item<?php echo $k; ?>">
						<div class="btn" onclick="openCharityDiv('single-item<?php echo $k; ?>')">
							<div></div>
						</div>
						<div class="left">
							<div class="img-wrapper">
								<img src="<?php echo $item['image']; ?>" alt="thumb-1">
							</div>
							<h3><?php echo $item['title']; ?></h3>
							<h6><?php echo $item['info']; ?></h6>
						</div>
						<div class="right">
							<p><?php echo $item['content']; ?></p>
						</div>
					</div>
			<?php }
			} ?>  
	    </div>
	  </div>
	</section>
	<!-- charity auction section end -->

	<!-- sigma foundation start -->
	<section class="sigma-foundation">
	  <div class="container">
	    <div class="charity-foundation">
	      <img src="<?php echo $charity_auction_items['proceed_text']['logo']; ?>" alt="">
	      <p><?php echo $charity_auction_items['proceed_text']['description']; ?></p>
	      <div class="our-btn">
	        <a href="<?php echo $charity_auction_items['proceed_text']['button']['link']; ?>" style="background: #19548c;"><?php echo $charity_auction_items['proceed_text']['button']['label']; ?></a>
	      </div>
	    </div>
	  </div>
	</section>
	<!-- sigma foundation end -->

	<!-- Faq start -->
	<section class="faq">
	  <div class="container">
	    <div class="page-title">
	      <h2 style="color: #13375b;"><?php echo $faq['title']; ?></h2>
	    </div>
	    <?php foreach($faq['lists_of_faq'] as $k => $item) { ?>
		    <div class="single-faq">
		      <?php if(!empty($item['title'])) { ?>
		      	<h4><?php echo $item['title']; ?></h4>
		      <?php } ?>
		      <?php if(!empty($item['description'])) { ?>
		      	<p><?php echo $item['description']; ?></p>
		      <?php } ?>
		      <?php if(!empty($item['deadline'])) { ?>
		      	<p><?php echo $item['deadline']; ?></p>
		      <?php } ?>
		    </div>
		<?php } ?>
		<div class="four-tab-panels">
	    	<?php echo do_shortcode('[sigma-mt-seating-arrangments position="bottom"]'); ?>
	    </div>
	  </div>
	</section>
	<!-- Faq end -->

	<!-- Past winner section start -->
	<section class="past-winner">
	  <div class="container">
	    <div class="page-title">
	      <h2 style="color: #13375b;"><?php echo $meet_the_past_winners['title']; ?></h2>
	    </div>
	    <?php if(!empty($meet_the_past_winners['winners_tab']['winners'])) {
	    	foreach($meet_the_past_winners['winners_tab']['winners'] as $winner) { ?>
			    <div class="wrapper">
			      <div class="toggle" style="background: #13375b;">
			        <h3><?php echo $winner['title']; ?></h3>
			        <div class="all-sell">
			          <i class="fas fa-plus icon"></i>
			        </div>
			      </div>
			      <div class="content">
			        <?php echo do_shortcode($winner['shortcode']); ?>
			      </div>
			    </div>
			<?php }
		} ?>
	  </div>
	</section>
	<!-- Past winner section start -->

	<!-- Testimonial section start --> 
	<section class="testimonial">
	  <div class="container">
	    <div class="page-title">
	      <h2 style="color: #13375b;"><?php echo $testimonials['title']; ?></h2>
	    </div>
	    <?php echo do_shortcode($testimonials['shortcode']); ?>
	  </div>
	</section>
	<!-- Testimonial section end --> 

</div>

<?php echo do_shortcode('[sigma-mt-newsletter]'); ?>

<?php get_footer(); ?>
