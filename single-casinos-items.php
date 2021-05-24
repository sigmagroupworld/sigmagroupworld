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
$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' ); 
$image_id = get_image_id_by_url($featured_image);
$image_info = wp_get_attachment_metadata($image_id);
$image_title = get_the_title($image_id);
$casino_provider = get_field('casino_details', $post_id);
?>

<section class="single-casino-page">
	<div class="container">
		<div class="single-casino-banner">
	    	<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $image_title; ?>">
	    </div>
	    <div class="casino-detail">
	    	<div class="tab">
  				<button class="tablinks active review" onclick="opendetails(event, 'casino-review')">
  					CASINO REVIEW
  				</button>
  				<button class="tablinks details" onclick="opendetails(event, 'casino-details')">
  					casino details
  				</button>
			</div>
			<div class="casino-all">
				<div class="casino-tab-details">
					<div id="casino-review" class="tabcontent" style="display: block;">
		  				<?php the_content(); ?>
					</div>
					<div id="casino-details" class="tabcontent">
						<?php #echo '<pre>'; print_r($casino_provider); ?>
		  				<div class="every-casino-detail">
		  					<div class="casino-title licences">
		  						<h2>Licences</h2>
		  					</div>
		  					<div class="every-detail">
		  						<p><?php if(isset($casino_provider['licences'])) { echo $casino_provider['licences']; } ?></p>
		  					</div>
		  				</div>
		  				<div class="every-casino-detail">
		  					<div class="casino-title countries">
		  						<h2>Restricted Countries</h2>
		  					</div>
		  					<div class="every-detail">
		  						<p><?php if(isset($casino_provider['restricted_countries'])) { echo $casino_provider['restricted_countries']; } ?></p>
		  					</div>
		  				</div>
		  				<div class="every-casino-detail">
		  					<div class="casino-title d-method">
		  						<h2>Deposit Methods</h2>
		  					</div>
		  					<div class="every-detail">
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
										    $ecopayz = __( 'Ecopayz', 'sigmaigaming' );
											?>
											<div class="method-single-img">
												<?php if($value === $visa) echo '<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/VISA-new-logo.png">'; ?>
												<?php if($value === $mastercard) echo '<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/Payments%20Logo/Maestro-1.jpg">'; ?>
												<?php if($value === $neteller) echo '<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/Neteller.jpg">'; ?>
												<?php if($value === $skrill) echo '<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/Skrill%20.jpg">'; ?>
											</div>
									<?php }
									} ?>
		  						</div>
		  					</div>
		  				</div>
		  				<div class="every-casino-detail">
		  					<div class="casino-title d-method">
		  						<h2>Withdrawal Methods</h2>
		  					</div>
		  					<div class="every-detail">
		  						<div class="method-all-imgs">
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
												<?php if($value === $visa) echo '<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/VISA-new-logo.png">'; ?>
												<?php if($value === $mastercard) echo '<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/Payments%20Logo/Maestro-1.jpg">'; ?>
												<?php if($value === $neteller) echo '<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/Neteller.jpg">'; ?>
												<?php if($value === $skrill) echo '<img src="https://www.sigma.com.mt/hubfs/Online%20Casino%20Provider/cards/Skrill%20.jpg">'; ?>
											</div>
									<?php }
									} ?>
		  						</div>
		  					</div>
		  				</div>
		  				<div class="every-casino-detail">
		  					<div class="casino-title limits">
		  						<h2>Withdrawal Limit</h2>
		  					</div>
		  					<div class="every-detail">
		  						<p><?php if(isset($casino_provider['withdrawal_limit'])) { 
		  								echo $casino_provider['withdrawal_limit']; 
		  							} else {
		  								_e( 'No Limits', 'sigmaigaming' );
		  							} ?></p>
		  					</div>
		  				</div>
		  				<div class="every-casino-detail">
		  					<div class="casino-title limits">
		  						<h2>Casino Games</h2>
		  					</div>
		  					<div class="every-detail">
		  						<?php if(isset($casino_provider['casino_games'])) { 
									foreach($casino_provider['casino_games'] as $value) { ?>
										<div class="method-single-img">
											<?php echo  $value; ?>
										</div>
								<?php }
								} ?>
		  					</div>
		  				</div>
					</div>
				</div>
			</div>
	    </div>
	    <div class="tab-bottom-links">
	    	<div class="left">
	    		<a href="javascript:void(0)" onclick="goBack()">Back</a>
	    	</div>
	    	<div class="left">
	    		<a href="<?php if(isset($casino_provider['play_link'])) { echo $casino_provider['play_link']; } ?>" target="_blank">Play</a>
	    	</div>
	    </div>
	</div>
</section>

<script type="text/javascript">
	/** Casino Provider Details Tab ***/
	function opendetails(evt, cityName) {
		var i, tabcontent, tablinks;
	  	tabcontent = document.getElementsByClassName("tabcontent");
	  	for (i = 0; i < tabcontent.length; i++) {
	    	tabcontent[i].style.display = "none";
	  	}
	  	tablinks = document.getElementsByClassName("tablinks");
	  	for (i = 0; i < tablinks.length; i++) {
	    	tablinks[i].className = tablinks[i].className.replace(" active", "");
	  	}
	  	document.getElementById(cityName).style.display = "block";
	  	evt.currentTarget.className += " active";
	}
	function goBack() {
		window.history.back();
	}
	/** Casino Provider Details Tab ***/
</script>

<?php get_footer(); ?>
