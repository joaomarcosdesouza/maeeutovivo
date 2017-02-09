<?php
/**
 * The template for displaying content in the single.php template
 *
 */
?>

<?php
  global $data, $post;
  $featured_image_post = stripslashes( $data['ct_featured_image_post'] );
  $blog_sharing = stripslashes( $data['ct_blog_sharing'] );
  $about_author = stripslashes( $data['ct_about_author'] );
  $disqus_shortname = stripslashes( $data['ct_disqus_shortname'] );
  $facebook_appid = stripslashes( $data['ct_facebook_appid'] );
?>

<div class="row-fluid">
	<div class="span12">
		<div id="entry-post" class="margin-30t box border-1px bottom-shadow clearfix">
	    	<?php 
		  	if ( have_posts() ) : 
		  		while ( have_posts() ) : the_post(); 
       	    		setPostViews(get_the_ID()); 

  	  				// get post format
	  				$ct_format = get_post_format();
	  
	  				if ( false === $ct_format ) {
	      				$format = 'image';
	  				} else {
		  				$format = $ct_format;
	  				}

					//Get post type: standard post or review
					$post_type = get_post_meta($post->ID, 'ct_mb_post_type', true);
					if( $post_type == '' ) $post_type = 'standard_post';
       	    		?>
			
       	    		<?php if ($post_type == 'standard_post') : ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/BlogPosting">
					<?php else: ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemprop="review" itemscope itemtype="http://schema.org/Review">
					<?php endif; ?>
	  				
	  					<?php
	  					$cat_color = '';

	  					if ( !is_attachment() ) {
							// Retrieve the color of category
							$category = get_the_category(); 
							$cat_color = ct_get_color($category[0]->term_id);
						}

						if ( $cat_color == '') { $cat_color = '#000'; }

	  					// if Video post format
	  					if ( $ct_format == 'video' ) : get_template_part( 'includes/widget', $ct_format );

	    				// if Audio post format
	  					elseif( $ct_format == 'audio' ): get_template_part( 'includes/widget', $ct_format );

	  					// if Gallery post format	
	  					elseif( $ct_format == 'gallery' ): get_template_part( 'includes/widget', $ct_format );

						// if post has Feature image
	  					else:

							if ( $featured_image_post == 'Show' ) :
								if(has_post_thumbnail()) : ?>
			      	  				<div class="widget-post-big-thumb ct-preload">
		        						<?php 
		        						$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'post-thumb');
		                  				$large_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
		        						?>	
										<a data-rel="prettyPhoto" href="<?php echo $large_image[0]; ?>" title="<?php the_title(); ?>"><img itemprop="image" src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>
		  	  						</div><!-- .widget-post-big-thumb -->
	    						<?php
	    						endif; //has_post_thumbnail
	    					endif; //featured_image_post

		  				endif; ?>

		  				<!-- different meta style if no thumbnail -->
	        			<div class="meta-posted-by muted-small" style="border-top: 3px solid <?php echo $cat_color; ?>;">
		        			<?php 
		        				$author = sprintf( '<span class="author vcard">%4$s<a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
								esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
								esc_attr( sprintf( __( 'View all posts by %s', 'color-theme-framework' ), get_the_author() ) ),
								get_the_author(),
								_e('Posted by ','color-theme-framework')
								);
								printf( $author	);
							?>
		        			<meta itemprop="author" content="<?php echo get_the_author_meta( 'nickname' ); ?>">
    						<span class="post-format" title="<?php echo $format; ?>" style="background-color:<?php echo $cat_color; ?>;"><i class="ct-format <?php echo $format; ?>"></i></span><!-- post-format -->
	        			</div><!-- .meta-posted-by -->

		  				<!-- title -->
		  				<?php if( $post_type == 'review_post' ) : ?>
		  					<h1 class="entry-title" itemprop="itemreviewed"><?php the_title(); ?></h1>
		  					<meta itemprop="author" content="<?php the_author(); ?>">
		  				<?php else : ?>
		  					<h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
		  				<?php endif; ?>


						<?php if( $post_type == 'review_post' ) : ?>
			  			
			  			<!-- Review Score -->
			  			<div class="review-block">
			  				<div class="overall_score" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">

			  					<?php 
			  					$p_ID = get_the_ID();
			  				
			  					$overall_name = get_post_meta( $post->ID, 'ct_mb_over_name', true); 
			  					$overall_score = get_post_meta( $post->ID, 'ct_mb_over_score', true);
			  					$overall_score_color = get_post_meta( $post->ID, 'ct_mb_overall_color', true);
			  					if ( empty($overall_score_color) ) $overall_score_color = '#dd0c0c';

								// Criteria #1 and Score #1
			  					$c1_name = get_post_meta( $post->ID, 'ct_mb_criteria1_name', true);
			  					$c1_score = get_post_meta( $post->ID, 'ct_mb_criteria1_score', true);

								// Criteria #2 and Score #2
			  					$c2_name = get_post_meta( $post->ID, 'ct_mb_criteria2_name', true);
			  					$c2_score = get_post_meta( $post->ID, 'ct_mb_criteria2_score', true);

								// Criteria #3 and Score #3
			  					$c3_name = get_post_meta( $post->ID, 'ct_mb_criteria3_name', true);
			  					$c3_score = get_post_meta( $post->ID, 'ct_mb_criteria3_score', true);

								// Criteria #4 and Score #4
			  					$c4_name = get_post_meta( $post->ID, 'ct_mb_criteria4_name', true);
			  					$c4_score = get_post_meta( $post->ID, 'ct_mb_criteria4_score', true);

								// Criteria #5 and Score #5
			  					$c5_name = get_post_meta( $post->ID, 'ct_mb_criteria5_name', true);
			  					$c5_score = get_post_meta( $post->ID, 'ct_mb_criteria5_score', true);

								// Criteria #5 and Score #5
								$summary = get_post_meta( $post->ID, 'ct_mb_summary', true);

			  					echo '<span class="score_name">' . $overall_name . '</span>'; 
			  					echo '<span class="score_value" style="color:' . $overall_score_color .';">' . $overall_score . '</span>'; 
					  			?>
			  			
							      <meta itemprop="worstRating" content = "1">
							      <meta itemprop="ratingValue" content = "<?php echo $overall_score; ?>">
							      <meta itemprop="bestRating" content = "5">

			  					<ul class="score-list">
			  						<?php if ( !empty($c1_name) ): ?>
			  						<li class="clearfix">
			  							<?php 
			  							echo '<span class="criteria_name">' . $c1_name . '</span>';
										echo '<div class="rating-stars">';
										echo ct_get_single_rating ( $c1_score, $post->ID );
										echo '</div>';	
										?>
				  					</li>
				  					<?php endif;?>
				  					<?php if ( !empty($c2_name) ): ?>
			  						<li class="clearfix">
		  								<?php 
		  								echo '<span class="criteria_name">' . $c2_name . '</span>';
										echo '<div class="rating-stars">';
										echo ct_get_single_rating ( $c2_score, $post->ID );
										echo '</div>';	
										?>			  			
					  				</li>
					  				<?php endif;?>
					  				<?php if ( !empty($c3_name) ): ?>
					  				<li class="clearfix">
			  							<?php 
			  							echo '<span class="criteria_name">' . $c3_name . '</span>';
										echo '<div class="rating-stars">';
										echo ct_get_single_rating ( $c3_score, $post->ID );
										echo '</div>';	
										?>
			  						</li>
			  						<?php endif;?>
			  						<?php if ( !empty($c4_name) ): ?>
			  						<li class="clearfix">
			  							<?php 
			  							echo '<span class="criteria_name">' . $c4_name . '</span>';
										echo '<div class="rating-stars">';
										echo ct_get_single_rating ( $c4_score, $post->ID );
										echo '</div>';	
										?>			  				
			  						</li>
			  						<?php endif;?>
			  						<?php if ( !empty($c5_name) ): ?>
			  						<li class="clearfix">
			  							<?php 
			  							echo '<span class="criteria_name">' . $c5_name . '</span>';
										echo '<div class="rating-stars">';
										echo ct_get_single_rating ( $c5_score, $post->ID );
										echo '</div>';	
										?>			  				
			  						</li>
									<?php endif;?>
			  						<?php if ( $summary != '' ) : ?>
			  							<li class="summary-review clearfix" itemprop="description" style="background-color:<?php echo $overall_score_color; ?>;">
			  								<?php echo $summary; ?>
			  							</li>
			  						<?php endif; ?>
					  			</ul> <!-- /score-list -->
			  				</div>	<!-- /overall_score -->	 
			  			</div>	<!-- /review-block -->
						<?php endif; //review_post ?>


		  				<!-- post content -->
		  				<?php if( $post_type == 'review_post' ) : ?>
							<div class="entry-content clearfix" itemprop="reviewBody"><?php the_content(); ?></div><!-- .entry-content -->
		  				<?php else : ?>
							<div class="entry-content clearfix" itemprop="articleBody"><?php the_content(); ?></div><!-- .entry-content -->
		  				<?php endif; ?>

						<?php 
						// Displays a link to edit the current post, if a user is logged in and allowed to edit the post
						edit_post_link( __( 'Edit', 'color-theme-framework' ), '<span class="edit-link">', '</span>' ); ?>

						<!-- post tags -->
		  				<div class="entry-tags clearfix">
			    			<?php the_tags('','' ,'' ); ?>
			    			<meta itemprop="keywords" content="<?php echo strip_tags(get_the_tag_list('',', ','')); ?>">
			  			</div><!-- entry-tags -->

						<?php if ( !is_attachment() ) { ?>
			  				<!-- post meta -->
							<div class="meta">
								<?php 
								//If Review, show Stars
								if ( $post_type == 'review_post' ) : 
									ct_get_rating_stars();
								endif; ?>
								<?php getPostLikeLink($post->ID); ?>
								<?php ct_get_post_meta($post->ID, false, true, true, true, true); ?>
								<meta itemprop="datePublished" content="<?php the_time('F j, Y'); ?>"><span class="meta-time"><?php the_time('F j, Y'); ?></span>
							</div><!-- .meta -->
						<?php } ?>
						<div class="widget-devider-1px"></div>


						<?php if ( $blog_sharing != '') { ?>
						<!-- post sharing -->			
							<div class="entry-share">
			  					<div><?php echo $blog_sharing; ?></div>
							</div><!-- entry-share -->
		  				<?php } ?>


						<?php if ( ( $about_author == 'Show') and !is_attachment() ) { ?>
						<!-- about the author -->			
							<div id="author-info" class="clearfix">
								<div id="author-avatar">
									<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyeleven_author_bio_avatar_size', 100 ) ); ?>
								</div><!-- #author-avatar -->

								<div id="author-description">
									<h2 class="entry-title"><?php _e('About the author', 'color-theme-framework'); ?></h2>
									<!-- <meta itemprop="description" content="<?php the_author_meta( 'description' ); ?>"> -->
									<p><?php the_author_meta( 'description' ); ?></p>
									<a style="font-size: 11px;" href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php _e('View all articles by ', 'color-theme-framework'); the_author_meta('display_name'); ?></a>
								</div><!-- #author-description	-->
							</div><!-- #author-info -->
		  				<?php } ?>


						<!-- START COMMENTS -->
			  			<div id="entry-comments" class="clearfix">
							<?php comments_template( '', true ); ?>

							<?php if ($data['ct_comments_type']['facebook'] == true && $facebook_appid != '') { ?>
					    		<div class="post-title" style="margin-top:40px;"><h4 style="border-top: 1px solid #EBECED; padding-top: 10px;"><?php _e('Facebook Comments','color-theme-framework'); ?></h4></div><!-- post-title -->
					    		<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-num-posts="2" data-width="470"></div><!-- fb-comments -->
								<div id="fb-root"></div><!-- fb-root -->
								<script>(function(d, s, id) {
								  var js, fjs = d.getElementsByTagName(s)[0];
								  if (d.getElementById(id)) return;
								  js = d.createElement(s); js.id = id;
								  js.src = <?php echo '"//connect.facebook.net/en_GB/all.js#xfbml=1&appId=' . $facebook_appid . '"'; ?>; ;
								  fjs.parentNode.insertBefore(js, fjs);
								}(document, 'script', 'facebook-jssdk'));</script>
							<?php } ?>


							<?php if ($data['ct_comments_type']['disqus'] == true && $disqus_shortname != '') { ?>
        						<div id="disqus_thread"></div>
        						<script type="text/javascript">
            						/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
            						var disqus_shortname = <?php echo json_encode($disqus_shortname); ?>; // required: replace example with your forum shortname

						            /* * * DON'T EDIT BELOW THIS LINE * * */
            						(function() {
                						var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                						dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
                						(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            						})();
        						</script>
        						<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        						<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
							<?php } ?>

						</div><!-- entry-comments -->
					</article><!-- post-ID -->

					<?php
					if ( is_single() and !is_attachment() ) { ?>
						<nav class="nav-single">
							<div class="widget-devider"></div>
							<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'color-theme-framework' ) . '</span> %title' ); ?></span>
							<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'color-theme-framework' ) . '</span>' ); ?></span>
						</nav><!-- .nav-single -->

						<?php
						if( get_previous_post() || get_next_post() )  { ?>
							<nav class="nav-single-hidden">
								<?php if( get_previous_post() ) : ?>				
									<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'color-theme-framework' ) . '</span> Previous' ); ?></span>
								<?php endif; ?>
								<?php if( get_next_post() ) : ?>
			                        <!-- next_posts_link -->
									<span class="nav-next"><?php next_post_link( '%link', 'Next <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'color-theme-framework' ) . '</span>' ); ?></span>
								<?php endif; ?>	
								<div class="clear"></div>
							</nav><!-- .nav-single-hidden -->
						<?php }
					} else if ( is_attachment() ) { ?>
						<nav id="image-navigation" class="navigation image-navigation clearfix">
							<div class="widget-devider"></div>
							<div class="nav-links">
								<div class="nav-previous"><?php previous_image_link( false, __( 'Previous Image', 'color-theme-framework' ) ); ?></div><div class="nav-next"><?php next_image_link( false, __( 'Next Image', 'color-theme-framework' ) ); ?></div>
							</div><!-- .nav-links -->
						</nav><!-- .image-navigation -->						
					<?php }	?>

				<?php
	  			endwhile;  
			endif;  
			?>		
		</div> <!-- post-entry -->
	  </div><!-- span12 -->
	</div><!-- row-fluid -->