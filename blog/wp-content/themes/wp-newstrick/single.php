<?php get_header(); ?>


	<?php 
  	$blog_sharing = stripslashes( $data['ct_blog_sharing'] );
	  $disqus_shortname = stripslashes( $data['ct_disqus_shortname'] );
	  $facebook_appid = stripslashes( $data['ct_facebook_appid'] );
	  $single_layout = stripslashes( $data['ct_single_layout'] );
	?>	


  <!-- START SINGLE CONTENT ENTRY -->
  <div id="content" class="container">

	<?php
	if ( is_active_sidebar('ct_single_top') ): ?>
	<!-- START TOP SINGLE WIDGETS AREA -->
	  <div class="row-fluid">
	    <div class="span12">
			<?php
			  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Single Top Widgets") ) : ?>
			<?php endif; ?>
	    </div> <!-- /span12 -->	
	  </div> <!-- /row-fluid -->
	<!-- END TOP SINGLE WIDGETS AREA -->
	<?php endif; ?>	


    <?php if ( $single_layout == 'l_c_r' ) :	?>
	  <!-- LEFT + CONTENT + RIGHT -->
      <div class="row-fluid">
        <div class="span3 sb-3">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Single Left Sidebar") ) : ?>
		  <?php endif; ?>
        </div><!-- span3 -->
        <div class="span6 sb-6">
          <?php if ( is_active_sidebar('ct_single_before') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Single Before Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
          <div class="row-fluid">
            <div class="span12">
		  	  <?php get_template_part( 'content', 'single' ); ?>
            </div><!-- span12 -->
          </div><!-- row-fluid -->
          <?php if ( is_active_sidebar('ct_single_after') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Single After Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
        </div><!-- span6 -->
        <div class="span3 sb-3">
		      <?php
            global $wp_query; 
            $postid = $wp_query->post->ID; 
            $cus = get_post_meta($postid, 'sbg_selected_sidebar_replacement', true);
   
            if ($cus != '') {
              if ($cus[0] != '0') { if  (function_exists('dynamic_sidebar') && dynamic_sidebar($cus[0])) : endif; }
              else { if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Single Right Sidebar')) : endif; }
            }
            else { if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Single Right Sidebar')) : endif; } ?>
        </div><!-- span3 -->      
      </div><!-- row-fluid l_c_r -->
	  <!-- END LEFT + CONTENT + RIGHT -->
	  
    <?php elseif ( $single_layout == 'c_l_r' ) :	?>
    
	  <!-- CONTENT + LEFT + RIGHT -->
      <div class="row-fluid">
        <div class="span6 sb-6">
          <?php if ( is_active_sidebar('ct_single_before') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Single Before Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
          <div class="row-fluid">
            <div class="span12">
		  	  <?php get_template_part( 'content', 'single' ); ?>
            </div><!-- span12 -->
          </div><!-- row-fluid -->
          <?php if ( is_active_sidebar('ct_single_after') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Single After Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
        </div><!-- span6 -->
        <div class="span3 sb-3">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Single Left Sidebar") ) : ?>
		  <?php endif; ?>
        </div><!-- span3 -->
        <div class="span3 sb-3">
          <?php
            global $wp_query; 
            $postid = $wp_query->post->ID; 
            $cus = get_post_meta($postid, 'sbg_selected_sidebar_replacement', true);
   
            if ($cus != '') {
              if ($cus[0] != '0') { if  (function_exists('dynamic_sidebar') && dynamic_sidebar($cus[0])) : endif; }
              else { if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Single Right Sidebar')) : endif; }
            }
            else { if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Single Right Sidebar')) : endif; } ?>
        </div><!-- span3 -->      
      </div><!-- row-fluid -->
	  <!-- END LEFT + CONTENT + RIGHT -->


    <?php elseif ( $single_layout == 'l_r_c' ) :	?>
	  <!-- LEFT + RIGHT + CONTENT -->
      <div class="row-fluid">
        <div class="span3 sb-3">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Single Left Sidebar") ) : ?>
		  <?php endif; ?>
        </div><!-- span3 -->
        <div class="span3 sb-3">
          <?php
            global $wp_query; 
            $postid = $wp_query->post->ID; 
            $cus = get_post_meta($postid, 'sbg_selected_sidebar_replacement', true);
   
            if ($cus != '') {
              if ($cus[0] != '0') { if  (function_exists('dynamic_sidebar') && dynamic_sidebar($cus[0])) : endif; }
              else { if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Single Right Sidebar')) : endif; }
            }
            else { if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Single Right Sidebar')) : endif; } ?>
        </div><!-- span3 -->
        <div class="span6 sb-6">
          <?php if ( is_active_sidebar('ct_single_before') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Single Before Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
          <div class="row-fluid">
            <div class="span12">
		  	  <?php get_template_part( 'content', 'single' ); ?>
            </div><!-- span12 -->
          </div><!-- row-fluid -->
          <?php if ( is_active_sidebar('ct_single_after') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Single After Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
        </div><!-- span6 -->
      </div><!-- row-fluid -->
	  <!-- END LEFT + RIGHT + CONTENT -->


    <?php elseif ( $single_layout == 'c_r' ) :	?>
	  <!-- CONTENT + RIGHT -->
      <div id="wide-sidebar" class="row-fluid">
        <div class="span8 sb-8">
          <?php if ( is_active_sidebar('ct_single_before') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Single Before Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
          <div class="row-fluid">
            <div class="span12">
		  	  <?php get_template_part( 'content', 'single' ); ?>
            </div><!-- span12 -->
          </div><!-- row-fluid -->
          <?php if ( is_active_sidebar('ct_single_after') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Single After Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
        </div><!-- span8 -->
        <div class="span4 sb-4">
          <?php
            global $wp_query; 
            $postid = $wp_query->post->ID; 
            $cus = get_post_meta($postid, 'sbg_selected_sidebar_replacement', true);
   
            if ($cus != '') {
              if ($cus[0] != '0') { if  (function_exists('dynamic_sidebar') && dynamic_sidebar($cus[0])) : endif; }
              else { if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Single Right Sidebar')) : endif; }
            }
            else { if  (function_exists('dynamic_sidebar') && dynamic_sidebar('Single Right Sidebar')) : endif; } ?>
        </div><!-- span4 -->      
      </div><!-- row-fluid -->
	  <!-- END CONTENT + RIGHT -->


    <?php elseif ( $single_layout == 'l_c' ) :	?>
	  <!-- LEFT + CONTENT -->
      <div id="wide-sidebar" class="row-fluid">
        <div class="span4 sb-4">
		  <?php
		    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Single Left Sidebar") ) : ?>
		  <?php endif; ?>
        </div><!-- span4 -->
        <div class="span8 sb-8">
          <?php if ( is_active_sidebar('ct_single_before') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Single Before Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
          <div class="row-fluid">
            <div class="span12">
		  	  <?php get_template_part( 'content', 'single' ); ?>
            </div><!-- span12 -->
          </div><!-- row-fluid -->
          <?php if ( is_active_sidebar('ct_single_after') ): ?>
            <div class="row-fluid">
              <div class="span12">
		  	    <?php
		    	  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Single After Widgets") ) : ?>
		  	    <?php endif; ?>
              </div><!-- span12 -->
            </div><!-- row-fluid -->
		  <?php endif; ?>
        </div><!-- span8 -->
      </div><!-- row-fluid -->
	  <!-- END LEFT + CONTENT -->
    <?php endif; ?>
    
  </div> <!-- #content -->
  <!-- END CONTENT ENTRY -->

<?php get_footer(); ?>