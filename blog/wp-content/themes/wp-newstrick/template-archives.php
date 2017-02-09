<?php
/*
	Template Name: Archives

	 * @package WordPress
	 * @subpackage CrossRoad - Responsive WordPress Magazine Blog Theme
	 * @since CrossRoad 1.0

*/

get_header(); ?>


<!-- START ARCHIVES CONTENT ENTRY -->
<div id="content" class="container" role="main">

	<!-- CONTENT + RIGHT -->
    <div id="wide-sidebar" class="row-fluid">
    	<div class="span8">
			<div class="ct-page margin-30t box border-1px bottom-shadow clearfix" style="padding-top: 20px;">
		  <h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="row-fluid">
		  	  <div class="span12">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>	

				  <?php the_content(__('Read more...', 'color-theme-framework')); ?>
				  <?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:', 'color-theme-framework').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					
				  <!-- /archive-lists -->
				  <div class="row-fluid">
				    <div class="span4">
					  <h5><?php _e('Last 30 Posts', 'color-theme-framework') ?></h5>
					  <ul class="archives" style="">
					    <?php $archive_30 = get_posts('numberposts=30');
					    foreach($archive_30 as $post) : ?>
						  <li><a href="<?php the_permalink(); ?>"><?php the_title();?></a></li>
					  	<?php endforeach; ?>
					  </ul>
					</div><!-- /span4 -->
						
					<div class="span4">
					  <h5><?php _e('Archives by Month:', 'color-theme-framework') ?></h5>
					  <ul class="archives" style="">
					    <?php wp_get_archives('type=monthly'); ?>
					  </ul>
					</div><!-- /span4 -->

				    <div class="span4">
					  <h5><?php _e('Archives by Subject:', 'color-theme-framework') ?></h5>
					  <ul class="archives">
					    <?php wp_list_categories( 'title_li=' ); ?>
					  </ul>
					</div><!-- /span4 -->					
				  <!-- /archive-lists -->
				  </div><!-- row-fluid -->
				<?php endwhile; endif; ?>
			  </div><!-- /span12 -->
			</div><!-- row-fluid -->
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
<!-- END ARCHIVES CONTENT ENTRY -->

<?php get_footer(); ?>