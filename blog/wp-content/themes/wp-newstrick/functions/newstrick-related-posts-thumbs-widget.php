<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT Related Posts Thumbs Widget
 	Plugin URI: http://www.color-theme.com
 	Description: A widget that show Related posts by tags or category ).
 	Version: 1.0
 	Author: ZERGE
 	Author URI:  http://www.color-theme.com
 
-----------------------------------------------------------------------------------
*/



/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'CT_related_posts_widget' );

function CT_related_posts_widget() {
	register_widget( 'CT_Related_Posts' );
}


/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update. 
 *
 */
class CT_Related_Posts extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function  CT_Related_Posts() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'ct-relatedposts-widget', 'description' => __( 'A widget that show related posts by tags or category' , 'color-theme-framework' ) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'ct-relatedposts-widget' );

		/* Create the widget. */
		parent::__construct( 'ct-relatedposts-widget', __('CT: Related Posts Thumbs', 'color-theme-framework'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		global $post;

		/* Our variables from the widget settings. */
		$title = apply_filters('Related Posts', $instance['title'] );
		$num_posts = $instance['num_posts'];
		$show_random = isset($instance['show_random']) ? 'true' : 'false';
		$widget_width = $instance['widget_width'];
		$posts_by = $instance['posts_by'];
		$background = $instance['background'];
		$background_title = $instance['background_title'];

		/* Before widget (defined by themes). */
		if ( $title ){
			echo "\n<!-- START RELATED POSTS WIDGETS -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';">';
			echo '<div class="widget-title bottom-shadow" style="background:' . $background_title .';"><h2>' . $title . '</h2><div class="arrow-down" style="border-top-color:' . $background_title . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->';
		} else {
			echo "\n<!-- START RELATED POSTS WIDGETS -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';padding-top: 20px;">';
		}

		?>

		<?php 

		$orderby = 'date';
		if ( $show_random == 'true' ) { $orderby = 'rand'; }

		// show related posts by tags
		if ( $posts_by == 'tags') :
			$tags = get_the_tags();

			if( $tags):

   				$related_posts = ct_get_related_posts( $post->ID, $tags, $num_posts, $orderby); ?>

				<ul class="related-posts-single clearfix">
					<?php while($related_posts->have_posts()): $related_posts->the_post(); ?>
			    		<?php if(has_post_thumbnail()): ?>
			      			<li class="ct-preload">
								<a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'><?php echo get_the_post_thumbnail($post->ID, 'thumbnail', array('title' => the_title('','',false))); ?></a>
								<?php
								//Get post type: standard post or review
								$post_type = get_post_meta($post->ID, 'ct_mb_post_type', true);

								//If Review, show Stars
								if ( $post_type == 'review_post' ) : 
									echo "<div class=\"review-box\">\n";
										ct_get_rating_stars_s();
									echo "\n</div><!-- .review-box -->";
								endif; ?>
	  	  		  	  		</li>
						<?php endif; ?>
				  	<?php endwhile; ?>
				</ul><!-- related-posts-single -->

				<?php if ($related_posts->have_posts()) echo ''; else echo __('No related posts were found','color-theme-framework');
			else : echo __('No related posts were found','color-theme-framework');
			endif;

		// else, show related posts by category
		else :
			if ( is_category() ) :
				$current_category = single_cat_title('', false);
				$related_category_id = get_cat_ID($current_category);
			else :
				$related_category = get_the_category($post->ID);
				$related_category_id = get_cat_ID( $related_category[0]->cat_name );			
			endif;
	  		$related_posts = new WP_Query(array('orderby' => $orderby, 'showposts' => $num_posts, 'post_type' => 'post', 'cat' => $related_category_id, 'post__not_in' => array( $post->ID )));

			if ($related_posts->have_posts()) : ?>

				<ul class="related-posts-single clearfix">
					<?php while($related_posts->have_posts()): $related_posts->the_post(); ?>
			    		<?php if(has_post_thumbnail()): ?>
			      			<li class="ct-preload">
								<a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'><?php echo get_the_post_thumbnail($post->ID, 'thumbnail', array('title' => the_title('','',false))); ?></a>
	  	  		  	  		</li>
						<?php endif; ?>
				  	<?php endwhile; ?>
				</ul><!-- related-posts-single -->	
			<?php
			else : echo __('No related posts were found','color-theme-framework');
			endif;
		endif; ?>

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
		$instance['num_posts'] = $new_instance['num_posts'];
		$instance['widget_width'] = $new_instance['widget_width'];
		$instance['show_random'] = $new_instance['show_random'];
		$instance['posts_by'] = $new_instance['posts_by'];
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
			'title' => __( 'Related Posts' , 'color-theme-framework' ),
			'num_posts' => 4,
			'show_random' => 'off',
			'posts_by' => 'tags',
			'widget_width' => 'ct-full-width', 
			'background' => '#FFFFFF',
			'background_title' => '#ff0000'
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
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' , 'color-theme-framework' ) ?></label>
		<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('num_posts'); ?>"><?php _e( 'Number of posts to show:' , 'color-theme-framework' ); ?></label>
		<input type="number" min="1" max="50" class="widefat" id="<?php echo $this->get_field_id('num_posts'); ?>" name="<?php echo $this->get_field_name('num_posts'); ?>" value="<?php echo $instance['num_posts']; ?>" />
	</p>

	<p>
		<input class="checkbox" type="checkbox" <?php checked($instance['show_random'], 'on'); ?> id="<?php echo $this->get_field_id('show_random'); ?>" name="<?php echo $this->get_field_name('show_random'); ?>" /> 
		<label for="<?php echo $this->get_field_id('show_random'); ?>"><?php _e( 'Random order' , 'color-theme-framework' ); ?></label>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'posts_by' ); ?>"><?php _e('Show related posts by:', 'color-theme-framework'); ?></label> 
		<select id="<?php echo $this->get_field_id( 'posts_by' ); ?>" name="<?php echo $this->get_field_name( 'posts_by' ); ?>" class="widefat" style="width:100%;">
			<option <?php if ( 'tags' == $instance['posts_by'] ) echo 'selected="selected"'; ?>>tags</option>
			<option <?php if ( 'category' == $instance['posts_by'] ) echo 'selected="selected"'; ?>>category</option>
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