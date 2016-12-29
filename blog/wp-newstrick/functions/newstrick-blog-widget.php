<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT Blog Widget
 	Plugin URI: http://www.color-theme.com
 	Description: A widget that show recent posts as Blog.
 	Version: 1.0
 	Author: ZERGE
 	Author URI:  http://www.color-theme.com
 
-----------------------------------------------------------------------------------
*/


/**
 * Add function to widgets_init that'll load our widget.
 */

add_action('widgets_init','CT_blog_load_widgets');


function CT_blog_load_widgets(){
		register_widget("CT_blog_Widget");
}

/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update. 
 *
 */
class CT_blog_Widget extends WP_widget{

	/**
	 * Widget setup.
	 */	
	function CT_blog_Widget(){
		
		/* Widget settings. */	
		$widget_ops = array( 'classname' => 'ct_blog_widget', 'description' => __( 'Blog Widget' , 'color-theme-framework' ) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'ct_blog_widget' );
		
		/* Create the widget. */
		parent::__construct( 'ct_blog_widget', __( 'CT: Blog Widget' , 'color-theme-framework' ) ,  $widget_ops, $control_ops );
		
	}
	
	function widget($args,$instance){
		extract($args);	

		global $data, $post, $wp_query, $query;

		$ct_num_blog_posts = $instance['ct_num_blog_posts'];
		//$categories = $instance['categories'];
		$title = apply_filters ('widget_title', $instance ['title']);
		$pagination_type = $instance['pagination_type'];

		$show_image = isset($instance['show_image']) ? 'true' : 'false';
		$show_likes = isset($instance['show_likes']) ? 'true' : 'false';
		$show_comments = isset($instance['show_comments']) ? 'true' : 'false';
		$show_views = isset($instance['show_views']) ? 'true' : 'false';
		$show_date = isset($instance['show_date']) ? 'true' : 'false';
		$show_category = isset($instance['show_category']) ? 'true' : 'false';
		$excerpt_lenght = $instance['excerpt_lenght'];
		$video_height = $instance['video_height'];
		$widget_width = $instance['widget_width'];
		$background = $instance['background'];
		$background_title = $instance['background_title'];
		$divider_type = $instance['divider_type'];

		// Get number of posts to display from Theme Options
		$blog_num_posts = stripslashes( $data['ct_blog_num_posts'] );

		$max = 0;
		$count_posts = wp_count_posts();
		$ct_post_count = $count_posts->publish;
		$max = ceil ($ct_post_count / $blog_num_posts);

		/* Before widget (defined by themes). */
		if ( $title ){
			echo "\n<!-- START BLOG WIDGET -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget ct-blog-widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';">';
			echo '<div class="widget-title bottom-shadow" style="background:' . $background_title .';"><h2>' . $title . '</h2><div class="arrow-down" style="border-top-color:' . $background_title . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->';
		} else {
			echo "\n<!-- START BLOG WIDGET -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';padding-top: 20px;">';
		}
				
		?>

		<?php

		if ( get_query_var('paged') ) {
      		$paged = get_query_var('paged');
		} elseif ( get_query_var('page') ) {
	  		$paged = get_query_var('page');
		} else {
	  		$paged = 1;
		}


		if ( !function_exists( 'ct_blog_pagination' ) ) {
    		function ct_blog_pagination($pages = '', $range = 4)
    		{  
        		$showitems = ($range * 2)+1;  
 
		        global $paged;
		        if(empty($paged)) $paged = 1;

		        if($pages == '')
			    {
		            global $wp_query;
            		$pages = $wp_query->max_num_pages;
            		if(!$pages)
            		{
                		$pages = 1;
            		}
        		}   
 
		        if(1 != $pages)
		        {
            		echo "<div class=\"pagination clearfix\"><span>Page ".$paged." of ".$pages."</span>";
            		if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
            		if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
 
            		for ($i=1; $i <= $pages; $i++)
            		{
                		if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
                		{
                    		echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
                		}
            		}
 
		            if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";  
            		if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
            		echo "</div>\n";
        		}
    		}
		}


		// Check if Load More Button
		if ( $pagination_type == 'load_more' ) :
 			wp_enqueue_script(
	 			'pbd-alp-load-posts',
 				get_template_directory_uri() . '/js/load-posts.js',
 				array('jquery'),
 				'1.0',
 				true
 			);

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

		$recent_posts = new WP_Query(array(
			'posts_per_page' => $blog_num_posts,
			'paged' => $paged,
			'post_type' => 'post'
			//'cat' => $categories
		));


		echo "<!-- START #ENTRY-BLOG -->\n";
		echo '<div id="entry-blog">'."\n";

		if ( $recent_posts->have_posts() ) : 
			while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>

				<?php
				// Retrieve the color of category
				$category = get_the_category(); 
				$cat_color = ct_get_color($category[0]->term_id);
				if ( $cat_color == '') { $cat_color = '#000'; }

  				// get post format
	  			$ct_format = get_post_format();
	  
	  			if ( false === $ct_format ) {
	      			$format = 'standard';
	  			} else {
		  			$format = $ct_format;
	  			}

		  		//Get post type: standard post or review
				$post_type = get_post_meta($post->ID, 'ct_mb_post_type', true);
				if( $post_type == '' ) $post_type = 'standard_post';
				?>
			
				<article id="post-<?php the_ID(); ?>" class="entry-post post" >	

   				<div class="cat-one-columnn <?php echo $format . " " . $post_type; ?>">
	  	  			
	  	  			<?php 
	  
	  				// if Video post format
	  				if ( $ct_format == 'video' ) : get_template_part( 'includes/widget', $ct_format );

	    			// if Audio post format
	  				elseif( $ct_format == 'audio' ): get_template_part( 'includes/widget', $ct_format );

	  				// if Gallery post format	
	  				elseif( ($ct_format == 'gallery') && ( $pagination_type != 'load_more' ) ): get_template_part( 'includes/widget', $ct_format );

					// if post has Feature image
	  				else:

						if(has_post_thumbnail()) : ?>
	      	  				<div class="widget-post-big-thumb ct-preload">
		        				<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'slider-thumb'); ?>	
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>
		  	  				</div><!-- .widget-post-big-thumb -->
	    				<?php endif; //has_post_thumbnail

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
		  			<div class="entry-content"><?php $post_excerpt = get_the_excerpt(); echo strip_tags(mb_substr($post_excerpt, 0, $excerpt_lenght ) ) . ' ...'; ?></div><!-- .entry-content -->

		  			<?php
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

			<?php
			endwhile;
		endif;  

		echo '</div><!-- entry-blog -->'; ?>
		

	    <!-- Begin Navigation -->
		<?php if ( $max > 1 ) : ?>
		  <div class="blog-navigation clearfix" role="navigation">
			<?php if(function_exists('ct_blog_pagination')) { ct_blog_pagination($max); } ?>
		  </div> <!-- blog-navigation -->
		<?php endif; ?>
		<!-- End Navigation -->

		<?php echo $after_widget; 

		// Restor original Query & Post Data
		wp_reset_query();
		wp_reset_postdata();

		$ct_ppp = '0';
		?>
		
<?php } 

	/**
	 * Update the widget settings.
	 */		
	function update($new_instance, $old_instance){
		$instance = $old_instance;

		$instance['ct_num_blog_posts'] = $new_instance['ct_num_blog_posts'];
		//$instance['categories'] = $new_instance['categories'];
		$instance['title'] = $new_instance['title'];
		$instance['pagination_type'] = $new_instance['pagination_type'];
		$instance['show_image'] = $new_instance['show_image'];
		$instance['show_likes'] = $new_instance['show_likes'];
		$instance['show_comments'] = $new_instance['show_comments'];
		$instance['show_views'] = $new_instance['show_views'];
		$instance['show_date'] = $new_instance['show_date'];
		$instance['show_category'] = $new_instance['show_category'];
		$instance['excerpt_lenght'] = $new_instance['excerpt_lenght'];		
		$instance['widget_width'] = $new_instance['widget_width'];
		$instance['video_height'] = $new_instance['video_height'];
		$instance['background'] = strip_tags($new_instance['background']);
		$instance['background_title'] = strip_tags($new_instance['background_title']);
		$instance['divider_type'] = $new_instance['divider_type'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */	
	function form($instance){ 

		global $data;
		$blog_num_posts = stripslashes( $data['ct_blog_num_posts'] );

		$defaults = array(
			'title' => __( 'Latest Posts', 'color-theme-framework' ), 
			//'categories' => 'all',
			'ct_num_blog_posts' => $blog_num_posts, 
			'pagination_type' => 'load_more',
			'show_image'=>'on', 
			'show_likes'=>'on',
			'show_comments'=>'on',
			'show_views'=>'on',
			'show_date'=>'off',
			'show_date'=>'off',
			'show_category'=>'off',
			'widget_width' => 'ct-full-width', 
			'background' => '#FFFFFF', 
			'background_title' => '#ff0000',
			'excerpt_lenght' => '140',
			'video_height' => '231',
			'divider_type' => 'striped',
		);

		$instance = wp_parse_args((array) $instance, $defaults); 
		$background = esc_attr($instance['background']);
		$background_title = esc_attr($instance['background_title']); 

		?>

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
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' , 'color-theme-framework' ); ?></label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('ct_num_blog_posts'); ?>"><?php _e( 'Number of posts:' , 'color-theme-framework' ); ?></label>
			<br/><em>Specified in the Theme Options -> Blog Settings</em>
			<input disabled type="number" min="1" max="100" class="widefat" id="<?php echo $this->get_field_id('ct_num_blog_posts'); ?>" name="<?php echo $this->get_field_name('ct_num_blog_posts'); ?>" value="<?php echo $instance['ct_num_blog_posts']; ?>" />
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

		<p>
			<label for="<?php echo $this->get_field_id( 'pagination_type' ); ?>"><?php _e('Type of Pagination:', 'color-theme-framework'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'pagination_type' ); ?>" name="<?php echo $this->get_field_name( 'pagination_type' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'load_more' == $instance['pagination_type'] ) echo 'selected="selected"'; ?>>load_more</option>
				<option <?php if ( 'standard_numeric' == $instance['pagination_type'] ) echo 'selected="selected"'; ?>>standard_numeric</option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('excerpt_lenght'); ?>"><?php _e( 'Length of post excerpt (chars):' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="500" class="widefat" id="<?php echo $this->get_field_id('excerpt_lenght'); ?>" name="<?php echo $this->get_field_name('excerpt_lenght'); ?>" value="<?php echo $instance['excerpt_lenght']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('video_height'); ?>"><?php _e( 'Height of embedded audio/video (px):' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="1000" class="widefat" id="<?php echo $this->get_field_id('video_height'); ?>" name="<?php echo $this->get_field_name('video_height'); ?>" value="<?php echo $instance['video_height']; ?>" />
		</p>

		<!-- <p>
			<label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e( 'Filter by Category:' , 'color-theme-framework' ); ?></label> 
			<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" class="widefat" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p> -->


		<p>
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
			<label for="<?php echo $this->get_field_id( 'divider_type' ); ?>"><?php _e('Divider type (below the first post):', 'color-theme-framework'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'divider_type' ); ?>" name="<?php echo $this->get_field_name( 'divider_type' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'striped' == $instance['divider_type'] ) echo 'selected="selected"'; ?>>striped</option>
				<option <?php if ( '1px' == $instance['divider_type'] ) echo 'selected="selected"'; ?>>1px</option>
			</select>
		</p>

		<p>
          <label for="<?php echo $this->get_field_id('background'); ?>"><?php _e('Background Color:', 'color-theme-framework'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('background'); ?>" name="<?php echo $this->get_field_name('background'); ?>" type="text" value="<?php if($background) { echo $background; } else { echo '#FFFFFF'; } ?>" />
			<div class="cw-color-picker" rel="<?php echo $this->get_field_id('background'); ?>"></div>
        </p>

		<p>
          <label for="<?php echo $this->get_field_id('background_title'); ?>"><?php _e('Background Title Color:', 'color-theme-framework'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('background_title'); ?>" name="<?php echo $this->get_field_name('background_title'); ?>" type="text" value="<?php if($background_title) { echo $background_title; } else { echo '#ff0000'; } ?>" />
			<div class="cw-color-picker" rel="<?php echo $this->get_field_id('background_title'); ?>"></div>
        </p>

		<?php

	}
}
?>