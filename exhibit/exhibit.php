<?php
/**
 * Template Name: SigmaMT Exhibit Page Layout
 * Created By: Rinkal Petersen
 * Created at: 22 May 2021
 */
/* Exhibit template css */
get_header();

$post_data = $wp_query->get_queried_object();
$page_id = $post_data->ID;
$company_term = sigma_mt_get_company_term($page_id);
$exhibit_banner = get_field('banner');
$sponsors_term = get_field('sponsors_term', $page_id);
$taxonomy = 'sponsoring-cat';
?>
<div class="exhibit-template">
	<!-- Banner section start -->
	<section class="banner europe">
	  <div class="container">
	    <div class="banner-txts">
	      <div class="banner-title">
	        <h2><?php echo $exhibit_banner['title']; ?></h2>
	      </div>
	      <div class="banner-contact">
	        <p><?php echo $exhibit_banner['page_info']; ?></p>
	      </div>
	    </div>
	  </div>
	</section>
	<!-- Banner section end -->

	<!-- FAQ section start -->
	<section class="page-faq">
	  <div class="container">
	    <div class="faq-sub">
	    	<?php $explore_text = get_field('explore_text'); ?>
	      	<p><?php echo $explore_text; ?></p>
	    </div>
	    <div class="faq-main">

	    	<?php if(!empty($sponsors_term['roadshow_opportunities'][0])) {
	    		echo do_shortcode('[sigma-mt-sponsors-top-tabs tag_id = "'.$sponsors_term['roadshow_opportunities'][0].'" taxonomy = "'.$taxonomy.'" count = "5"]');
	    	} ?>

	    	<?php $sponsoring_categories = sigma_mt_get_sponsoring_tags_data($sponsors_term['exhibiting_opportunities'][0], $taxonomy, 5);
	    	if(!empty($sponsoring_categories)) { ?>
				<div class="wrapper">
					<div class="toggle">
						<h3><?php echo $sponsoring_categories['term_value']->name; ?></h3>
						<div class="all-sell">
							<i class="fas fa-plus icon"></i>
						</div>
					</div>
					<div class="content">
						<div class="all-packages">
							<?php foreach($sponsoring_categories['term_data'] as $k => $sponsoring) {
								$exhibit_details = get_field('exhibit_details', $sponsoring->ID);
								$sponsors_amount = isset($exhibit_details['amount']) ? $exhibit_details['amount'] : '';
								$sponsors_count = isset($exhibit_details['sponsors_count']) ? $exhibit_details['sponsors_count'] : '';
								$package = isset($exhibit_details['package']) ? $exhibit_details['package'] : '';
								$package_status = isset($exhibit_details['package_status']) ? $exhibit_details['package_status'] : '';
								$gold_pkg = __( 'Gold Package', 'sigmaigaming' );
								$outdoor_pkg = __( 'Outdoor Platinum', 'sigmaigaming' );
								$silver_pkg = __( 'Silver Package', 'sigmaigaming' );
								$platinum_pkg = __( 'Platinum Package', 'sigmaigaming' );
								$bronze_pkg = __( 'Bronze Package', 'sigmaigaming' );
								$meeting_pkg = __( 'Meeting Room Package', 'sigmaigaming' );
								if($package === $gold_pkg) {
									$class = 'gold';
									$image = '<img src="'.CHILD_DIR.'/exhibit/images/gold-package-icon.png" alt="" class="soldout">';
								} else if($package === $outdoor_pkg || $package === $platinum_pkg) {
									$class = 'platinum';
									$image = '<img src="'.CHILD_DIR.'/exhibit/images/platinum-package-blue-icon-1.png" alt="" class="soldout">';
								} else if($package === $silver_pkg) {
									$class = 'silver';
									$image = '<img src="'.CHILD_DIR.'/exhibit/images/silver-package-icon.png" alt="" class="soldout">';
								} else {
									$class = '';
									$image = '';
								}
								?>
								<div class="single-package <?php echo $class; ?>" id="sponsorPopup<?php echo $sponsoring->ID; ?>" onclick="openModal('sponsorPopup<?php echo $sponsoring->ID; ?>', 'sponsorContent<?php echo $sponsoring->ID; ?>', 'closeSponsor<?php echo $sponsoring->ID; ?>')">
									<div class="top">
										<h3><?php echo $package; ?></h3>
										<div class="package-icon"><?php echo $image; ?></div>
									</div>
									<div class="mid">
										<div class="price-wrapper">
											<h3><?php echo $sponsors_amount; ?></h3>
										</div>
									</div>
									<div class="bottom">
										<span class="open-btn"><?php echo $package_status; ?></span>
									</div>
								</div>
								<!-- The Modal -->
                                <div id="sponsorContent<?php echo $sponsoring->ID; ?>" class="modal">
                                    <!-- Modal content -->
                                    <div class="modal-content">
                                        <span class="close" id="closeSponsor<?php echo $sponsoring->ID; ?>">&times;</span>
                                        <h4><?php echo $sponsoring->post_title; ?></h4>
                                        <?php $sponsors_gallery = $exhibit_details['sponsers_gallery'];
                                        if(!empty($sponsors_gallery)) {
                                            echo '<div class="sponsors_gallery">';
                                                foreach($sponsors_gallery as $image) {
                                                    echo '<img src="'.$image.'">';
                                                }
                                            echo '</div>';
                                        }
                                        if(!empty($sponsoring->post_content)) {
                                           	echo '<div class="post_content">'.$sponsoring->post_content.'</div>';
                                        }
                                        if(!empty($sponsors_amount)) {
                                            echo '<div class="bottom '.$class.'">
                                                <span class="prcie">'.$sponsors_amount.'</span>
                                                <span class="status">'.$sponsors_count.'</span>
                                            </div>';
                                        }
                                    echo '</div>
                                </div>';
							} ?>
						</div>
					</div>
				</div>
			<?php } ?>

			<?php if(!empty($sponsors_term['sponsorship_opportunities'][0])) {
	    		echo do_shortcode('[sigma-mt-sponsors-top-tabs tag_id = "'.$sponsors_term['sponsorship_opportunities'][0].'" taxonomy = "'.$taxonomy.'" count = "5"]');
	    	} ?>

	    	<?php if(!empty($sponsors_term['advisory_opportunities'][0])) {
	    		echo do_shortcode('[sigma-mt-sponsors-top-tabs tag_id = "'.$sponsors_term['advisory_opportunities'][0].'" taxonomy = "'.$taxonomy.'" count = "5"]');
	    	} ?>

			<div class="wrapper">
				<?php $sponsoring_categories = __( 'Networking Igatherings', 'sigmaigaming' ); ?>
				<a href="<?php echo SITE_URL; ?>">
					<div class="toggle_link">
						<h3><?php echo $sponsoring_categories; ?></h3>
						<div class="all-sell">
							<i class="fas fa-plus icon_link"></i>
						</div>
					</div>
				</a>
			</div>

			<?php if(!empty($sponsors_term['workshop_opportunities'][0])) {
				echo do_shortcode('[sigma-mt-sponsors-bottom-tabs tag_id = "'.$sponsors_term['workshop_opportunities'][0].'" taxonomy = "'.$taxonomy.'" count = "5"]'); 
			} ?>

	    </div>
	  </div>
	</section>
	<!-- FAQ section end -->

	<!-- Contact Us section start -->
	<?php
	$people_list = do_shortcode( '[sigma-mt-people-lists post_id = '.$page_id.' person_name = "yes" person_image = "yes" person_position = "yes" person_company = "no" person_language = "yes" person_email= "yes" person_phone= "yes" person_skype= "yes" posts_per_page = "5"]');
	echo $people_list;
	?>
	<!-- Contact Us section end -->

	<!-- Supplier section start -->
	<?php 
	$our_trusted_suppliers = get_field('our_trusted_suppliers');
	$term_id = $our_trusted_suppliers['comany_term'][0];
	echo do_shortcode('[sigma-mt-company-lists term_id = "'.$term_id.'" posts_per_page = "1"]'); 
	?>
	<!-- Supplier section end -->

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
