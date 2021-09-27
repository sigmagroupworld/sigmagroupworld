<?php
/**
 * The template for displaying single post of company 
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since 1.0.0
 */

get_header();

$post_id = get_the_ID();
$thumbnail = get_field('single_thumbnail', $post_id);
$key_metrics = get_field('key_metrics', $post_id);
$platform_provider = get_field('platform_provider', $post_id);
$payment_provider = get_field('payment_provider', $post_id);
$game_provider = get_field('game_provider', $post_id);
$shared_fields = get_field('shared_fields', $post_id);

$color = isset($_GET['appearance']) ? $_GET['appearance'] : '';

?>

<section>
	<!-- News page main section start -->
	<div class="blog-content">
		<h1 style="padding: 34px 0 0;text-align: center;font-size: 24px;font-weight: 600;"><?php the_title(); ?></h1>
		<div class="page-container">
			<!-- Leftbar start -->
			<div class="blog-leftbar">
				<?php echo do_shortcode('[sigma_mt_show_sidebar elements="96567, 22553"]'); ?>
			</div>
			<!-- Leftbar end -->

			<!-- Middle Detail News start -->
			<div class="blog-details <?php echo $color; ?>">
				<div class="featured-img">
					<?php echo '<img src="' . $thumbnail . '">'; ?>
				</div>
				<div class="post-body">
					<div class="post-content">
						<div class="SinglegamingWrapper">
							<div class="SinglegamingInnerWrapper">
								
								<div class="single-desc">
									<?php the_content(); ?>
								</div>
								
								<div class="Keymatricswraper">
									
									<h2 class="sectiontitle"><?php echo __('Key Metrics', 'sigmaigaming'); ?></h2>
									
										
									<?php if(isset($payment_provider) && isset($payment_provider['type']) && !empty($payment_provider['type'])) { ?>
										<div class="key_choices">
											<?php 
											$arrayVal = array();
											$options = array('PSP', 'Aggregator', 'Acquire');
											foreach($payment_provider['type'] as $val) {
												$arrayVal[] = $val;
											}
											foreach($options as $val) {
												$class = ((in_array($val, $arrayVal)) ? ' selected' : '');
												echo '<div class="keyitem detail'.$class.'"><span>'.$val.'</span></div>';
											} ?>
										</div>
									<?php } ?>
										
									<?php if(isset($payment_provider) && isset($payment_provider['regions_served']) && $payment_provider['regions_served'] != '') { ?>
										<div class="keyabout">
											<p class="region">
												<span><?php echo __('Regions served', 'sigmaigaming'); ?>: </span><?php echo $payment_provider['regions_served']; ?>
											</p>
										 </div>
									<?php } ?>
									
									<?php if(isset($shared_fields) && isset($shared_fields['licences']) && $shared_fields['licences'] != '') { ?>
									<div class="lj_text">
										<p class="title"><?php echo __('Licences', 'sigmaigaming'); ?>:</p>
										<p class="detail"><?php echo $shared_fields['licences']; ?></p>
									</div>
									<?php } ?>
									
									<div class="km_content">
										
										<div class="left">
											
											<?php if(isset($game_provider) && isset($game_provider['number_of_games']) && !empty($game_provider['number_of_games'])) { ?>
											<div class="nogames">
												<p class="title"><?php echo __('Number of Games', 'sigmaigaming'); ?>:</p>
												<p class="detail"><?php echo $game_provider['number_of_games']; ?></p>
											</div>
											<?php } ?>
											
											<?php if(isset($game_provider) && isset($game_provider['game_types']) && !empty($game_provider['game_types'])) { ?>
											<div class="gametypes">
												<p class="title"><?php echo __('Game Types:', 'sigmaigaming'); ?></p>
												<?php 
												  $arrayVal = array();
												  $options = array('Slots', 'Live Casino Games', 'Dice Games', 'Table games (Blackjack, Baccarat, Roulette)', 'Keno, Lottery', 'Video Poker', 'Scratchcard Games', 'Branded Games', 'VR', 'Others');
												  foreach($game_provider['game_types'] as $val) {
													  $arrayVal[] = $val;
												  }
												  foreach($options as $val) {
													  $class = ((in_array($val, $arrayVal)) ? ' selected' : '');
													  echo '<p class="gametypeitem detail'.$class.'">'.$val.'</p>';
												  } ?>
											</div>
											<?php } ?>
											
											<?php if(isset($platform_provider) && isset($platform_provider['platform_types']) && !empty($platform_provider['platform_types'])) { ?>
											<div class="gametypes">
												<p class="title"><?php echo __('Platform Types:', 'sigmaigaming'); ?></p>
												<?php 
												  $arrayVal = array();
												  $options = array('Licensed platform', 'White Label provider');
												  foreach($platform_provider['platform_types'] as $val) {
													  $arrayVal[] = $val;
												  }
												  foreach($options as $val) {
													  $class = ((in_array($val, $arrayVal)) ? ' selected' : '');
													  echo '<p class="gametypeitem detail'.$class.'">'.$val.'</p>';
												  } ?>
											</div>
											<?php } ?>
											
											<?php if(isset($platform_provider) && isset($platform_provider['platform_product']) && !empty($platform_provider['platform_product'])) { ?>
											<div class="gametypes">
												<p class="title"><?php echo __('Platform Product:', 'sigmaigaming'); ?></p>
												<?php 
												  $arrayVal = array();
												  $options = array('Casino platform provider', 'Sportsbook provider');
												  foreach($platform_provider['platform_product'] as $val) {
													  $arrayVal[] = $val;
												  }
												  foreach($options as $val) {
													  $class = ((in_array($val, $arrayVal)) ? ' selected' : '');
													  echo '<p class="gametypeitem detail'.$class.'">'.$val.'</p>';
												  } ?>
											</div>
											<?php } ?>
											
											<?php if(isset($platform_provider) && isset($platform_provider['landbasedretail_platform']) && $platform_provider['landbasedretail_platform'] != '') { ?>
											<div class="gametypes">
												<p class="title"><?php echo __('Landbased / Retail Platform:', 'sigmaigaming'); ?></p>
												<?php 
												  $options = array('Yes', 'No');
												  foreach($options as $val) {
													  $class = ($platform_provider['landbasedretail_platform'] == $val ? ' selected' : '');
													  echo '<p class="gametypeitem detail'.$class.'">'.$val.'</p>';
												  } ?>
											</div>
											<?php } ?>
											<?php if(isset($platform_provider) && isset($platform_provider['service_included_in_the_platform']) && !empty($platform_provider['service_included_in_the_platform'])) { ?>
											<div class="gametypes">
												<p class="title"><?php echo __('Services included in the platform:', 'sigmaigaming'); ?></p>
												<?php 
												  $arrayVal = array();
												  $options = array('24/7 customer service', 'CRM tool', 'CRM service', 'Payment gateway', 'Anti-Fraud tools', 'KYC services', 'Affiliate Platform' ,'Licences (certifications)' ,'Marketing options (bonuses, jackpots cashbacks, free spins) Other', 'Games aggregator as B2B', 'Blockchain &amp; smart contract solution');
												  
												  foreach($platform_provider['service_included_in_the_platform'] as $val) {
													  $arrayVal[] = $val;
												  }
												  foreach($options as $val) {
													  $class = ((in_array($val, $arrayVal)) ? ' selected' : '');
													  echo '<p class="gametypeitem detail'.$class.'">'.$val.'</p>';
												  } ?>
											</div>
											<?php } ?>
											
											<?php if(isset($payment_provider) && isset($payment_provider['payment_methods_type']) && !empty($payment_provider['payment_methods_type'])) { ?>
											<div class="gametypes">
												<p class="title"><?php echo __('Payment Methods Type', 'sigmaigaming'); ?>:</p>
												<?php 
												  $arrayVal = array();
												  $options = array('Visa/Mastercard', 'E-wallets', 'Prepaid Cards and Vouchers', 'Direct Bank', 'Agents', 'Cash on delivery', 'Crypto', 'Mobile Payments');
												  foreach($payment_provider['payment_methods_type'] as $val) {
													  $arrayVal[] = $val;
												  }
												  foreach($options as $val) {
													  $class = ((in_array($val, $arrayVal)) ? ' selected' : '');
													  echo '<p class="gametypeitem detail'.$class.'">'.$val.'</p>';
												  } ?>
											</div>
											<?php } ?>
											
											<?php if(isset($payment_provider) && isset($payment_provider['payment_services']) && !empty($payment_provider['payment_services'])) { ?>
											<div class="gametypes">
												<p class="title"><?php echo __('Payment Services', 'sigmaigaming'); ?>:</p>
												<?php 
												  $arrayVal = array();
												  $options = array('Payment facilitator', 'Risk management', 'Fraud protection', 'Multi-currency processing', 'Retail');
												  foreach($payment_provider['payment_services'] as $val) {
													  $arrayVal[] = $val;
												  }
												  foreach($options as $val) {
													  $class = ((in_array($val, $arrayVal)) ? ' selected' : '');
													  echo '<p class="gametypeitem detail'.$class.'">'.$val.'</p>';
												  } ?>
											</div>
											<?php } ?>
										</div>
										<div class="right">

											<?php if(isset($shared_fields) && isset($shared_fields['operators_integrated']) && $shared_fields['operators_integrated'] != '') { ?>
											<div class="casino_qt">
												<p class="title"><?php echo __('Operators Integrated:', 'sigmaigaming'); ?></p>
												<?php 
												  $options = array('<10', '11-25', '26-50', '51-100', '>101');
												  foreach($options as $val) {
													  $class = ($shared_fields['operators_integrated'] == $val ? ' selected' : '');
													  echo '<p class="qtyitem detail'.$class.'">'.$val.'</p>';
												  } ?>
											</div>
											<?php } ?>
											<?php if(isset($shared_fields) && isset($shared_fields['years_in_business']) && $shared_fields['years_in_business'] != '') { ?>
											<div class="year_est">
												<p class="title"><?php echo __('Years in Business:', 'sigmaigaming'); ?></p>
												<?php 
												  $options = array('< 2', '3-5', '6-10', '>10');
												  foreach($options as $val) {
													  $class = ($shared_fields['years_in_business'] == $val ? ' selected' : '');
													  echo '<p class="qtyitem detail'.$class.'">'.$val.'</p>';
												  } ?>
											</div>
											<?php } ?>
											<?php if(isset($platform_provider) && isset($platform_provider['types_of_bet']) && $platform_provider['types_of_bet'] != '') { ?>
											<div class="year_est">
												<p class="title"><?php echo __('Types of Bet:', 'sigmaigaming'); ?></p>
												<?php 
												  $arrayVal = array();
												  $options = array('Sportsbook','E-sports','Virtual Sports','Live Casino Games','Dice Games','Table games (Blackjack, Baccarat, Roulette, Poker)','Keno,Lottery','Video Poker','Scratch card Games');
												  foreach($platform_provider['types_of_bet'] as $val) {
													  $arrayVal[] = $val;
												  }
												  foreach($options as $val) {
													  $class = ((in_array($val, $arrayVal)) ? ' selected' : '');
													  echo '<p class="qtyitem detail'.$class.'">'.$val.'</p>';
												  } ?>
											</div>
											<?php } ?>
										</div>
									</div>	
								</div>
								
								<?php if(isset($shared_fields) && isset($shared_fields['review_video_url']) && !empty($shared_fields['review_video_url'])) { ?>
								<div class="gameReviewwrapper">
								  <h2 class="sectiontitle">Game Provider Review</h2>
								  <div class="gameReviewContent">
									<iframe width="560" height="315" src="<?php echo $shared_fields['review_video_url']; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
								  </div>
								</div>
								<br />
								<?php } ?>
								
								<?php if(isset($shared_fields) && isset($shared_fields['certified_by']) && !empty($shared_fields['certified_by'])) { ?>
								<div class="certifiedWrap">
								  <h2 class="sectiontitle"><?php echo __('Certified By:', 'sigmaigaming'); ?></h2>
								  <div class="certifiedcontent">
									<p>
										<?php foreach($shared_fields['certified_by'] as $certified) { 
											$featured = wp_get_attachment_image_src( get_post_thumbnail_id( $certified ), 'full' );
											if(!empty($featured)){ ?>
												<img src="<?php echo $featured[0]; ?>" width="177" style="width: 177px;" sizes="(max-width: 177px) 100vw, 177px">&nbsp;
										<?php }
										} ?>
									</p>
								  </div>
								</div>
								<br />
								<?php } ?>
								
								<?php if(isset($shared_fields) && isset($shared_fields['awards_won']) && !empty($shared_fields['awards_won'])) { ?>
								<div class="latestawardWrap">
									<h2 class="sectiontitle"><?php echo __('Awards won:', 'sigmaigaming'); ?></h2>
									<div class="awardcontent">
										<div class="awards-won-list slick-initialized slick-slider">
											<div class="slick-list draggable">
												<div class="slick-track" style="opacity: 1; width: 592px; transform: translate3d(0px, 0px, 0px);">
													<?php foreach($shared_fields['awards_won'] as $award) { ?>
													<div class="slick-slide slick-current slick-active" style="width: 148px;" data-slick-index="0" aria-hidden="false">
														<div>
															<div class="award-won" style="width: 100%; display: inline-block;" data-order="<?php echo $award['award_name']; ?>">
																<img class="awardicon" src="<?php echo $award['award_logo']; ?>" />
																<h4 class="awardtitle"><?php echo $award['award_name']; ?></h4>
															</div>
														</div>
													</div>
													<?php }?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<br />
								<?php }
								if(isset($game_provider) && isset($game_provider['select_games'])){
									$games = $game_provider['select_games'];
									if ($color != 'purple') {
										if (isset($games) && !empty($games)) { ?>
											<div class="gamesWrap">
												<h2 class="sectiontitle">GAMES</h2>
												<div class="gamescontent">
													<div class="gameswrap load-more-items">
														<?php foreach ($games as $game) { ?>
															<div class="games on-page show-item">
																<div class="gamesinner">
																	<a target="_blank"
																	   href="<?php echo get_the_permalink($game->ID); ?>">
																		<img class="gameimg"
																			 src="<?php echo get_the_post_thumbnail_url($game->ID); ?>"/>
																		<h4 class="gamelink">Play Now</h4>
																	</a>
																</div>
															</div>
														<?php } ?>
													</div>
												</div>
											</div>
											<br/>
										<?php }
									}
								}?>
								
								<?php if(isset($shared_fields)) { ?>
								<div class="intrestedIn">
									<?php echo __('Interested in', 'sigmaigaming'); ?><?php echo ' ' . get_the_title($post_id); ?>?<br />
									<a href="https://www.sigma.world/contact">Contact</a> <?php echo $shared_fields['contact_person']; ?> 
									<?php if(isset($shared_fields['email']) && $shared_fields['email'] != '') { ?>
										&nbsp;<a href="mailto:<?php echo $shared_fields['email']; ?>"><img src="/fileadmin/mail.png" /></a>
									<?php } ?>
									<?php if(isset($shared_fields['phone']) && $shared_fields['phone'] != '') { ?>
										&nbsp;<a href="tel:<?php echo $shared_fields['phone']; ?>"><img src="/fileadmin//call.png" /></a>
									<?php if(isset($shared_fields['skype']) && $shared_fields['skype'] != '') { ?>
									<?php } ?>
										&nbsp;<a href="skype:<?php echo $shared_fields['skype']; ?>"><img src="/fileadmin//skype-icon.png" /></a>
									<?php } ?>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="releted-post">
						<br />
						<?php echo do_shortcode('[sigma-mt-related-articles term_name="'.get_the_title().'" post_per_page = 10]'); ?>
					</div>
				</div>
			</div>
			<!-- Middle Detail News end -->

			<!-- Rightbar start -->
			<div class="blog-rightbar">
				<?php echo do_shortcode('[sigma_mt_show_sidebar elements="22579, 22586, 22549, 22583"]'); ?>
			</div>
			<!-- Rightbar end -->
		</div>
	</div>
	<!-- News page main section end -->
</section>

<?php echo do_shortcode('[sigma-mt-newsletter]'); ?>

<?php get_footer(); ?>