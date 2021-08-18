<?php
/**
 * Template Name: Single News Post layout
 * Template Post Type: news-items
 * Created By: Rinkal Petersen
 * Created at: 15 Apr 2021
 */
get_header();
?>
​
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri();?>/assets/css/all.css">
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri();?>/news/css/news.css">
</head>
<body>

<section>
	<!-- News Banner start -->
	<div class="blog-banner">
		<a href="#">
			<img src="<?php echo get_field('banner_image'); ?>" alt="">
		</a>
	</div>
	<!-- News Banner end -->

	<!-- News page main section start -->
	<div class="blog-content">
		<div class="page-container">
			<!-- Leftbar start -->
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
					<iframe width="100%" height="100%" src="https://www.youtube.com/embed/YHfPQvoi_tU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			</div>
			<!-- Leftbar end -->

			<!-- Middle Detail News start -->
			<div class="blog-details">
				<h2 class="blog-title"><?php the_title(); ?></h2>
				<div class="info">
					<span id="publish-date">
						Added: <strong><?php echo get_the_date( 'M d, Y' ); ?> <?php the_time( 'H:i' );?></strong>
					</span>
					<span id="tags">
						Category: 
						<strong>
						<?php $categories = wp_get_post_terms( get_the_ID(),array( 'news-cat' ) );?>
						<?php foreach($categories as $c){ 
								$cat = get_category( $c );
								?>
							<a class="topic-link" href="<?php echo get_term_link($cat);?>"><?php echo $cat->name; ?></a>
							<span>,</span>
						<?php }?>
						</strong> 
					</span>
					<?php $avatar_url = get_avatar_url(get_the_author_meta( 'ID' ), array('size' => 450)); ?>
					<span class="author" id="author">
						Posted by
						<div class="avatar" style="background-image:url('<?php echo esc_url( $avatar_url ); ?>')"> </div> 
						<a class="author-link" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
							<strong>
								<?php echo get_the_author(); ?>
							</strong>
						</a>
					</span>
				</div>
				<div class="social-sharing">
					<ul>
						<li>Share Article</li>
						<li>
							<a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo get_permalink(); ?>"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
						</li>
						<li>
							<a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_permalink(); ?>"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
						</li>
						<li>
							<a target="_blank" href="https://twitter.com/intent/tweet?url=<?php echo get_permalink(); ?>"><i class="fab fa-twitter" aria-hidden="true"></i></a>
						</li>
					</ul>
				</div>
				<div class="featured-img">
					<?php the_post_thumbnail();
//                    set_post_thumbnail_from_content();
                    ?>
				</div>
				<div class="post-body">
					<?php the_content(); ?>
				</div>
				<div class="social-sharing last">
					<ul>
						<li>Share Article</li>
						<li>
							<a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo get_permalink(); ?>"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
						</li>
						<li>
							<a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_permalink(); ?>"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
						</li>
						<li>
							<a target="_blank" href="https://twitter.com/intent/tweet?url=<?php echo get_permalink(); ?>"><i class="fab fa-twitter" aria-hidden="true"></i></a>
						</li>
					</ul>
				</div>
				<div class="releted-post">
					<h3>Related Posts</h3>
					<div class="listing-wrapper">
					<?php 
					/*$post_categories = array();
					$categories = wp_get_post_terms( get_the_ID(),array( 'news-cat' ) );
						 foreach($categories as $c){ 
								$cat = get_category( $c );	
							 $post_categories[] = $cat->name; 	
						 }*/
						$the_query = new WP_Query( array(
							//'category_name' => 'home-slider', 
							'post_type' => 'news-items',
							'posts_per_page' => 6,
					   ));?>
                        <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                            <article class="post-item">
                                <div class="thumb"
                                     style="background-image: url('<?php echo wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())); ?>')">
                                    <a href="<?php echo get_the_permalink(); ?>"></a>
                                </div>
                                <div class="content-wrapper">
                                    <h2><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <p>

                                    </p>
                                </div>
                            </article>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
					</div> 
				</div>

			</div>
			<!-- Middle Detail News end -->

			<!-- Rightbar start -->
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
					<div class="post-item">
					<?php 
					   $the_query = new WP_Query( array(
						 'post_type' => 'news-items',
						  'posts_per_page' => 10,
					   )); 
					?>
					<?php if ( $the_query->have_posts() ) : ?>
					  <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					 <h4 style="margin-bottom: 0px;"> <a class="more-link" href="<?php echo get_permalink();?>"><?php the_title(); ?></a></h4>
						<div class="info">
						  <div>
							<strong>
							<?php $categories = wp_get_post_terms( get_the_ID(),array( 'news-cat' ) );?>
							<?php foreach($categories as $c){ 
								$cat = get_category( $c );
								?>
									<a style="text-decoration: none;color:#e21735;" class="topic-link" href="<?php echo get_term_link($cat);?>"> <?php echo $cat->name; ?><span>,</span></a>
								<?php }?>
							  </strong> 
						  </div>
						</div>    
					  
					  <?php endwhile; 
					  wp_reset_postdata(); ?>

					<?php else : ?>
					  <p><?php __('No News'); ?></p>
					<?php endif; ?>
				</div>
				<div class="aftermovie bottom-border">
					<div class="blog-sub-title">
						<h3>SiGMA 2019 Aftermovie</h3>
					</div>
					<iframe width="100%" height="100%" src="https://www.youtube.com/embed/ZWE0KQRlSaU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
				<div class="upcoming-event">
					<div class="blog-sub-title">
						<h3>Upcoming Events</h3>
					</div>
					<?php 
						 $the_query = new WP_Query( array(
						 'post_type' => 'event-items',
					   ));
					?>
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
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
					<?php endwhile; 
					  wp_reset_postdata(); ?>
				</div>
			</div>
			<!-- Rightbar end -->

		</div>
	</div>
	<!-- News page main section end -->
</section>
<?php
	get_footer();
?>
</body>
</html>