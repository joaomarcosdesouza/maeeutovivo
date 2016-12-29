<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT Tabbed Widget
 	Plugin URI: http://www.color-theme.com
 	Description: A widget that show recent posts and comments.
 	Version: 1.0
 	Author: ZERGE
 	Author URI:  http://www.color-theme.com
 
-----------------------------------------------------------------------------------
*/



/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'CT_tabbed_widget' );

function CT_tabbed_widget() {
	register_widget( 'CT_Tabbed' );
}


/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update. 
 *
 */
class CT_Tabbed extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function  CT_Tabbed() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'ct-tabbed-widget', 'description' => __( 'A widget that show popular posts' , 'color-theme-framework' ) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'ct-tabbed-widget' );

		/* Create the widget. */
		parent::__construct( 'ct-tabbed-widget', __('CT: Tabbed Widget', 'color-theme-framework'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
		
		global $wpdb;
		$time_id = rand();

		/* Our variables from the widget settings. */
		$title = apply_filters ('widget_title', $instance ['title']);
		$title2 = apply_filters ('widget_title', $instance ['title2']);
		$num_posts = $instance['num_posts'];
		$categories = $instance['categories'];
		$show_image = isset($instance['show_image']) ? 'true' : 'false';
		$show_related = isset($instance['show_related']) ? 'true' : 'false';
		$theme_orderby = $instance['theme_orderby'];
		$show_likes = isset($instance['show_likes']) ? 'true' : 'false';
		$show_comments = isset($instance['show_comments']) ? 'true' : 'false';
		$show_views = isset($instance['show_views']) ? 'true' : 'false';
		$show_date = isset($instance['show_date']) ? 'true' : 'false';
		$show_category = isset($instance['show_category']) ? 'true' : 'false';
		$show_striped = isset($instance['show_striped']) ? 'true' : 'false';
		$show_avatar = isset($instance['show_avatar']) ? 'true' : 'false';
		$num_comments = $instance['num_comments'];
		$comment_len = $instance['comment_len'];
		$thumb_pos = $instance['thumb_pos'];
		$widget_width = $instance['widget_width'];
		$background = $instance['background'];
		$background_title = $instance['background_title'];

		/* Before widget (defined by themes). */
		echo "\n<!-- START TABBED WIDGETS -->\n";
		echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';padding-top: 20px;">';


		/* Display the widget title if one was input (before and after defined by themes). */
		?>
			
		<?php 
			global $post, $data;

			if ( $show_related == 'true' ) { //show related category
				$related_category = get_the_category($post->ID);
				$related_category_id = get_cat_ID( $related_category[0]->cat_name );			
			  
				$recent_posts = new WP_Query(array(
					'showposts' => $num_posts,
					'cat' => $related_category_id, 
					'post__not_in' => array( $post->ID )
				));		
			}
			
			else {
				$recent_posts = new WP_Query(array(
					'showposts' => $num_posts,
					'cat' => $categories,
				));		
			}

		if ( $show_striped == 'true' ) : 
			echo '<style>'."\n";
				echo '.recent-widget-' . $time_id . ' li:nth-child(2n+2) { background-color: ' . $background_title . '; }'."\n";
				echo '.recent-widget-' . $time_id . ' li:nth-child(2n+2) .post-title a,'."\n";
				echo '.recent-widget-' . $time_id . ' li:nth-child(2n+2) .meta-likes,'."\n"; 
				echo '.recent-widget-' . $time_id . ' li:nth-child(2n+2) .meta-comments a,'."\n"; 
				echo '.recent-widget-' . $time_id . ' li:nth-child(2n+2) .meta-views,'."\n"; 
				echo '.recent-widget-' . $time_id . ' li:nth-child(2n+2) .meta-category a,'."\n";
				echo '.recent-widget-' . $time_id . ' li:nth-child(2n+2) .meta-author,'."\n";
				echo '.recent-widget-' . $time_id . ' li:nth-child(2n+2) .meta-date { color: #FFF; }'."\n";
				echo '.recent-widget-' . $time_id . ' { margin-left: -20px; margin-right: -20px; }';
				echo '.recent-widget-' . $time_id . ' li { padding-left: 20px;padding-right: 20px; padding-top: 15px; margin-bottom: 0;}'."\n";
				echo '.recent-widget-' . $time_id . ' li:first-child { padding-top: 0; }'."\n";
				echo '.recent-widget-' . $time_id . ' li { border-bottom: 1px solid #FFF; }'."\n";
			echo '</style>';
		endif; ?>

		<?php if ( $thumb_pos == 'right' ) : 
			//echo '<style>'."\n";
				//echo '.recent-widget-' . $time_id . ' .widget-post-small-thumb { float: right; }'."\n";
				//echo '.recent-widget-' . $time_id . ' .widget-post-small-thumb img { margin-right:0; margin-left: 15px; }'."\n";
			//echo '</style>'."\n";
		endif; ?>

		<?php if ( $thumb_pos == 'right' ) : ?>
		<script type="text/javascript">
		/* <![CDATA[ */
		jQuery.noConflict()(function($){
			$(document).ready(function() {
				$('.recent-widget-<?php echo $time_id ?> .widget-post-small-thumb').css("float","right");
				$('.recent-widget-<?php echo $time_id ?> .widget-post-small-thumb img').css("margin-right","0");
				$('.recent-widget-<?php echo $time_id ?> .widget-post-small-thumb img').css("margin-left","15");
			});
		});
		/* ]]> */
		</script>	
		<?php endif; ?>			 

		<?php
		$recent_comments = get_comments( array(
    		'number'    => $num_comments,
    		'status'    => 'approve'
		) );
		?>


		<!-- Tabs -->
		<section id="ct-tabs-<?php echo $time_id; ?>" class="ct-tabs">
        	<ul id="ctTab-<?php echo $time_id; ?>" class="nav nav-tabs bottom-shadow" style="background:<?php echo $background_title; ?>;">
            	<li class="active">
            		<a href="#ct-posts" data-toggle="tab"><?php echo $title; ?></a>
	            	<div class="arrow-down" style="border-top-color:<?php echo $background_title; ?>"></div><!-- .arrow-down -->
            	</li>

            	<li class="">
	            	<a href="#ct-comments" data-toggle="tab"><?php echo $title2; ?></a>
					<div class="arrow-down" style="border-top-color:<?php echo $background_title; ?>"></div><!-- .arrow-down -->
            	</li>
         	</ul>

          	<div id="ctTabContent-<?php echo $time_id; ?>" class="tab-content">
            	
          		<!-- Start Recent Posts -->
            	<div class="tab-pane fade active in" id="ct-posts">
					<ul class="recent-posts-widget recent-widget-<?php echo $time_id; ?>">
						<?php while($recent_posts->have_posts()): $recent_posts->the_post(); ?>
							<li class="clearfix">
								<?php
								if( $show_image == 'true' ):
									if(has_post_thumbnail()):
				    					$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'small-thumb'); 
				    					if ( $image[1] == 75 && $image[2] == 75 ) : //if has generated thumb ?>
						 					<div class="widget-post-small-thumb">
												<a href='<?php the_permalink(); ?>' title='<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>'><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>
						  					</div><!-- widget-post-small-thumb -->
										<?php 
										else : // else use standard 150x150 thumb
					  		  				$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail'); ?>
						 	 				<div class="widget-post-small-thumb">
												<a href='<?php the_permalink(); ?>' title='<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>'><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>
											</div><!-- widget-post-small-thumb -->
					  					<?php
					  					endif;
									endif; //has_post_thumbnail
								endif; //show_image ?>

								<div class="post-title">
									<h5><a href='<?php the_permalink(); ?>' title='<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>'><?php the_title(); ?></a></h5>
								</div><!-- post-title -->

		  						<?php
		  						//Get post type: standard post or review
								$post_type = get_post_meta($post->ID, 'ct_mb_post_type', true);
								if( $post_type == '' ) $post_type = 'standard_post';

								// Check if post is Review, then show rating
								if ( $post_type == 'review_post' ) : ?>
									<div class="meta">
										<?php
										ct_get_rating_stars_s();
										ct_get_post_meta($post->ID, $show_likes, $show_comments, $show_views, $show_date, $show_category);
										?>
									</div><!-- .meta -->
								<?php
								// Else, show standard meta
								else : ?>

								<div class="meta">
									<?php ct_get_post_meta($post->ID, $show_likes, $show_comments, $show_views, $show_date, $show_category); ?>
								</div><!-- .meta -->
								<?php endif; ?>
							</li>	
						<?php endwhile; ?>
					</ul>
            	</div><!-- .tab-pane -->


				<!-- Start Recent Comments -->
            	<div class="tab-pane fade" id="ct-comments">
					<ul class="recent-comments-widget recent-widget-<?php echo $time_id; ?>">
						<?php foreach( $recent_comments as $comment ) { ?>
							<li class="clearfix">
								<?php
								if( $show_avatar == 'true' ) {
									echo '<div class="widget-post-small-thumb">'."\n";
									echo get_avatar( $comment, $size='55', $default='' );
									echo '</div><!-- widget-post-small-thumb -->'."\n";
								} ?>

								<div class="comment-text">
					 				<a href="<?php echo get_permalink( $comment->comment_post_ID ); ?>">
										<?php		 
										echo strip_tags(substr(apply_filters('get_comment_text', $comment->comment_content), 0, $comment_len ) ) . ' ...'; 
										?>
									</a>
								</div><!-- .comment-text -->

		  						<div class="meta">
		  							<span class="meta-author" title="<?php _e('Author','color-theme-framework'); ?>">
		  								<?php echo ct_get_author($comment); ?>
            						</span>
		  							<span class="meta-date" title="<?php _e('Date','color-theme-framework'); ?>">
		  								<?php comment_date( 'd F, Y', $comment->comment_ID ); ?>
            						</span>
									<?php //echo $comment->comment_post_ID; ct_get_post_meta($post->ID, false, false, false, $show_date, $show_category ); ?>
		  						</div><!-- .meta -->
							</li> 
						<?php } ?>
					</ul><!-- .recent-comments-widget -->
            	</div><!-- .tab-pane -->
          	</div><!-- .tab-content -->
    	</section>







		<?php
		/* After widget (defined by themes). */
		echo $after_widget;

	 	// Restor original Query & Post Data
		wp_reset_query();
		wp_reset_postdata();		
		}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['title2'] = strip_tags( $new_instance['title2'] );
		$instance['categories'] = $new_instance['categories'];
		$instance['num_posts'] = $new_instance['num_posts'];
		$instance['show_image'] = $new_instance['show_image'];
		$instance['show_related'] = $new_instance['show_related'];
		$instance['theme_orderby'] = $new_instance['theme_orderby'];
		$instance['show_likes'] = $new_instance['show_likes'];
		$instance['show_comments'] = $new_instance['show_comments'];
		$instance['show_views'] = $new_instance['show_views'];
		$instance['show_date'] = $new_instance['show_date'];
		$instance['show_category'] = $new_instance['show_category'];
		$instance['show_striped'] = $new_instance['show_striped'];
		$instance['show_avatar'] = $new_instance['show_avatar'];
		$instance['num_comments'] = $new_instance['num_comments'];
		$instance['comment_len'] = $new_instance['comment_len'];
		$instance['thumb_pos'] = $new_instance['thumb_pos'];
		$instance['widget_width'] = $new_instance['widget_width'];
		$instance['background'] = strip_tags($new_instance['background']);
		$instance['background_title'] = strip_tags($new_instance['background_title']);
		
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form($instance)
	{
		/* Set up some default widget settings. */
		$defaults = array(
			'title' => __( 'Recent Posts' , 'color-theme-framework' ),
			'title2' => __( 'Recent Comments' , 'color-theme-framework' ),
			'num_posts' => 4,
			'categories' => 'all',
			'show_related' => 'off',
			'show_image'=>'on', 
			'show_likes'=>'on',
			'show_comments'=>'on',
			'show_views'=>'on',
			'show_date'=>'off',
			'show_category' => 'off',
			'show_striped'=>'off',
			'show_avatar'=>'on',
			'num_comments' => 4,
			'comment_len' => 75,
			'thumb_pos' => 'left', 
			'widget_width' => 'ct-full-width', 
			'background' => '#FFFFFF', 
			'background_title' => '#00A1D9',
			'theme_orderby' => 'comments'
		);

		$instance = wp_parse_args((array) $instance, $defaults); 
		$background = esc_attr($instance['background']);
		$background_title = esc_attr($instance['background_title']); ?>

		<script type="text/javascript">
			//<![CDATA[
				jQuery(document).ready(function()
				{
					// colorpicker field
					jQuery('.cw-color-picker').each(function(){
						var $this = jQuery(this),
							id = $this.attr('rel');

						$this.farbtastic('#' + id);
					});
				});
			//]]>   
		  </script>	
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title1:' , 'color-theme-framework' ) ?></label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('num_posts'); ?>"><?php _e( 'Number of posts:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="100" class="widefat" id="<?php echo $this->get_field_id('num_posts'); ?>" name="<?php echo $this->get_field_name('num_posts'); ?>" value="<?php echo $instance['num_posts']; ?>" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_related'], 'on'); ?> id="<?php echo $this->get_field_id('show_related'); ?>" name="<?php echo $this->get_field_name('show_related'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_related'); ?>"><?php _e( 'Show related category posts' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_image'], 'on'); ?> id="<?php echo $this->get_field_id('show_image'); ?>" name="<?php echo $this->get_field_name('show_image'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_image'); ?>"><?php _e( 'Show thumbnail image' , 'color-theme-framework' ); ?></label>
		</p>

		<p style="margin-top: 20px;">
			<label style="font-weight: bold;"><?php _e( 'Post meta info' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_likes'], 'on'); ?> id="<?php echo $this->get_field_id('show_likes'); ?>" name="<?php echo $this->get_field_name('show_likes'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_likes'); ?>"><?php _e( 'Show likes' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_comments'], 'on'); ?> id="<?php echo $this->get_field_id('show_comments'); ?>" name="<?php echo $this->get_field_name('show_comments'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_comments'); ?>"><?php _e( 'Show comments' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_views'], 'on'); ?> id="<?php echo $this->get_field_id('show_views'); ?>" name="<?php echo $this->get_field_name('show_views'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_views'); ?>"><?php _e( 'Show views' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_date'], 'on'); ?> id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e( 'Show date' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_category'], 'on'); ?> id="<?php echo $this->get_field_id('show_category'); ?>" name="<?php echo $this->get_field_name('show_category'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_category'); ?>"><?php _e( 'Show category' , 'color-theme-framework' ); ?></label>
		</p>

		<p style="margin-top: 30px;">
			<input class="checkbox" type="checkbox" <?php checked($instance['show_striped'], 'on'); ?> id="<?php echo $this->get_field_id('show_striped'); ?>" name="<?php echo $this->get_field_name('show_striped'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_striped'); ?>"><?php _e( 'Show as striped' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e( 'Filter by Category:' , 'color-theme-framework' ); ?></label> 
			<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" class="widefat categories" style="width:100%;">
				<option value='all' <?php if ( 'all' == $instance['categories'] ) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories = get_categories( 'hide_empty=0&depth=1&type=post' ); ?>
				<?php foreach( $categories as $category ) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'thumb_pos' ); ?>"><?php _e('Thumbnail position:', 'color-theme-framework'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'thumb_pos' ); ?>" name="<?php echo $this->get_field_name( 'thumb_pos' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'left' == $instance['thumb_pos'] ) echo 'selected="selected"'; ?>>left</option>
				<option <?php if ( 'right' == $instance['thumb_pos'] ) echo 'selected="selected"'; ?>>right</option>
			</select>
		</p>

		<p style="margin-top: 30px;">
			<label style="font-weight: bold;"><?php _e( 'Recent Comment Settings' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('title2'); ?>"><?php _e( 'Title2:' , 'color-theme-framework' ) ?></label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title2'); ?>" name="<?php echo $this->get_field_name('title2'); ?>" value="<?php echo $instance['title2']; ?>" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_avatar'], 'on'); ?> id="<?php echo $this->get_field_id('show_avatar'); ?>" name="<?php echo $this->get_field_name('show_avatar'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_avatar'); ?>"><?php _e( 'Show avatar' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('num_comments'); ?>"><?php _e( 'Number of comments:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="100" class="widefat" id="<?php echo $this->get_field_id('num_comments'); ?>" name="<?php echo $this->get_field_name('num_comments'); ?>" value="<?php echo $instance['num_comments']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('comment_len'); ?>"><?php _e( 'Comments lenght:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="300" class="widefat" id="<?php echo $this->get_field_id('comment_len'); ?>" name="<?php echo $this->get_field_name('comment_len'); ?>" value="<?php echo $instance['comment_len']; ?>" />
		</p>

		<p style="margin-top: 30px;">
			<label for="<?php echo $this->get_field_id( 'widget_width' ); ?>"><?php _e('Widget width:', 'color-theme-framework'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'widget_width' ); ?>" name="<?php echo $this->get_field_name( 'widget_width' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'span2' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span2</option>
				<option <?php if ( 'span3' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span3</option>
				<option <?php if ( 'span4' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span4</option>
				<option <?php if ( 'span5' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span5</option>				
				<option <?php if ( 'span6' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span6</option>
				<option <?php if ( 'span7' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span7</option>
				<option <?php if ( 'span8' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span8</option>
				<option <?php if ( 'span9' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span9</option>
				<option <?php if ( 'span10' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span10</option>
				<option <?php if ( 'span11' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span11</option>
				<option <?php if ( 'span12' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>span12</option>
				<option <?php if ( 'ct-full-width' == $instance['widget_width'] ) echo 'selected="selected"'; ?>>ct-full-width</option>
			</select>
		</p>

		<p>
          <label for="<?php echo $this->get_field_id('background'); ?>"><?php _e('Background Color:', 'color-theme-framework'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('background'); ?>" name="<?php echo $this->get_field_name('background'); ?>" type="text" value="<?php if($background) { echo $background; } else { echo '#FFFFFF'; } ?>" />
			<div class="cw-color-picker" rel="<?php echo $this->get_field_id('background'); ?>"></div>
        </p>

		<p>
          <label for="<?php echo $this->get_field_id('background_title'); ?>"><?php _e('Background Title Color:', 'color-theme-framework'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('background_title'); ?>" name="<?php echo $this->get_field_name('background_title'); ?>" type="text" value="<?php if($background_title) { echo $background_title; } else { echo '#748098'; } ?>" />
			<div class="cw-color-picker" rel="<?php echo $this->get_field_id('background_title'); ?>"></div>
        </p>
        
	<?php 
	}
}

?>