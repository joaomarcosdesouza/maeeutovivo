<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT Instagram Widget
 	Plugin URI: http://www.color-theme.com
 	Description: A widget thats displays your photos from instagram.com
 	Version: 1.0
 	Author: ZERGE
 	Author URI:  http://www.color-theme.com
 
-----------------------------------------------------------------------------------
*/


/**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init', 'CT_load_instagram_widgets');

function CT_load_instagram_widgets()
{
	register_widget('CT_Instagram_Widget');
}


/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update. 
 *
 */
class CT_Instagram_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */		
	function CT_Instagram_Widget() {
		
		/* Widget settings. */
		$widget_ops = array('classname' => 'ct_instagram_widget', 'description' => __( 'CT: Instagram Widget', 'color-theme-framework' ) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'ct_instagram_widget' );

		/* Create the widget. */		
		parent::__construct( 'ct_instagram_widget', 'CT: Instagram Widget ', $widget_ops);
	}

	/*-----------------------------------------------------------------------------------*/
	/*	Display Widget
	/*-----------------------------------------------------------------------------------*/
	
	function widget( $args, $instance ) {
		extract( $args );
		
		if ( !is_admin() ) {
			/* Instagram */
			wp_register_script('jquery-instagram',get_template_directory_uri().'/js/spectragram.min.js',false, null , true);
			wp_enqueue_script('jquery-instagram',array('jquery'));
		}


		// Our variables from the widget settings
		$title = apply_filters('widget_title', $instance['title'] );
		$access_token = $instance['access_token'];
		$client_id = $instance['client_id'];
		$your_query = $instance['your_query'];
		$num_images = $instance['num_images'];
		$image_size = $instance['image_size'];
		$widget_width = $instance['widget_width'];
		$feed_type = $instance['feed_type'];
		$background = $instance['background'];
		$background_title = $instance['background_title'];

		/* Before widget (defined by themes). */
		if ( $title ){
			echo "\n<!-- START INSTAGRAM WIDGET -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';">';
			echo '<div class="widget-title bottom-shadow" style="background:' . $background_title .';"><h2>' . $title . '</h2><div class="arrow-down" style="border-top-color:' . $background_title . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->';
		} else {
			echo "\n<!-- START INSTAGRAM WIDGET -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';padding-top: 20px;">';
		}

		// Display widget
		$time_id = rand();	

		if ( $feed_type == 'Popular' ) : $get_feed_type = 'getPopular';
		elseif ( $feed_type == 'RecentTagged' ) : $get_feed_type = 'getRecentTagged';
		else : $get_feed_type = 'getUserFeed';
		endif;
		?>

		<?php if ( empty($access_token) || empty($client_id) ) : ?>
			<p>You must define an accessToken and a clientID</p>
		<?php else : ?>
		<script type="text/javascript">
		/* <![CDATA[ */
		/***************************************************
							Instagram
		***************************************************/
		jQuery.noConflict()(function($){
			$(document).ready(function() {
				jQuery.fn.spectragram.accessData = {
					accessToken: '<?php echo $access_token; ?>',
					clientID: '<?php echo $client_id; ?>'
				};

				//Call spectagram function on the container element and pass it your query
				$('.ct-instagram-<?php echo $time_id; ?>').spectragram('<?php echo $get_feed_type; ?>', {
					query: '<?php echo $your_query; ?>', //this gets user photo feed
					size: 'small',
					max: <?php echo $num_images; ?>
				});

			});
		});
		/* ]]> */
		</script>
		<?php endif; ?>

		<ul class="ct-instagram-<?php echo $time_id; ?> clearfix"></ul>
	
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
	$instance['access_token'] = stripslashes( $new_instance['access_token']);
	$instance['client_id'] = stripslashes( $new_instance['client_id']);
	$instance['your_query'] = stripslashes( $new_instance['your_query']);
	$instance['num_images'] = stripslashes( $new_instance['num_images']);
	$instance['image_size'] = stripslashes( $new_instance['image_size']);
	$instance['widget_width'] = $new_instance['widget_width'];
	$instance['feed_type'] = $new_instance['feed_type'];
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
		'title' => __( 'Instagram Feed' , 'color-theme-framework' ),
		'access_token' => '',
		'client_id' => '',
		'your_query' => 'awesomeinventions',
		'num_images' => '8',
		'image_size' => '103',
		'widget_width' => 'ct-full-width', 
		'feed_type' => 'Popular',
		'background' => '#FFFFFF',
		'background_title' => '#517FA4'
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
		<label for="<?php echo $this->get_field_id( 'client_id' ); ?>"><?php _e('Your Instagram application clientID:', 'color-theme-framework') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'client_id' ); ?>" name="<?php echo $this->get_field_name( 'client_id' ); ?>" value="<?php echo stripslashes(htmlspecialchars(( $instance['client_id'] ), ENT_QUOTES)); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'access_token' ); ?>"><?php _e('Your Instagram access token:', 'color-theme-framework') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'access_token' ); ?>" name="<?php echo $this->get_field_name( 'access_token' ); ?>" value="<?php echo stripslashes(htmlspecialchars(( $instance['access_token'] ), ENT_QUOTES)); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'your_query' ); ?>"><?php _e('Query (user name or tag):', 'color-theme-framework') ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'your_query' ); ?>" name="<?php echo $this->get_field_name( 'your_query' ); ?>" value="<?php echo stripslashes(htmlspecialchars(( $instance['your_query'] ), ENT_QUOTES)); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'num_images' ); ?>"><?php _e('The number of displayed images:', 'color-theme-framework') ?></label>
		<input type="number" min="1" max="30" class="widefat" id="<?php echo $this->get_field_id( 'num_images' ); ?>" name="<?php echo $this->get_field_name( 'num_images' ); ?>" value="<?php echo stripslashes(htmlspecialchars(( $instance['num_images'] ), ENT_QUOTES)); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'image_size' ); ?>"><?php _e('Image size (height/width):', 'color-theme-framework') ?></label>
		<input type="number" min="1" max="150" class="widefat" id="<?php echo $this->get_field_id( 'image_size' ); ?>" name="<?php echo $this->get_field_name( 'image_size' ); ?>" value="<?php echo stripslashes(htmlspecialchars(( $instance['image_size'] ), ENT_QUOTES)); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'feed_type' ); ?>"><?php _e('Feed type:', 'color-theme-framework'); ?></label> 
		<select id="<?php echo $this->get_field_id( 'feed_type' ); ?>" name="<?php echo $this->get_field_name( 'feed_type' ); ?>" class="widefat" style="width:100%;">
			<option <?php if ( 'UserFeed' == $instance['feed_type'] ) echo 'selected="selected"'; ?>>UserFeed</option>
			<option <?php if ( 'Popular' == $instance['feed_type'] ) echo 'selected="selected"'; ?>>Popular</option>
			<option <?php if ( 'RecentTagged' == $instance['feed_type'] ) echo 'selected="selected"'; ?>>RecentTagged</option>
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
        <input class="widefat" id="<?php echo $this->get_field_id('background_title'); ?>" name="<?php echo $this->get_field_name('background_title'); ?>" type="text" value="<?php if($background_title) { echo $background_title; } else { echo '#517FA4'; } ?>" />
		<div class="cw-color-picker" rel="<?php echo $this->get_field_id('background_title'); ?>"></div>
    </p>

	<?php
	}
}
?>