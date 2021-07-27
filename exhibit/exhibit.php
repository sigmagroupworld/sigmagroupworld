<?php
/**
 * Template Name: SigmaMT Exhibit Page Layout
 * Created By: Rinkal Petersen
 * Created at: 22 May 2021
 */
/* Exhibit template css */
wp_enqueue_style('home', get_stylesheet_directory_uri().'/exhibit/css/exhibit.css'); 
get_header();

global $post;
$page_id = $wp_query->get_queried_object()->ID;
$parent_page = get_the_title( wp_get_post_parent_id( $post->ID ) );
$exhibit_banner = get_field('banner');
$sponsors_term = get_field('sponsors_term', $page_id);
$taxonomy = 'sponsoring-cat';

$field = get_field('accordian_section', $page_id);
?>
<div class="exhibit-template <?php echo $parent_page; ?>">
	<!-- Banner section start -->
	<section class="exhibit-banner europe">
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

	<!-- Sponsors Accordian Tabs section start -->
	<section class="page-accordion">
	  <div class="container">
	    <div class="accordion-sub">
	    	<?php $explore_text = get_field('explore_text'); ?>
	      	<p><?php echo $explore_text; ?></p>
	    </div>
	    <div class="accordion-main">
	    	<!-- Roadshow opportunities -->
	    	<?php
			echo do_shortcode($field['roadshow_opportunities']['shortcode']);
			?>
			<!-- Roadshow opportunities end -->

			<?php
			echo do_shortcode($field['exhibiting_opportunities']['shortcode']);
			?>

			<!-- Sponsorship Opportunities -->
			<?php 
			echo do_shortcode($field['sponsorship_opportunities']['shortcode']);
			?>
			<!-- Sponsorship Opportunities end -->

			<!-- Advisory Opportunities -->
	    	<?php 
			echo do_shortcode($field['advisory_opportunities']['shortcode']);
			?>
			<!-- Advisory Opportunities end -->

			<!-- Networking Igatherings -->
			<div class="wrapper">
				<?php $sponsoring_categories = __( 'Networking Igatherings', 'sigmaigaming' ); ?>
				<a href="https://sigma.world/igatherings/">
					<div class="toggle_link">
						<h3><?php echo $sponsoring_categories; ?></h3>
						<div class="all-sell">
							<i class="fas fa-plus icon_link"></i>
						</div>
					</div>
				</a>
			</div>
			<!-- Networking Igatherings end -->

			<!-- Print Opportunities -->
	    	<?php 
			echo do_shortcode($field['print_opportunities']['shortcode']);
			?>
			<!-- Advisory Opportunities end -->

			<!-- Media/TV Opportunities -->
	    	<?php 
			echo do_shortcode($field['mediatv_opportunities']['shortcode']);
			?>
			<!-- Advisory Opportunities end -->

			<!-- Conference Opportunities -->
	    	<?php 
			echo do_shortcode($field['conference_opportunities']['shortcode']);
			?>
			<!-- Advisory Opportunities end -->

			<!-- Workshop Opportunities -->
			<?php
			echo do_shortcode($field['workshop_opportunities']['shortcode']);
			?>
			<!-- Workshop Opportunities end -->

	    </div>
	  </div>
	</section>
	<!-- Sponsors Accordian Tabs section end -->

	<!-- Contact Us section start -->
	<?php
	$field = get_field('contact_us', $page_id);
	echo do_shortcode('[sigma-mt-people-lists sort_ordering="ASC" ordering_by="sort_order_exhibit_pages" term_id = "1171" person_name = "YES" person_image = "YES" person_position = "YES" person_company = "no" person_language = "YES" person_email= "YES" person_phone= "YES" person_skype= "YES" appearance = "Regular" color="'.$field['contact_us_color'].'" ]');
	?>
	<!-- Contact Us section end -->

	<!-- Supplier section start -->
	<?php 
	$field = get_field('our_trusted_suppliers', $page_id);
	echo do_shortcode($field['trusted_suppliers_shortcode']);
	?>
	<!-- Supplier section end -->

</div>

<?php echo do_shortcode('[sigma-mt-newsletter]'); ?>

<?php get_footer(); ?>
