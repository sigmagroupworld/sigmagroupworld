<?php global $desktop_banner, $taxonomy, $row; ?>

<!-- Asia news section -->
<?php $news_tags = sigma_mt_get_news_tags_data(1061, $taxonomy, 6); ?>
<section class="home-blog">
	<div class="container">
		<div class="home-news">				
			<div class="latest-news hp-left">
				<div class="h-title">
					<a href="<?php echo get_tag_link($news_tags['term_value']->term_id); ?>">
						<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
	       		<?php
        		foreach ( $news_tags['term_data'] as $k => $post ) {
	        		setup_postdata( $post );
	        		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
		            <div class="blog-listing-module">								
						<div class="post-item">
							<a href="<?php echo get_permalink($post); ?>">
								<?php if($row === 0) { ?>
									<div class="thumb-img">
		                        		<img src="<?php echo $featured_image[0] ?>" alt="<?php echo $post->post_title; ?>">
		                    		</div>
		                    	<?php } ?>
	                    		<h2 <?php if($row === 0) { ?> class="big" <?php } ?> ><?php echo $post->post_title; ?></h2>
							</a>
						</div>
					</div>							
					<?php $row++; ?>
					<?php wp_reset_postdata(); ?>
				<?php } ?>
			</div>
			<div class="affiliate hp-center">
				<?php
				$news_tags = sigma_mt_get_news_tags_data(1062, $taxonomy, 6);
				?>
				<div class="h-title">
					<a href="<?php echo get_tag_link($news_tags['term_value']->term_id); ?>">
						<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
				<div class="blog-listing-module">
					<?php
					foreach ( $news_tags['term_data'] as $k => $post ) {
			        	setup_postdata( $post );
			        	$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); ?>
			        	<?php if($row === 0) { ?>
							<div class="post-item">
								<a href="<?php echo get_permalink($post); ?>">
									<div class="thumb-img">
		                        		<img src="<?php echo $featured_image[0] ?>" alt="<?php echo $post->post_title; ?>">
		                    		</div>
	                    			<h2><?php echo $post->post_title; ?></h2>
								</a>
							</div>
						<?php } else { ?>
							<div class="post-item">
								<a href="<?php echo get_permalink($post); ?>">
									<div class="thumb-img">
		                        		<img src="<?php echo $featured_image[0] ?>" alt="<?php echo $post->post_title; ?>">
		                    		</div>
		                    		<h2><?php echo $post->post_title; ?></h2>
								</a>
							</div>
						<?php } ?>
					<?php $row++; } ?>
					<!-- Testomonial Section -->
					<div class="testimonial-slide-home">
						<?php $testimonials = sigma_mt_get_testimonial_data();
						$r = 1;
						$total = count($testimonials);
						foreach($testimonials as $k => $item) {
							$testimonial_value = $r . '/' . $total;
							$company_name = get_field( "testimonial_company", $item->ID );
							$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'thumbnail' ); ?>
							<figure class="testimonial">
								<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $item->post_title; ?>" />
								<div class="peopl">
									<h3><?php echo $item->post_title; ?></h3>
									<p class="company_name"><?php echo $company_name; ?></p>
								</div>
								<blockquote><?php echo $item->post_content; ?>
									<div class="btn"></div>
								</blockquote>
								<span><?php echo $testimonial_value; ?></span>
							</figure>
						<?php $r++; } ?>
					</div>
					<!-- Testomonial Section end -->
				</div>
			</div>
			<div class="spotify hp-right">
				<?php
				$news_tags = sigma_mt_get_news_tags_data(1055, $taxonomy, 12);
				?>
				<div class="h-title">
					<a href="<?php echo get_tag_link($news_tags['term_value']->term_id); ?>">
						<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
				<div class="blog-listing-module">
					<?php
					foreach ( $news_tags['term_data'] as $k => $post ) {
			        	setup_postdata( $post );
			        	$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); ?>
			        	<?php if($row === 0) { ?>
							<div class="post-item">
								<a href="<?php echo get_permalink($post); ?>">
									<div class="thumb-img">
		                        		<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $post->post_title; ?>">
		                    		</div>
	                    			<h2><?php echo $post->post_title; ?></h2>
								</a>
							</div>
						<?php } else { ?>
							<div class="post-item">
								<a href="<?php echo get_permalink($post); ?>">
									<div class="thumb-img">
		                        		<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $post->post_title; ?>">
		                    		</div>
		                    		<h2><?php echo $post->post_title; ?></h2>
								</a>
							</div>
						<?php } ?>
					<?php $row++; } ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Asia news section end-->

<!-- News Image slider start -->
<?php echo do_shortcode( '[sigma-mt-banner-adds banner_add = '.$desktop_banner["sigma_asia_add"].' ]' ); ?>
<!-- News Image slider end -->

<!-- Europe news section -->
<section class="home-blog">
	<div class="container">
		<div class="home-news">
			<?php
			$news_tags = sigma_mt_get_news_tags_data(1054, $taxonomy, 9);
			?>					
			<div class="latest-news hp-left">
				<div class="h-title">
					<a href="<?php echo get_tag_link($news_tags['term_value']->term_id); ?>">
						<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
	       		<?php
        		foreach ( $news_tags['term_data'] as $k => $post ) {
	        		setup_postdata( $post );
	        		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
		            <div class="blog-listing-module">								
						<div class="post-item">
							<a href="<?php echo get_permalink($post); ?>">
								<?php if($row === 0) { ?>
									<div class="thumb-img">
		                        		<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $post->post_title; ?>">
		                    		</div>
		                    	<?php } ?>
	                    		<h2 <?php if($row === 0) { ?> class="big" <?php } ?> ><?php echo $post->post_title; ?></h2>
							</a>
						</div>
					</div>							
					<?php $row++; ?>
					<?php wp_reset_postdata();
				} ?>
			</div>
			<div class="affiliate hp-center">
				<?php
				$news_tags = sigma_mt_get_news_tags_data(1067, $taxonomy, 9);
				?>
				<div class="h-title">
					<a href="<?php echo get_tag_link($news_tags['term_value']->term_id); ?>">
						<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
				<div class="blog-listing-module">
					<?php
					foreach ( $news_tags['term_data'] as $k => $post ) {
			        	setup_postdata( $post );
			        	$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); ?>
			        	<?php if($row === 0) { ?>
							<div class="post-item">
								<a href="<?php echo get_permalink($post); ?>">
									<div class="thumb-img">
		                        		<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $post->post_title; ?>">
		                    		</div>
	                    			<h2><?php echo $post->post_title; ?></h2>
								</a>
							</div>
						<?php } else { ?>
							<div class="post-item">
								<a href="<?php echo get_permalink($post); ?>">
									<div class="thumb-img">
		                        		<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $post->post_title; ?>">
		                    		</div>
		                    		<h2><?php echo $post->post_title; ?></h2>
								</a>
							</div>
						<?php } ?>
					<?php $row++; } ?>
				</div>
				<!-- Testomonial Magazine -->
				<div class="magazine-section">
					<div class="sigma-magazines testimonial-slide-home">
						<?php $sigma_magazines = sigma_mt_get_magazines(1149);
						foreach($sigma_magazines as $k => $item) {
							$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' ); ?>
							<figure class="testimonial">
								<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $item->post_title; ?>" />
							</figure>
						<?php } ?>
					</div>
					<div class="block-magazines testimonial-slide-home">
						<?php $sigma_magazines = sigma_mt_get_magazines(1148);
						foreach($sigma_magazines as $k => $item) {
							$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' ); ?>
							<figure class="testimonial">
								<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $item->post_title; ?>" />
							</figure>
						<?php } ?>
					</div>
				</div>
				<!-- Testomonial Section end -->
			</div>
			<div class="spotify hp-right">
				<?php
				$news_tags = sigma_mt_get_news_tags_data(1079, $taxonomy, 12);
				?>
				<div class="h-title">
					<a href="<?php echo get_tag_link($news_tags['term_value']->term_id); ?>">
						<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
				<div class="blog-listing-module">
					<?php
					foreach ( $news_tags['term_data'] as $k => $post ) {
			        	setup_postdata( $post );
			        	$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); ?>
			        	<?php if($row === 0) { ?>
							<div class="post-item">
								<a href="<?php echo get_permalink($post); ?>">
									<div class="thumb-img">
		                        		<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $post->post_title; ?>">
		                    		</div>
	                    			<h2><?php echo $post->post_title; ?></h2>
								</a>
							</div>
						<?php } else { ?>
							<div class="post-item">
								<a href="<?php echo get_permalink($post); ?>">
									<div class="thumb-img">
		                        		<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $post->post_title; ?>">
		                    		</div>
		                    		<h2><?php echo $post->post_title; ?></h2>
								</a>
							</div>
						<?php } ?>
					<?php $row++; } ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Europe news section end-->

<!-- News Image slider start -->
<?php echo do_shortcode( '[sigma-mt-banner-adds banner_add = '.$desktop_banner["sigma_europe_add"].' ]' ); ?>
<!-- News Image slider end -->

<!-- America news section -->
<section class="home-blog">
	<div class="container">
		<div class="home-news">
			<?php
			$news_tags = sigma_mt_get_news_tags_data(1066, $taxonomy, 12);
			?>					
			<div class="latest-news hp-left">
				<div class="h-title">
					<a href="<?php echo get_tag_link($news_tags['term_value']->term_id); ?>">
						<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
	       		<?php
        		foreach ( $news_tags['term_data'] as $k => $post ) :
	        		setup_postdata( $post );
	        		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
		            <div class="blog-listing-module">								
						<div class="post-item">
							<a href="<?php echo get_permalink($post); ?>">
								<?php if($row === 0) { ?>
									<div class="thumb-img">
		                        		<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $post->post_title; ?>">
		                    		</div>
		                    	<?php } ?>
	                    		<h2 <?php if($row === 0) { ?> class="big" <?php } ?> ><?php echo $post->post_title; ?></h2>
							</a>
						</div>
					</div>							
					<?php $row++; ?>
					<?php wp_reset_postdata();
				endforeach; ?>
			</div>
			<div class="affiliate hp-center">
				<?php
				$news_tags = sigma_mt_get_news_tags_data(1068, $taxonomy, 6);
				?>
				<div class="h-title">
					<a href="<?php echo get_tag_link($news_tags['term_value']->term_id); ?>">
						<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
				<div class="blog-listing-module">
					<?php
					foreach ( $news_tags['term_data'] as $k => $post ) {
			        	setup_postdata( $post );
			        	$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); ?>
			        	<?php if($row === 0) { ?>
							<div class="post-item">
								<a href="<?php echo get_permalink($post); ?>">
									<div class="thumb-img">
		                        		<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $post->post_title; ?>">
		                    		</div>
	                    			<h2><?php echo $post->post_title; ?></h2>
								</a>
							</div>
						<?php } else { ?>
							<div class="post-item">
								<a href="<?php echo get_permalink($post); ?>">
									<div class="thumb-img">
		                        		<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $post->post_title; ?>">
		                    		</div>
		                    		<h2><?php echo $post->post_title; ?></h2>
								</a>
							</div>
						<?php } ?>
					<?php $row++; } ?>
				</div>
			</div>
			<div class="spotify hp-right">
				<?php
				$news_tags = sigma_mt_get_news_tags_data(1081, $taxonomy, 12);
				?>
				<div class="h-title">
					<a href="<?php echo get_tag_link($news_tags['term_value']->term_id); ?>">
						<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
				<div class="blog-listing-module">
					<?php 
					$row = 0;
					foreach ( $news_tags['term_data'] as $k => $post ) {
			        	setup_postdata( $post );
			        	$featuredImage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); ?>
			        	<?php if($row === 0) { ?>
							<div class="post-item">
								<a href="<?php echo get_permalink($post); ?>">
									<div class="thumb-img">
		                        		<img src="<?php echo $featuredImage[0] ?>" alt="">
		                    		</div>
	                    			<h2><?php echo $post->post_title; ?></h2>
								</a>
							</div>
						<?php } else { ?>
							<div class="post-item">
								<a href="<?php echo get_permalink($post); ?>">
									<div class="thumb-img">
		                        		<img src="<?php echo $featuredImage[0] ?>" alt="">
		                    		</div>
		                    		<h2><?php echo $post->post_title; ?></h2>
								</a>
							</div>
						<?php } ?>
					<?php $row++; } ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- America news section end-->

<!-- News Image slider start -->
<?php echo do_shortcode( '[sigma-mt-banner-adds banner_add = '.$desktop_banner["sigma_americas_add"].' ]' ); ?>
<!-- News Image slider end -->

<!-- Africa news section -->
<section class="home-blog">
	<div class="container">
		<div class="home-news">
			<?php
			$news_tags = sigma_mt_get_news_tags_data(1078, $taxonomy, 13);
			?>					
			<div class="latest-news hp-left">
				<div class="h-title">
					<a href="<?php echo get_tag_link($news_tags['term_value']->term_id); ?>">
						<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
	       		<?php
        		foreach ( $news_tags['term_data'] as $k => $post ) :
	        		setup_postdata( $post );
	        		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
		            <div class="blog-listing-module">								
						<div class="post-item">
							<a href="<?php echo get_permalink($post); ?>">
								<?php if($row === 0) { ?>
									<div class="thumb-img">
		                        		<img src="<?php echo $featured_image[0] ?>" alt="<?php echo $post->post_title; ?>">
		                    		</div>
		                    	<?php } ?>
	                    		<h2 <?php if($row === 0) { ?> class="big" <?php } ?> ><?php echo $post->post_title; ?></h2>
							</a>
						</div>
					</div>							
					<?php $row++; ?>
					<?php wp_reset_postdata();
				endforeach; ?>
			</div>
			<div class="affiliate hp-center">
				<?php
				$news_tags = sigma_mt_get_news_tags_data(1070, $taxonomy, 12);
				?>
				<div class="h-title">
					<a href="<?php echo get_tag_link($news_tags['term_value']->term_id); ?>">
						<?php echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
				<div class="blog-listing-module">
					<?php 
					foreach ( $news_tags['term_data'] as $k => $post ) {
			        	setup_postdata( $post );
			        	$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); ?>
			        	<?php if($row === 0) { ?>
							<div class="post-item">
								<a href="<?php echo get_permalink($post); ?>">
									<div class="thumb-img">
		                        		<img src="<?php echo $featured_image[0] ?>" alt="<?php echo $post->post_title; ?>">
		                    		</div>
	                    			<h2><?php echo $post->post_title; ?></h2>
								</a>
							</div>
						<?php } else { ?>
							<div class="post-item">
								<a href="<?php echo get_permalink($post); ?>">
									<div class="thumb-img">
		                        		<img src="<?php echo $featured_image[0] ?>" alt="<?php echo $post->post_title; ?>">
		                    		</div>
		                    		<h2><?php echo $post->post_title; ?></h2>
								</a>
							</div>
						<?php } ?>
					<?php $row++; } ?>
				</div>
			</div>
			<div class="spotify hp-right">
				<?php
				$news_tags = sigma_mt_get_news_tags_data(1064, $taxonomy, 12);
				?>
				<div class="h-title">
					<a href="<?php echo get_tag_link($news_tags['term_value']->term_id); ?>">
						<?php  echo $news_tags['term_value']->name; ?><i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
				<div class="blog-listing-module">
					<?php
					foreach ( $news_tags['term_data'] as $k => $post ) {
			        	setup_postdata( $post );
			        	$featuredImage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); ?>
			        	<?php if($row === 0) { ?>
							<div class="post-item">
								<a href="<?php echo get_permalink($post); ?>">
									<div class="thumb-img">
		                        		<img src="<?php echo $featuredImage[0] ?>" alt="">
		                    		</div>
	                    			<h2><?php echo $post->post_title; ?></h2>
								</a>
							</div>
						<?php } else { ?>
							<div class="post-item">
								<a href="<?php echo get_permalink($post); ?>">
									<div class="thumb-img">
		                        		<img src="<?php echo $featuredImage[0] ?>" alt="">
		                    		</div>
		                    		<h2><?php echo $post->post_title; ?></h2>
								</a>
							</div>
						<?php } ?>
					<?php $row++; } ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Africa news section end-->

<!-- News Image slider start -->
<?php echo do_shortcode( '[sigma-mt-banner-adds banner_add = '.$desktop_banner["sigma_africa_add"].' ]' ); ?>
<!-- News Image slider end -->