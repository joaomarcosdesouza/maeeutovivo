<?php
/**
 * The template for displaying the footer.
 *
 */
?>

<?php
	global $data;
?>
<?php
	/*
	----------------------------------------------------
			Start Footer
	----------------------------------------------------				
	*/
?>

<footer id="footer" role="contentinfo" itemscope="" itemtype="http://schema.org/WPFooter">

	<?php
    $top_block_style = stripslashes( $data['ct_top_block_style'] ); 

    if ( $top_block_style == 'Boxed' ) : ?>
    <div style="margin-bottom: 150px; margin-top: 50px;">
    	<div id="bottom-block-bg" class="container border-1px bottom-shadow totop-container">

    <?php else : ?>
    <div id="bottom-block-bg" class="border-1px bottom-shadow" style="border-left: 0;border-right: 0;margin-bottom: 150px; margin-top: 50px;">
    	<div id="bottom-block-bg-boxed" class="container totop-container">
    <?php endif; ?>

    		<div class="row-fluid">
	  		
	  			<!-- START FOOTER WIDGETS -->
				<?php
		    		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer") ) : ?>
				<?php endif; ?>
				<!-- END FOOTER WIDGETS -->
  	    
  	    	</div> <!-- .row-fluid -->

      <?php if ( has_nav_menu('bottom_menu') ) : ?>
			<div class="container" style="position: absolute; bottom: -30px; text-align: center;">
    			<div class="bottom-menu border-1px bottom-shadow">
					<?php wp_nav_menu( array('theme_location' => 'bottom_menu', 'menu_class' => 'sf-menu add-nav')); ?>
	  			</div> <!-- .bottom-menu -->
			</div> <!-- .container -->  	    
      <?php endif; ?>

		</div><!-- #top-block-bg-boxed .container -->
	</div><!-- #bottom-block-bg -->

</footer>

<div class="html-mobile-background"></div><!-- .html-mobile-background -->

<?php wp_footer(); ?>


<?php 
$img_preload = stripslashes( $data['ct_img_preload'] );
$sticky_menu = stripslashes( $data['ct_sticky_menu'] );
$type_menu = stripslashes( $data['ct_type_menu'] ); 


if ( ( $sticky_menu == 'Yes') and ($type_menu != 'Flat') ) { ?>
<!-- STICKY MAIN MENU -->
<script>
jQuery.noConflict()(function($){
  $(document).ready(function(){
  
  // grab the initial top offset of the navigation 
  var sticky_navigation_offset_top = $('#mainmenu-block-bg').offset().top+60;
  
  // our function that decides weather the navigation bar should have "fixed" css position or not.
  var sticky_navigation = function(){
    var scroll_top = $(window).scrollTop(); // our current vertical position from the top
    
    // if we've scrolled more than the navigation, change its position to fixed to stick to top, otherwise change it back to relative
    if (scroll_top > sticky_navigation_offset_top) {
      <?php if ( !is_admin_bar_showing() ) : ?>
        $('#mainmenu-block-bg').css({ 'background': 'rgba(47, 47, 47, 0.9)',  'position': 'fixed', 'top':0, 'left':0 });
      <?php else : ?>
        $('#mainmenu-block-bg').css({ 'background': 'rgba(47, 47, 47, 0.9)',  'position': 'fixed', 'top':28, 'left':0 });
      <?php endif; ?>
    } else {
      $('#mainmenu-block-bg').css({ 'top':0, 'position': 'relative', 'background': '#FFF' }); 
    }   
  };
  
  // run our function on load
  sticky_navigation();
  
  // and run it again every time you scroll
  $(window).scroll(function() {
     sticky_navigation();
  });
  });
});
</script>
<!-- END STICKY MAIN MENU -->
<?php } ?>


<?php if ( $img_preload == 'Yes') { ?>
<!-- For Images Preloading -->
	<script type="text/javascript">var runFancy = true;</script>

    <!--[if IE]>
    <script type="text/javascript">
      runFancy = false;
    </script>
    <![endif]-->
    
    <script type="text/javascript">
    /* <![CDATA[ */
      if (runFancy) {
        jQuery.noConflict()(function($){
          $(".ct-preload").preloader();
          });
        };
    /* ]]> */
	</script>
<!-- END For Images Preloading -->
<?php } ?>

<?php echo stripslashes ( $data['ct_google_analytics'] ); ?>

</body>

</html>


