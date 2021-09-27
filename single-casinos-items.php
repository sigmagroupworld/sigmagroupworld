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
$review = get_field('review_content', $post_id);
$detail = get_field('detail_content', $post_id);
$casino_provider = get_field('casino_details', $post_id);
$migrated = get_field('fully_migrated', $post_id);
$thumbnail = $casino_provider['casino_logo'];
?>

<section class="single-casino-page">
		<h1 style="padding: 34px 0 ;text-align: center;font-size: 24px;font-weight: 600;"><?php the_title(); ?></h1>
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
												foreach($casino_provider['deposit_methods'] as $value) { ?>
													<div class="method-single-img">
														<?php echo '<img src="/fileadmin/providers/'.$value.'.png">'; ?>
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
											foreach($casino_provider['withdrawal_methods'] as $value) { ?>
										<div class="method-single-img">
											<?php echo '<img src="/fileadmin/providers/'.$value.'.png">'; ?>
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
								$slots = 'Slots';
								$roulette = 'Roulette';
								$blackjack = 'BlackJack';
								$sports_betting = 'Sports Betting';
								$videopoker = 'Video Poker';
								$bingo = 'Bingo';
								$baccarat = 'Baccarat';
								$jackpot_games = 'Jackpot Games';
								$live_games ='Live Games';
								$poker = 'Poker';
								$craps = 'Craps';
								$keno = 'Keno';
								$scratch_cards = 'Scratch Cards';
								$e_sports = 'eSports betting';
								if(!empty($casino_provider['casino_games'])){
							?>
							<div class="casino_type detailblk">
								<div class="title"><?php echo __('Casino Games', 'sigmaigaming'); ?></div>
								<div class="content">
									<ul>
										<li class="keyitem <?php if(in_array($slots, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php if(!in_array($slots, $casino_provider['casino_games'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $slots; ?><img src="/fileadmin/games/slot-machine.png" /></a></li>
										<li class="keyitem <?php if(in_array($roulette, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php if(!in_array($roulette, $casino_provider['casino_games'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $roulette; ?><img src="/fileadmin/games/roulette.png" /></a></li>
										<li class="keyitem <?php if(in_array($blackjack, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php if(!in_array($blackjack, $casino_provider['casino_games'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $blackjack; ?><img src="/fileadmin/games/black-jack.png" /></a></li>
										<li class="keyitem <?php if(in_array($sports_betting, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php if(!in_array($sports_betting, $casino_provider['casino_games'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $sports_betting; ?><img src="/fileadmin/games/sport-betting.png" /></a></li>
										<li class="keyitem <?php if(in_array($videopoker, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php if(!in_array($videopoker, $casino_provider['casino_games'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $videopoker; ?><img src="/fileadmin/games/online-betting.png" /></a></li>
										<li class="keyitem <?php if(in_array($bingo, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php if(!in_array($bingo, $casino_provider['casino_games'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $bingo; ?><img src="/fileadmin/games/bingo.png" /></a></li>
										<li class="keyitem <?php if(in_array($baccarat, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php if(!in_array($baccarat, $casino_provider['casino_games'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $baccarat; ?><img src="/fileadmin/games/baccarat.png" /></a></li>
										<li class="keyitem <?php if(in_array($jackpot_games, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php if(!in_array($jackpot_games, $casino_provider['casino_games'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $jackpot_games; ?> Games<img src="/fileadmin/games/jackpot-games.png" /></a></li>
										<li class="keyitem <?php if(in_array($live_games, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php if(!in_array($live_games, $casino_provider['casino_games'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $live_games; ?><img src="/fileadmin/games/live-games.png" /></a></li>
										<li class="keyitem <?php if(in_array($poker, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php if(!in_array($poker, $casino_provider['casino_games'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $poker; ?><img src="/fileadmin/games/live-games.png" /></a></li>
										<li class="keyitem <?php if(in_array($craps, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php if(!in_array($craps, $casino_provider['casino_games'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $craps; ?><img src="/fileadmin/games/keno.png" /></a></li>
										<li class="keyitem <?php if(in_array($keno, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php if(!in_array($keno, $casino_provider['casino_games'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $keno; ?><img src="/fileadmin/games/keno.png" /></a></li>
										<li class="keyitem <?php if(in_array($scratch_cards, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php if(!in_array($scratch_cards, $casino_provider['casino_games'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $scratch_cards; ?><img src="/fileadmin/games/scratch-card.png" /></a></li>
										<li class="keyitem <?php if(in_array($e_sports, $casino_provider['casino_games'])) {echo "selected";} ?>"><a><?php if(!in_array($e_sports, $casino_provider['casino_games'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $e_sports; ?><img src="/fileadmin/games/esport-betting.png" /></a></li>
									</ul>
								</div>
							</div>
							<?php } ?>
							
							<?php 
								$football = 'Football';
								$basketball = 'Basketball';
								$volleyball = 'VolleyBall / Handball';
								$tennis = 'Racket sports(tennis,etc...)';
								$boxing = 'Boxing/MMA';
								$icehockey = 'Ice Hockey';
								$cricket = 'Cricket';
								$cycling = 'Cycling';
								$darts  ='Darts';
								$rugby = 'Rugby';
								$golf = 'Golf';
								$horse = 'Horse Riding';
								$formulaone  ='Formula 1';
								$ufc = 'UFC/Martial Arts';
								$esports = 'Esports';
								$virtual  ='Virtual Sports';
								if(!empty($casino_provider['sport_types'])){
							?>
							<div class="casino_type detailblk">
								<div class="title"><?php echo __('Sport Type', 'sigmaigaming'); ?></div>
								<div class="content">
									<ul>
										<li class="keyitem <?php if(in_array($football, $casino_provider['sport_types'])) {echo "selected";} ?>"><a><?php if(!in_array($football, $casino_provider['sport_types'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $football; ?><img src="/fileadmin/sports/Football.svg" /></a></li>
										<li class="keyitem <?php if(in_array($basketball, $casino_provider['sport_types'])) {echo "selected";} ?>"><a><?php if(!in_array($basketball, $casino_provider['sport_types'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $basketball; ?><img src="/fileadmin/sports/Basketball.svg" /></a></li>
										<li class="keyitem <?php if(in_array($volleyball, $casino_provider['sport_types'])) {echo "selected";} ?>"><a><?php if(!in_array($volleyball, $casino_provider['sport_types'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $volleyball; ?><img src="/fileadmin/sports/Volley.svg" /></a></li>
										<li class="keyitem <?php if(in_array($tennis, $casino_provider['sport_types'])) {echo "selected";} ?>"><a><?php if(!in_array($tennis, $casino_provider['sport_types'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $tennis; ?><img src="/fileadmin/sports/Racket.svg" /></a></li>
										<li class="keyitem <?php if(in_array($boxing, $casino_provider['sport_types'])) {echo "selected";} ?>"><a><?php if(!in_array($boxing, $casino_provider['sport_types'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $boxing; ?><img src="/fileadmin/sports/Boxing.svg" /></a></li>
										<li class="keyitem <?php if(in_array($icehockey, $casino_provider['sport_types'])) {echo "selected";} ?>"><a><?php if(!in_array($icehockey, $casino_provider['sport_types'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $icehockey; ?><img src="/fileadmin/sports/IceHockey.svg" /></a></li>
										<li class="keyitem <?php if(in_array($cricket, $casino_provider['sport_types'])) {echo "selected";} ?>"><a><?php if(!in_array($cricket, $casino_provider['sport_types'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $cricket; ?><img src="/fileadmin/sports/Cricket.svg" /></a></li>
										<li class="keyitem <?php if(in_array($cycling, $casino_provider['sport_types'])) {echo "selected";} ?>"><a><?php if(!in_array($cycling, $casino_provider['sport_types'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $cycling; ?><img src="/fileadmin/sports/Cycling.svg" /></a></li>										
										<li class="keyitem <?php if(in_array($darts, $casino_provider['sport_types'])) {echo "selected";} ?>"><a><?php if(!in_array($darts, $casino_provider['sport_types'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $darts; ?><img src="/fileadmin/sports/Darts.svg" /></a></li>
										<li class="keyitem <?php if(in_array($rugby, $casino_provider['sport_types'])) {echo "selected";} ?>"><a><?php if(!in_array($rugby, $casino_provider['sport_types'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $rugby; ?><img src="/fileadmin/sports/Rugby.svg" /></a></li>										
										<li class="keyitem <?php if(in_array($golf, $casino_provider['sport_types'])) {echo "selected";} ?>"><a><?php if(!in_array($golf, $casino_provider['sport_types'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $golf; ?><img src="/fileadmin/sports/Golf.svg" /></a></li>
										<li class="keyitem <?php if(in_array($horse, $casino_provider['sport_types'])) {echo "selected";} ?>"><a><?php if(!in_array($horse, $casino_provider['sport_types'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $horse; ?><img src="/fileadmin/sports/HorseRiding.svg" /></a></li>										
										<li class="keyitem <?php if(in_array($formulaone, $casino_provider['sport_types'])) {echo "selected";} ?>"><a><?php if(!in_array($formulaone, $casino_provider['sport_types'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $formulaone; ?><img src="/fileadmin/sports/Formula1.svg" /></a></li>
										<li class="keyitem <?php if(in_array($ufc, $casino_provider['sport_types'])) {echo "selected";} ?>"><a><?php if(!in_array($ufc, $casino_provider['sport_types'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $ufc; ?><img src="/fileadmin/sports/UFC.svg" /></a></li>
										
										<li class="keyitem <?php if(in_array($esports, $casino_provider['sport_types'])) {echo "selected";} ?>"><a><?php if(!in_array($esports, $casino_provider['sport_types'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $esports; ?><img src="/fileadmin/sports/Esports.svg" /></a></li>
										<li class="keyitem <?php if(in_array($virtual, $casino_provider['sport_types'])) {echo "selected";} ?>"><a><?php if(!in_array($virtual, $casino_provider['sport_types'])) {echo __('No ', 'sigmaigaming');}  ?><?php echo $virtual; ?><img src="/fileadmin/sports/VirtualSports.svg" /></a></li>
									</ul>
								</div>
							</div>
							<?php } ?>
							
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