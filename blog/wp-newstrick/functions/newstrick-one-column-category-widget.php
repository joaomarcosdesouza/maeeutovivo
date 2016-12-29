<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT One Column Category Widget
 	Plugin URI: http://www.color-theme.com
 	Description: A widget that show latest posts by category.
 	Version: 1.0
 	Author: ZERGE
 	Author URI:  http://www.color-theme.com
 
-----------------------------------------------------------------------------------
*/


/**
 * Add function to widgets_init that'll load our widget.
 */

add_action('widgets_init','CT_one_columng_cat_load_widgets');


function CT_one_columng_cat_load_widgets(){
		register_widget("CT_one_columng_cat_Widget");
}

/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update. 
 *
 */
class CT_one_columng_cat_Widget extends WP_widget{

	/**
	 * Widget setup.
	 */	
	function CT_one_columng_cat_Widget(){
		
		/* Widget settings. */	
		$widget_ops = array( 'classname' => 'ct_one_columng_cat_widget', 'description' => __( 'One Column Category Widget' , 'color-theme-framework' ) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'ct_one_columng_cat_widget' );
		
		/* Create the widget. */
		parent::__construct( 'ct_one_columng_cat_widget', __( 'CT: One Column Category Widget' , 'color-theme-framework' ) ,  $widget_ops, $control_ops );
		
	}
	
	function widget($args,$instance){
		extract($args);

		$title = apply_filters ('widget_title', $instance ['title']);
		$categories = $instance['categories'];
		$posts = $instance['posts'];
		$excerpt_lenght = $instance['excerpt_lenght'];
		$video_height = $instance['video_height'];
		$widget_width = $instance['widget_width'];
		$background = $instance['background'];
		$background_title = $instance['background_title'];
		$divider_type = $instance['divider_type'];

		?>

		<?php
		  $cat_color = ct_get_color($categories);
		  if ( $cat_color == '') { $cat_color = '#000'; }
		
		/* Before widget (defined by themes). */
		if ( $title ){
			echo "\n<!-- START ONE COLUMN CATEGORY WIDGET -->\n";
			echo '<div class="' . $widget_width . ' ' . $id . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';">';

			if ( $categories != 'all' ):
			  $category_title_link = get_category_link( $categories );
			  echo '<div class="widget-title bottom-shadow" style="background:' . $cat_color .';"><h2><a href="'.$category_title_link.'" title="'.__('View all posts in ','color-theme-framework').$title.'">'.$title.'</a></h2><div class="arrow-down" style="border-top-color:' . $cat_color . ';"></div><!-- .arrow-down --><div class="plus"><a href="'.$category_title_link.'" title="'.__('View all posts in ','color-theme-framework').$title.'"><span></span></a></div><!-- .plus --></div><!-- widget-title -->';
			else :
			  echo '<div class="widget-title bottom-shadow" style="background:' . $background_title .';"><h2>' . $title . '</h2><div class="arrow-down" style="border-top-color:' . $background_title . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->';
			endif;
			
		} else {
			echo "\n<!-- START ONE COLUMN CATEGORY WIDGET -->\n";
			echo '<div class="' . $widget_width . ' ' . $id . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';padding-top: 20px;">';
		}
		
		/* Display the widget title if one was input (before and after defined by themes). */ ?>
		
		<?php	
			$cat_recent_posts = new WP_Query(array(
				'showposts' => $posts,
				'post_type' => 'post',
				'cat' => $categories,
			));
		
		 	global $data, $post, $ct_video_height;
		 	$ct_video_height = $video_height;
		?>


  		<?php while($cat_recent_posts->have_posts()): $cat_recent_posts->the_post(); 
  
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

    	<div class="cat-one-columnn <?php echo $format . " " . $post_type; ?>">
	  	 
	  	<?php 
	  
	  	// if Video post format
	  	if ( $ct_format == 'video' ) : get_template_part( 'includes/widget', $ct_format );

	    // if Audio post format
	  	elseif( $ct_format == 'audio' ): get_template_part( 'includes/widget', $ct_format );

	  	// if Gallery post format	
	  	elseif( $ct_format == 'gallery' ): get_template_part( 'includes/widget', $ct_format );

		// if post has Feature image
	  	else:

			if(has_post_thumbnail()) : ?>
	      		<div class="widget-post-big-thumb ct-preload">
		        	<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'post-thumb'); ?>	
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>
		  	  	</div><!-- .widget-post-big-thumb -->
	    		<?php
	    	endif;

	  	endif; ?>

		
		<?php 
		// different meta style if no thumbnail
		if(has_post_thumbnail() or ($ct_format == 'audio') or ($ct_format == 'video') or ($ct_format == 'gallery') ): 
		?>
		  
		<!-- with thumbnail -->
	    <div class="meta-posted-by muted-small" style="border-top: 3px solid <?php echo $cat_color; ?>;">
	        <?php _e('Posted by ','color-theme-framework'); echo the_author_posts_link(); ?>
    		<span class="post-format" title="<?php echo $format; ?>" style="background-color:<?php echo $cat_color; ?>;"><i class="ct-format <?php echo $format; ?>"></i></span><!-- post-format -->
	    </div><!-- .meta-posted-by -->
	        
	    <span class="meta-time"><?php echo esc_attr( get_the_date( 'd F' ) ); ?></span><!-- meta-time -->
		
		<?php else: ?>

		<!-- without thumbnail -->
		<div style="margin-bottom: 15px;padding-top: 3px;border-top: 3px solid <?php echo $cat_color; ?>;">
	    	<span class="meta-posted-by muted-small"><?php _e('Posted by ','color-theme-framework'); echo the_author_posts_link(); ?></span><!-- .meta-posted-by -->
	        <span style="font-size:11px;"><?php _e('on','color-theme-framework'); ?></span>
	        <span class="meta-time no-thumb muted-small"><?php echo esc_attr( get_the_date( 'd F' ) ); ?></span><!-- meta-time -->
			<span class="post-format" title="<?php echo $format; ?>" style="top: 0;background-color:<?php echo $cat_color; ?>;"><i class="ct-format <?php echo $format; ?>"></i></span><!-- post-format -->
	    </div>
		<?php endif; ?>
	      
		<!-- title -->
		<h4 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>"><?php the_title(); ?></a></h4>

		<!-- post excerpt -->
		<div class="entry-content"><?php $post_excerpt = get_the_excerpt(); echo strip_tags(mb_substr($post_excerpt, 0, $excerpt_lenght ) ) . ' ...'; ?></div><!-- .entry-content -->

		<?php
		// Check if post is Review, then show rating
		if ( $post_type == 'review_post' ) : ?>
			<div class="meta clearfix">
				<?php
				ct_get_rating_stars();
				ct_get_post_meta($post->ID, false, false, false, true, false);
				?>
				<?php ct_get_readmore(); // get read more link ?>
			</div><!-- .meta -->
			<?php
		
		// Else, show standard meta
		else : ?>

			<div class="meta">
				<?php ct_get_post_meta($post->ID, true, true, true, false, false); ?>
				<?php ct_get_readmore(); // get read more link ?>
			</div><!-- .meta -->
		<?php endif; ?>

		<?php if ( $divider_type == 'striped') : ?>
			<div class="widget-devider"></div>
		<?php else: ?>
			<div class="widget-devider-1px"></div>
		<?php endif; ?>

		</div><!-- .cat-one-columnn  -->
	  <?php endwhile; ?>


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
	function update($new_instance, $old_instance){
		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];
		$instance['categories'] = $new_instance['categories'];
		$instance['posts'] = $new_instance['posts'];
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
		?>
		<?php
			$defaults = array( 
				'title' => __( 'Category Name', 'color-theme-framework' ),
				'categories' => 'all',
				'posts' => '1', 
				'widget_width' => 'span4', 
				'background' => '#FFFFFF', 
				'background_title' => '#ff0000',
				'excerpt_lenght' => '140',
				'video_height' => '231',
				'divider_type' => 'striped'
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
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' , 'color-theme-framework' ); ?></label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('posts'); ?>"><?php _e( 'Number of posts:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="100" class="widefat" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo $instance['posts']; ?>" />
			
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('excerpt_lenght'); ?>"><?php _e( 'Length of post excerpt (chars):' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="500" class="widefat" id="<?php echo $this->get_field_id('excerpt_lenght'); ?>" name="<?php echo $this->get_field_name('excerpt_lenght'); ?>" value="<?php echo $instance['excerpt_lenght']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('video_height'); ?>"><?php _e( 'Height of embedded video (px):' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="1000" class="widefat" id="<?php echo $this->get_field_id('video_height'); ?>" name="<?php echo $this->get_field_name('video_height'); ?>" value="<?php echo $instance['video_height']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e( 'Filter by Category:' , 'color-theme-framework' ); ?></label> 
			<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" class="widefat" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>

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