<?php
/**
 * The template for displaying content in the archive.php template
 *
 */
?>


<?php
  global $data, $post, $page, $paged, $wp_query;
  $ct_pagination_type = stripslashes ( $data['ct_pagination_type'] );  
  $use_excerpt = stripslashes( $data['ct_excerpt_function'] );
  $excerpt_lenght = stripslashes( $data['ct_excerpt_length'] );  
  $divider_type = stripslashes( $data['ct_divider_type'] ); 
?>

<?php

if ( $ct_pagination_type == 'Show more button' ) :
	// Queue JS and CSS
	wp_enqueue_script(
		'pbd-alp-load-posts',
		get_template_directory_uri() . '/js/load-posts.js',
		array('jquery'),
		'1.0',
		true
	);
 		
	// What page are we on? And what is the pages limit?
	$max = $wp_query->max_num_pages;

	if ( get_query_var('paged') ) {
      $paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) {
	  $paged = get_query_var('page');
	} else {
	  $paged = 1;
	}
 		
	// Add some parameters for the JS.
	wp_localize_script(
		'pbd-alp-load-posts',
		'pbd_alp',
		array(
			'startPage' => $paged,
			'maxPages' => $max,
			'nextLink' => next_posts($max, false)
		)
	);
endif;
?>


<div class="ct-page margin-30t box border-1px bottom-shadow clearfix">
	<div class="row-fluid">
		<div class="span12 button-blog">
			<div class="category-title">
			    <h1 class="entry-title">
					<?php if ( is_day() ) : ?>
						<?php printf( __( 'Daily Archives: %s', 'color-theme-framework' ), '<span>' . get_the_date() . '</span>' ); ?>
					<?php elseif ( is_month() ) : ?>
						<?php printf( __( 'Monthly Archives: %s', 'color-theme-framework' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'color-theme-framework' ) ) . '</span>' ); ?>
					<?php elseif ( is_year() ) : ?>
						<?php printf( __( 'Yearly Archives: %s', 'color-theme-framework' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'color-theme-framework' ) ) . '</span>' ); ?>
					<?php else : ?>
						<?php _e( 'Blog Archives', 'color-theme-framework' ); ?>
					<?php endif; ?>
			    </h1>
				<div class="widget-devider"></div>
		    </div> <!-- category-title -->

			<div id="entry-blog">
				<?php if ( have_posts() ) :
					while ( have_posts() ) : the_post(); ?>
					
					<?php 
					// Retrieve the color of category
					$category = get_the_category(); 
					$cat_color = ct_get_color($category[0]->term_id);
					if ( $cat_color == '') { $cat_color = '#000'; }

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

					//Get data for post meta
					if ($data['ct_show_meta']['likes'] == '1') : $show_likes = 'true'; else : $show_likes = 'false'; endif;
					if ($data['ct_show_meta']['comments'] == '1') : $show_comments = 'true'; else : $show_comments = 'false'; endif;
					if ($data['ct_show_meta']['views'] == '1') : $show_views = 'true'; else : $show_views = 'false'; endif;
					if ($data['ct_show_meta']['date'] == '1') : $show_date = 'true'; else : $show_date = 'false'; endif;
					if ($data['ct_show_meta']['category'] == '1') : $show_category = 'true'; else : $show_category = 'false'; endif;
					?>


					<article id="post-<?php the_ID(); ?>" <?php post_class('entry-post'); ?>>	
   						<div class="cat-one-columnn <?php echo $format . " " . $post_type; ?>">
	  	  			
	  	  				<?php 
	  
	  					// if Video post format
	  					if ( $ct_format == 'video' ) : get_template_part( 'includes/widget', $ct_format );

	    				// if Audio post format
	  					elseif( $ct_format == 'audio' ): get_template_part( 'includes/widget', $ct_format );

	  					// if Gallery post format	
	  					elseif( ($ct_format == 'gallery') and ( $ct_pagination_type != 'Show more button' ) ): get_template_part( 'includes/widget', $ct_format );

						else:

							// if post has Feature image
							if(has_post_thumbnail()) : ?>
	      	  					<div class="widget-post-big-thumb ct-preload">
		        					<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'slider-thumb'); ?>	
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>
		  	  					</div><!-- .widget-post-big-thumb -->
	    					<?php 
	    					// if Gallery post has no Feature image, display first image from Gallery
	    					elseif (!has_post_thumbnail() && $ct_format == 'gallery'):

	    						$meta_gallery = get_post_meta(get_the_ID(), 'ct_mb_gallery', false);

								if (!is_array($meta_gallery)) $meta_gallery = (array) $meta_gallery;

								$meta_gallery = implode(',', $meta_gallery);

								$images = $wpdb->get_col("
									SELECT ID FROM $wpdb->posts
									WHERE post_type = 'attachment'
									AND ID in ($meta_gallery)
									ORDER BY menu_order ASC
								");

								foreach ($images as $att) {
									$src = wp_get_attachment_image_src($att, 'slider-thumb');
									$src = $src[0];
								?>

	      	  					<div class="widget-post-big-thumb ct-preload">
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $src; ?>" alt="<?php the_title(); ?>" /></a>
		  	  					</div><!-- .widget-post-big-thumb -->

								<?php
								break;
								 } 

	    					endif; //has_post_thumbnail

	  					endif; ?>

		  				<!-- different meta style if no thumbnail -->
		  				<?php if(has_post_thumbnail() or ($ct_format == 'audio') or ($ct_format == 'video') or ($ct_format == 'gallery') ): ?>

		  					<!-- with thumbnail -->
	        				<div class="meta-posted-by muted-small" style="border-top: 3px solid <?php echo $cat_color; ?>;">
			        			<?php _e('Posted by ','color-theme-framework'); echo the_author_posts_link(); ?>
    							<span class="post-format" title="<?php echo $format; ?>" style="background-color:<?php echo $cat_color; ?>;"><i class="ct-format <?php echo $format; ?>"></i></span><!-- post-format -->
	        				</div><!-- .meta-posted-by -->
	        
	        				<span class="meta-time"><?php echo esc_attr( get_the_date( 'd F' ) ); ?></span><!-- meta-time -->

						<!-- without thumbnail -->
		  				<?php else: ?>

							<div style="margin-bottom: 15px;padding-top: 3px;border-top: 3px solid <?php echo $cat_color; ?>;">
		        				<span class="meta-posted-by muted-small"><?php _e('Posted by ','color-theme-framework'); echo the_author_posts_link(); ?></span><!-- .meta-posted-by -->
	        					<span style="font-size:11px;"><?php _e('on','color-theme-framework'); ?></span>
	        					<span class="meta-time no-thumb muted-small"><?php echo esc_attr( get_the_date( 'd F' ) ); ?></span><!-- meta-time -->
								<span class="post-format" title="<?php echo $format; ?>" style="top: 0;background-color:<?php echo $cat_color; ?>;"><i class="ct-format <?php echo $format; ?>"></i></span><!-- post-format -->
	      					</div>
		  				<?php endif; ?>

		  				<!-- title -->
		  				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>"><?php the_title(); ?></a></h2>

		  				<!-- post excerpt -->
		  				<div class="entry-content">
				    		<?php if ( $use_excerpt == 'Content' ) {	
					  			the_content('',true,'');
				    		}	
				    		else if ( $use_excerpt == 'Excerpt' ){
					  			$post_excerpt = get_the_excerpt(); echo strip_tags(substr($post_excerpt, 0, $excerpt_lenght ) );
				    		} ?>
		  				</div><!-- .entry-content -->

		  				<?php
		  				//Get post type: standard post or review
						$post_type = get_post_meta($post->ID, 'ct_mb_post_type', true);
						if( $post_type == '' ) $post_type = 'standard_post';

						// Check if post is Review, then show rating
						if ( $post_type == 'review_post' ) : ?>
							<div class="meta clearfix">
								<?php
								ct_get_rating_stars();
								ct_get_post_meta($post->ID, $show_likes, $show_comments, $show_views, $show_date, $show_category );
								?>
								<?php ct_get_readmore(); // get read more link ?>
							</div><!-- .meta -->
						<?php
						// Else, show standard meta
						else : ?>

							<div class="meta">
								<?php ct_get_post_meta($post->ID, $show_likes, $show_comments, $show_views, $show_date, $show_category ); ?>
								<?php ct_get_readmore(); // get read more link ?>
							</div><!-- .meta -->
						<?php endif; ?>

						<?php
						// Divider type
						if ( $divider_type == 'striped') : ?>
							<div class="widget-devider"></div>
						<?php else: ?>
							<div class="widget-devider-1px"></div>
						<?php endif; ?>

						</div><!-- .cat-one-columnn  -->

					</article> <!-- /post ID -->

				<?php endwhile; endif;  ?>

			</div><!-- entry-blog -->

	    <!-- Begin Navigation -->
		<?php if ( $wp_query->max_num_pages > 1 ) : ?>
		  <div class="blog-navigation clearfix" role="navigation">
			<?php if(function_exists('ct_pagination')) { ct_pagination(); } ?>
		  </div> <!-- blog-navigation -->
		<?php endif; ?>
		<!-- End Navigation -->


</div><!-- span12 -->
</div><!-- row-fluid -->
</div><!-- .widget -->