<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 *
 * @package WordPress
 * @subpackage NewsTrick
 * @since NewsTrick 1.0
 *
 */

get_header(); ?>

<!-- START PAGE CONTENT ENTRY -->
<div id="content" class="container" role="main">

	<!-- CONTENT + RIGHT -->
    <div id="wide-sidebar" class="row-fluid">
    	<div class="span8">
			<div class="ct-page margin-30t box border-1px bottom-shadow clearfix" style="padding-top: 20px;">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'page' ); ?>

					<?php $page_comments = get_post_meta($post->ID,'ct_mb_page_comments', true); ?>
					<?php if ( $page_comments == '1') : ?>
						<?php comments_template( '', true ); ?>
					<?php endif; ?>
				<?php endwhile; // end of the loop. ?>
			</div><!-- ct-page box -->
		</div><!-- span8 -->
		<div class="span4" role="complementary">
			<?php
			global $wp_query; 
			$postid = $wp_query->post->ID; 
			$cus = get_post_meta($postid, 'sbg_selected_sidebar_replacement', true);

			if ($cus != '') {
				if ($cus[0] != '0') { if  (function_exists('dynamic_sidebar') && dynamic_sidebar($cus[0])) : endif; }
				else { if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar Widgets')) : endif; }
			}
			else { if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar Widgets')) : endif; } ?>			
        </div><!-- span4 -->
	</div><!-- #wide-sidebar .row-fluid -->
	<!-- END CONTENT + RIGHT -->

</div> <!-- #content -->
<!-- END PAGE CONTENT ENTRY -->

<?php get_footer(); ?>