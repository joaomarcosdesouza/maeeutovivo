<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT Social Counter Widget
 	Plugin URI: http://www.color-theme.com
 	Description: A widget that show counters for facebook/twitter/feedburner.
 	Version: 1.0
 	Author: ZERGE
 	Author URI:  http://www.color-theme.com
 
-----------------------------------------------------------------------------------
*/


/**
 * Add function to widgets_init that'll load our widget.
 */

add_action('widgets_init','CT_social_counter_load_widgets');


function CT_social_counter_load_widgets(){
		register_widget("CT_social_counter_Widget");
}

/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update. 
 *
 */
class CT_social_counter_Widget extends WP_widget{

	/**
	 * Widget setup.
	 */	
	function CT_social_counter_Widget(){
		
		/* Widget settings. */	
		$widget_ops = array( 'classname' => 'ct_social_counter_widget', 'description' => __( 'Social Counter Widget' , 'color-theme-framework' ) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'ct_social_counter_widget' );
		
		/* Create the widget. */
		parent::__construct( 'ct_social_counter_widget', __( 'CT: Social Counter' , 'color-theme-framework' ) ,  $widget_ops, $control_ops );
		
	}
	
	function widget($args,$instance){
		extract($args);

			$title = apply_filters ('widget_title', $instance ['title']);
			$widget_width = $instance['widget_width'];
			$twitter_ID = $instance['twitter_ID'];
			$facebook_ID = $instance['facebook_ID'];
			$youtube_ID = $instance['youtube_ID'];

			$show_twitter = isset($instance['show_twitter']) ? 'true' : 'false';
			$show_facebook = isset($instance['show_facebook']) ? 'true' : 'false';
			$show_youtube = isset($instance['show_youtube']) ? 'true' : 'false';
			$background = $instance['background'];
			$background_title = $instance['background_title'];
		?>


		<?php
		/* Before widget (defined by themes). */
		if ( $title ){
			echo "\n<!-- START SOCIAL COUNTER WIDGET -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';">';
			//echo '<div class="widget-title bottom-shadow" style="background:' . $background_title .';"><h2>' . __($title, color-theme-framework) . '</h2><div class="arrow-down" style="border-top-color:' . $background_title . ';"></div><!-- .arrow-down --><div class="plus"><a href=""><span></span></a></div><!-- .plus --></div><!-- widget-title -->';
			echo '<div class="widget-title bottom-shadow" style="background:' . $background_title .';"><h2>'; printf( __( '%s', 'color-theme-framework' ), $title );  echo '</h2><div class="arrow-down" style="border-top-color:' . $background_title . ';"></div><!-- .arrow-down --><div class="plus"><a href=""><span></span></a></div><!-- .plus --></div><!-- widget-title -->';
		} else {
			echo "\n<!-- START SOCIAL COUNTER WIDGET -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';padding-top: 20px;">';
		}
		?>
	
	  <ul id="social-counter">	

<?php if ( class_exists('SC_Class') ) { ?>	  	
		<?php if ( $show_facebook == 'true') : //$facebook_english_format = number_format($fans); ?>
		<li class="facebook-social">
		  <a target="_blank" href="https://www.facebook.com/<?php echo $facebook_ID ?>"><span class="c-icon-big"></span>
		  <span class="arrow-down"></span>
		  <?php echo '<span class="social">' . do_shortcode( '[aps-get-count social_media="facebook"]' ) . '</span>'; ?><br/><span class="fans muted-small"><?php _e('Fans','color-theme-framework'); ?></span></a>
		</li>
		<?php endif; ?>

		<?php if ( $show_twitter == 'true') : //$twitter_english_format = $followers; ?>
		<li class="twitter-social">
		  <a target="_blank" href="http://twitter.com/<?php echo $twitter_ID ?>"><span class="c-icon-big"></span>
		  <span class="arrow-down"></span>
		  <?php echo '<span class="social">' . do_shortcode( '[aps-get-count social_media="twitter"]' ) . '</span>'; ?><br/><span class="fans muted-small"><?php _e('Followers','color-theme-framework'); ?></span></a>
		</li>
		<?php endif; ?>

		<?php if ( $show_youtube == 'true') : //$youtube_english_format = number_format($yt_subscribers); ?>
		<li class="youtube-social">
		  <a target="_blank" href="http://www.youtube.com/user/<?php echo $youtube_ID ?>"><span class="c-icon-big"></span>
		  <span class="arrow-down"></span>
		  <?php echo '<span class="social">' . do_shortcode( '[aps-get-count social_media="youtube"]' ) . '</span>'; ?><br/><span class="fans muted-small"><?php _e('Subscribers','color-theme-framework'); ?></span></a>
		</li>
		<?php endif; ?>

	  </ul><!-- #social-counter -->
<?php } else { echo esc_html( 'Need to install and activate "AccessPress Social Counter" plugin.', 'color-theme-framework' ); } ?>	

		<?php

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */		
	function update($new_instance, $old_instance){
		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];
		$instance['widget_width'] = $new_instance['widget_width'];
		$instance['twitter_ID'] = $new_instance['twitter_ID'];
		$instance['facebook_ID'] = $new_instance['facebook_ID'];
		$instance['youtube_ID'] = $new_instance['youtube_ID'];
		$instance['show_twitter'] = $new_instance['show_twitter'];
		$instance['show_facebook'] = $new_instance['show_facebook'];
		$instance['show_youtube'] = $new_instance['show_youtube'];

		$instance['background'] = strip_tags($new_instance['background']);
		$instance['background_title'] = strip_tags($new_instance['background_title']);
		
		delete_transient('social_subscribers_counter_twitter_ct'.$twitter_ID);
		delete_transient('social_subscribers_counter_facebook'.$facebook_ID);
		delete_transient('social_subscribers_counter_youtube'.$youtube_ID);

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
			'title' => '', 
			'twitter_ID' => 'envato' , 
			'facebook_ID' => 'themeforest', 
			'youtube_ID' => 'Envato',
			'show_twitter' => 'on',
			'show_facebook' => 'on',
			'show_youtube' => 'off',
			'background_title' => '#ff0000',
			'background' => '#FFFFFF',
			'widget_width' => 'ct-full-width' );
			
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
			<label for="<?php echo $this->get_field_id('twitter_ID'); ?>"><?php _e( 'Twitter ID:' , 'color-theme-framework' ); ?></label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('twitter_ID'); ?>" name="<?php echo $this->get_field_name('twitter_ID'); ?>" value="<?php echo $instance['twitter_ID']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('facebook_ID'); ?>"><?php _e( 'Facebook ID:' , 'color-theme-framework' ); ?></label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('facebook_ID'); ?>" name="<?php echo $this->get_field_name('facebook_ID'); ?>" value="<?php echo $instance['facebook_ID']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('youtube_ID'); ?>"><?php _e( 'YouTube ID:' , 'color-theme-framework' ); ?></label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('youtube_ID'); ?>" name="<?php echo $this->get_field_name('youtube_ID'); ?>" value="<?php echo $instance['youtube_ID']; ?>" />
		</p>

		<p style="display:block; margin-bottom:5px;">
			<label for="Show counters" style="display:block;"><?php _e( 'Show counters:' , 'color-theme-framework' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_twitter'], 'on'); ?> id="<?php echo $this->get_field_id('show_twitter'); ?>" name="<?php echo $this->get_field_name('show_twitter'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_twitter'); ?>"><?php _e( 'Twitter' , 'color-theme-framework' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_facebook'], 'on'); ?> id="<?php echo $this->get_field_id('show_facebook'); ?>" name="<?php echo $this->get_field_name('show_facebook'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_facebook'); ?>"><?php _e( 'Facebook' , 'color-theme-framework' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_youtube'], 'on'); ?> id="<?php echo $this->get_field_id('show_youtube'); ?>" name="<?php echo $this->get_field_name('show_youtube'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_youtube'); ?>"><?php _e( 'Youtube' , 'color-theme-framework' ); ?></label>
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