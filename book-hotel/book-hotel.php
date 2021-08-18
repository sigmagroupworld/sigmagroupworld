<?php
/**
 * Template Name: SigmaMT Book Hotel Page Layout
 * Created By: Rinkal Petersen
 * Created at: 22 May 2021
 */
/* Book Hotel template css */
wp_enqueue_style('directory', get_stylesheet_directory_uri().'/book-hotel/css/book-hotel.css');
get_header();

$page_id = $wp_query->get_queried_object()->ID;
$flights_accommodation = get_field('flights_and_accommodation');
$sigma_offical_hotels = get_field('sigma_offical_hotels');
$show_flight_form = get_field('show_flight_form');
$top_section = get_field('top_section');
$hotel_listing = get_field('hotel_listing', $page_id);
?>

<div class="book-hotel-template">
	<!-- book hotel page start -->
	<section class="book-hotel-page">
	  <div class="container">
	  	<!-- TOP SECTION START -->
        <?php 
          if(!empty($top_section) && !empty($top_section['banner_image'])){ ?>
           <div class="book-pass-top" style="display: none;">
               <div class="top-image">
               	<img src="<?php echo $top_section['banner_image']; ?>">
               </div>     
               <?php
               if(!empty($top_section['button_1_link']) && !empty($top_section['button_2_text'])){ ?>

               <div class="btn-wrapper-hotel">
               	 <a class="btn-one btn-hotel" href="<?php echo $top_section['button_1_link']; ?>"><?php echo $top_section['button_1_text'] ?></a>
               	 <a class="btn-two btn-hotel" href="<?php echo $top_section['button_2_link']; ?>"><?php echo $top_section['button_2_text'] ?></a>

               </div> 
               <?php    	
                }
                ?>
           </div>
    
         <?php } ?>
			<!-- Flights & accomodation start -->
	    <?php if(!empty($flights_accommodation['title'])) { ?>
		    <div class="flights">
		      <div class="page-title">
		        <h2><?php echo $flights_accommodation['title']; ?></h2>
		      </div>
		      <div class="book-txt-all">
		        <div class="book-txt">
		          <p><?php echo $flights_accommodation['description']; ?></p>
		        </div>
		        <div class="book-video">
		          <?php echo $flights_accommodation['video_iframe']; ?>
		        </div>
		      </div>
		    </div>
		<?php } ?>
	    <!-- Flights & accomodation end -->

	    <!-- Flights Booking form start -->
	    <div>
			<?php if($show_flight_form == true) {
				echo do_shortcode('[sigma-mt-book-flight-form]'); 
		}?>
		</div>
	    <!-- Flights Booking form end -->

	    <!-- Sigma official hotel start -->
	    <?php if(!empty($sigma_offical_hotels['title'])) { ?>
		    <div class="sigma-hotels">
		      <div class="page-title">
		        <h2><?php echo $sigma_offical_hotels['title']; ?></h2>
		      </div>
		      <div class="hotels-sub">
		        <img src="<?php echo $sigma_offical_hotels['icon']; ?>" alt="">
		        <p><?php echo $sigma_offical_hotels['text']; ?></p>
		      </div>
		      <div class="hotel-imgs">
		      	<?php if(!empty($sigma_offical_hotels['official_photo_gallery'])) {
		      		foreach($sigma_offical_hotels['official_photo_gallery'] as $image) { ?>
				        <div class="single-img">
				          <img src="<?php echo $image['image']; ?>" alt="">
				        </div>
			    <?php }
			    } ?>
		      </div>	      
		      <?php echo do_shortcode($sigma_offical_hotels['official_hotel_shortcode']); ?>
		    </div>
		<?php } ?>
	    <!-- Sigma official hotel end -->

	    <!-- STAR HOTELS Listing -->
	    <?php if(!empty($hotel_listing)) {
	    	foreach($hotel_listing as $list) { ?>
			    <div class="sigma-hotels">
					<div class="page-title">
						<h2><?php echo $list['title']; ?></h2>
					</div>
				    <?php echo do_shortcode($list['shortcode']); ?>
				</div>
		<?php }
		} ?>
		<!-- STAR HOTELS Listing end -->
	  </div>
	</section>
	<!-- book hotel page end -->

</div>

<?php echo do_shortcode('[sigma-mt-newsletter]'); ?>

<?php get_footer(); ?>