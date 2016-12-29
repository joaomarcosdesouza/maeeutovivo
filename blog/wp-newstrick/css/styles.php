<?php
	if ( isset( $data['ct_theme_border_color'] ) ) $theme_border_color = stripslashes ( $data['ct_theme_border_color'] );
	if ( isset( $data['ct_header_background'] ) ) $header_background = stripslashes ( $data['ct_header_background'] );
	if ( isset( $data['ct_widget_title_color'] ) ) $widget_title_color = stripslashes ( $data['ct_widget_title_color'] );	
	//if ( isset( $data['ct_menu_background'] ) ) $menu_background = stripslashes ( $data['ct_menu_background'] );
	if ( isset( $data['ct_links_color'] ) ) $links_color = stripslashes ( $data['ct_links_color'] );
	if ( isset( $data['ct_bg_attachment'] ) ) $bg_attachment = stripslashes ( $data['ct_bg_attachment'] );
	if ( isset( $data['ct_thumb_posts_stretch'] ) ) $thumb_posts_stretch = stripslashes ( $data['ct_thumb_posts_stretch'] );
	if ( isset( $data['ct_custom_css'] ) ) $custom_css = stripslashes ( $data['ct_custom_css'] );
	if ( isset( $data['ct_google_fontfamily'] ) ) $font_family = stripslashes ( $data['ct_google_fontfamily'] );
	if ( isset( $data['ct_google_stylesheet'] ) ) $google_stylesheet = stripslashes ( $data['ct_google_stylesheet'] );
	if ( isset( $data['ct_img_preload'] ) ) $img_preload = stripslashes ( $data['ct_img_preload'] );
	
	if ( isset( $data['ct_bg_upload'] ) ) $bg_upload = stripslashes( $data['ct_bg_upload'] );
	if ( isset( $data['ct_type_menu'] ) ) $type_menu = stripslashes( $data['ct_type_menu'] );
	if ( isset( $data['ct_ddmenu_bg_color'] ) ) $ddmenu_bg_color = stripslashes( $data['ct_ddmenu_bg_color'] );
?>

.widget-title { background:<?php echo $widget_title_color; ?>; }
.widget-title .arrow-down { border-top-color: <?php echo $widget_title_color; ?>; }

/* Drop-Down menu bg color */
.ct-dropdown-menu { background:<?php echo $ddmenu_bg_color; ?>; }

<?php if ($type_menu == 'Drop-Down') { ?>
#top-block-bg { margin-bottom: 40px; }
<?php } ?>

#top-block-bg, #bottom-block-bg, top-block-bg-boxed { background:<?php echo $header_background; ?>;}
/* #mainmenu-block-bg, #bottommenu-block-bg { } */

/* Border Color */
.border-1px, .widget-slider .flex-direction-nav { border: 1px solid <?php echo $theme_border_color; ?>; }

a { color: <?php echo $links_color; ?>; }
	textarea:focus, input[type="text"]:focus, input[type="password"]:focus, input[type="datetime"]:focus, input[type="datetime-local"]:focus, input[type="date"]:focus, input[type="month"]:focus, input[type="time"]:focus, input[type="week"]:focus, input[type="number"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="search"]:focus, input[type="tel"]:focus, input[type="color"]:focus, .uneditable-input:focus {
	border-color: <?php echo $links_color; ?>;
}


/* Links Color */
.widget .category-title a:hover,
#pbd-alp-load-posts a:hover, #pbd-alp-load-posts a:active,
.widget li.cat-item a:hover, .left-col a:hover, .right-col a:hover,
#social-counter li:hover .social,
.copyright a:hover, .add-info a:hover,
.meta-comments a:hover, .meta-category a:hover,
#comments a.muted-small:hover,
.two-column-widget .post-title a:hover,
ul.popular-post-widget .comments a:hover,
.pagination a:hover,
.sf-menu-flat .sub-menu a:hover,
.sf-menu-flat a:hover,
.sf-menu.add-nav li a:hover,
.sf-menu li:hover, .sf-menu li.sfHover, .sf-menu a:focus, .sf-menu a:hover, .sf-menu a:active, .sf-menu .active a,
[id^="v-newsticker-"] .entry-tags a:hover, [id^="v-newsticker-"] .entry-category a:hover,
h2.entry-title a:hover, h4.entry-title a:hover, h5.entry-title a:hover,
.news-title h4 a:hover, .colored,
.meta-posted-by a:hover, .comment-text a:hover,
.popular-posts-widget .post-title a:hover,
.tweet_list .tweet_time a:hover,
.recent-posts-widget .post-title a:hover,
.one-column-widget .post-title a:hover,
.two-column-widget  .post-title a:hover,
.popular-posts-widget .post-title a:hover { color: <?php echo $links_color; ?>; }

.tagcloud a[class|=tag-link]:hover { background-color:<?php echo $links_color; ?>; }
.pagination a:hover, .pagination .current { background: <?php echo $links_color; ?>; }


/* Stretch images */
<?php 
if ( $thumb_posts_stretch == 'No' ) { ?>
.widget .entry-thumb img, .widget .single-media-thumb img, #entry-blog .entry-thumb img, #entry-blog .single-media-thumb img { width:auto;}

<?php } else { ?>
.widget-post-big-thumb img, .widget .entry-thumb img, .widget .single-media-thumb img, #entry-blog .entry-thumb img, #entry-blog .single-media-thumb img { width:100%;}
<?php } ?>

::selection { 	background-color: <?php echo $links_color; ?> !important; color: #fff	 }
::-moz-selection { 	background-color: <?php echo $links_color; ?> !important;	 }

/* Google Fonts for headings */
<?php if ( ( $font_family != '' ) &&  ( $google_stylesheet != '' ) ) { ?>
h1, h2, h3, h4, h5, h6,	#menu, .bottom-menu .add-nav li a, #pbd-alp-load-posts a, .category-item, .title-block .category-item  { <?php echo $font_family ?> };
<?php } ?>

/* For image preloader */
<?php if ( $img_preload == 'Yes' ) { ?>
.ct-preload { position: relative; text-align: center; cursor: default; background: url('../img/preloader-fading.gif') center center no-repeat #fff !important; }
.ct-preload img { -webkit-transition: all 0.2s linear; -moz-transition: all 0.2s linear; -o-transition: all 0.2s linear; -ms-transition: all 0.2s linear; transition: all 0.2s linear; }
<?php } else { ?>
.cat-one-columnn .meta-time { visibility:visible; }
<?php } ?>