<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT Flickr Widget
 	Plugin URI: http://www.color-theme.com
 	Description: A widget thats displays your projects from flickr.com
 	Version: 1.0
 	Author: ZERGE
 	Author URI:  http://www.color-theme.com
 
-----------------------------------------------------------------------------------
*/


/**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init', 'CT_load_flickr_widgets');

function CT_load_flickr_widgets()
{
	register_widget('CT_Flickr_Widget');
}


/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update. 
 *
 */
class CT_Flickr_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */		
	function CT_Flickr_Widget() {
		
		/* Widget settings. */
		$widget_ops = array('classname' => 'ct_flickr_widget', 'description' => __( 'CT: Flickr Widget', 'color-theme-framework' ) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'ct_flickr_widget' );

		/* Create the widget. */		
		parent::__construct( 'ct_flickr_widget', 'CT: Flickr Widget ', $widget_ops);
	}

	/*-----------------------------------------------------------------------------------*/
	/*	Display Widget
	/*-----------------------------------------------------------------------------------*/
	
	function widget( $args, $instance ) {
		extract( $args );
		
		if ( !is_admin() ) {
			/* Flickr */
			wp_register_script('jquery-flickr',get_template_directory_uri().'/js/jflickrfeed.min.js',false, null , true);
			wp_enqueue_script('jquery-flickr',array('jquery'));
		}


		// Our variables from the widget settings
		$title = apply_filters('widget_title', $instance['title'] );
		$user_id = $instance['user_id'];
		$num_images = $instance['num_images'];
		$image_size = $instance['image_size'];
		$widget_width = $instance['widget_width'];
		$feed_type = $instance['feed_type'];
		$background = $instance['background'];
		$background_title = $instance['background_title'];

		/* Before widget (defined by themes). */
		if ( $title ){
			echo "\n<!-- START FLICKR WIDGET -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';">';
			echo '<div class="widget-title bottom-shadow" style="background:' . $background_title .';"><h2>' . $title . '</h2><div class="arrow-down" style="border-top-color:' . $background_title . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->';
		} else {
			echo "\n<!-- START FLICKR WIDGET -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';padding-top: 20px;">';
		}

		// Display widget
		$time_id = rand();	
		?>

		<!-- <style>
			[class^="ct-flickr-"] li a img { width: <?php echo $image_size . 'px'; ?>; height: <?php echo $image_size . 'px'; ?>; }
		</style> -->

		<script type="text/javascript">
		/* <![CDATA[ */
		jQuery.noConflict()(function($){
			$(document).ready(function() {
				$(".ct-flickr-<?php echo $time_id; ?>").jflickrfeed({
					limit: <?php echo $instance['num_images']; ?>,
					feedapi:"<?php echo $instance['feed_type']; ?>",
					qstrings: {
						id: "<?php echo $instance['user_id']; ?>"
					},
					itemTemplate: '<li>'+
								'<a rel="prettyPhoto[flickr]" href="{{image_b}}" title="{{title}}">' +
								'<img src="{{image_s}}" alt="{{title}}" />' +
								'</a>' +
								'</li>'
				},  function(data) {
						$('.ct-flickr-<?php echo $time_id; ?> a').prettyPhoto({
							animationSpeed: 'normal', /* fast/slow/normal */
							opacity: 0.80, /* Value between 0 and 1 */
							showTitle: true, /* true/false */
							deeplinking: false,
							theme:'light_square'
						});
				});

				$('[class^="ct-flickr-"] li a img').css("width",<?php echo '"'.$image_size.'px'.'"'; ?>);
				$('[class^="ct-flickr-"] li a img').css("height",<?php echo '"'.$image_size.'px'.'"'; ?>);
			});
		});
		/* ]]> */
		</script>		

		<ul class="ct-flickr-<?php echo $time_id; ?> thumbs clearfix"></ul>

	
	<?php

	// After widget (defined by theme functions file)
	echo $after_widget;
	
}


/*-----------------------------------------------------------------------------------*/
/*	Update Widget
/*-----------------------------------------------------------------------------------*/
	
function update( $new_instance, $old_instance ) {
	$instance = $old_instance;

	// Strip tags to remove HTML (important for text inputs)
	$instance['title'] = strip_tags( $new_instance['title'] );
	
	// Stripslashes for html inputs
	$instance['user_id'] = stripslashes( $new_instance['user_id']);
	$instance['num_images'] = stripslashes( $new_instance['num_images']);
	$instance['image_size'] = stripslashes( $new_instance['image_size']);
	$instance['feed_type'] = $new_instance['feed_type'];
	$instance['widget_width'] = $new_instance['widget_width'];
	$instance['background'] = strip_tags($new_instance['background']);
	$instance['background_title'] = strip_tags($new_instance['background_title']);

	// No need to strip tags

	return $instance;
}


/*-----------------------------------------------------------------------------------*/
/*	Widget Settings (Displays the widget settings controls on the widget panel)
/*-----------------------------------------------------------------------------------*/
	 
function form( $instance ) {

	// Set up some default widget settings
	$defaults = array(
		'title' => __( 'Flickr' , 'color-theme-framework' ),
		'user_id' => '52617155@N08',
		'num_images' => '9',
		'image_size' => '75',
		'feed_type' => 'photos_public.gne',
		'widget_width' => 'span4', 
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


	<!-- Widget Title: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'color-theme-framework') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'user_id' ); ?>"><?php _e('User ID:', 'color-theme-framework') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'user_id' ); ?>" name="<?php echo $this->get_field_name( 'user_id' ); ?>" value="<?php echo stripslashes(htmlspecialchars(( $instance['user_id'] ), ENT_QUOTES)); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'num_images' ); ?>"><?php _e('The number of displayed images:', 'color-theme-framework') ?></label>
		<input type="number" min="1" max="50" class="widefat" id="<?php echo $this->get_field_id( 'num_images' ); ?>" name="<?php echo $this->get_field_name( 'num_images' ); ?>" value="<?php echo stripslashes(htmlspecialchars(( $instance['num_images'] ), ENT_QUOTES)); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'image_size' ); ?>"><?php _e('Image size (height/width):', 'color-theme-framework') ?></label>
		<input type="number" min="1" max="75" class="widefat" id="<?php echo $this->get_field_id( 'image_size' ); ?>" name="<?php echo $this->get_field_name( 'image_size' ); ?>" value="<?php echo stripslashes(htmlspecialchars(( $instance['image_size'] ), ENT_QUOTES)); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'feed_type' ); ?>"><?php _e('Feed type:', 'color-theme-framework'); ?></label> 
		<select id="<?php echo $this->get_field_id( 'feed_type' ); ?>" name="<?php echo $this->get_field_name( 'feed_type' ); ?>" class="widefat" style="width:100%;">
			<option <?php if ( 'photos_public.gne' == $instance['feed_type'] ) echo 'selected="selected"'; ?>>photos_public.gne</option>
			<option <?php if ( 'photos_friends.gne' == $instance['feed_type'] ) echo 'selected="selected"'; ?>>photos_friends.gne</option>
			<option <?php if ( 'photos_faves.gne' == $instance['feed_type'] ) echo 'selected="selected"'; ?>>photos_faves.gne</option>
			<option <?php if ( 'groups_pool.gne' == $instance['feed_type'] ) echo 'selected="selected"'; ?>>groups_pool.gne</option>				
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