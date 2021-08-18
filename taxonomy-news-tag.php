<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since 1.0.0
 */

get_header();
$description = get_the_archive_description();
// get the current taxonomy term
$term = get_queried_object();
$term_image = get_field('taxonomy_image', $term);
$term_url = get_field('texonomy_link', $term);
$tag_url = get_tag_link($term);
$image_id = get_image_id_by_url($term_image);
$image_info = wp_get_attachment_metadata($image_id);
$image_title = get_the_title($image_id);

if(isset($term_url) && !empty($term_url)) {
	$link = $term_url;
} else {
	$link = $tag_url;
}
?>

<section class="texonomy-page">
	<!-- News Banner section start -->
	<div class="blog-banner texonomy-banner">
		<a href="<?php echo $term_url; ?>">
			<img src="<?php echo $term_image; ?>" alt="<?php echo $image_title; ?>">
		</a>
	</div>
	<!-- News Banner section start -->

	<!-- News Content section start -->
	<div class="blog-content">
		<div class="page-container">
			<div class="blog-leftbar">
				<div class="singleBannerAdvert bottom-border">
					<a href="#" target="_blank">
                    	<img src="https://www.sigma.world/hubfs/6M%20Sigma%20Files/Banners/Sold%20Banners/AGS-PM-Affiliate-Program-Left-Banner.png" alt="">       
    				</a>
				</div>
				<div class="affiliates bottom-border">
					<div class="blog-sub-title">
						<h3>Affiliates</h3>
					</div>
					<!-- Affliates blog -->
				</div>
				<div class="malta bottom-border">
					<div class="blog-sub-title">
						<h3>WHY MALTA?</h3>
					</div>
					<!-- video -->
				</div>
			</div>
			<div class="blog-details">
				<div class="blog-listing-wrapper">
					<?php if ( have_posts() ) {
						while ( have_posts() ) {
							the_post();
							$featured_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
							$image_id = get_image_id_by_url($featured_image_url[0]);
							$image_info = wp_get_attachment_metadata($image_id);
							$image_title = get_the_title($image_id); ?>
							<div class="list-single-item">
								<a href="<?php echo get_permalink(); ?>">
									<div class="post-desc">
										<img src="<?php echo $featured_image_url[0]; ?>" alt="<?php echo $image_title; ?>">
										<h3><?php the_title(); ?></h3>
									</div>
								</a>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
				<?php the_posts_pagination(); ?>
			</div>
			<?php /*if ( is_active_sidebar( 'news-posts-sidebar' ) ) : ?>
			    <div id="secondary" class="widget-area" role="complementary">
			    <?php dynamic_sidebar( 'news-posts-sidebar' ); ?>
			    </div>
			<?php endif;*/ ?>
			<div class="blog-rightbar">
				<div class="magazine-widget bottom-border">
					<div class="blog-sub-title">
						<h3>Latest Magazines</h3>
					</div>
  					<a href="#" target="_blank">
    					<img src="https://www.sigma.world/hubfs/6M%20Sigma%20Files/Magazine/Magazine%20covers/Sigma%2013%20for%20web-1.png" alt="magazine"/>
  					</a>
				</div>
				<div class="offersWrapper">
					<div class="blog-sub-title">
						<h3>Casino Offers</h3>
					</div>
					<div class="offerwrap">
						<div class="offeritem">
							<div class="imgwrap">
          						<img src="https://www.sigma.world/hubfs/1xbet-1.png" alt="offer"/>
        					</div>
        					<div class="linkwrap">
        						<a class="playbtn" target="_blank" href="#">Play Now</a>
        						<a class="tnclink" href="#">*T&amp;C Apply</a>
        					</div>
						</div>
						<div class="offeritem">
							<div class="imgwrap">
          						<img src="https://www.sigma.world/hubfs/1xbet-1.png" alt="offer"/>
        					</div>
        					<div class="linkwrap">
        						<a class="playbtn" target="_blank" href="#">Play Now</a>
        						<a class="tnclink" href="#">*T&amp;C Apply</a>
        					</div>
						</div>
						<div class="offeritem">
							<div class="imgwrap">
          						<img src="https://www.sigma.world/hubfs/1xbet-1.png" alt="offer"/>
        					</div>
        					<div class="linkwrap">
        						<a class="playbtn" target="_blank" href="#">Play Now</a>
        						<a class="tnclink" href="#">*T&amp;C Apply</a>
        					</div>
						</div>
						<div class="offeritem">
							<div class="imgwrap">
          						<img src="https://www.sigma.world/hubfs/1xbet-1.png" alt="offer"/>
        					</div>
        					<div class="linkwrap">
        						<a class="playbtn" target="_blank" href="#">Play Now</a>
        						<a class="tnclink" href="#">*T&amp;C Apply</a>
        					</div>
						</div>
						<div class="offeritem">
							<div class="imgwrap">
          						<img src="https://www.sigma.world/hubfs/1xbet-1.png" alt="offer"/>
        					</div>
        					<div class="linkwrap">
        						<a class="playbtn" target="_blank" href="#">Play Now</a>
        						<a class="tnclink" href="#">*T&amp;C Apply</a>
        					</div>
						</div>
					</div>
				</div>
				<div class="latest-news bottom-border">
					<div class="blog-sub-title">
						<h3>Latest News</h3>
					</div>
					<!-- Latest news blog -->
				</div>
				<div class="aftermovie bottom-border">
					<div class="blog-sub-title">
						<h3>SiGMA 2019 Aftermovie</h3>
					</div>
					<!-- Video -->
				</div>
				<div class="upcoming-event">
					<div class="blog-sub-title">
						<h3>Upcoming Events</h3>
					</div>
					<div class="calendar-event ">
						<h5>SiGMA Europe (Malta)</h5> 
    					<div class="date">  
      						November 16, 2021
    					</div>
    					<div class="widget_type_rich-text">
     						<p>Following the UK's December 2020 release of the Pfizer BioNTech vaccine, SIGMA Group will move its April event to November. SIGMA Europe, which will be based...</p>
    					</div>
    					<a class="eventbtn" href="#" target="_blank">REGISTER FREE</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- News Content section End -->
</section>

<?php get_footer(); ?>
