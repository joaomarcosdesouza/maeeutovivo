<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT Recent Posts Thumbs Widget
 	Plugin URI: http://www.color-theme.com
 	Description: A widget that show thumbs for recent posts ( Specified by cat-id ).
 	Version: 1.0
 	Author: ZERGE
 	Author URI:  http://www.color-theme.com
 
-----------------------------------------------------------------------------------
*/


/**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init','CT_poststhumbs_load_widgets');

function CT_poststhumbs_load_widgets(){
		register_widget("CT_poststhumbs_Widget");
}

/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update. 
 *
 */
class CT_poststhumbs_Widget extends WP_widget{

	/**
	 * Widget setup.
	 */	
	function CT_poststhumbs_Widget(){
		
		/* Widget settings. */	
		$widget_ops = array( 'classname' => 'ct_poststhumbs_widget', 'description' => __( 'Displays Recent Posts Thumbs' , 'color-theme-framework' ) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'ct_poststhumbs_widget' );
		
		/* Create the widget. */
		parent::__construct( 'ct_poststhumbs_widget', __( 'CT: Recent Posts Thumbs' , 'color-theme-framework' ) ,  $widget_ops, $control_ops );
		
	}
	
	function widget($args,$instance){
		extract($args);

		$title = apply_filters ('widget_title', $instance ['title']);
		$categories = $instance['categories'];
		$posts = $instance['posts'];
		$show_related = isset($instance['show_related']) ? 'true' : 'false';
		$show_random = isset($instance['show_random']) ? 'true' : 'false';
		$show_big_img = isset($instance['show_big_img']) ? 'true' : 'false';
		$widget_width = $instance['widget_width'];
		$background = $instance['background'];
		$background_title = $instance['background_title'];

		?>

		<?php
		/* Before widget (defined by themes). */
		if ( $title ){
			echo "\n<!-- Recent Posts Thumbs Widget -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';">';
			echo '<div class="widget-title bottom-shadow" style="background:' . $background_title .';"><h2>' . $title . '</h2><div class="arrow-down" style="border-top-color:' . $background_title . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->'; 
		} else {
			echo "\n<!-- Recent Posts Thumbs Widget -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';padding-top: 20px;">';
		}
		/* Display the widget title if one was input (before and after defined by themes). */ ?>
		
<?php
	global  $data, $post;
	$orderby = 'date';
	$i = 0;
	
	if ( $show_random == 'true' ) { $orderby = 'rand'; }
	
	if ( $show_related == 'true' ) :
	  $related_category = get_the_category($post->ID);
	  $related_category_id = get_cat_ID( $related_category[0]->cat_name );			
	  $recent_posts = new WP_Query(array('orderby' => $orderby, 'showposts' => $posts, 'post_type' => 'post', 'cat' => $related_category_id, 'post__not_in' => array( $post->ID )));
	else :
	  $recent_posts = new WP_Query(array('orderby' => $orderby, 'showposts' => $posts, 'post_type' => 'post', 'cat' => $categories));
	endif; ?>


	<ul class="widget-thumb clearfix">
	  <?php while($recent_posts->have_posts()): $recent_posts->the_post(); ?>
				
		<?php if ( has_post_thumbnail() && ($i == 0) && ($show_big_img == 'true' ) ) : ?>
		<li>
		  <div class="widget-big-thumb ct-preload">
			<?php $big_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'carousel-thumb'); ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<img src="<?php echo $big_image[0]; ?>" alt="<?php the_title(); ?>" />
			</a>
			<div class="title-mask">
			  <span class="ico-plus"></span>
			  <?php the_title(); ?>
			</div><!-- .title-mask -->
		  </div><!-- .widget-big-thumb -->
		</li>
		<?php $i++; endif; ?>

		<?php if ( has_post_thumbnail() && ($i != 1 ) ) : ?>
		  <li>
			<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'small-thumb');

			//Check if exists thumbnail small-thumb (75x75 px)
			if ( $image[1] == 75 && $image[2] == 75 ) { ?>	      
			  <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>
			<?php } 

			// if no, use standard 150x150 thumbnail
			else { 
			  $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail');?>
	          <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>
			<?php } ?>			

		  </li>
		<?php endif; //end has_post_thumbnail
				
		if ( $i == 1 ) { $i++; }
		?>
				
	  <?php endwhile; ?>
	</ul> <!-- .widget-thumb -->

	<?php

	  // Restore original Query & Post Data
	  wp_reset_query();
	  wp_reset_postdata();

	  /* After widget (defined by themes). */
	  echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */		
	function update($new_instance, $old_instance){
		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];
		$instance['categories'] = $new_instance['categories'];
		$instance['posts'] = $new_instance['posts'];
		$instance['show_related'] = $new_instance['show_related'];
		$instance['show_random'] = $new_instance['show_random'];
		$instance['show_big_img'] = $new_instance['show_big_img'];
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
	function form($instance){
		?>
		<?php
			$defaults = array(
				'title' => __( 'Recent Posts Thumbs', 'color-theme-framework' ), 
				'categories' => 'all', 
				'posts' => '16', 
				'show_related' => 'off',
				'show_random' => 'off',
				'show_big_img' => 'on',
				'widget_width' => 'span8', 
				'background' => '#FFFFFF',
				'background_title' => '#ff0000' );				
				
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
			<input class="checkbox" type="checkbox" <?php checked($instance['show_big_img'], 'on'); ?> id="<?php echo $this->get_field_id('show_big_img'); ?>" name="<?php echo $this->get_field_name('show_big_img'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_big_img'); ?>"><?php _e( 'Show big image' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_related'], 'on'); ?> id="<?php echo $this->get_field_id('show_related'); ?>" name="<?php echo $this->get_field_name('show_related'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_related'); ?>"><?php _e( 'Show related posts by Category' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_random'], 'on'); ?> id="<?php echo $this->get_field_id('show_random'); ?>" name="<?php echo $this->get_field_name('show_random'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_random'); ?>"><?php _e( 'Random order' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('posts'); ?>"><?php _e( 'Number of posts:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="100" class="widefat" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo $instance['posts']; ?>" />
			
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