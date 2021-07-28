<?php
/**
 * Template Name: SigmaMT Single Post Layout
 * Template Post Type: news-items
 * Created By: Rinkal Petersen
 * Created at: 15 Apr 2021
 */
/* News template css */

get_header();

$featured_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
$image_id = get_image_id_by_url($featured_image_url[0]);
$image_info = wp_get_attachment_metadata($image_id);
$image_title = get_the_title($image_id);
?>

<section>
	<!-- News Banner start -->
	<div class="blog-banner">
		<a href="#">
			<img src="<?php echo $featured_image_url[0]; ?>" alt="<?php echo $image_title; ?>">
		</a>
	</div>
	<!-- News Banner end -->

	<!-- News page main section start -->
	<div class="blog-content">
		<div class="page-container">
			<!-- Leftbar start -->
			<div class="blog-leftbar">
				<?php echo do_shortcode('[sigma_mt_show_sidebar elements="22817, 22581, 22553"]'); ?>
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
						<?php } ?>
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
							<a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo get_permalink(); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
						</li>
						<li>
							<a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_permalink(); ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
						</li>
						<li>
							<a target="_blank" href="https://twitter.com/intent/tweet?url=<?php echo get_permalink(); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
						</li>
					</ul>
				</div>
				<div class="featured-img">
					<?php the_post_thumbnail(); ?>
				</div>
				<div class="post-body">
					<?php the_content(); ?>
				</div>
				<div class="social-sharing last">
					<ul>
						<li>Share Article</li>
						<li>
							<a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo get_permalink(); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
						</li>
						<li>
							<a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_permalink(); ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
						</li>
						<li>
							<a target="_blank" href="https://twitter.com/intent/tweet?url=<?php echo get_permalink(); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
						</li>
					</ul>
				</div>
				<div class="releted-post">
					<h3>Related Posts</h3>
					<div class="listing-wrapper">
						<?php 
						//echo do_shortcode('[sigma-mt-related-articles post_per_page = 10]');
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
						)); ?>
						<?php
						if ( $the_query->have_posts() ) :
							while ( $the_query->have_posts() ) : $the_query->the_post();?>
								<a href="'.get_permalink().'"><article class="post-item">
									<div class="thumb" style="background-image: url('<?php echo wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ); ?>')">
										<a href="<?php echo get_permalink();?>"></a>
									</div>
									<div class="content-wrapper">
										<h2><a href="<?php echo get_permalink();?>"><?php the_title(); ?></a></h2>
										<p>
											<?php 	
											$content = the_content('read more', true);
											$content = substr($content,0,50);
											$content = apply_filters('the_content', $content.'...' );
											//$content = $content . '<a href="'.get_permalink().'">(Read More...)</a>'; 
											echo $content;  
											?>
										</p>
									</div>
								</article></a>
							<?php endwhile; ?>
						<?php else : ?>
							<p><?php __('No News'); ?></p>
						<?php endif; ?>
						<?php wp_reset_postdata(); ?>
					</div>
				</div>
			</div>
			<!-- Middle Detail News end -->

			<!-- Rightbar start -->
			<div class="blog-rightbar">
				<?php echo do_shortcode('[sigma_mt_show_sidebar elements="22578, 22577, 22582, 22549, 22583"]'); ?>
			</div>
			<!-- Rightbar end -->
		</div>
	</div>
	<!-- News page main section end -->
</section>

<?php get_footer(); ?>
