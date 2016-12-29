<?php
/* 
Template Name: Full Width Page

* @package WordPress
* @subpackage NewsTrick
* @since NewsTrick 1.0
*/

get_header(); ?>

<!-- START PAGE CONTENT ENTRY -->
<div id="content" class="container" role="main">

	<!-- CONTENT + RIGHT -->
    <div id="wide-sidebar" class="row-fluid">
    	<div class="span12">
			<div class="ct-page margin-30t box border-1px bottom-shadow clearfix" style="padding-top: 20px;">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'page' ); ?>

					<?php $page_comments = get_post_meta($post->ID,'ct_mb_page_comments', true); ?>
					<?php if ( $page_comments == '1') : ?>
						<?php comments_template( '', true ); ?>
					<?php endif; ?>
				<?php endwhile; // end of the loop. ?>
			</div><!-- ct-page box -->
		</div><!-- span12 -->
	</div><!-- #wide-sidebar .row-fluid -->
	<!-- END CONTENT + RIGHT -->

</div> <!-- #content -->
<!-- END PAGE CONTENT ENTRY -->

<?php get_footer(); ?>