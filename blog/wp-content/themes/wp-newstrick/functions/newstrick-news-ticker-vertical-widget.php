<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT News Ticker Vertical
 	Plugin URI: http://www.color-theme.com
 	Description: A widget that news ticker with featured posts.
 	Version: 1.0
 	Author: ZERGE
 	Author URI:  http://www.color-theme.com
 
-----------------------------------------------------------------------------------
*/


/**
 * Add function to widgets_init that'll load our widget.
 */

add_action('widgets_init','ct_v_newsticker_load_widgets');


function ct_v_newsticker_load_widgets(){
		register_widget("ct_v_newsticker_Widget");
}

/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update. 
 *
 */
class ct_v_newsticker_Widget extends WP_widget{

	/**
	 * Widget setup.
	 */	
	function ct_v_newsticker_Widget(){
		
		/* Widget settings. */	
		$widget_ops = array( 'classname' => 'ct_v_newsticker_widget', 'description' => __( 'News Ticker Vertical' , 'color-theme-framework' ) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'ct_v_newsticker_widget' );
		
		/* Create the widget. */
		parent::__construct( 'ct_v_newsticker_widget', __( 'CT: News Ticker Vertical' , 'color-theme-framework' ) ,  $widget_ops, $control_ops );
		
	}
	
	function widget($args,$instance){
		extract($args);


		if ( !is_admin() ) {
			/* Vertical News Ticker */
			wp_register_script('v-news-ticker',get_template_directory_uri().'/js/jquery.easy-ticker.min.js',false, null , true);
			wp_enqueue_script('v-news-ticker',array('jquery'));
		}

		$title = apply_filters ('widget_title', $instance ['title']);
		$categories = $instance['categories'];
		$posts = $instance['posts'];
		$news = $instance['news'];
		$speed = $instance['speed'];
		$interval = $instance['interval'];
		$min_height = $instance['min_height'];
		$slideshow = isset($instance['slideshow']) ? 'true' : 'false';
		$carousel = isset($instance['carousel']) ? 'true' : 'false';
		$widget_width = $instance['widget_width'];
		$show_meta = $instance['show_meta'];
		$background = $instance['background'];
		$background_title = $instance['background_title'];
		
		/* Before widget (defined by themes). */
		if ( $title ){
			echo "\n<!-- START NEWS TICKER VERTICAL WIDGET -->\n";
			echo '<div class="' . $widget_width . '">';
			//echo '<div class="widget news-widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';">';
			echo '<div class="widget news-widget margin-30t box border-1px bottom-shadow clearfix" style="min-height:' .$min_height. 'px;max-height:' .$min_height. 'px; background:' . $background . ';">';
					
			if ( $categories != 'all' ):
			  $category_title_link = get_category_link( $categories );
			  echo '<div class="widget-title bottom-shadow" style="z-index:3; background:' . $background_title .';"><h2><a href="'.$category_title_link.'" title="'.__('View all posts in ','color-theme-framework').$title.'">'.$title.'</a></h2><div class="arrow-down" style="border-top-color:' . $background_title . ';"></div><!-- .arrow-down --><div class="plus"><a href="'.$category_title_link.'" title="'.__('View all posts in ','color-theme-framework').$title.'"><span></span></a></div><!-- .plus --></div><!-- widget-title -->';
			else :
			  echo '<div class="widget-title bottom-shadow" style="z-index:3; background:' . $background_title .';"><h2>' . $title . '</h2><div class="arrow-down" style="border-top-color:' . $background_title . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->';
			endif;
		
		} else {
			echo "\n<!-- START NEWS TICKER VERTICAL WIDGET -->\n";
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';padding-top: 20px;">';
		}

		$news_posts = new WP_Query(array(
			'showposts' => $posts,
			'post_type' => 'post',
			'cat' => $categories,
		));

		global $data, $post;
		$time_id = rand();
	?>

	<script type="text/javascript">
	/* <![CDATA[ */
		jQuery.noConflict()(function($){
			"use strict";
			$(document).ready(function(){

		jQuery('#v-newsticker-<?php echo $time_id; ?>').easyTicker({
			direction: 'up',
			visible:<?php echo $news; ?>,
			speed:<?php echo $speed; ?>,
			interval:<?php echo $interval; ?>
		});


		$('.news-widget').css("overflow","inherit");
		$('.news-widget .widget-title').css("visibility","visible");

			});
		});
	/* ]]> */
	</script>


	<div id="v-newsticker-<?php echo $time_id; ?>">
	  <ul>
		<?php while($news_posts->have_posts()): $news_posts->the_post(); ?>
	      <li class="clearfix">
			<div class="news-date">
			  <?php echo esc_attr( get_the_date( 'd.m.y' ) ); ?>
			  <span class="arrow-right"></span>
			</div><!-- .news-date -->
			
			<div class="news-title">
			  <h4><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'color-theme-framework' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php echo strip_tags(mb_substr(the_title('','',false), 0, 22 ) ) . ' ...'; ?></a></h4>
			</div><!-- .title-mask -->

		  	<?php
		  	//Get post type: standard post or review
			$post_type = get_post_meta($post->ID, 'ct_mb_post_type', true);
			if( $post_type == '' ) $post_type = 'standard_post';

			// Check if post is Review, then show rating
			if ( $post_type == 'review_post' ) : ?>
				<div class="entry-stars">
					<?php ct_get_rating_stars_s(); ?>
				</div><!-- entry-stars -->
			<?php
			// Else, show standard meta
			else : ?>
				<?php if ( $show_meta == 'tags' ) : ?>
					<div class="entry-tags">
			  			<?php the_tags('', ', ', ''); ?>
		    		</div><!-- entry-tags -->
				<?php else : ?>
					<div class="entry-category">
			  			<?php $category = get_the_category(); echo get_the_category_list(', ', '', $post->ID); //echo $category[0]->cat_name;  ?>
		    		</div><!-- entry-category -->
				<?php endif ?>
			<?php endif; //endif review or standard ?>
	      </li>
		<?php endwhile; ?>
	  </ul>
	</div><!-- #v-newsticker -->


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
		$instance['news'] = $new_instance['news'];
		$instance['speed'] = $new_instance['speed'];
		$instance['interval'] = $new_instance['interval'];
		$instance['min_height'] = $new_instance['min_height'];
		$instance['widget_width'] = $new_instance['widget_width'];
		$instance['show_meta'] = $new_instance['show_meta'];
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
				'title' => __( 'Breaking News', 'color-theme-framework' ), 
				'categories' => 'all', 
				'posts' => '10',
				'news' => '4',
				'speed' => '500',
				'interval' => '3000',
				'min_height' => '305',
				'widget_width' => 'span4', 
				'background' => '#FFFFFF',
				'background_title' => '#ff0000',
				'show_meta' => 'tags' );
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
			<label for="<?php echo $this->get_field_id('posts'); ?>"><?php _e( 'Number of news to query:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="100" class="widefat" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo $instance['posts']; ?>" />
			
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('news'); ?>"><?php _e( 'Number of visible news:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="30" class="widefat" id="<?php echo $this->get_field_id('news'); ?>" name="<?php echo $this->get_field_name('news'); ?>" value="<?php echo $instance['news']; ?>" />
			
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('min_height'); ?>"><?php _e( 'Min Height of widget (px):' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="500" class="widefat" id="<?php echo $this->get_field_id('min_height'); ?>" name="<?php echo $this->get_field_name('min_height'); ?>" value="<?php echo $instance['min_height']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('speed'); ?>"><?php _e( 'Speed, in milliseconds:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="100000" class="widefat" id="<?php echo $this->get_field_id('speed'); ?>" name="<?php echo $this->get_field_name('speed'); ?>" value="<?php echo $instance['speed']; ?>" />
			
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('interval'); ?>"><?php _e( 'Interval, in milliseconds:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="100000" class="widefat" id="<?php echo $this->get_field_id('interval'); ?>" name="<?php echo $this->get_field_name('interval'); ?>" value="<?php echo $instance['interval']; ?>" />
			
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show_meta' ); ?>"><?php _e('Show meta:', 'color-theme-framework'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'show_meta' ); ?>" name="<?php echo $this->get_field_name( 'show_meta' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'tags' == $instance['show_meta'] ) echo 'selected="selected"'; ?>>tags</option>
				<option <?php if ( 'category' == $instance['show_meta'] ) echo 'selected="selected"'; ?>>category</option>
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