<?php
/*
  Template Name: Blog

 * @package WordPress
 * @subpackage NewsTrick
 * @since NewsTrick 1.0

*/

?>

<?php get_header(); ?>


  <?php 
	$blog_layout = stripslashes( $data['ct_blog_layout'] );
  ?>	


  <!-- START BLOG CONTENT ENTRY -->
  <div id="content" class="container">

	<?php
	if ( is_active_sidebar('ct_blog_top') ): ?>
	<!-- START TOP BLOG WIDGETS AREA -->
	  <div class="row-fluid">
	    <div class="span12">
			<?php
			  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Top Widgets") ) : ?>
			<?php endif; ?>
	    </div> <!-- /span12 -->	
	  </div> <!-- /row-fluid -->
	<!-- END TOP BLOG WIDGETS AREA -->
	<?php endif; ?>	


    <?php if ( $blog_layout == 'l_c_r' ) :	?>
	  <!-- LEFT + CONTENT + RIGHT -->
      <div class="row-fluid">
        <div class="span3 sb-3">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Left Sidebar") ) : ?>
		  <?php endif; ?>
        </div><!-- span3 -->
        <div class="span6 sb-6">
          <?php if ( is_active_sidebar('ct_blog_before') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Before Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
          <?php if ( is_active_sidebar('ct_blog_after') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog After Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
        </div><!-- span6 -->
        <div class="span3 sb-3">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Right Sidebar") ) : ?>
		  <?php endif; ?>
        </div><!-- span3 -->      
      </div><!-- row-fluid l_c_r -->
	  <!-- END LEFT + CONTENT + RIGHT -->
	  
    <?php elseif ( $blog_layout == 'c_l_r' ) :	?>
    
	  <!-- CONTENT + LEFT + RIGHT -->
      <div class="row-fluid">
        <div class="span6 sb-6">
          <?php if ( is_active_sidebar('ct_blog_before') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Before Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
          <?php if ( is_active_sidebar('ct_blog_after') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog After Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
        </div><!-- span6 -->
        <div class="span3 sb-3">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Left Sidebar") ) : ?>
		  <?php endif; ?>
        </div><!-- span3 -->
        <div class="span3 sb-3">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Right Sidebar") ) : ?>
		  <?php endif; ?>
        </div><!-- span3 -->      
      </div><!-- row-fluid -->
	  <!-- END LEFT + CONTENT + RIGHT -->


    <?php elseif ( $blog_layout == 'l_r_c' ) :	?>
	  <!-- LEFT + RIGHT + CONTENT -->
      <div class="row-fluid">
        <div class="span3 sb-3">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Left Sidebar") ) : ?>
		  <?php endif; ?>
        </div><!-- span3 -->
        <div class="span3 sb-3">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Right Sidebar") ) : ?>
		  <?php endif; ?>
        </div><!-- span3 -->
        <div class="span6 sb-6">
          <?php if ( is_active_sidebar('ct_blog_before') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Before Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
          <?php if ( is_active_sidebar('ct_blog_after') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog After Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
        </div><!-- span6 -->
      </div><!-- row-fluid -->
	  <!-- END LEFT + RIGHT + CONTENT -->


    <?php elseif ( $blog_layout == 'c_r' ) :	?>
	  <!-- CONTENT + RIGHT -->
      <div id="wide-sidebar" class="row-fluid">
        <div class="span8 sb-8">
          <?php if ( is_active_sidebar('ct_blog_before') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Before Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
          <?php if ( is_active_sidebar('ct_blog_after') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog After Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
        </div><!-- span8 -->
        <div class="span4 sb-4">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Right Sidebar") ) : ?>
		  <?php endif; ?>
        </div><!-- span4 -->      
      </div><!-- row-fluid -->
	  <!-- END CONTENT + RIGHT -->


    <?php elseif ( $blog_layout == 'l_c' ) :	?>
	  <!-- LEFT + CONTENT -->
      <div id="wide-sidebar" class="row-fluid">
        <div class="span4 sb-4">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Left Sidebar") ) : ?>
		  <?php endif; ?>
        </div><!-- span4 -->
        <div class="span8 sb-8">
          <?php if ( is_active_sidebar('ct_blog_before') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Before Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
          <?php if ( is_active_sidebar('ct_blog_after') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog After Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
        </div><!-- span8 -->
      </div><!-- row-fluid -->
	  <!-- END LEFT + CONTENT -->
    <?php endif; ?>
    
  </div> <!-- #content -->
  <!-- END BLOG ENTRY -->

<?php get_footer(); ?>