<?php
/**
 * The template for displaying single post of author 
 *
 * Template Name: SigmaMT Author Layout
 * Template Post Type: authors
 */

get_header();
$post_id = get_the_ID();
$featured_images = wp_get_attachment_image_src(get_post_thumbnail_id( $post_id ));
?>

<style>
	h1.blog-author-name {
		font-size: 35px;
		font-weight: bold;
		color: #1a1a1a !important;
		line-height: 1.2;
	}
	.item--post {
		width:-webkit-calc(50% - 10px);
		width:-moz-calc(50% - 10px);
		width:calc(50% - 10px);
		min-height:200px;
		margin-bottom:20px;
		float: left;
	}
	div.item--post:nth-child(2n+1) {
		margin-right: 20px;
	}

	.item--post a {
		display:block;
		width:100%;
		-moz-background-size:cover;
		background-size:cover;
		height:200px;
		text-decoration:none;
		position:relative;
		overflow:hidden;
		display:-webkit-box;
		display:-webkit-flex;
		display:-moz-box;
		display:-ms-flexbox;
		display:flex;
		-webkit-box-orient:vertical;
		-webkit-box-direction:normal;
		-webkit-flex-direction:column;
		-moz-box-orient:vertical;
		-moz-box-direction:normal;
		-ms-flex-direction:column;
		flex-direction:column
	}
	.item--post a:before {
		content:'';
		position:absolute;
		top:0;
		left:auto;
		right:0;
		bottom:0;
		opacity:0;
		z-index:15;
		width:100%;
		height:100%;
		opacity:0;
		-webkit-transition:all .3s linear;
		-o-transition:all .3s linear;
		-moz-transition:all .3s linear;
		transition:all .3s linear;
		background-color:rgba(255,
		255,
		255,
		0.6)
	}
	.item--post a:after {	
		font-family: "Font Awesome 5 Free";
		content:'\f360';
		position:absolute;
		top:150%;
		left:50%;
		width:70px;
		height:70px;
		-webkit-border-radius:50%;
		-moz-border-radius:50%;
		border-radius:50%;
		font-size:35px;
		line-height:70px;
		margin-top:-35px;
		margin-left:-35px;
		opacity:0;
		text-align:center;
		-webkit-transform:scale(0);
		-moz-transform:scale(0);
		-ms-transform:scale(0);
		-o-transform:scale(0);
		transform:scale(0);
		-webkit-transition:top .4s,
		opacity .4s,
		-webkit-transform 0s .4s;
		transition:top .4s,
		opacity .4s,
		-webkit-transform 0s .4s;
		-o-transition:top .4s,
		opacity .4s,
		-o-transform 0s .4s;
		-moz-transition:top .4s,
		opacity .4s,
		transform 0s .4s,
		-moz-transform 0s .4s;
		transition:top .4s,
		opacity .4s,
		transform 0s .4s;
		transition:top .4s,
		opacity .4s,
		transform 0s .4s,
		-webkit-transform 0s .4s,
		-moz-transform 0s .4s,
		-o-transform 0s .4s;
		z-index:16;
		background-color:#fff
	}
	.item--post a:hover {
		opacity:1
	}
	.item--post a:hover:before {
		opacity:1;
		-webkit-transition:all .3s linear;
		-o-transition:all .3s linear;
		-moz-transition:all .3s linear;
		transition:all .3s linear
	}
	.item--post a:hover:after {
		opacity:1;
		top:50%;
		-webkit-transform:scale(1);
		-moz-transform:scale(1);
		-ms-transform:scale(1);
		-o-transform:scale(1);
		transform:scale(1);
		-webkit-transition:top 0s,
		opacity .4s,
		-webkit-transform .4s;
		transition:top 0s,
		opacity .4s,
		-webkit-transform .4s;
		-o-transition:top 0s,
		opacity .4s,
		-o-transform .4s;
		-moz-transition:top 0s,
		opacity .4s,
		transform .4s,
		-moz-transform .4s;
		transition:top 0s,
		opacity .4s,
		transform .4s;
		transition:top 0s,
		opacity .4s,
		transform .4s,
		-webkit-transform .4s,
		-moz-transform .4s,
		-o-transform .4s
	}
	.item--post .post-desc {
		/*background-color:#ee4438;*/
		background-color: rgba(0,0,0,0.75);
		width:100%;
		margin:auto 0 0 0;
		padding:10px;
		display:-webkit-box;
		display:-webkit-flex;
		display:-moz-box;
		display:-ms-flexbox;
		display:flex;
		-webkit-box-orient:vertical;
		-webkit-box-direction:normal;
		-webkit-flex-direction:column;
		-moz-box-orient:vertical;
		-moz-box-direction:normal;
		-ms-flex-direction:column;
		flex-direction:column;
		-webkit-box-align:start;
		-webkit-align-items:flex-start;
		-moz-box-align:start;
		-ms-flex-align:start;
		align-items:flex-start;
		-webkit-box-pack:end;
		-webkit-justify-content:flex-end;
		-moz-box-pack:end;
		-ms-flex-pack:end;
		justify-content:flex-end;
		text-align:left
	}
	.item--post .post-desc h2 {
		color:#fff;
		margin:0;
		font-size:15px;
		font-weight:500;
		overflow:hidden;
		-o-text-overflow:ellipsis;
		text-overflow:ellipsis;
		line-clamp:3;
		-webkit-line-clamp:3;
		-webkit-box-orient:vertical;
		display:-webkit-box
	}
		.blog-author-info {
		-webkit-box-pack: justify;
		-webkit-justify-content: space-between;
		-moz-box-pack: justify;
		-ms-flex-pack: justify;
		justify-content: space-between;
		display: -webkit-box;
		display: -webkit-flex;
		display: -moz-box;
		display: -ms-flexbox;
		display: flex;
		margin: 20px auto 20px;
		padding-bottom: 15px;
		border-bottom: 1px solid rgba(0, 0, 0, 0.1);
		background-color: #fff
	}

	.blog-author-profile {
		display: -webkit-box;
		display: -webkit-flex;
		display: -moz-box;
		display: -ms-flexbox;
		display: flex;
		-webkit-flex-wrap: wrap;
		-ms-flex-wrap: wrap;
		flex-wrap: wrap;
		width: 100%;
		-webkit-box-align: center;
		-webkit-align-items: center;
		-moz-box-align: center;
		-ms-flex-align: center;
		align-items: center
	}

	.blog-author-avatar-wrapper {
		-webkit-border-radius: 50%;
		-moz-border-radius: 50%;
		border-radius: 50%;
		overflow: hidden;
		width: 110px;
		height: 110px;
		max-width: 110px;
		margin: 20px 30px 20px 40px
	}

	.blog-author-avatar img {
		display: inline-block;
		width: 110px;
		-moz-background-size: cover;
		background-size: cover;
		background-position: center center
	}

	.blog-author-bio {
		padding: 10px 20px 20px 20px
	}

	.blog-details.author-details {
		background-color: #f4f4f4;
		padding-top: 51px;
		margin:  20px;
	}
	.blog-banner.author-top-banner img {
		width: 100%;
		object-fit: cover;
		max-height: 400px;
	}

	@media only screen and (max-width:544px) {
		.blog-author-avatar-wrapper {
			display: block;
			margin: 10px auto 10px auto
		}
		.blog-author-name {
			display: block;
			margin: 0 auto 10px auto
		}
	}

	@media only screen and (max-width:375px) {
		.blog-author-name {
			display: block;
			margin: 10px auto 10px auto;
			font-size: 25px !important
		}
	}
</style>

<section>
	<!-- News Banner start -->
	<div class="blog-banner author-top-banner">
		<a href="#">
			<img src="/fileadmin/SiGMA-news-preview.png">
		</a>
	</div>
	<!-- News Banner end -->

	<!-- News page main section start -->
	<div class="blog-content">
		<div class="page-container">
			<!-- Leftbar start -->
			<div class="blog-leftbar">
				<?php echo do_shortcode('[sigma_mt_show_sidebar elements="22554"]'); ?>
			</div>
			<!-- Leftbar end -->

			<!-- Middle Detail News start -->
			<div class="blog-details author-details">
				<div class="blog-inner-details"><div class="blog-author-info">
					<div class="blog-author-profile">
					  <div class="blog-author-avatar-wrapper">
						  <?php if(!empty($featured_images)){ ?>
						  <div class="blog-author-avatar"> <img src="<?php echo $featured_images[0]; ?>" alt="<?php echo the_title(); ?>"> </div> 
						  <?php } ?>
					  </div>
					  <h1 class="blog-author-name"><?php echo the_title(); ?></h1>
					  <div class="blog-author-bio">
						<?php echo the_content(); ?>
					  </div>
					</div>    
				  </div>
				  <div>
					<?php echo do_shortcode('[sigma-mt-related-articles author_id='.$post_id.']') ?>
				  </div>
				</div>
			</div>
			<!-- Middle Detail News end -->

			<!-- Rightbar start -->
			<div class="blog-rightbar">
				<?php echo do_shortcode('[sigma_mt_show_sidebar elements="22586, 22579, 22549, 22583"]'); ?>
			</div>
			<!-- Rightbar end -->
		</div>
	</div>
	<!-- News page main section end -->
</section>

<?php get_footer(); ?>
