<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage NewsTrick
 * @since NewsTrick 1.0
 */

get_header(); ?>

<!-- START 404 CONTENT ENTRY -->
<div id="content" class="container" role="main">

	<!-- CONTENT + RIGHT -->
    <div id="wide-sidebar" class="row-fluid">
    	<div class="span8">
			<div class="ct-page margin-30t box border-1px bottom-shadow clearfix" style="padding-top: 20px;">
			<article id="post-0" class="post error404 no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'color-theme-framework' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'color-theme-framework' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

			</div><!-- ct-page box -->
		</div><!-- span8 -->
		<div class="span4" role="complementary">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Sidebar Widgets") ) : ?>
		  <?php endif; ?>
        </div><!-- span4 -->
	</div><!-- #wide-sidebar .row-fluid -->
	<!-- END CONTENT + RIGHT -->

</div> <!-- #content -->
<!-- END 404 ENTRY -->

<?php get_footer(); ?>