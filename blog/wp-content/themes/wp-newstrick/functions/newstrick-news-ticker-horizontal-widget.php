<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT News Ticker Horizontal
 	Plugin URI: http://www.color-theme.com
 	Description: A widget that show Feaftures posts in a scrolling News Ticker
 	Version: 1.0
 	Author: ZERGE
 	Author URI:  http://www.color-theme.com
 
-----------------------------------------------------------------------------------
*/



/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'ct_h_newsticker_load_widgets' );

function ct_h_newsticker_load_widgets() {
	register_widget( 'ct_h_newsticker_Widget' );
}


/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update. 
 *
 */
class ct_h_newsticker_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function ct_h_newsticker_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'ct_h_newsticker_widget', 'description' => __( 'A widget that show latest (featured) posts titles in a scrolling newsticker' , 'color-theme-framework' ) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'ct_h_newsticker_widget' );

		/* Create the widget. */
		parent::__construct( 'ct_h_newsticker_widget', __('CT: News Ticker Horizontal', 'color-theme-framework'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		if ( !is_admin() ) {
			/* Vertical News Ticker */
			wp_register_script('h-news-ticker',get_template_directory_uri().'/js/horizontal-newsticker.js',false, null , true);
			wp_enqueue_script('h-news-ticker',array('jquery'));
		}

		/* Our variables from the widget settings. */
		$title = apply_filters ('widget_title', $instance ['title']);
		$widget_width = $instance['widget_width'];
		$background = $instance['background'];
		$background_title = $instance['background_title'];
		$num_posts = $instance['num_posts'];
		$text_type = $instance['text_type'];
		$controls = isset($instance['controls']) ? 'true' : 'false';
		$categories = $instance['categories'];

		/* Before widget (defined by themes). */
		if ( $title ){
			echo "\n<!-- START HORIZONTAL NEWS WIDGET -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';">';
			echo '<div class="widget-title bottom-shadow" style="background:' . $background_title .';"><h2>' . $title . '</h2><div class="arrow-down" style="border-top-color:' . $background_title . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->';
		} else {
			echo "\n<!-- START HORIZONTAL NEWS WIDGET -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';padding-top: 20px;">';
		}

		?>

		<script type="text/javascript">
		/* <![CDATA[ */
		/***************************************************
					Horizontal News Ticker
		***************************************************/
		jQuery.noConflict()(function($){
			$(document).ready(function() {
	
		    $('#js-news').ticker({
		        ajaxFeed: false,       // Populate jQuery News Ticker via a feed
		        feedUrl: false,        // The URL of the feed
		        // MUST BE ON THE SAME DOMAIN AS THE TICKER
		        feedType: 'xml',       // Currently only XML
		        htmlFeed: true,        // Populate jQuery News Ticker via HTML
		        debugMode: false,       // Show some helpful errors in the console or as alerts
		        // SHOULD BE SET TO FALSE FOR PRODUCTION SITES!
		        controls: <?php echo $controls; ?>,        // Whether or not to show the jQuery News Ticker controls
		        titleText: '',   // To remove the title set this to an empty String
		        displayType: 'fade', // Animation type - current options are 'reveal' or 'fade'
		        direction: 'ltr',       // Ticker direction - current options are 'ltr' or 'rtl'
		        pauseOnItems: 3000,    // The pause on a news item before being replaced
		        fadeInSpeed: 600,      // Speed of fade in animation
		        fadeOutSpeed: 300      // Speed of fade out animation
    		});		
			});
		});
		/* ]]> */
		</script>

		<?php 
  		  global $post;
		  $news_posts = new WP_Query(array('showposts' => $num_posts, 'post_type' => 'post', 'cat' => $categories)); 
		?>

		<ul id="js-news" class="js-hidden">
			<?php while($news_posts->have_posts()): $news_posts->the_post(); 

		    	$my_excerpt = get_the_excerpt();

		    	if ( $text_type == 'title' ) { ?>
		    		<li class="news-item"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
		    	
		    	<?php }
		    	else if ( $text_type == 'post excerpt' && $my_excerpt != '' ) { ?> 
		    		<li class="news-item"><a href="<?php the_permalink(); ?>"><?php the_excerpt(); ?></a></li>
		  		<?php
		  		} 
		  	endwhile; ?>
		</ul> <!-- js-news -->
		
		<?php wp_reset_query(); ?>

		<?php
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['categories'] = $new_instance['categories'];
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['num_posts'] = $new_instance['num_posts'];
		$instance['text_type'] = $new_instance['text_type'];
		$instance['controls'] = $new_instance['controls'];
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
			'title' => __( 'Breaking News' , 'color-theme-framework' ) ,
			'categories' => 'all', 
			'num_posts' => 10,
			'text_type' => 'post excerpt',
			'controls' => 'on',
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
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('num_posts'); ?>" name="<?php echo $this->get_field_name('num_posts'); ?>" value="<?php echo $instance['num_posts']; ?>" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['controls'], 'on'); ?> id="<?php echo $this->get_field_id('controls'); ?>" name="<?php echo $this->get_field_name('controls'); ?>" /> 
			<label for="<?php echo $this->get_field_id('controls'); ?>"><?php _e( 'Show Controls' , 'color-theme-framework' ); ?></label>
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
			<label for="<?php echo $this->get_field_id( 'text_type' ); ?>"><?php _e('Show:', 'color-theme-framework'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'text_type' ); ?>" name="<?php echo $this->get_field_name( 'text_type' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'title' == $instance['text_type'] ) echo 'selected="selected"'; ?>>title</option>
				<option <?php if ( 'post excerpt' == $instance['text_type'] ) echo 'selected="selected"'; ?>>post excerpt</option>
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