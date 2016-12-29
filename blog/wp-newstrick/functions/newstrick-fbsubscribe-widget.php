<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT Facebook Subscribe Widget
 	Plugin URI: http://www.color-theme.com
 	Description: A widget that show subscribe button from facebook.com
 	Version: 1.0
 	Author: ZERGE
 	Author URI:  http://www.color-theme.com
 
-----------------------------------------------------------------------------------
*/


/*
==========================================================================
  Add function to widgets_init that'll load our widget.
==========================================================================  
*/

add_action('widgets_init','CT_fbsubscribe_load_widgets');


function CT_fbsubscribe_load_widgets(){
		register_widget("CT_fb_subscribe_Widget");
}

/*
==========================================================================
  Widget class.
  This class handles everything that needs to be handled with the widget:
  the settings, form, display, and update. 
==========================================================================
*/
class CT_fb_subscribe_Widget extends WP_widget{

	/* Widget setup. */
	function CT_fb_subscribe_Widget(){
		
		/* Widget settings. */		
		$widget_ops = array( 'classname' => 'ct_subscribe_widget', 'description' => __( 'Facebook Subscribe Widget' , 'color-theme-framework' ) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'ct_subscribe_widget' );
		
		/* Create the widget. */
		parent::__construct( 'ct_subscribe_widget' , __( 'CT: Facebook Subscribe' , 'color-theme-framework' ) , $widget_ops, $control_ops );
		
	}
	
	function widget($args,$instance){
		extract($args);
		
		$title = apply_filters ('widget_title', $instance ['title']);
		$profile_url = $instance['profile_url'];
		$layout = $instance['layout'];		
		$show_faces = isset($instance['show_faces']) ? 'true' : 'false';
		$theme_color = $instance['theme_color'];			
		$lang = $instance['lang'];
		$widget_width = $instance['widget_width'];
		$background = $instance['background'];
		$background_title = $instance['background_title'];
		

		/* Before widget (defined by themes). */
		if ( $title ){
			echo "\n<!-- START FB SUBSCRIBE WIDGET -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';">';
			echo '<div class="widget-title bottom-shadow" style="background:' . $background_title .';"><h2>' . $title . '</h2><div class="arrow-down" style="border-top-color:' . $background_title . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->';
		} else {
			echo "\n<!-- START FB SUBSCRIBE WIDGET -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';padding-top: 20px;">';
		}
		?>
			

		<div id="fb-root"></div>
		<script>(function(d, s, id) {
  		var js, fjs = d.getElementsByTagName(s)[0];
  		if (d.getElementById(id)) return;
  		js = d.createElement(s); js.id = id;
  		js.src = "//connect.facebook.net/<?php echo $lang; ?>/all.js#xfbml=1";
  		fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
			
		
		<div>
			<div class="fb-subscribe" <?php if($layout=='button_count') echo 'data-layout="button_count"'; if($layout=='box_count') echo 'data-layout="box_count"'; ?> data-href="<?php echo $profile_url; ?>" data-font="arial"  data-show-faces="<?php echo $show_faces; ?>" <?php if( $theme_color == 'dark' ) echo 'data-colorscheme="dark"'; ?> ></div>
		</div>
					
		<?php
		echo $after_widget;
		}

	/**
	 * Update the widget settings.
	 */		
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );


		$instance['profile_url'] = $new_instance['profile_url'];
		$instance['layout'] = $new_instance['layout'];		
		$instance['show_faces'] = $new_instance['show_faces'];
		$instance['theme_color'] = $new_instance['theme_color'];			
		$instance['lang'] = $new_instance['lang'];		
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
				'title'=> __( 'Facebook Subscribe', 'color-theme-framework' ),
				'profile_url' => 'https://facebook.com/envato', 
				'lang' => 'en_US', 
				'theme_color' => 'light', 
				'show_faces' => 'on', 
				'layout' => 'standard',
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
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' , 'color-theme-framework' ); ?></label>
			<input class="widefat" style="width: 210px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('profile_url'); ?>"><?php _e( 'Profile URL:' , 'color-theme-framework' ); ?></label>
			<input class="widefat" style="width: 210px;" id="<?php echo $this->get_field_id('profile_url'); ?>" name="<?php echo $this->get_field_name('profile_url'); ?>" value="<?php echo $instance['profile_url']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'layout' ); ?>"><?php _e('Layout Style:', 'color-theme-framework'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'layout' ); ?>" name="<?php echo $this->get_field_name( 'layout' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'standard' == $instance['layout'] ) echo 'selected="selected"'; ?>>standard</option>
				<option <?php if ( 'button_count' == $instance['layout'] ) echo 'selected="selected"'; ?>>button_count</option>
				<option <?php if ( 'box_count' == $instance['layout'] ) echo 'selected="selected"'; ?>>box_count</option>				
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'theme_color' ); ?>"><?php _e('Theme Color:', 'color-theme-framework'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'theme_color' ); ?>" name="<?php echo $this->get_field_name( 'theme_color' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'dark' == $instance['theme_color'] ) echo 'selected="selected"'; ?>>dark</option>
				<option <?php if ( 'light' == $instance['theme_color'] ) echo 'selected="selected"'; ?>>light</option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('lang'); ?>"><?php _e( 'Facebook Language:' , 'color-theme-framework' ); ?></label>
			<input class="widefat" style="width: 60px;" id="<?php echo $this->get_field_id('lang'); ?>" name="<?php echo $this->get_field_name('lang'); ?>" value="<?php echo $instance['lang']; ?>" />
		</p>


		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_faces'], 'on'); ?> id="<?php echo $this->get_field_id('show_faces'); ?>" name="<?php echo $this->get_field_name('show_faces'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_faces'); ?>"><?php _e( 'Show Faces' , 'color-theme-framework' ); ?></label>
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
          <input class="widefat" id="<?php echo $this->get_field_id('background_title'); ?>" name="<?php echo $this->get_field_name('background_title'); ?>" type="text" value="<?php if($background_title) { echo $background_title; } else { echo '#748098'; } ?>" />
			<div class="cw-color-picker" rel="<?php echo $this->get_field_id('background_title'); ?>"></div>
        </p>

		
		
		<?php

	}
}
?>