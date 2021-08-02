<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();
$term = get_queried_object();
$featured_image = get_field('featured', $term);
$header_image = get_field('header', $term);
?>

<style>

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
	content:'\e628';
	position:absolute;
	top:150%;
	left:50%;
	width:70px;
	height:70px;
	-webkit-border-radius:50%;
	-moz-border-radius:50%;
	border-radius:50%;
	font-family:'thegem-icons';
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
	background-color:#ee4438;
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
	font-weight:100;
	overflow:hidden;
	-o-text-overflow:ellipsis;
	text-overflow:ellipsis;
	line-clamp:3;
	-webkit-line-clamp:3;
	-webkit-box-orient:vertical;
	display:-webkit-box
}
</style>

<section>
	<!-- News Banner start -->
    <?php if ($featured_image) { ?>
        <div class="blog-banner">
            <a href="#">
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
				<?php echo do_shortcode('[sigma_mt_show_sidebar elements="100427"]'); ?>
			</div>
			<!-- Leftbar end -->

			<!-- Middle Detail News start -->
			<div class="blog-details">
				<?php if ($header_image) { ?>
					<img src="<?php echo $header_image; ?>" style="width: calc(100%-20px);"><br /><br />
				<?php } ?>
				<div class="blog-inner-details">
				<?php if ( have_posts() ) {
					// The Loop
					while ( have_posts() ) {
						the_post(); ?>
						<div class="item item--post">
							<a class="more" href="<?php echo the_permalink(); ?>" style="background-image:url('<?php echo the_post_thumbnail_url(); ?>')" target="_blank">
								<div class="post-desc">
									<h2><?php echo the_title(); ?></h2>
								</div>
							</a>
						</div>
					<?php }
				 
				} else { ?>
					<p><?php __('Sorry, no posts matched your criteria.', 'sigmaigaming'); ?></p>
				<?php } ?>
				</div>
			</div>
			<!-- Middle Detail News end -->

			<!-- Rightbar start -->
			<div class="blog-rightbar">
				<?php echo do_shortcode('[sigma_mt_show_sidebar elements="22586, 22578, 22549, 22583"]'); ?>
			</div>
			<!-- Rightbar end -->
		</div>
	</div>
	<!-- News page main section end -->
</section>

<?php get_footer(); ?>
