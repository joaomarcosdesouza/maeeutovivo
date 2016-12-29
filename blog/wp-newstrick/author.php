<?php 
/**
 * The template for displaying Author Archive pages.
 *
 * Used to display archive-type pages for posts by an author.
 *
 * @package WordPress
 * @subpackage NewsTrick
 * @since NewsTrick 1.0
 */

get_header(); ?>


  <?php 
	$category_layout = stripslashes( $data['ct_category_layout'] );
  ?>	


  <!-- START AUTHOR CONTENT ENTRY -->
  <div id="content" class="container">

	<?php
	if ( is_active_sidebar('ct_category_top') ): ?>
	<!-- START TOP AUTHOR WIDGETS AREA -->
	  <div class="row-fluid">
	    <div class="span12">
			<?php
			  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Category Top Widgets") ) : ?>
			<?php endif; ?>
	    </div> <!-- /span12 -->	
	  </div> <!-- /row-fluid -->
	<!-- END TOP AUTHOR WIDGETS AREA -->
	<?php endif; ?>	


    <?php if ( $category_layout == 'l_c_r' ) :	?>
	  <!-- LEFT + CONTENT + RIGHT -->
      <div class="row-fluid">
        <div class="span3 sb-3">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Category Left Sidebar") ) : ?>
		  <?php endif; ?>
        </div><!-- span3 -->
        <div class="span6 sb-6">
          <?php if ( is_active_sidebar('ct_category_before') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Category Before Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
          <div class="row-fluid">
            <div class="span12">
		  	  <?php get_template_part( 'content', 'author' ); ?>
            </div><!-- span12 -->
          </div><!-- row-fluid -->
          <?php if ( is_active_sidebar('ct_category_after') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Category After Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
        </div><!-- span6 -->
        <div class="span3 sb-3">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Category Right Sidebar") ) : ?>
		  <?php endif; ?>
        </div><!-- span3 -->      
      </div><!-- row-fluid l_c_r -->
	  <!-- END LEFT + CONTENT + RIGHT -->
	  
    <?php elseif ( $category_layout == 'c_l_r' ) :	?>
    
	  <!-- CONTENT + LEFT + RIGHT -->
      <div class="row-fluid">
        <div class="span6 sb-6">
          <?php if ( is_active_sidebar('ct_category_before') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Category Before Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
          <div class="row-fluid">
            <div class="span12">
		  	  <?php get_template_part( 'content', 'author' ); ?>
            </div><!-- span12 -->
          </div><!-- row-fluid -->
          <?php if ( is_active_sidebar('ct_category_after') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Category After Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
        </div><!-- span6 -->
        <div class="span3 sb-3">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Category Left Sidebar") ) : ?>
		  <?php endif; ?>
        </div><!-- span3 -->
        <div class="span3 sb-3">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Category Right Sidebar") ) : ?>
		  <?php endif; ?>
        </div><!-- span3 -->      
      </div><!-- row-fluid -->
	  <!-- END LEFT + CONTENT + RIGHT -->


    <?php elseif ( $category_layout == 'l_r_c' ) :	?>
	  <!-- LEFT + RIGHT + CONTENT -->
      <div class="row-fluid">
        <div class="span3 sb-3">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Category Left Sidebar") ) : ?>
		  <?php endif; ?>
        </div><!-- span3 -->
        <div class="span3 sb-3">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Category Right Sidebar") ) : ?>
		  <?php endif; ?>
        </div><!-- span3 -->
        <div class="span6 sb-6">
          <?php if ( is_active_sidebar('ct_category_before') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Category Before Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
          <div class="row-fluid">
            <div class="span12">
		  	  <?php get_template_part( 'content', 'author' ); ?>
            </div><!-- span12 -->
          </div><!-- row-fluid -->
          <?php if ( is_active_sidebar('ct_category_after') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Category After Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
        </div><!-- span6 -->
      </div><!-- row-fluid -->
	  <!-- END LEFT + RIGHT + CONTENT -->


    <?php elseif ( $category_layout == 'c_r' ) :	?>
	  <!-- CONTENT + RIGHT -->
      <div id="wide-sidebar" class="row-fluid">
        <div class="span8 sb-8">
          <?php if ( is_active_sidebar('ct_category_before') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Category Before Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
          <div class="row-fluid">
            <div class="span12">
		  	  <?php get_template_part( 'content', 'author' ); ?>
            </div><!-- span12 -->
          </div><!-- row-fluid -->
          <?php if ( is_active_sidebar('ct_category_after') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Category After Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
        </div><!-- span8 -->
        <div class="span4 sb-4">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Category Right Sidebar") ) : ?>
		  <?php endif; ?>
        </div><!-- span4 -->      
      </div><!-- row-fluid -->
	  <!-- END CONTENT + RIGHT -->


    <?php elseif ( $category_layout == 'l_c' ) :	?>
	  <!-- LEFT + CONTENT -->
      <div id="wide-sidebar" class="row-fluid">
        <div class="span4 sb-4">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Category Left Sidebar") ) : ?>
		  <?php endif; ?>
        </div><!-- span4 -->
        <div class="span8 sb-8">
          <?php if ( is_active_sidebar('ct_category_before') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Category Before Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
          <div class="row-fluid">
            <div class="span12">
		  	  <?php get_template_part( 'content', 'author' ); ?>
            </div><!-- span12 -->
          </div><!-- row-fluid -->
          <?php if ( is_active_sidebar('ct_category_after') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Category After Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
        </div><!-- span8 -->
      </div><!-- row-fluid -->
	  <!-- END LEFT + CONTENT -->
    <?php endif; ?>
    
  </div> <!-- #content -->
  <!-- END AUTHOR ENTRY -->

<?php get_footer(); ?>