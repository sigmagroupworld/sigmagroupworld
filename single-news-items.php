<?php
/**
 * Template Post Type: news-items
 * Created By: Rinkal Petersen
 * Created at: 15 Apr 2021
 */
/* News template css */

get_header();

$post = get_post();
$fallback_sidebars_left = '22554, 22581, 22553';
$fallback_sidebars_right = '22578, 22577, 22582, 22549, 22583';
$terms = get_the_terms($post, 'news-cat');
$featured_image;
$featured_image;
$sidebars_left_final;
$sidebars_right_final;
$featured_image_post = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );

$banner_category = get_field('banner_category', get_the_id());
$firstcategory = (($banner_category != null && $banner_category != '') ? $banner_category : (!empty($terms) ? $terms[0] : null));
if($firstcategory != null){
	$featured_image_category = get_field('header', $firstcategory);
	$featured_image = ($featured_image_category != '' ? $featured_image_category : (!empty($featured_image_post) ? $featured_image_post[0] : ''));
	
	$sidebars_left = get_field('left_sidebar_children', $firstcategory);
	$sidebars_right = get_field('right_sidebar_children', $firstcategory);
	$sidebars_right = get_field('right_sidebar_children', $firstcategory);
	$sidebars_left_final = !empty($sidebars_left) ? implode(', ', $sidebars_left) : $fallback_sidebars_left;
	$sidebars_right_final = !empty($sidebars_right) ? implode(', ', $sidebars_right) : $fallback_sidebars_right;
	$header_link = get_field('header_link', $firstcategory);
} else {
	$featured_image = (!empty($featured_image_post) ? $featured_image_post[0] : '');
	$sidebars_left_final = $fallback_sidebars_left;
	$sidebars_right_final = $fallback_sidebars_right;
	$header_link = '';
}
?>

<section>
	<!-- News Banner start -->
    <?php if ($featured_image != '') { ?>
        <div class="blog-banner">
            <a href="<?php echo ($header_link != '' ? ($header_link . '" target="_blank"') : '#"'); ?>">
                <img src="<?php echo $featured_image; ?>">
            </a>
        </div>
    <?php } ?>
	<!-- News Banner end -->

	<!-- News page main section start -->
	<div class="blog-content">
		<div class="page-container">
			<!-- Leftbar start -->
			<div class="blog-leftbar">
				<?php echo do_shortcode('[sigma_mt_show_sidebar elements="'.$sidebars_left_final.'"]'); ?>
			</div>
			<!-- Leftbar end -->

			<!-- Middle Detail News start -->
			<div class="blog-details">
				<h2 class="blog-title"><?php the_title(); ?></h2>
				<div class="info">
					<span id="publish-date">
						<?php echo __('Posted:', 'sigmaigaming'); ?>: <strong><?php echo get_the_date( 'M d, Y' ); ?> <?php the_time( 'H:i' );?></strong>
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
						<?php echo __('Posted by', 'sigmaigaming'); ?>
						<?php 
						$post_id = get_the_ID();
						$author = get_field('author', $post_id);
						if(empty($author)) { ?>
							<div class="avatar" style="background-image:url('<?php echo esc_url( $avatar_url ); ?>')"> </div> 
							<a class="author-link" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
								<strong>
									<?php echo get_the_author(); ?>
								</strong>
							</a>
						<?php } else { ?>
							<a class="author-link" href="<?php echo get_the_permalink($author->ID); ?>">
								<strong>
									<?php echo $author->post_title; ?>
								</strong>
							</a>
						<?php } ?>
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
								<a href="<?php echo get_the_permalink(); ?>"><article class="post-item">
									<div class="thumb" style="background-image: url('<?php echo wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ); ?>')">
										<a href="<?php echo get_the_permalink();?>"></a>
									</div>
									<div class="content-wrapper">
										<h2><a href="<?php echo get_the_permalink();?>"><?php echo wp_trim_words(get_the_title(), 5); ?></a></h2>
										<p>
                                            <?php echo wp_trim_words(get_the_content(), 20); ?>
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
				<?php echo do_shortcode('[sigma_mt_show_sidebar elements="'.$sidebars_right_final.'"]'); ?>
			</div>
			<!-- Rightbar end -->
		</div>
	</div>
	<!-- News page main section end -->
</section>

<?php get_footer(); ?>

