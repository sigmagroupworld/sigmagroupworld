<?php
/**
 * The template for displaying single post of media partner 
 *
 * Template Name: SigmaMT Single Media Partner Layout
 * Template Post Type: company-items
 */

get_header();

$post_id = get_the_ID();
$featured = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

?>

<style>
.relatedmps {
	display: flex;
	flex-wrap: wrap;
	position: relative
}

.relatedpartner {
	display: flex;
	align-items: center;
	flex-direction: column;
	flex-basis: 31%;
	margin: 0 3.5% 3.5% 0;
	border: 1px solid #c4c4c4;
	background-color: #fff;
	border-radius: 15px;
	transition: .3s all;
	position: relative
}

.relatedpartner:nth-child(3n+3) {
	margin-right: 0
}

.relatedinnerpartner {
	text-align: center;
	padding: 25px 20px
}

.mp-logo img {
	min-height: 160px;
	object-fit: cover;
	object-position: left
}

.relatedinnerpartner .btn {
	-webkit-border-radius: 100%;
	-moz-border-radius: 100%;
	border-radius: 100%;
	width: 35px;
	height: 35px;
	background-color: #fcd72a;
	position: absolute;
	bottom: 30px;
	right: -17px;
	cursor: pointer
}

.relatedinnerpartner .btn>div {
	position: relative;
	-webkit-transition: .3s all;
	-o-transition: .3s all;
	-moz-transition: .3s all;
	transition: .3s all;
	width: 35px;
	height: 35px;
	-webkit-border-radius: 100%;
	-moz-border-radius: 100%;
	border-radius: 100%
}

.relatedinnerpartner .btn>div::before,
.relatedinnerpartner .btn>div::after {
	content: '';
	display: block;
	width: 20px;
	height: 2px;
	background-color: #fff;
	position: absolute;
	top: 16px;
	left: 8px
}

.relatedinnerpartner .btn>div::after {
	-webkit-transform: rotate(90deg);
	-moz-transform: rotate(90deg);
	-ms-transform: rotate(90deg);
	-o-transform: rotate(90deg);
	transform: rotate(90deg)
}

.mediapartnerTitle {
	margin: 20px auto;
	text-align: center
}

.mediapartnerTitle h2 {
	background: #ed1a3b;
	color: #fff;
	text-transform: uppercase;
	font-size: 26px;
	line-height: 28px;
	padding: 15px;
	width: 75%;
	margin: 0 auto
}

.partnercontent {
	margin: 20px auto;
	width: 60%
}

.partnerlogo {
	text-align: center;
	margin: 0 0 15px 0
}

.partnerlogo img {
	max-width: 380px;
	max-height: 250px
}

.partnerDesc {
	margin-bottom: 15px;
	font-size: 14px;
	line-height: 18px;
	color: #000;
	font-family: 'Montserrat';
	font-weight: 400
}

.partnerDesc a {
	color: #ed1a3b
}

.RelatedPartners {
	margin: 30px 0
}

.relatedtitle {
	margin: 0 0 25px 0
}

.relatedtitle h2 {
	padding: 0 0 10px 0;
	border: 0;
	border-bottom: 1px solid #fcd72a;
	margin: 0;
	font-size: 26px;
	color: #ed1a3b;
	text-transform: uppercase
}

.relatedname h4 {
	font-family: 'Montserrat';
	font-weight: 600;
	font-size: 16px;
	margin: 10px auto 0 auto;
	color: #000
}

.mp-logo a {
	cursor: pointer;
	display: inline-block
}

.relatedabout p {
	font-family: 'Montserrat';
	font-weight: 400;
	font-size: 14px;
	margin: 12px auto;
	color: #000
}

@media(max-width:990px) {
	.mp-logo img {
		min-height: auto
	}
}

@media(max-width:680px) {
	.relatedinnerpartner .btn>div:before,
	.relatedinnerpartner .btn>div:after {
		width: 12px;
		height: 2px;
		top: 10px;
		left: 6px
	}
	.relatedinnerpartner .btn>div,
	.relatedinnerpartner .btn {
		width: 22px;
		height: 22px
	}
	.relatedinnerpartner .btn {
		right: -10px;
		bottom: 10%
	}
	.relatedinnerpartner {
		padding: 15px 10px
	}
	.mediapartnerTitle h2 {
		font-size: 22px;
		line-height: 24px;
		padding: 10px;
		width: 90%
	}
	.partnerlogo img {
		max-width: 320px;
		max-height: 200px
	}
	.partnercontent {
		width: 90%
	}
	.relatedpartner {
		flex-basis: 48%;
		margin: 0 4% 4% 0
	}
	.relatedpartner:nth-child(3n+3) {
		margin-right: 4%
	}
	.relatedpartner:nth-child(2n+2) {
		margin-right: 0
	}
}

@media(max-width:520px) {
	.relatedpartner {
		flex-basis: 100%;
		margin: 0 auto 20px auto
	}
	.relatedpartner:nth-child(3n+3) {
		margin-right: auto
	}
	.relatedpartner:nth-child(2n+2) {
		margin-right: auto
	}
	.partnerlogo img {
		max-width: 100%;
		max-height: 200px
	}
}
</style>

<section>
	<!-- News page main section start -->
	<div class="blog-content">
		<div class="page-container">
			<div class="SingleMediaPartnerWrapper">
		  		<div class="mediapartnerTitle">
					<h2><?php echo __('Media Partners', 'sigmaigaming'); ?></h2>
		 		</div>
		  		<div class="partnercontent">
					<?php if(!empty($featured)){ ?>
					<div class="partnerlogo">
				  		<img src="<?php echo $featured[0]; ?>">
					</div>
					<?php } ?>
			  		<div class="partnerDesc">
						<?php the_content(); ?>
			  		</div>
		  		</div>
				<div class="RelatedPartners">
					<div class="relatedtitle">
						<h2> Related Articles  </h2>
					</div>
					<div class="relatedmps">
						<?php echo do_shortcode('[sigma-mt-get-related-external-articles post_id="'.$post_id.'"]'); ?>
					</div>
				</div>
		 	 </div>
		</div>
	</div>
	<!-- News page main section end -->
</section>

<?php echo do_shortcode('[sigma-mt-newsletter]'); ?>

<?php get_footer(); ?>
