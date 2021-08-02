<?php
/**
 * The template for displaying single post of casino 
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since 1.0.0
 */

get_header();

// get the current casino post
$post_id = get_the_ID();
$thumbnail = get_field('review_thumbnail', $post_id);
$review = get_field('review_content', $post_id);
$detail = get_field('detail_content', $post_id);
$casino_provider = get_field('casino_details', $post_id);
$migrated = get_field('fully_migrated', $post_id);
?>

<section class="single-casino-page">
	<div class="container">
		<div class="single-casino-banner">
	    	<img src="<?php echo $thumbnail; ?>">
	    </div>
	    <div class="casino-detail">
	    	<div class="tab">
  				<button class="tablinks active review" onclick="opendetails(event, 'casino-review')">
  					<?php (get_the_terms( $post_id, 'casinos-cat' )[0]->name  == 'Casino' ? _e( 'Casino Review', 'sigmaigaming' ) :  _e( 'Sports Betting Site Review', 'sigmaigaming' )); ?>
  				</button>
  				<button class="tablinks details" onclick="opendetails(event, 'casino-details')">
  					<?php (get_the_terms( $post_id, 'casinos-cat' )[0]->name == 'Casino' ? _e( 'Casino Details', 'sigmaigaming' ) :  _e( 'Sports Betting Site Details', 'sigmaigaming' )); ?>
  				</button>
			</div>
			<div class="casino-all">
				<div class="casino-tab-details">
					<div id="casino-review" class="tabcontent" style="display: block;">
						<?php echo $review; ?>
					</div>
					<div id="casino-details" class="tabcontent">
						<?php 
						if(!$migrated){
							echo $detail; 
						} else { ?> 
						
						<div class="detailcontent casinotab">
							<?php if(isset($casino_provider['licences'])) { ?>
							<div class="casino_licences detailblk">
								<div class="title"><?php echo __('Licences', 'sigmaigaming'); ?></div>
								<div class="content">
									<h4><?php echo $casino_provider['licences']; ?></h4>
								</div>
							</div>
							<?php } ?>
							
							<?php if(isset($casino_provider['restricted_countries'])) { ?>
							<div class="casino_players detailblk">
								<div class="title"><?php echo __('Restricted Countries', 'sigmaigaming'); ?></div>
								<div class="content">
									<div class="innerplayer">
										<?php echo $casino_provider['restricted_countries']; ?>
									</div>
								</div>
							</div>
							<?php } ?>
							
							<div class="casino_deposite detailblk">
								<div class="title"><?php echo __('Deposit Methods', 'sigmaigaming'); ?></div>
								<div class="content">
									<div class="innermethod">
										<div class="method-all-imgs">
											<?php if(isset($casino_provider['deposit_methods'])) {
												foreach($casino_provider['deposit_methods'] as $value) {
													$visa = __( 'Visa', 'sigmaigaming' );
													$mastercard = __( 'Mastercard', 'sigmaigaming' );
													$neteller =__( 'Neteller', 'sigmaigaming' );
													$skrill = __( 'Skrill', 'sigmaigaming' );
													$mestrocard = __( 'Mestrocard', 'sigmaigaming' );
													$paypal = __( 'Paypal', 'sigmaigaming' );
													$bitcoin =__( 'Bitcoin', 'sigmaigaming' );
													$ecopays = __( 'Ecopays', 'sigmaigaming' );
													$entropay = __( 'Entropay', 'sigmaigaming' );
													$webpay =__( 'Webpay', 'sigmaigaming' );
													$epay = __( 'Epay', 'sigmaigaming' );
													$trustpay =__( 'Trustpay', 'sigmaigaming' );
													$payeer = __( 'Payeer', 'sigmaigaming' );
													?>
													<div class="method-single-img">
														<?php if($value === $visa) echo '<img src="'. CHILD_DIR . '/online-casinos/images/VISA-new-logo.png">'; ?>
														<?php if($value === $mastercard) echo '<img src="'. CHILD_DIR . '/online-casinos/images/mastercard.png">'; ?>
														<?php if($value === $neteller) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Neteller.png">'; ?>
														<?php if($value === $payeer) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Payeer.png">'; ?>
														<?php if($value === $bitcoin) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Bitcoin.png">'; ?>
														<?php if($value === $ecopays) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Ecopayz.png">'; ?>
														<?php if($value === $webpay) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Webpay logo.png">'; ?>
														<?php if($value === $epay) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Epay logo.png">'; ?>
													</div>
											<?php }
											} ?>
										</div>
									</div>
								</div>
							</div>
							
							<div class="casino_withdraw_method detailblk">
								<div class="title"><?php echo __('Withdrawal Methods', 'sigmaigaming'); ?></div>
								<div class="content">
									<div class="innermethod">
										<?php if(isset($casino_provider['withdrawal_methods'])) { 
											foreach($casino_provider['withdrawal_methods'] as $value) {
												$visa = __( 'Visa', 'sigmaigaming' );
												$mastercard = __( 'Mastercard', 'sigmaigaming' );
												$neteller =__( 'Neteller', 'sigmaigaming' );
												$skrill = __( 'Skrill', 'sigmaigaming' );
												$mestrocard = __( 'Mestrocard', 'sigmaigaming' );
												$paypal = __( 'Paypal', 'sigmaigaming' );
												$bitcoin =__( 'Bitcoin', 'sigmaigaming' );
												$ecopayz = __( 'Ecopayz', 'sigmaigaming' );
												?>
												<div class="method-single-img">
													<?php if($value === $visa) echo '<img src="'. CHILD_DIR . '/online-casinos/images/VISA-new-logo.png">'; ?>
													<?php if($value === $mastercard) echo '<img src="'. CHILD_DIR . '/online-casinos/images/mastercard.png">'; ?>
													<?php if($value === $neteller) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Neteller.png">'; ?>
													<?php if($value === $payeer) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Payeer.png">'; ?>
													<?php if($value === $bitcoin) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Bitcoin.png">'; ?>
													<?php if($value === $ecopays) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Ecopayz.png">'; ?>
													<?php if($value === $webpay) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Webpay logo.png">'; ?>
													<?php if($value === $epay) echo '<img src="'. CHILD_DIR . '/online-casinos/images/Epay logo.png">'; ?>
												</div>
										<?php }
										} ?>
									</div>
								</div>
							</div>
							
							<div class="casino_withdraw_limit detailblk">
								<div class="title"><?php echo __('Withdrawal Limit', 'sigmaigaming'); ?></div>
								<div class="content">
									<h4><?php if(isset($casino_provider['withdrawal_limit'])) { 
											echo $casino_provider['withdrawal_limit']; 
										} else {
											__( 'No Limits', 'sigmaigaming' );
										} ?></h4>
								</div>
							</div>
							<?php 
								$slots = __( 'Slots', 'sigmaigaming' );
								$roulette = __( 'Roulette', 'sigmaigaming' );
								$blackjack = __( 'Black Jack', 'sigmaigaming' );
								$no_sports_betting = __( 'No Sports betting', 'sigmaigaming' );
								$videopoker = __( 'Video Poker', 'sigmaigaming' );
								$bingo = __( 'Bingo', 'sigmaigaming' );
								$baccarat = __( 'Baccarat', 'sigmaigaming' );
								$jackpot_games = __( 'Jackpot Games', 'sigmaigaming' );
								$live_games =__( 'Live Games', 'sigmaigaming' );
								$no_poker = __( 'No Poker', 'sigmaigaming' );
								$craps = __( 'Craps', 'sigmaigaming' );
								$keno = __( 'Keno', 'sigmaigaming' );
								$scratch_cards = __( 'Scratch Cards', 'sigmaigaming' );
								$no_e_sports = __( 'No eSports betting', 'sigmaigaming' );
							?>
							<div class="casino_type detailblk">
								<div class="title"><?php echo __('Casino Games', 'sigmaigaming'); ?></div>
								<div class="content">
									<ul>
										<li class="keyitem <?php if(in_array($slots, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php echo $slots; ?><img src="<?php echo CHILD_DIR; ?>/online-casinos/images/slot-machine.png" /></a></li>
										<li class="keyitem <?php if(in_array($roulette, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php echo $roulette; ?><img src="<?php echo CHILD_DIR; ?>/online-casinos/images/roulette.png" /></a></li>
										<li class="keyitem <?php if(in_array($blackjack, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php echo $blackjack; ?><img src="<?php echo CHILD_DIR; ?>/online-casinos/images/black-jack.png" /></a></li>
										<li class="keyitem <?php if(in_array($no_sports_betting, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php echo $no_sports_betting; ?><img src="<?php echo CHILD_DIR; ?>/online-casinos/images/sport-betting.png" /></a></li>
										<li class="keyitem <?php if(in_array($videopoker, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php echo $videopoker; ?><img src="<?php echo CHILD_DIR; ?>/online-casinos/images/online-betting.png" /></a></li>
										<li class="keyitem <?php if(in_array($bingo, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php echo $bingo; ?><img src="<?php echo CHILD_DIR; ?>/online-casinos/images/bingo.png" /></a></li>
										<li class="keyitem <?php if(in_array($baccarat, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php echo $baccarat; ?><img src="<?php echo CHILD_DIR; ?>/online-casinos/images/baccarat.png" /></a></li>
										<li class="keyitem <?php if(in_array($jackpot_games, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php echo $jackpot_games; ?> Games<img src="<?php echo CHILD_DIR; ?>/online-casinos/images/jackpot-games.png" /></a></li>
										<li class="keyitem <?php if(in_array($live_games, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php echo $live_games; ?><img src="<?php echo CHILD_DIR; ?>/online-casinos/images/live-games.png" /></a></li>
										<li class="keyitem <?php if(in_array($no_poker, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php echo $no_poker; ?><img src="<?php echo CHILD_DIR; ?>/online-casinos/images/live-games.png" /></a></li>
										<li class="keyitem <?php if(in_array($craps, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php echo $craps; ?><img src="<?php echo CHILD_DIR; ?>/online-casinos/images/keno.png" /></a></li>
										<li class="keyitem <?php if(in_array($keno, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php echo $keno; ?><img src="<?php echo CHILD_DIR; ?>/online-casinos/images/keno.png" /></a></li>
										<li class="keyitem <?php if(in_array($scratch_cards, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php echo $scratch_cards; ?><img src="<?php echo CHILD_DIR; ?>/online-casinos/images/scratch-card.png" /></a></li>
										<li class="keyitem <?php if(in_array($no_e_sports, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php echo $no_e_sports; ?><img src="<?php echo CHILD_DIR; ?>/online-casinos/images/esport-betting.png" /></a></li>
									</ul>
								</div>
							</div>
							
							<?php if(isset($casino_provider['software_providers'])) { ?>
							<div class="casino_software detailblk">
								<div class="title"><?php echo __('Software Providers', 'sigmaigaming'); ?></div>
								<div class="content">
									<?php 
										echo $casino_provider['software_providers'];
									?>
								</div>
							</div>
							<?php } ?>
								
						</div>
						
							
						<?php } ?>
					</div>
				</div>
			</div>
			<!-- Related Article Section -->
			<div class="casino related-articles">
				<?php echo do_shortcode('[sigma-mt-related-articles term_name="'.get_the_title().'" post_per_page = 10]'); ?>
			</div>
		    <!-- Related Article Section end -->
		    <div class="tab-bottom-links">
		    	<div class="left">
		    		<a href="<?php echo SITE_URL . '/online-casinos'; ?>" onclick="goBack()"><?php _e( 'Back', 'sigmaigaming' ); ?></a>
		    	</div>
		    	<div class="left">
		    		<a href="<?php if(isset($casino_provider['play_link'])) { echo $casino_provider['play_link']; } ?>" target="_blank"><?php _e( 'Play', 'sigmaigaming' ); ?></a>
		    	</div>
		    </div>
	    </div>
	</div>
</section>

<?php get_footer(); ?>