<?php
/**
 * The template for displaying single post of company 
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since 1.0.0
 */

get_header();

$show_article_id = $_GET['page_id'];
$featured_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
$image_id = get_image_id_by_url($featured_image_url[0]);
$image_info = wp_get_attachment_metadata($image_id);
$image_title = get_the_title($image_id);
$taxonomy = 'news-cat';
$term_value = get_the_terms( $show_article_id, $taxonomy );
$related_article_term = isset($term_value[0]->term_id) ? $term_value[0]->term_id : '';
$key_metrics = get_field('key_metrics', get_the_ID());
$game_provider_review = get_field('game_provider_review', get_the_ID());
$certified_by = get_field('certified_by', get_the_ID());
$awards_won = get_field('awards_won', get_the_ID());
$games = get_field('games', get_the_ID());
?>

<section>
	<!-- News page main section start -->
	<div class="blog-content">
		<div class="page-container">
			<!-- Leftbar start -->
			<div class="blog-leftbar">
				<div class="single-banner-advert bottom-border">
					<a href="#" target="_blank">
                    	<img src="https://www.sigma.com.mt/hubfs/6M%20Sigma%20Files/Banners/Sold%20Banners/AGS-PM-Affiliate-Program-Left-Banner.png" alt="">       
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
				<div class="featured-img">
					<?php the_post_thumbnail(); ?>
				</div>
				<div class="post-body">
					<div class="post-content">
						<?php the_content(); ?>
					</div>
					<?php if(!empty($key_metrics)) { ?>
						<div class="key-metrics-content">
							<h3><?php echo $key_metrics['title']; ?></h3>
							<div class="licences">
								<span>
									<?php echo $key_metrics['licences']['title']; ?> :
									<?php echo $key_metrics['licences']['value']; ?>
								</span>
							</div>
							<div class="number-of-games">
								<span>
									<?php echo $key_metrics['number_of_games']['title']; ?> :
									<?php echo $key_metrics['number_of_games']['value']; ?>
								</span>
							</div>
							<div class="game-types">
								<span>
									<?php echo $key_metrics['game_types']['title']; ?>
								</span>
								<div class="gametypes">
									<?php 
									$arrayVal = array();
									$options = array('Slots', 'Live Casino Games', 'Dice Games', 'Table games (Blackjack, Baccarat, Roulette)', 'Keno, Lottery', 'Video Poker', 'Scratchcard Games', 'Branded Games', 'VR', 'Others');
									foreach($key_metrics['game_types']['value'] as $val) {
										$arrayVal[] = $val;
									}
									foreach($options as $val) {
						            	if(in_array($val, $arrayVal)) {
							               $class = ' selected';
							            } else {
							            	$class = '';
							            }
										echo '<p class="gametypeitem detail'.$class.'">'.$val.'</p>';
									} ?>
						        </div>
							</div>
							<div class="operators-integrated">
								<span>
									<?php echo $key_metrics['operators_integrated']['title']; ?> :
								</span>
								<div class="casino-qt">
									<?php 
									$arrayVal = array();
									$options = array('< 10', '11-25', '26-50', '51-100', '> 101');
									foreach($key_metrics['operators_integrated']['value'] as $val) {
										$arrayVal[] = $val;
									}
									foreach($options as $val) {
						            	if(in_array($val, $arrayVal)) {
							               $class = ' selected';
							            } else {
							            	$class = '';
							            }
										echo '<p class="qtyitem detail'.$class.'">'.$val.'</p>';
									} ?>
						        </div>
							</div>
							<div class="years-in-business">
								<span>
									<?php echo $key_metrics['years_in_business']['title']; ?> :
								</span>
								<div class="year-est">
									<?php 
									$arrayVal = array();
									$options = array('< 2', '3-5', '6-10', '>10');
									foreach($key_metrics['years_in_business']['value'] as $val) {
										$arrayVal[] = $val;
									}
									foreach($options as $val) {
						            	if(in_array($val, $arrayVal)) {
							               $class = ' selected';
							            } else {
							            	$class = '';
							            }
										echo '<p class="yearitem detail'.$class.'">'.$val.'</p>';
									} ?>
						        </div>
							</div>
						</div>
					<?php } ?>
					<?php if(!empty($game_provider_review)) { ?>
						<div class="game-provider-review-content">
							<h3><?php echo $game_provider_review['title']; ?></h3>
							<div class="">
								<?php echo $game_provider_review['value']; ?>
							</div>
						</div>
					<?php } ?>
					<?php if(!empty($certified_by)) { ?>
						<div class="game-provider-review-content">
							<h3><?php echo $certified_by['title']; ?></h3>
							<div class="">
								<?php foreach($certified_by['images'] as $image) {
									echo '<img src="'.$image['image'].'" alt="" width="30">';
								} ?>
							</div>
						</div>
					<?php } ?>
					<?php if(!empty($awards_won)) { ?>
						<div class="game-provider-review-content">
							<h3><?php echo $awards_won['title']; ?></h3>
							<div class="">
								<?php foreach($awards_won['images'] as $image) { 
									echo '<img src="'.$image['image'].'" alt="" width="30">';
								} ?>
							</div>
						</div>
					<?php } ?>
					<?php if(!empty($games)) { ?>
						<div class="game-provider-review-content">
							<h3><?php echo $games['text']; ?></h3>
							<div class="">
								<?php echo do_shortcode($games['value']); ?>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="releted-post">
					<h3><?php echo __( 'Related Articles', 'sigmaigaming' ); ?></h3>
					<?php echo do_shortcode('[sigma-mt-related-articles term_id = "'.$related_article_term.'" post_per_page = 10]'); ?>
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
    					<img src="https://www.sigma.com.mt/hubfs/6M%20Sigma%20Files/Magazine/Magazine%20covers/Sigma%2013%20for%20web-1.png" alt="magazine"/>
  					</a>
				</div>
				<div class="offers-wrapper">
					<div class="blog-sub-title">
						<h3>Casino Offers</h3>
					</div>
					<div class="offer-wrap">
						<div class="offer-item">
							<div class="img-wrap">
          						<img src="https://www.sigma.com.mt/hubfs/1xbet-1.png" alt="offer"/>
        					</div>
        					<div class="link-wrap">
        						<a class="play-btn" target="_blank" href="#">Play Now</a>
        						<a class="tnc-link" href="#">*T&amp;C Apply</a>
        					</div>
						</div>
						<div class="offer-item">
							<div class="img-wrap">
          						<img src="https://www.sigma.com.mt/hubfs/1xbet-1.png" alt="offer"/>
        					</div>
        					<div class="link-wrap">
        						<a class="play-btn" target="_blank" href="#">Play Now</a>
        						<a class="tnc-link" href="#">*T&amp;C Apply</a>
        					</div>
						</div>
						<div class="offer-item">
							<div class="img-wrap">
          						<img src="https://www.sigma.com.mt/hubfs/1xbet-1.png" alt="offer"/>
        					</div>
        					<div class="link-wrap">
        						<a class="play-btn" target="_blank" href="#">Play Now</a>
        						<a class="tnc-link" href="#">*T&amp;C Apply</a>
        					</div>
						</div>
						<div class="offer-item">
							<div class="img-wrap">
          						<img src="https://www.sigma.com.mt/hubfs/1xbet-1.png" alt="offer"/>
        					</div>
        					<div class="link-wrap">
        						<a class="play-btn" target="_blank" href="#">Play Now</a>
        						<a class="tnc-link" href="#">*T&amp;C Apply</a>
        					</div>
						</div>
						<div class="offer-item">
							<div class="img-wrap">
          						<img src="https://www.sigma.com.mt/hubfs/1xbet-1.png" alt="offer"/>
        					</div>
        					<div class="link-wrap">
        						<a class="play-btn" target="_blank" href="#">Play Now</a>
        						<a class="tnc-link" href="#">*T&amp;C Apply</a>
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
					<?php 
					if ( $the_query->have_posts() ) : ?>
						<?php 
						while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					 		<h4 style="margin-bottom: 0px;"> <a class="more-link" href="<?php echo get_permalink();?>"><?php the_title(); ?></a></h4>
							<div class="info">
						  		<div>
									<strong>
										<?php 
										$categories = wp_get_post_terms( get_the_ID(),array( 'news-cat' ) );?>
										<?php 
										foreach($categories as $c){ 
											$cat = get_category( $c );
										?>
										<a style="text-decoration: none;color:#e21735;" class="topic-link" href="<?php echo get_term_link($cat);?>"> <?php echo $cat->name; ?><span>,</span>
										</a>
										<?php }?>
							  		</strong> 
						  		</div>
							</div>    
					  	<?php endwhile; ?> 
					  	<?php wp_reset_postdata(); ?>
					<?php else : ?>
					<p><?php __('No News'); ?></p>
					<?php endif; ?>
				</div>
				<div class="after-movie bottom-border">
					<div class="blog-sub-title">
						<h3>SiGMA 2019 after-movie</h3>
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
					<?php 
					while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
						<div class="calendar-event ">
							<h5>SiGMA Europe (Malta)</h5> 
    						<div class="date">  November 16, 2021</div>
    					<div class="widget-type-rich-text">
     						<p>Following the UK's December 2020 release of the Pfizer BioNTech vaccine, SIGMA Group will move its April event to November. SIGMA Europe, which will be based...</p>
    					</div>
    					<a class="event-btn" href="#" target="_blank">REGISTER FREE</a>
					</div>
					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				</div>
			</div>
			<!-- Rightbar end -->
		</div>
	</div>
	<!-- News page main section end -->
</section>

<?php echo do_shortcode('[sigma-mt-newsletter]'); ?>

<?php get_footer(); ?>
