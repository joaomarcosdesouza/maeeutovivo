<?php
/**
 * The template for displaying content in the widgets for gallery
 *
 * @package WordPress
 * @subpackage NewsTrick
 * @since NewsTrick 1.0
 */
?>

<?php
global $data, $post, $wpdb;

$time_id = rand();
$meta_gallery = get_post_meta(get_the_ID(), 'ct_mb_gallery', false);
$gallery_thumb = get_post_meta( $post->ID, 'ct_mb_post_gallery_thumb', true );

if (!is_array($meta_gallery)) $meta_gallery = (array) $meta_gallery;

// if gallery thumb not specified, set up default value
if ( empty($gallery_thumb) ) {
	$gallery_thumb = 'gallery';
}

if(has_post_thumbnail() && $gallery_thumb == 'featured' && !is_singular() ) : ?>
    <div class="widget-post-big-thumb ct-preload">
		<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'post-thumb'); ?>	
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>
	</div><!-- .widget-post-big-thumb -->

<?php 

else:
//if Gallery thumb == gallery ?>
	      
	<?php 
	if (!empty($meta_gallery)) { ?>

		<?php
			/* Flex Slider */
			wp_register_script('flex-min-jquery',get_template_directory_uri().'/js/jquery.flexslider-min.js',false, null , true);
			wp_enqueue_script('flex-min-jquery',array('jquery'));
		?>

		<script type="text/javascript">
		/* <![CDATA[ */
			jQuery.noConflict()(function($){
		    	$(window).load(function () {

		    		$(".slider-preloader").css("display","none");

					$('#slider-<?php echo $post->ID . '-' . $time_id; ?>').flexslider({
				    	animation: "fade",
						directionNav: true,
						controlNav: false,
						slideshow: false,
						smoothHeight: true
				  	});
				});
   			});
   		/* ]]> */
		</script>

		<!-- Start FlexSlider -->
		<div id="slider-<?php echo $post->ID . '-' . $time_id; ?>" class="flexslider clearfix">
			<div class="slider-preloader"></div>
			<ul class="slides clearfix">

				<?php
		    	$meta_gallery = implode(',', $meta_gallery);

				$images = $wpdb->get_col("
					SELECT ID FROM $wpdb->posts
					WHERE post_type = 'attachment'
					AND ID in ($meta_gallery)
					ORDER BY menu_order ASC
				");

				foreach ($images as $att) {
					$src = wp_get_attachment_image_src($att, 'post-thumb');
					$src_full = wp_get_attachment_image_src($att, 'full');		    
					$src = $src[0];
					$src_full = $src_full[0];
					?>

					<?php
					echo '<li class="ct-preload"><a href="' . $src_full . '" data-rel="prettyPhoto[gal]">';
					echo '<img src="' . $src . '" alt="' . the_title('','',false) . '" title="'. __('Click on image to start slideshow','color-theme-framework') .'">';
					echo '</a></li>';
    			} // end foreach ?>
			</ul><!-- .slides -->
		</div><!-- .flexSlider -->
		
	<?php
	}
endif; ?>