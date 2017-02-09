<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT Carousel Widget
 	Plugin URI: http://www.color-theme.com
 	Description: A widget that show carousel with latest posts.
 	Version: 1.0
 	Author: Zerge
 	Author URI:  http://www.color-theme.com
 
-----------------------------------------------------------------------------------
*/


/**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init','CT_carousel_load_widgets');

function CT_carousel_load_widgets(){
		register_widget("CT_carousel_Widget");
}

/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update. 
 *
 */
class CT_carousel_Widget extends WP_widget{

	/**
	 * Widget setup.
	 */	
	function CT_carousel_Widget(){
		
		/* Widget settings. */	
		$widget_ops = array( 'classname' => 'ct_carousel_widget', 'description' => __( 'Carousel widget' , 'color-theme-framework' ) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'ct_carousel_widget' );
		
		/* Create the widget. */
		parent::__construct( 'ct_carousel_widget', __( 'CT: Carousel Widget' , 'color-theme-framework' ) ,  $widget_ops, $control_ops );
		
	}
	
	function widget($args,$instance){
		extract($args);
		
		$title = apply_filters ('widget_title', $instance ['title']);
		$categories = $instance['categories'];
		$posts = $instance['posts'];
		$slideshow = isset($instance['slideshow']) ? 'true' : 'false';
		$show_related = isset($instance['show_related']) ? 'true' : 'false';
		$show_random = isset($instance['show_random']) ? 'true' : 'false';
		$show_text = $instance['show_text'];
		$widget_width = $instance['widget_width'];
		$background = $instance['background'];
		$background_title = $instance['background_title'];
		?>

		<?php
		
		/* Before widget (defined by themes). */
		/* Before widget (defined by themes). */
		if ( $title ){
			echo "\n<!-- START CAROUSEL WIDGET -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget ct-carousel-widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';">';
			echo '<div class="widget-title bottom-shadow" style="background:' . $background_title .';"><h2>' . $title . '</h2><div class="arrow-down" style="border-top-color:' . $background_title . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->'; 
		} else {
			echo "\n<!-- START CAROUSEL WIDGET -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';padding-top: 20px;">';
		}
		/* Display the widget title if one was input (before and after defined by themes). */ ?>
		
<?php
	global  $data, $post;
	$time_id = rand();
	$orderby = 'date';
	$extra_class = '';
	
	if ( $show_random == 'true' ) { $orderby = 'rand'; }

	if ( $show_related == 'true' ) :
		if ( is_category() ) :
			$current_category = single_cat_title('', false);
			$related_category_id = get_cat_ID($current_category);
			$recent_posts = new WP_Query(array('orderby' => $orderby, 'showposts' => $posts, 'post_type' => 'post', 'cat' => $related_category_id));
		else :
			$related_category = get_the_category($post->ID);
			$related_category_id = get_cat_ID( $related_category[0]->cat_name );
			$recent_posts = new WP_Query(array('orderby' => $orderby, 'showposts' => $posts, 'post_type' => 'post', 'cat' => $related_category_id, 'post__not_in' => array( $post->ID )));
		endif;
	else :
	  $recent_posts = new WP_Query(array('orderby' => $orderby, 'showposts' => $posts, 'post_type' => 'post', 'cat' => $categories));
	endif;

	$recent_posts_count = $recent_posts->found_posts;
	if ( $recent_posts_count == 1 ) : $extra_class = 'ct-one-related-posts'; endif; 
?>

	<?php
		/* Flex Slider */
		wp_register_script('flex-min-jquery',get_template_directory_uri().'/js/jquery.flexslider-min.js',false, null , true);
		wp_enqueue_script('flex-min-jquery',array('jquery'));
	?>

<script type="text/javascript">
/* <![CDATA[ */
jQuery.noConflict()(function($){
	$(document).ready(function() {

  $('#carousel-<?php echo $time_id; ?>').flexslider({
    animation: "slide",
    animationLoop: true,
    itemWidth: 267,
    itemMargin: 20,
	minItems: 1,
	maxItems: 4,   
    slideshow: <?php echo $slideshow; ?>,
    controlNav: false
  });
   
});
}); 
/* ]]> */
</script>
		
	<div id="carousel-<?php echo $time_id; ?>" class="flexslider flex-carousel <?php echo $extra_class?>">
	  <ul class="slides">
		<?php
		  global $post;		
		  while($recent_posts->have_posts()): $recent_posts->the_post(); 
		?>

		<?php if( has_post_thumbnail() ): ?>

	    <li>
	      <div class="carousel-thumb ct-preload">
			<?php $carousel_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'carousel-thumb'); 
			if ( $carousel_image_url[1] == 267 && $carousel_image_url[2] == 188 ) { ?>	      
			  <a href="<?php the_permalink(); ?>"><img src="<?php echo $carousel_image_url[0]; ?>" alt="<?php the_title(); ?>" /></a>
			  
			<?php } else { 
			  $carousel_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail');?>
	          <a href="<?php the_permalink(); ?>"><img src="<?php echo $carousel_image_url[0]; ?>" alt="<?php the_title(); ?>" /></a>
			<?php } ?>
			
  			  <?php 
			    if ( has_post_format ( 'video' ) ) {
			  ?>

			    <?php	
			      $video_type = get_post_meta( $post->ID, 'ct_mb_post_video_type', true );
				  $perma_link = get_permalink($post->ID);

				  if ( $video_type == 'youtube' ) {
				    echo '<div class="video youtube"><a href="' . $perma_link . '" title="'. __('Watch Youtube Video','color-theme-framework').'"></a></div>';
			      }
   				  else if ( $video_type == 'vimeo' ) {
				    echo '<div class="video vimeo"><a href="' . $perma_link . '" title="'. __('Watch Vimeo Video','color-theme-framework').'"></a></div>';
			      }	
				  elseif ( $video_type == 'dailymotion' ) {
				    echo '<div class="video dailymotion"><a href="' . $perma_link . '" title="'. __('Watch DailyMotion Video','color-theme-framework').'"></a></div>';
				  } 
			    ?>
			  <?php } ?>

			<?php
			if ( is_category() ) :
				$cat_color = ct_get_color($related_category_id);
			else :
				$category = get_the_category(); 
				$cat_color = ct_get_color($category[0]->term_id);
			endif;
			  if ( $cat_color == '') { $cat_color = '#000'; }
			?>

			<?php if ( $show_text == 'category' ) {
				if ( is_category() ) :
					$category_id = $related_category_id;
					$category_link = get_category_link( $category_id );
					$category_name = $current_category;
				else :
					$category_id = get_cat_ID( $category[0]->cat_name );
					$category_link = get_category_link( $category_id );
					$category_name = $category[0]->cat_name;
				endif;
				?>
			  <span class="category-item bottom-shadow-2px" style="background-color:<?php echo $cat_color; ?>">
			    <a href="<?php echo esc_url( $category_link ); ?>" title="<?php echo __('View all posts in ', 'color-theme-framework'); echo $category_name; ?>"><?php echo $category_name; ?></a>
			    <span class="arrow-down" style="border-top-color:<?php echo $cat_color; ?>"></span>
			  </span>
			<?php } 
			else if ( $show_text == 'title' ) { ?>
			  <span class="category-item bottom-shadow-2px" style="background-color:<?php echo $cat_color; ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>			
			<?php }
			else { }

		  	//Get post type: standard post or review
			$post_type = get_post_meta($post->ID, 'ct_mb_post_type', true);

			//If Review, show Stars
			if ( $post_type == 'review_post' ) : 
				echo "<div class=\"review-box\">\n";
				ct_get_rating_stars_s();
				echo "\n</div><!-- .review-box -->";
			endif; ?>

			<div class="title-mask">
			  <span class="ico-plus"></span>
			  <?php the_title(); ?>
			</div><!-- title-mask -->
			
		  </div><!-- /carousel-thumb -->
		  
	    </li>
<?php endif; ?>
	<?php endwhile; ?>

	  </ul>
	</div> <!-- /flexslider -->

		<?php
		
		// Restor original Query & Post Data
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
		$instance['slideshow'] = $new_instance['slideshow'];
		$instance['show_text'] = $new_instance['show_text'];
		$instance['show_related'] = $new_instance['show_related'];
		$instance['show_random'] = $new_instance['show_random'];
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
				'title' => __( '', 'color-theme-framework' ), 
				'slideshow' => 'off', 
				'categories' => 'all', 
				'show_text' => 'category', 
				'posts' => '10', 
				'show_related' => 'off', 
				'show_random' => 'off',
				'widget_width' => 'span12', 
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
			<label for="<?php echo $this->get_field_id( 'show_text' ); ?>"><?php _e('Type of text to show:', 'color-theme-framework'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'show_text' ); ?>" name="<?php echo $this->get_field_name( 'show_text' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'category' == $instance['show_text'] ) echo 'selected="selected"'; ?>>category</option>
				<option <?php if ( 'title' == $instance['show_text'] ) echo 'selected="selected"'; ?>>title</option>
				<option <?php if ( 'none' == $instance['show_text'] ) echo 'selected="selected"'; ?>>none</option>
			</select>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_related'], 'on'); ?> id="<?php echo $this->get_field_id('show_related'); ?>" name="<?php echo $this->get_field_name('show_related'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_related'); ?>"><?php _e( 'Show related category posts' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_random'], 'on'); ?> id="<?php echo $this->get_field_id('show_random'); ?>" name="<?php echo $this->get_field_name('show_random'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_random'); ?>"><?php _e( 'Random order' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['slideshow'], 'on'); ?> id="<?php echo $this->get_field_id('slideshow'); ?>" name="<?php echo $this->get_field_name('slideshow'); ?>" /> 
			<label for="<?php echo $this->get_field_id('slideshow'); ?>"><?php _e( 'Animate carousel automatically' , 'color-theme-framework' ); ?></label>
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