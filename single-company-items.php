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
$content = get_field('company_content', $post_id);
$migrated = get_field('fully_migrated', $post_id);
$key_metrics = get_field('key_metrics', $post_id);
$game_provider_review = get_field('game_provider_review', $post_id);
$certified_by = get_field('certified_by', $post_id);
$awards_won = get_field('awards_won', $post_id);
$games = get_field('games', $post_id);
?>

<section>
	<!-- News page main section start -->
	<div class="blog-content">
		<div class="page-container">
			<!-- Leftbar start -->
			<div class="blog-leftbar">
				<?php echo do_shortcode('[sigma_mt_show_sidebar elements="96567, 22553"]'); ?>
			</div>
			<!-- Leftbar end -->

			<!-- Middle Detail News start -->
			<div class="blog-details">
				<div class="featured-img">
					<?php echo '<img src="' . $thumbnail . '">'; ?>
				</div>
				<div class="post-body">
					<?php if(!$migrated){ ?>
					<div class="post-content">
						<?php echo $content; ?>
					</div>
					<?php } else { ?>
					<div class="post-content">
						<div class="SinglegamingWrapper">
							<div class="SinglegamingInnerWrapper">
								
								<div class="single-gaming-banner"></div>
								
								<div class="single-desc">
									<?php the_content(); ?>
								</div>
								
								<div class="Keymatricswraper">
									
									<h2 class="sectiontitle">Key Metrics</h2>
									
									<div class="lj_text">
										<p class="title"><?php echo __('Licences', 'sigmaigaming'); ?>:</p>
										<p class="detail">Malta Gaming Authority, Romanian National Gambling Office (ONJN), United Kingdom Gambling Commission</p>
									</div>
									
									<div class="km_content">
										<div class="left">
											<div class="gametypes">
												<p class="title">Platform Types:</p>
												<p class="gametypeitem selected detail">Licensed platform</p>
												<p class="gametypeitem selected detail">White Label provider</p>
											</div>
											
											<div class="gametypes">
												<p class="title">Platform Product:</p>
												<p class="gametypeitem detail">Casino platform provider</p>
												<p class="gametypeitem selected detail">Sportsbook provider</p>

											</div>
											<div class="gametypes">
												<p class="title">LANDBASED/RETAIL PLATFORM:</p>
												<p class="gametypeitem selected detail">Yes</p>
												<p class="gametypeitem detail">No</p>
											</div>
										</div>
										<div class="right">
											<div class="casino_qt">
												<p class="title">OPERATORS INTEGRATED:</p>
												<p class="qtyitem detail">0-10</p>
												<p class="qtyitem selected detail">10-50</p>
												<p class="qtyitem detail">&gt;50</p>
											</div>
											<div class="year_est">
												<p class="title">YEARS IN BUSINESS:</p>
												<p class="yearitem detail">&lt;2</p>
												<p class="yearitem detail">3-5</p>
												<p class="yearitem selected detail">6-10</p>
												<p class="yearitem detail">&gt;10</p>
											</div>
										</div>
									</div>
									
									<div class="km_content">
										<div class="left">
											<div class="gametypes">
												<p class="title">Services included in the platform:</p>
												<p class="gametypeitem selected detail">24/7 customer service</p>
												<p class="gametypeitem detail">CRM tool</p>
												<p class="gametypeitem selected detail">CRM service</p>
												<p class="gametypeitem selected detail">Payment gateway</p>
												<p class="gametypeitem selected detail">Anti-Fraud tools</p>
												<p class="gametypeitem detail">KYC services</p>
												<p class="gametypeitem detail">Affiliate Platform</p>
												<p class="gametypeitem selected detail">Licences (certifications)</p>
												<p class="gametypeitem detail">Marketing options (bonuses, jackpots cashbacks, free spins) Other</p>
												<p class="gametypeitem detail">Games aggregator as B2B</p>
												<p class="gametypeitem detail">Blockchain &amp; smart contract solution</p>
											</div>
										</div>
										<div class="right">
											<div class="gametypes">
												<p class="title">Types of bet:</p>
												<p class="gametypeitem selected detail">Sportsbook</p>
												<p class="gametypeitem selected detail">E-sports</p>
												<p class="gametypeitem selected detail">Virtual Sports</p>
												<p class="gametypeitem detail">Live Casino Games</p>
												<p class="gametypeitem detail">Dice Games</p>
												<p class="gametypeitem detail">Table games (Blackjack, Baccarat, Roulette, Poker)</p>
												<p class="gametypeitem detail">Keno,Lottery</p>
												<p class="gametypeitem detail">Video Poker</p>
												<p class="gametypeitem detail">Scratch card Games</p>
											</div>
										</div>
									</div>
									
								</div>
								
								<div class="latestawardWrap">
									<h2 class="sectiontitle">Awards Won</h2>
									<div class="awardcontent">
										<div class="awards-won-list slick-initialized slick-slider">
											<div class="slick-list draggable">
												<div class="slick-track" style="opacity: 1; width: 592px; transform: translate3d(0px, 0px, 0px);">
													<div class="slick-slide slick-current slick-active" style="width: 148px;" data-slick-index="0" aria-hidden="false">
														<div>
															<div class="award-won" style="width: 100%; display: inline-block;" data-order="Best Technology Provider of 2019 ">
																<img class="awardicon" src="https://www.sigma.com.mt/hubfs/6M%20Sigma%20Files/Game%20Provider%20awards/rootz-news-migea_uid_5fbe2cf44faa9.jpg" />
																<h4 class="awardtitle">Best Technology Provider of 2019</h4>
															</div>
														</div>
													</div>
													<div class="slick-slide slick-active" style="width: 148px;" data-slick-index="1" aria-hidden="false">
														<div>
															<div class="award-won" style="width: 100%; display: inline-block;" data-order="Rising Star in Sports Betting Tech 2019 ">
																<img class="awardicon" src="https://www.sigma.com.mt/hubfs/6M%20Sigma%20Files/Game%20Provider%20awards/the%20Baltic%20and%20Scandinavian%20Gaming%20Awards%20Logo.png" />
																<h4 class="awardtitle">Rising Star in Sports Betting Tech 2019</h4>
															</div>
														</div>
													</div>

													<div class="slick-slide slick-active" style="width: 148px;" data-slick-index="2" aria-hidden="false">
														<div>
															<div class="award-won" style="width: 100%; display: inline-block;" data-order="Rising Star in Sports Betting Tech 2019 ">
																<img class="awardicon" src="https://www.sigma.com.mt/hubfs/6M%20Sigma%20Files/Game%20Provider%20awards/147.jpg" />
																<h4 class="awardtitle">Rising Star in Sports Betting Tech 2019</h4>
															</div>
														</div>
													</div>
													<div class="slick-slide slick-active" style="width: 148px;" data-slick-index="3" aria-hidden="false">
														<div>
															<div class="award-won" style="width: 100%; display: inline-block;" data-order="Rising Star in Sports Betting Tech 2020 ">
																<img class="awardicon" src="https://www.sigma.com.mt/hubfs/6M%20Sigma%20Files/Game%20Provider%20awards/the%20Baltic%20and%20Scandinavian%20Gaming%20Awards%20Logo.png" />
																<h4 class="awardtitle">Rising Star in Sports Betting Tech 2020</h4>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="intrestedIn">
									Interested in Altenar?
									<a href="https://www.sigma.com.mt/en/contact/?hsLang=en">Contact</a> Maria <a href="mailto:maria.r@SiGMA.World"><img src="https://www.sigma.com.mt/hubfs/6M%20Sigma%20Files/Icons/mail.png" /></a> <a href="tel:+447718137711"><img src="https://www.sigma.com.mt/hubfs/6M%20Sigma%20Files/Icons/call.png" /></a> <a href="skype:live:65e02cd06ffacb1a"><img src="https://www.sigma.com.mt/hubfs/6M%20Sigma%20Files/Icons/skype-icon.png" /></a>

								</div>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
				<div class="releted-post">
					<br />
					<?php echo do_shortcode('[sigma-mt-related-articles term_name="'.get_the_title().'" post_per_page = 10]'); ?>
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
