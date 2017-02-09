<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT Flex Slider Widget
 	Plugin URI: http://www.color-theme.com
 	Description: A widget that show slider with latest posts.
 	Version: 1.01
 	Author: ZERGE
 	Author URI:  http://www.color-theme.com
 
-----------------------------------------------------------------------------------
*/


/**
 * Add function to widgets_init that'll load our widget.
 */

add_action('widgets_init','CT_slider_load_widgets');

function CT_slider_load_widgets(){
		register_widget("CT_slider_Widget");
}

/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update. 
 *
 */
class CT_slider_Widget extends WP_widget{

	/**
	 * Widget setup.
	 */	
	function CT_slider_Widget(){
		
		/* Widget settings. */	
		$widget_ops = array( 'classname' => 'ct_slider_widget', 'description' => __( 'Flex Slider widget' , 'color-theme-framework' ) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'ct_slider_widget' );
		
		/* Create the widget. */
		parent::__construct( 'ct_slider_widget', __( 'CT: Slider Widget' , 'color-theme-framework' ) ,  $widget_ops, $control_ops );
		
	}
	
	function widget($args,$instance){
		extract($args);

		$title = apply_filters ('widget_title', $instance ['title']);
		$categories = $instance['categories'];
		$posts = $instance['posts'];
		$show_random = isset($instance['show_random']) ? 'true' : 'false';
		$animation_speed = $instance['animation_speed'];
		$slideshow_speed = $instance['slideshow_speed'];
		//$slideshow = isset($instance['slideshow']) ? 'true' : 'false';
		$carousel = isset($instance['carousel']) ? 'true' : 'false';
//		$show_text = $instance['show_text'];
		$widget_width = $instance['widget_width'];
		$position_nav = $instance['position_nav'];
		$animation_type = $instance['animation_type'];
		$background = $instance['background'];
		$background_title = $instance['background_title'];
		$show_post_title = isset($instance['show_post_title']) ? 'true' : 'false';
		$show_post_text = isset($instance['show_post_text']) ? 'true' : 'false';

		$twitter_ID = $instance['twitter_ID'];
		$facebook_ID = $instance['facebook_ID'];
		$youtube_ID = $instance['youtube_ID'];

		$show_twitter = isset($instance['show_twitter']) ? 'true' : 'false';
		$show_facebook = isset($instance['show_facebook']) ? 'true' : 'false';
		$show_counters = isset($instance['show_counters']) ? 'true' : 'false';
		$show_youtube = isset($instance['show_youtube']) ? 'true' : 'false';
		
		?>

		<?php
		
		/* Before widget (defined by themes). */
		if ( $title ){ 
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';">';
			echo '<div class="widget-title bottom-shadow" style="background:' . $background_title .';"><h2>' . $title . '</h2><div class="arrow-down" style="border-top-color:' . $background_title . ';"></div><!-- .arrow-down --><div class="plus"><span></span></div><!-- .plus --></div><!-- widget-title -->'; 
		} else {
			echo '<div class="' . $widget_width . '"><div class="widget margin-30t box border-1px bottom-shadow clearfix" style="background:' . $background . ';padding-top: 20px;">';
		}
		
		/* Display the widget title if one was input (before and after defined by themes). */ ?>
		
		<?php
		global $data, $post;

		$time_id = rand();
		$orderby = 'date';
	
		if ( $show_random == 'true' ) { $orderby = 'rand'; }

			$slider_posts = new WP_Query(array(
				'orderby' => $orderby,
				'showposts' => $posts,
				'post_type' => 'post',
				'cat' => $categories,
			));
		?>

	<?php if ( $position_nav == 'Bottom' ) : ?>
	  <style>
	  	.widget-slider .flex-direction-nav {width:100px;background:white;height:60px;position:absolute;bottom:20px;right:0px;
	  	border: 0;-webkit-box-shadow: none;-moz-box-shadow: none;box-shadow: none;top:inherit;}
	  </style>
	<?php endif; ?>

	<?php if ( $title ) : ?>
	  <style>
		.widget-slider .flex-direction-nav {top:-51px;}
	  </style>
	<?php endif; ?>	

	<?php
		/* Flex Slider */
		wp_register_script('flex-min-jquery',get_template_directory_uri().'/js/jquery.flexslider-min.js',false, null , true);
		wp_enqueue_script('flex-min-jquery',array('jquery'));
	?>

<script type="text/javascript">
/* <![CDATA[ */
jQuery.noConflict()(function($){
	$(window).load(function() {

		$(".slider-preloader").css("display","none");

		$('#slider-<?php echo $time_id; ?>').flexslider({
			animation: "<?php echo $animation_type; ?>",
			controlNav: false,
			animationLoop: true,
			smoothHeight: true,
			slideshowSpeed: <?php echo $slideshow_speed; ?>,
			animationSpeed: <?php echo $animation_speed; ?>,
			sync: "#carousel-<?php echo $time_id; ?>"
		});

		$('#carousel-<?php echo $time_id; ?>').flexslider({
			animation: "slide",
			animationLoop: true,
			itemWidth: 150,
			itemMargin: 10,
			controlNav: false,
			asNavFor: '#slider-<?php echo $time_id; ?>'
		});

	});
});
/* ]]> */
</script>

<!-- #########  SLIDER  ######### -->
	<div id="slider-<?php echo $time_id; ?>" class="widget-slider flex-main flexslider">
	  <div class="slider-preloader"></div>
 	  <ul class="slides">

		<?php while($slider_posts->have_posts()): $slider_posts->the_post(); ?>
		  <?php if( has_post_thumbnail() ): 
		    $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'slider-thumb'); ?>
	    	<li>
			  <a href="<?php the_permalink(); ?>"><img src="<?php echo $image[0]; ?>" alt="" /></a>
			  <?php if ( $show_post_title == 'true' ) : ?>
			    <div class="title-mask">
			    	<h4 class="entry-title"><?php the_title(); ?></h4>
			    </div><!-- .title-mask -->
			  <?php endif; 
			  
			  if ( $show_post_text == 'true' ) : ?>
			    <div class="content-mask"><p><?php $post_excerpt = get_the_excerpt(); echo strip_tags(mb_substr($post_excerpt, 0, 120 ) ) . ' ...'; ?></p></div><!-- .content-mask -->
			  <?php endif; ?>
	    	</li>
		  <?php endif; ?>
		<?php endwhile; ?>
	  </ul><!-- slides -->
	</div><!-- slider -->



  <?php if ( $carousel == 'true') : ?>
<!-- #########  CAROUSEL  ######### -->
	<div id="carousel-<?php echo $time_id; ?>" class="widget-carousel flexslider ">
	  <ul class="slides">
		<?php
		  while($slider_posts->have_posts()): $slider_posts->the_post(); 
		?>

		<?php if( has_post_thumbnail() ): ?>

	    <li>
	      <div class="carousel-thumb">
			<?php $carousel_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'carousel-thumb'); 
			if ( $carousel_image_url[1] == 270 && $carousel_image_url[2] == 190 ) { ?>	      
			  <img src="<?php echo $carousel_image_url[0]; ?>" alt="<?php the_title(); ?>" />
			  
			<?php } else { 
			  $carousel_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail');?>
	          <img src="<?php echo $carousel_image_url[0]; ?>" alt="<?php the_title(); ?>" />
			<?php } ?>
			
		    <div class="mask"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"></a></div>
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

		  </div><!-- /carousel-thumb -->
	    </li>
<?php endif; ?>
	<?php endwhile; ?>

	  </ul>
	</div> <!-- /flexslider -->
<?php endif; ?> <!-- show carousel -->


<?php if ( ( $show_counters == 'true') and class_exists('SC_Class') ) : //Show/Hide Counters ?>
	<div id="entry-counters" class="border-1px">
	  <ul id="social-counter">
		<?php if ( $show_facebook == 'true') : //$facebook_english_format = number_format($fans); ?>
		<li class="facebook-social">
		  <a href="https://www.facebook.com/<?php echo $facebook_ID ?>" title="<?php _e('Fans','color-theme-framework'); ?>"><span class="c-icon"></span>
		  <span class="arrow-down"></span>
		  <?php echo '<span class="social">' . do_shortcode( '[aps-get-count social_media="facebook"]' ) . '</span>'; ?></a>
		</li>
		<?php endif; ?>

		<?php if ( $show_twitter == 'true') : //$twitter_english_format = number_format($followers); ?>
		<li class="twitter-social">
		  <a href="http://twitter.com/<?php echo $twitter_ID ?>" title="<?php _e('Followers','color-theme-framework'); ?>"><span class="c-icon"></span>
		  <span class="arrow-down"></span>
		  <?php echo '<span class="social">' . do_shortcode( '[aps-get-count social_media="twitter"]' ) . '</span>'; ?></a>
		</li>
		<?php endif; ?>

		<?php if ( $show_youtube == 'true') : //$youtube_english_format = number_format($yt_subscribers); ?>
		<li class="youtube-social">
		  <a href="http://www.youtube.com/user/<?php echo $youtube_ID ?>" title="<?php _e('Subscribers','color-theme-framework'); ?>"><span class="c-icon"></span>
		  <span class="arrow-down"></span>
		  <?php echo '<span class="social">' . do_shortcode( '[aps-get-count social_media="youtube"]' ) . '</span>'; ?></a>
		</li>
		<?php endif; ?>
		</ul>
	</div><!-- entry-counters -->
<?php elseif ( $show_counters == 'false') : echo ''; ?>
<?php else: echo esc_html( 'Need to install and activate "AccessPress Social Counter" plugin.', 'color-theme-framework' ); endif; ?>

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
		$instance['show_random'] = $new_instance['show_random'];
		$instance['animation_speed'] = $new_instance['animation_speed'];
		$instance['slideshow_speed'] = $new_instance['slideshow_speed'];
		//$instance['slideshow'] = $new_instance['slideshow'];
		$instance['carousel'] = $new_instance['carousel'];
//		$instance['show_text'] = $new_instance['show_text'];
		$instance['widget_width'] = $new_instance['widget_width'];
		$instance['position_nav'] = $new_instance['position_nav'];
		$instance['animation_type'] = $new_instance['animation_type'];
		$instance['background'] = strip_tags($new_instance['background']);
		$instance['background_title'] = strip_tags($new_instance['background_title']);
		$instance['show_post_title'] = $new_instance['show_post_title'];
		$instance['show_post_text'] = $new_instance['show_post_text'];
		$instance['twitter_ID'] = $new_instance['twitter_ID'];
		$instance['facebook_ID'] = $new_instance['facebook_ID'];
		$instance['youtube_ID'] = $new_instance['youtube_ID'];
		$instance['show_twitter'] = $new_instance['show_twitter'];
		$instance['show_facebook'] = $new_instance['show_facebook'];
		$instance['show_counters'] = $new_instance['show_counters'];
		$instance['show_youtube'] = $new_instance['show_youtube'];

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
				//'slideshow' => 'off', 
				'carousel' => 'off', 
				'categories' => 'all', 
				'posts' => '5',
				'show_random' => 'off',
				'widget_width' => 'span7', 
				'background' => '#FFFFFF', 
				'position_nav' => 'Top-right',
				'show_post_title' => 'on',
				'show_post_text' => 'on',
				'animation_speed' => '600',
				'slideshow_speed' => '7000',
				'animation_type' => 'slide',
				'background_title' => '#ff0000',
				'twitter_ID' => 'envato' , 
				'facebook_ID' => 'themeforest', 
				'youtube_ID' => 'Envato',
				'show_twitter' => 'on',
				'show_facebook' => 'on',
				'show_counters' => 'on',
				'show_youtube' => 'on' );
				
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
			<input class="checkbox" type="checkbox" <?php checked($instance['carousel'], 'on'); ?> id="<?php echo $this->get_field_id('carousel'); ?>" name="<?php echo $this->get_field_name('carousel'); ?>" /> 
			<label for="<?php echo $this->get_field_id('carousel'); ?>"><?php _e( 'Show carousel' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_post_title'], 'on'); ?> id="<?php echo $this->get_field_id('show_post_title'); ?>" name="<?php echo $this->get_field_name('show_post_title'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_post_title'); ?>"><?php _e( 'Show post title' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_post_text'], 'on'); ?> id="<?php echo $this->get_field_id('show_post_text'); ?>" name="<?php echo $this->get_field_name('show_post_text'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_post_text'); ?>"><?php _e( 'Show post text' , 'color-theme-framework' ); ?></label>
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
			<label for="<?php echo $this->get_field_id('slideshow_speed'); ?>"><?php _e( 'Slideshow speed, in millisec:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="100000" class="widefat" id="<?php echo $this->get_field_id('slideshow_speed'); ?>" name="<?php echo $this->get_field_name('slideshow_speed'); ?>" value="<?php echo $instance['slideshow_speed']; ?>" />
			
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('animation_speed'); ?>"><?php _e( 'Animation speed, in millisec:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="100000"class="widefat" id="<?php echo $this->get_field_id('animation_speed'); ?>" name="<?php echo $this->get_field_name('animation_speed'); ?>" value="<?php echo $instance['animation_speed']; ?>" />
			
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'animation_type' ); ?>"><?php _e('Animation type:', 'color-theme-framework'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'animation_type' ); ?>" name="<?php echo $this->get_field_name( 'animation_type' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'fade' == $instance['animation_type'] ) echo 'selected="selected"'; ?>>fade</option>
				<option <?php if ( 'slide' == $instance['animation_type'] ) echo 'selected="selected"'; ?>>slide</option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'position_nav' ); ?>"><?php _e('Position of navigation arrows:', 'color-theme-framework'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'position_nav' ); ?>" name="<?php echo $this->get_field_name( 'position_nav' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'Top-right' == $instance['position_nav'] ) echo 'selected="selected"'; ?>>Top-right</option>
				<option <?php if ( 'Bottom' == $instance['position_nav'] ) echo 'selected="selected"'; ?>>Bottom</option>
			</select>
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

		<p style="margin-top: 40px">
			<label style="font-weight:bold;"><?php _e( 'Social counters settings' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_counters'], 'on'); ?> id="<?php echo $this->get_field_id('show_counters'); ?>" name="<?php echo $this->get_field_name('show_counters'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_counters'); ?>"><?php _e( 'Show All Counters' , 'color-theme-framework' ); ?></label>
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