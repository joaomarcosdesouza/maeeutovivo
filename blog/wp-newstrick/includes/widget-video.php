<?php
/**
 * The template for displaying content in the widgets for video
 *
 */
?>

<?php
  global $data, $post, $ct_video_height;
?>

<?php

		$video_type = get_post_meta( $post->ID, 'ct_mb_post_video_type', true );
		$thumb_type = get_post_meta( $post->ID, 'ct_mb_post_video_thumb', true );
		$videoid = get_post_meta( $post->ID, 'ct_mb_post_video_file', true );
		$perma_link = get_permalink($post->ID);
		//$video_height = $ct_video_height;
		
		if ( empty($thumb_type) ) { $thumb_type = 'player'; }
		
		if( $videoid != '' ) : ?>
		  <div class="single-media-thumb">

		  <?php

		  	if ( is_single() ) : $thumb_type = 'player'; endif;

			// for Youtube
		    if ( $video_type == 'youtube' ) {
		      if ( $thumb_type == 'auto' ) {
		        echo '<img src="http://img.youtube.com/vi/' . $videoid . '/0.jpg" alt="'. the_title('','',false) . '" />';
			  }
			  else if ( $thumb_type == 'featured' && has_post_thumbnail() ) {
				$small_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumb');
				echo '<img src="' . $small_image_url[0] . '" alt="'. the_title('','',false) . '" />';
			  }
			  else if ( $thumb_type == 'player' or $thumb_type == '' ) {
			  	if ( is_single() ) :
			  		echo '<iframe src="//www.youtube.com/embed/' . $videoid .'"></iframe>';
			  	else :
					echo '<iframe src="//www.youtube.com/embed/' . $videoid .'?"></iframe>';
				endif;
			  }
			  else { echo '<img src="http://img.youtube.com/vi/' . $videoid . '/0.jpg" alt="'. the_title('','',false) . '" />'; }

 
			  if ( $thumb_type != 'player' && $thumb_type != '' ) {
				echo '<div class="mask"><a href="' . $perma_link . '"></a></div>';
				echo '<div class="video youtube"><a href="' . $perma_link . '" title="'. __('Watch Youtube Video','color-theme-framework').'"></a></div>';
			  }
			}

			// for Vimeo
			else if ( $video_type == 'vimeo' ) {
		      if ( $thumb_type == 'auto' ) {
			  	$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$videoid.php"));
			    echo '<img src="' . $hash[0]['thumbnail_large'] . '" alt="'. the_title('','',false) . '" />';
			  } 
			  else if ( $thumb_type == 'featured' && has_post_thumbnail() ) {
				$small_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumb');
				echo '<img src="' . $small_image_url[0] . '" alt="'. the_title('','',false) . '" />';
			  }
			  else if ( $thumb_type == 'player' or $thumb_type == '' ) {
			    echo '<iframe src="//player.vimeo.com/video/' . $videoid . '?title=0&amp;byline=0&amp;portrait=0&amp;"></iframe>';
			  }
			  else {
			    $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$videoid.php"));
			    echo '<img src="' . $hash[0]['thumbnail_large'] . '" alt="'. the_title('','',false) . '" />';
			  }

			  if ( $thumb_type != 'player' && $thumb_type != '' ) {
			    echo '<div class="mask"><a href="' . $perma_link . '"></a></div>';
				echo '<div class="video vimeo"><a href="' . $perma_link . '" title="'. __('Watch Vimeo Video','color-theme-framework').'"></a></div>';
			  }
			}	

			// for Dailymotion
			elseif ( $video_type == 'dailymotion' ) {
		      if ( $thumb_type == 'auto' ) {
			    echo '<img src="' . getDailyMotionThumb($videoid) . '" alt="'. the_title('','',false) . '" />';
			  } 
			  else if ( $thumb_type == 'featured' && has_post_thumbnail() ) {
				$small_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumb');
				echo '<img src="' . $small_image_url[0] . '" alt="'. the_title('','',false) . '" />';
			  }
			  else if ( $thumb_type == 'player' or $thumb_type == '' ) {
				echo '<iframe height="' . $video_height . '" src="//www.dailymotion.com/embed/video/' . $videoid . '"></iframe>';
			  }
			  else {
			    echo '<img src="' . getDailyMotionThumb($videoid) . '" alt="'. the_title('','',false) . '" />';
			  }										

			  if ( $thumb_type != 'player' && $thumb_type != '' ) {
				echo '<div class="mask"><a href="' . $perma_link . '"></a></div>';
				echo '<div class="video dailymotion"><a href="' . $perma_link . '" title="'. __('Watch DailyMotion Video','color-theme-framework').'"></a></div>';
			  }
			} 
		  ?>
		  </div> <!-- .single-media-thumb-->		
		<?php endif; ?>