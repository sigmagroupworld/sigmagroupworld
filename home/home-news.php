<?php global $desktop_banner, $row; ?>

<?php 
$taxonomy = 'news-cat';
$placeholder = wp_get_attachment_image_url(99850);
$placeholder_full = wp_get_attachment_image_url(99850, 'full');
$europe = '<section class="home-blog">
	<div class="container">
		<div class="home-news">';
			$news_tags = sigma_mt_get_news_tags_data(1884, $taxonomy, 12);
			$europe .= '<div class="latest-news hp-left">
				<div class="h-title">
					<a href="' . get_tag_link($news_tags['term_value']->term_id) . '">' . 
						$news_tags['term_value']->name . '<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>';
				$row = 0;
        		foreach ( $news_tags['term_data'] as $k => $post ) {
	        		setup_postdata( $post );
	        		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		            $europe .= '<div class="blog-listing-module">								
						<div class="post-item">
							<a href="' . get_permalink($post) . '">';
								if($row === 0) {
								    if ($featured_image) {
                                        $europe .= '<div class="thumb-img">
		                        		<img src="' . $featured_image[0] . '" alt="' . $post->post_title . '">
		                    		</div>';
                                    } else {
                                        $europe .= '<div class="thumb-img">
		                        		<img src="' . $placeholder_full . '" alt="' . $post->post_title . '">
		                    		</div>';
                                    }
		                    	}
	                    		$europe .= '<h2 '; 
								if($row === 0) { $europe .= 'class="big"'; } 
								$europe .= '>' . $post->post_title . '</h2>
							</a>
						</div>
					</div>';							
					$row++;
					wp_reset_postdata();
				}
			$europe .= '</div>
			<div class="affiliate hp-center">';
				$news_tags = sigma_mt_get_news_tags_data(1944, $taxonomy, 9);
				$europe .= '<div class="h-title">
					<a href="' . get_tag_link($news_tags['term_value']->term_id) . '">' .
						$news_tags['term_value']->name . '<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
				<div class="blog-listing-module">';
					$row = 0;
					foreach ( $news_tags['term_data'] as $k => $post ) {
			        	setup_postdata( $post );
			        	$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
						//$featured_image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
						if($row === 0) {
							$europe .= '<div class="post-item">
								<a href="' . get_permalink($post) . '">
									<div class="thumb-img">';
										if(!empty($featured_image)){
		                        			$europe .= '<img src="' . $featured_image[0] . '" alt="' . $post->post_title . '">';
										} else {
                                            $europe .= '<img src="' . $placeholder_full . '" alt="' . $post->post_title . '">';
                                        }
		                    		$europe .= '</div>
	                    			<h2>' . $post->post_title . '</h2>
								</a>
							</div>';
						} else {
							$europe .= '<div class="post-item">
								<a href="' . get_permalink($post) . '">';
							/*if ($featured_image_thumb) {
                                $europe .= '<div class="thumb-img">
		                        		<img src="' . $featured_image_thumb[0] . '" alt="' . $post->post_title . '">
		                    		</div>';
                            } else {
                                $europe .= '<div class="thumb-img">
		                        		<img src="' . $placeholder . '" alt="' . $post->post_title . '">
		                    		</div>';
                            }*/
                            $europe .= '<h2>' . $post->post_title . '</h2>
								</a>
							</div>';
						}
						$row++; 
					}
				$europe .= '</div>
				<div class="magazine-section">
					<div class="sigma-magazines testimonial-slide-home">';
						$sigma_magazines = sigma_mt_get_magazines(1149);
						foreach($sigma_magazines as $k => $item) {
							$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' );
							if ($featured_image) {
                                $europe .= '<figure class="testimonial">
								<img src="' . $featured_image[0] . '" alt="' . $item->post_title . '" />
							</figure>';
                            } else {
                                $europe .= '<figure class="testimonial">
								<img src="' . $placeholder_full . '" alt="' . $item->post_title . '" />
							</figure>';
                            }
						}
					$europe .= '</div>
					<div class="block-magazines testimonial-slide-home">';
						$sigma_magazines = sigma_mt_get_magazines(1148);
						foreach($sigma_magazines as $k => $item) {
							$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $item->ID ), 'full' );
							$europe .= '<figure class="testimonial">';
								if(!empty($featured_image)){
									$europe .= '<img src="' . $featured_image[0] . '" alt="' . $item->post_title . '" />';
								} else {
                                    $europe .= '<img src="' . $placeholder_full . '" alt="' . $item->post_title . '" />';
                                }
							$europe .= '</figure>';
						}
					$europe .= '</div>
				</div>
			</div>
			<div class="spotify hp-right">';
				$news_tags = sigma_mt_get_news_tags_data(2057, $taxonomy, 12);
				$europe .= '<div class="h-title">
					<a href="' . get_tag_link($news_tags['term_value']->term_id) . '">' .
						$news_tags['term_value']->name . '<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
				<div class="blog-listing-module">';
					$row = 0;
					foreach ( $news_tags['term_data'] as $k => $post ) {
			        	setup_postdata( $post );
			        	//$featured_image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
						$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			        	if($row === 0) {
							$europe .= '<div class="post-item">
								<a href="' . get_permalink($post) . '">
									<div class="thumb-img">';
										if(!empty($featured_image)){
		                        			$europe .= '<img src="' . $featured_image[0] . '" alt="' . $post->post_title . '">';
										} else {
                                            $europe .= '<img src="' . $placeholder_full . '" alt="' . $post->post_title . '">';
                                        }
		                    		$europe .= '</div>
	                    			<h2>' . $post->post_title . '</h2>
								</a>
							</div>';
						} else {
							$europe .= '<div class="post-item">
								<a href="' . get_permalink($post) . '">';
									/* <div class="thumb-img">';
										if(!empty($featured_image_thumb)){
		                        			$europe .= '<img src="' . $featured_image_thumb[0] . '" alt="' . $post->post_title . '">';
										} else {
                                            $europe .= '<img src="' . $placeholder . '" alt="' . $post->post_title . '">';
                                        }
		                    		$europe .= '</div> */
		                    $europe .= '<h2>' . $post->post_title . '</h2>
								</a>
							</div>';
						}
						$row++; 
					}
				$europe .= '</div>
			</div>
		</div>
	</div>
</section>'; ?>
<!-- Europe news section end-->

<!-- Asia news section -->
<?php 
$asia = '<section class="home-blog">
	<div class="container">
		<div class="home-news">';
			$news_tags = sigma_mt_get_news_tags_data(1892, $taxonomy, 12);
			$asia .= '<div class="latest-news hp-left">
				<div class="h-title">
					<a href="' . get_tag_link($news_tags['term_value']->term_id) . '">' . 
						$news_tags['term_value']->name . '<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>';
				$row = 0;
        		foreach ( $news_tags['term_data'] as $k => $post ) {
	        		setup_postdata( $post );
	        		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		            $asia .= '<div class="blog-listing-module">								
						<div class="post-item">
							<a href="' . get_permalink($post) . '">';
								if($row === 0) {
									$asia .= '<div class="thumb-img">';
									
										if(!empty($featured_image)){
		                        			$asia .= '<img src="' . $featured_image[0] . '" alt="' . $post->post_title . '">';
										} else {
                                            $asia .= '<img src="' . $placeholder_full . '" alt="' . $post->post_title . '">';
                                        }
		                    		$asia .= '</div>';
		                    	}
	                    		$asia .= '<h2 '; 
								if($row === 0) { $asia .= 'class="big"'; } 
								$asia .= '>' . $post->post_title . '</h2>
							</a>
						</div>
					</div>';							
					$row++;
					wp_reset_postdata();
				}
			$asia .= '</div>
			<div class="affiliate hp-center">';
				$news_tags = sigma_mt_get_news_tags_data(1907, $taxonomy, 6);
				$asia .= '<div class="h-title">
					<a href="' . get_tag_link($news_tags['term_value']->term_id) . '">' .
						$news_tags['term_value']->name . '<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
				<div class="blog-listing-module">';
					$row = 0;
					foreach ( $news_tags['term_data'] as $k => $post ) {
			        	setup_postdata( $post );
			        	$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
						//$featured_image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
						if($row === 0) {
							$asia .= '<div class="post-item">
								<a href="' . get_permalink($post) . '">';
                            if ($featured_image) {
                                $asia .= '<div class="thumb-img">
		                        		<img src="' . $featured_image[0] . '" alt="' . $post->post_title . '">
		                    		</div>';
                            } else {
                                $asia .= '<div class="thumb-img">
		                        		<img src="' . $placeholder_full . '" alt="' . $post->post_title . '">
		                    		</div>';
                            }
                            $asia .= '<h2>' . $post->post_title . '</h2>
								</a>
							</div>';
						} else {
							$asia .= '<div class="post-item">
								<a href="' . get_permalink($post) . '">';
							/*if ($featured_image_thumb) {
                                $asia .= '<div class="thumb-img">
		                        		<img src="' . $featured_image_thumb[0] . '" alt="' . $post->post_title . '">
		                    		</div>';
                            } else {
                                $asia .= '<div class="thumb-img">
		                        		<img src="' . $placeholder . '" alt="' . $post->post_title . '">
		                    		</div>';
                            }*/
                            $asia .= '<h2>' . $post->post_title . '</h2>
								</a>
							</div>';
						}
						$row++; 
					}
					$asia .= do_shortcode('[sigma-mt-get-testimonials appearance="frontpage" term_id=1307]');
				$asia .= '</div>
			</div>
			<div class="spotify hp-right">';
				$news_tags = sigma_mt_get_news_tags_data(1882, $taxonomy, 12);
				$asia .= '<div class="h-title">
					<a href="' . get_tag_link($news_tags['term_value']->term_id) . '">' .
						$news_tags['term_value']->name . '<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
				<div class="blog-listing-module">';
					$row = 0;
					foreach ( $news_tags['term_data'] as $k => $post ) {
			        	setup_postdata( $post );
			        	//$featured_image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
						$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			        	if($row === 0) {
							$asia .= '<div class="post-item">
								<a href="' . get_permalink($post) . '">';
							if ($featured_image) {
                                $asia .= '<div class="thumb-img">
		                        		<img src="' . $featured_image[0] . '" alt="' . $post->post_title . '">
		                    		</div>';
                            } else {
                                $asia .= '<div class="thumb-img">
		                        		<img src="' . $placeholder_full . '" alt="' . $post->post_title . '">
		                    		</div>';
                            }
                            $asia .= '<h2>' . $post->post_title . '</h2>
								</a>
							</div>';
						} else {
							$asia .= '<div class="post-item">
								<a href="' . get_permalink($post) . '">';
							/*if ($featured_image_thumb) {
                                $asia .= '<div class="thumb-img">
		                        		<img src="' . $featured_image_thumb[0] . '" alt="' . $post->post_title . '">
		                    		</div>';
                            } else {
                                $asia .= '<div class="thumb-img">
		                        		<img src="' . $placeholder . '" alt="' . $post->post_title . '">
		                    		</div>';
                            }*/
                            $asia .= '<h2>' . $post->post_title . '</h2>
								</a>
							</div>';
						}
						$row++; 
					}
				$asia .= '</div>
			</div>
		</div>
	</div>
</section>'; ?>
<!-- Asia news section end-->

<!-- America news section -->
<?php 
$americas = '<section class="home-blog">
	<div class="container">
		<div class="home-news">';
			$news_tags = sigma_mt_get_news_tags_data(1883, $taxonomy, 12);
			$americas .= '<div class="latest-news hp-left">
				<div class="h-title">
					<a href="' . get_tag_link($news_tags['term_value']->term_id) . '">' . 
						$news_tags['term_value']->name . '<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>';
				$row = 0;
        		foreach ( $news_tags['term_data'] as $k => $post ) {
	        		setup_postdata( $post );
	        		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		            $americas .= '<div class="blog-listing-module">								
						<div class="post-item">
							<a href="' . get_permalink($post) . '">';
								if($row === 0) {
								    if ($featured_image) {
                                        $americas .= '<div class="thumb-img">
		                        		<img src="' . $featured_image[0] . '" alt="' . $post->post_title . '">
		                    		</div>';
                                    } else {
                                        $americas .= '<div class="thumb-img">
		                        		<img src="' . $placeholder_full . '" alt="' . $post->post_title . '">
		                    		</div>';
                                    }
		                    	}
	                    		$americas .= '<h2 '; 
								if($row === 0) { $americas .= 'class="big"'; } 
								$americas .= '>' . $post->post_title . '</h2>
							</a>
						</div>
					</div>';							
					$row++;
					wp_reset_postdata();
				}
$americas .= '</div>
			<div class="affiliate hp-center">';
				$news_tags = sigma_mt_get_news_tags_data(1914, $taxonomy, 5);
				$americas .= '<div class="h-title">
					<a href="' . get_tag_link($news_tags['term_value']->term_id) . '">' .
						$news_tags['term_value']->name . '<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
				<div class="blog-listing-module">';
					$row = 0;
					foreach ( $news_tags['term_data'] as $k => $post ) {
			        	setup_postdata( $post );
			        	$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
						//$featured_image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
						if($row === 0) {
							$americas .= '<div class="post-item">
								<a href="' . get_permalink($post) . '">';
							if ($featured_image) {
                                $americas .= '<div class="thumb-img">
		                        		<img src="' . $featured_image[0] . '" alt="' . $post->post_title . '">
		                    		</div>';
                            } else {
                                $americas .= '<div class="thumb-img">
		                        		<img src="' . $placeholder_full . '" alt="' . $post->post_title . '">
		                    		</div>';
                            }
                            $americas .= '<h2>' . $post->post_title . '</h2>
								</a>
							</div>';
						} else {
							$americas .= '<div class="post-item">
								<a href="' . get_permalink($post) . '">';
								/*
									<div class="thumb-img">';
										if(!empty($featured_image_thumb)){
		                        			$americas .= '<img src="' . $featured_image_thumb[0] . '" alt="' . $post->post_title . '">';
										} else {
                                            $americas .= '<img src="' . $placeholder . '" alt="' . $post->post_title . '">';
                                        }
		                    		$americas .= '</div>*/
							$americas .= '<h2>' . $post->post_title . '</h2>
								</a>
							</div>';
						}
						$row++; 
					}
$americas .= do_shortcode('[sigma-mt-get-testimonials appearance="broker" term_id=4675]');

$americas .= '</div>
			</div>
			<div class="spotify hp-right">';
				$news_tags = sigma_mt_get_news_tags_data(1936, $taxonomy, 12);
				$americas .= '<div class="h-title">
					<a href="' . get_tag_link($news_tags['term_value']->term_id) . '">' .
						$news_tags['term_value']->name . '<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
				<div class="blog-listing-module">';
					$row = 0;
					foreach ( $news_tags['term_data'] as $k => $post ) {
			        	setup_postdata( $post );
			        	//$featured_image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
						$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			        	if($row === 0) {
							$americas .= '<div class="post-item">
								<a href="' . get_permalink($post) . '">';
							if ($featured_image) {
                                $americas .= '<div class="thumb-img">
		                        		<img src="' . $featured_image[0] . '" alt="' . $post->post_title . '">
		                    		</div>';
                            } else {
                                $americas .= '<div class="thumb-img">
		                        		<img src="' . $placeholder_full . '" alt="' . $post->post_title . '">
		                    		</div>';
                            }
                            $americas .= '<h2>' . $post->post_title . '</h2>
								</a>
							</div>';
						} else {
							$americas .= '<div class="post-item">
								<a href="' . get_permalink($post) . '">';
								/*
									<div class="thumb-img">';
										if(!empty($featured_image_thumb)){
		                        			$americas .= '<img src="' . $featured_image_thumb[0] . '" alt="' . $post->post_title . '">';
										} else {
                                            $americas .= '<img src="' . $placeholder . '" alt="' . $post->post_title . '">';
                                        }
		                    		$americas .= '</div> */
							$americas .= '<h2>' . $post->post_title . '</h2>
								</a>
							</div>';
						}
						$row++; 
					}
				$americas .= '</div>
			</div>
		</div>
	</div>
</section>'; ?>
<!-- America news section end-->

<!-- Africa news section -->
<?php 
$africa = '<section class="home-blog">
	<div class="container">
		<div class="home-news">';
			$news_tags = sigma_mt_get_news_tags_data(1889, $taxonomy, 13);
			$africa .= '<div class="latest-news hp-left">
				<div class="h-title">
					<a href="' . get_tag_link($news_tags['term_value']->term_id) . '">' . 
						$news_tags['term_value']->name . '<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>';
				$row = 0;
        		foreach ( $news_tags['term_data'] as $k => $post ) {
	        		setup_postdata( $post );
	        		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		            $africa .= '<div class="blog-listing-module">								
						<div class="post-item">
							<a href="' . get_permalink($post) . '">';
								if($row === 0) {
									$africa .= '<div class="thumb-img">';
										if(!empty($featured_image)){
		                        			$africa .= '<img src="' . $featured_image[0] . '" alt="' . $post->post_title . '">';
										} else {
                                            $africa .= '<img src="' . $placeholder_full . '" alt="' . $post->post_title . '">';
                                        }
		                    		$africa .= '</div>';
		                    	}
	                    		$africa .= '<h2 '; 
								if($row === 0) { $africa .= 'class="big"'; } 
								$africa .= '>' . $post->post_title . '</h2>
							</a>
						</div>
					</div>';							
					$row++;
					wp_reset_postdata();
				}
			$africa .= '</div>
			<div class="affiliate hp-center">';
				$news_tags = sigma_mt_get_news_tags_data(1937, $taxonomy, 12);
				$africa .= '<div class="h-title">
					<a href="' . get_tag_link($news_tags['term_value']->term_id) . '">' .
						$news_tags['term_value']->name . '<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
				<div class="blog-listing-module">';
					$row = 0;
					foreach ( $news_tags['term_data'] as $k => $post ) {
			        	setup_postdata( $post );
			        	$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
						//$featured_image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
						if($row === 0) {
							$africa .= '<div class="post-item">
								<a href="' . get_permalink($post) . '">';
							if ($featured_image) {
                                $africa .= '<div class="thumb-img">
		                        		<img src="' . $featured_image[0] . '" alt="' . $post->post_title . '">
		                    		</div>';
                            } else {
                                $africa .= '<div class="thumb-img">
		                        		<img src="' . $placeholder_full . '" alt="' . $post->post_title . '">
		                    		</div>';
                            }
                            $africa .='<h2>' . $post->post_title . '</h2>
								</a>
							</div>';
						} else {
							$africa .= '<div class="post-item">
								<a href="' . get_permalink($post) . '">';
							/*
							if ($featured_image_thumb) {
                                $africa .= '<div class="thumb-img">
		                        		<img src="' . $featured_image_thumb[0] . '" alt="' . $post->post_title . '">
		                    		</div>';
                            } else {
                                $africa .= '<div class="thumb-img">
		                        		<img src="' . $placeholder . '" alt="' . $post->post_title . '">
		                    		</div>';
                            }
							*/
                            $africa .='<h2>' . $post->post_title . '</h2>
								</a>
							</div>';
						}
						$row++; 
					}
				$africa .= '</div>
			</div>
			<div class="spotify hp-right">';
				$news_tags = sigma_mt_get_news_tags_data(1942, $taxonomy, 12);
				$africa .= '<div class="h-title">
					<a href="' . get_tag_link($news_tags['term_value']->term_id) . '">' .
						$news_tags['term_value']->name . '<i class="fa fa-angle-right" aria-hidden="true"></i>
					</a>
				</div>
				<div class="blog-listing-module">';
					$row = 0;
					foreach ( $news_tags['term_data'] as $k => $post ) {
			        	setup_postdata( $post );
			        	//$featured_image_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
						$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			        	if($row === 0) {
							$africa .= '<div class="post-item">
								<a href="' . get_permalink($post) . '">';
							if ($featured_image) {
                                $africa .= '<div class="thumb-img">
		                        		<img src="' . $featured_image[0] . '" alt="' . $post->post_title . '">
		                    		</div>';
                            } else {
                                $africa .= '<div class="thumb-img">
		                        		<img src="' . $placeholder_full . '" alt="' . $post->post_title . '">
		                    		</div>';
                            }
                            $africa .= '<h2>' . $post->post_title . '</h2>
								</a>
							</div>';
						} else {
							$africa .= '<div class="post-item">
								<a href="' . get_permalink($post) . '">';
							/*
							if ($featured_image_thumb) {
                                $africa .= '<div class="thumb-img">
		                        		<img src="' . $featured_image_thumb[0] . '" alt="' . $post->post_title . '">
		                    		</div>';
                            } else {
                                $africa .= '<div class="thumb-img">
		                        		<img src="' . $placeholder . '" alt="' . $post->post_title . '">
		                    		</div>';
                            }
							*/
                                $africa .= '<h2>' . $post->post_title . '</h2>
								</a>
							</div>';
						}
						$row++; 
					}
				$africa .= '</div>
			</div>
		</div>
	</div>
</section>'; ?>

<?php 
$sort = isset($_GET['front_page_sort']) ?  $_GET['front_page_sort'] : '';
if($sort == 'asia'){
	echo $asia . do_shortcode( '[sigma-mt-banner-adds banner_add="sigma_asia_banners" page_id='.$page_id.']' ) . $europe . do_shortcode( '[sigma-mt-banner-adds banner_add="sigma_europe_banners" page_id='.$page_id.']' ) . $americas .  do_shortcode( '[sigma-mt-banner-adds banner_add="sigma_americas_banners" page_id='.$page_id.']' ) . $africa . do_shortcode( '[sigma-mt-banner-adds banner_add="sigma_africa_banners" page_id='.$page_id.']' );
} else if($sort == 'americas'){
	echo $americas . do_shortcode( '[sigma-mt-banner-adds banner_add="sigma_americas_banners" page_id='.$page_id.']' ) . $europe . do_shortcode( '[sigma-mt-banner-adds banner_add="sigma_europe_banners" page_id='.$page_id.']' ) . $asia . do_shortcode( '[sigma-mt-banner-adds banner_add="sigma_asia_banners" page_id='.$page_id.']' ) . $africa . do_shortcode( '[sigma-mt-banner-adds banner_add="sigma_africa_banners" page_id='.$page_id.']' );
} else if($sort == 'africa'){
	echo $africa . do_shortcode( '[sigma-mt-banner-adds banner_add="sigma_africa_banners" page_id='.$page_id.']' ) . $europe . do_shortcode( '[sigma-mt-banner-adds banner_add="sigma_europe_banners" page_id='.$page_id.']' ) . $asia . do_shortcode( '[sigma-mt-banner-adds banner_add="sigma_asia_banners" page_id='.$page_id.']' ) . $americas . do_shortcode( '[sigma-mt-banner-adds banner_add="sigma_americas_banners" page_id='.$page_id.']' );
} else{
	echo $europe . do_shortcode( '[sigma-mt-banner-adds banner_add="sigma_europe_banners" page_id='.$page_id.']' ) . $asia . do_shortcode( '[sigma-mt-banner-adds banner_add="sigma_asia_banners" page_id='.$page_id.']' ) . $americas . do_shortcode( '[sigma-mt-banner-adds banner_add="sigma_americas_banners" page_id='.$page_id.']' ) . $africa . do_shortcode( '[sigma-mt-banner-adds banner_add="sigma_africa_banners" page_id='.$page_id.']' );
}
?>