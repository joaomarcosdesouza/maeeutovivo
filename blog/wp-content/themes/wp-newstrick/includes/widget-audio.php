<?php
/**
 * The template for displaying content in the widgets for audio
 *
 */
?>

<?php
  global $data, $post;
?>

<?php

    $soundcloud = get_post_meta( $post->ID, 'ct_mb_post_soundcloud', true );
	$audio_thumb_type = get_post_meta( $post->ID, 'ct_mb_post_audio_thumb', true );

	if ( empty($audio_thumb_type) ) { $audio_thumb_type = 'player'; }

	if ( $soundcloud != '' && $audio_thumb_type == 'player' ) : ?>
      	<div class="single-media-thumb">	
	      <?php echo $soundcloud; ?>
		</div> <!-- .single-media-thumb -->

		<?php elseif (has_post_thumbnail() && $audio_thumb_type == 'featured' ) : ?>
	      <div class="widget-post-big-thumb ct-preload">
		     <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'blog-thumb'); ?>	
		     <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>
		  </div><!-- .widget-post-big-thumb -->
	     <?php endif;
?>