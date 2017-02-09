<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		
		$shortname = "ct";
		
		//Access the WordPress Categories via an Array
		$of_categories = array();  
		
		$of_categories_obj = get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;
		    }

		$categories_tmp = array_unshift($of_categories, "all categories");    


		
	       
		//Access the WordPress Pages via an Array
		$of_pages = array();
		$of_pages_obj = get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
		    $of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp = array_unshift($of_pages, "Select a page:");       
	
		//Testing 
		$of_options_select = array("one","two","three","four","five"); 
		$of_options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
		
		//Sample Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		( 
			"disabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_one"		=> "Block One",
				"block_two"		=> "Block Two",
				"block_three"	=> "Block Three",
			), 
			"enabled" => array (
				"placebo" => "placebo", //REQUIRED!
				"block_four"	=> "Block Four",
			),
		);



		//Background Images Reader
		$bg_images_path = get_template_directory() . '/img/bg/'; // change this to where you store your bg images
		$favico_urls = get_template_directory_uri().'/img';
		$default_bg = get_template_directory_uri().'/img/';		
		$bg_images_url = get_template_directory_uri().'/img/bg/'; // change this to where you store your bg images
		$bg_images = array();
		
		if ( is_dir($bg_images_path) ) {
		    if ($bg_images_dir = opendir($bg_images_path) ) { 
		        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
		            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
		                $bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }    
		    }
		}
		

		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr = wp_upload_dir();
		$all_uploads_path = $uploads_arr['path'];
		$all_uploads = get_option('of_uploads');
//		$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
//		$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
		
		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 



/*
======================================================================================= 
*/

// Type of Logo ( image or text )
$ct_logotype = array ( "image" , "text" );

$comments_type = array(
    "facebook" => "Facebook",
    "disqus" => "Disqus",
);

$show_meta = array(
    "likes" => "Likes",
    "comments" => "Comments",
    "views" => "Views",
	"date" => "Date",
    "category" => "Category"
);

$post_content_excerpt = array( "Content" , "Excerpt" );
$ct_top_block_style = array( "Boxed" , "Full width" );
$post_video_thumb = array( "auto" , "featured", "player" );
$pagination_type = array( "Show more button" , "Standard pagination" );
$divider_type = array( "striped" ,"1px" );
$ct_type_menu = array( "Flat" ,"Drop-Down" );

$ct_show_hide = array( "Show" , "Hide" );
$ct_yes_no = array( "Yes" , "No" );

$theme_bg_type = array ( "Uploaded", "Predefined" , "Color" );
$theme_bg_attachment = array ( "Scroll" , "Fixed" );
$theme_bg_repeat = array ( "No-Repeat" , "Repeat", "Repeat-X" , "Repeat-Y" );
$theme_bg_position = array ( "Left" , "Right", "Centered" , "Full Screen" );
$show_top_banner = array ( "Upload" , "Code", "None" );


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

$prefix = 'ct_';

// Set the Options Array
global $of_options;
$of_options = array();


/*
=====================================================================================================================
					GENERAL SETTINGS
=====================================================================================================================	
*/

$of_options[] = array( "name" => __( "General Settings" , "color-theme-framework" ),
					"type" => "heading");

$url =  ADMIN_DIR . 'assets/images/';
$of_options[] = array( "name" => "Select a layout",
					"desc" => "Select main content and sidebar alignment.",
					"id" =>  $shortname . "_main_layout",
					"std" => "wide_c_r",
					"type" => "images",
					"options" => array(
						'wide_c_lr' => $url . '1col-lr.png', // wide content (w/left & right sidebar)						
						'wide_c_r' => $url . '1col-right.png', // wide content (w/right sidebar)
						'wide_c_l' => $url . '1col-left.png', // wide content (w/left sidebar)
						'l_c_r' => $url . '3cm.png', // left + content + right
						'c_l_r' => $url . '3cr.png', // content + left + right
						'l_r_c' => $url . '3lc.png', // left + right + content
						'c_r' => $url . '2cr.png',  // content + right
						'l_c' => $url . '2cl.png'  // left + content
						)
					);

$of_options[] = array( "name" => __( "Sticky main menu (applies only for drop-down menu type)" , "color-theme-framework" ),
					"desc" => __( "Stick main menu to the top" , "color-theme-framework" ),
					"id" => $shortname . "_sticky_menu",
					"std" => "No",
					"type" => "select",
					"options" => $ct_yes_no);

$of_options[] = array( "name" => __( "Menu Type" , "color-theme-framework" ),
					"desc" => __( "Select style for main menu" , "color-theme-framework" ),
					"id" => $shortname . "_type_menu",
					"std" => "Flat",
					"type" => "select",
					"options" => $ct_type_menu);

$of_options[] = array( "name" => __( "Top/Bottom blocks style" , "color-theme-framework" ),
					"desc" => __( "Select style for top block" , "color-theme-framework" ),
					"id" => $shortname . "_top_block_style",
					"std" => "Boxed",
					"type" => "select",
					"options" => $ct_top_block_style);

$of_options[] = array( "name" => __( "Use Image Preloader" , "color-theme-framework" ),
					"desc" => __( "Awesome Image Preloader feature" , "color-theme-framework" ),
					"id" => $shortname . "_img_preload",
					"std" => "No",
					"type" => "select",
					"options" => $ct_yes_no);

$of_options[] = array( "name" => __( "Number of Home page widgetized areas (rows)" , "color-theme-framework" ),
					"desc" => __( "Enter the number of areas.<br/>Appears on Appearance &rarr; Widgets" , "color-theme-framework" ),
					"id" => $shortname . "_num_widget_areas",
					"std" => "5",
					"type" => "text");

$of_options[] = array( "name" => __("Type of Logo","color-theme-framework"),
					   "desc" => __("Select your logo type ( Image or Text )" , "color-theme-framework"),
					   "id" => $shortname . "_type_logo",
					   "std" => "image",
					   "type" => "select",
					   "options" => $ct_logotype); 

									
$of_options[] = array( "name" => __( "Custom Logo" , "color-theme-framework" ),
					"desc" => __( "Upload a logo for your theme, or specify the image address of your online logo. (http://example.com/logo.png)" , "color-theme-framework" ),
					"id" => $shortname . "_logo_upload",
					"std" => get_template_directory_uri() . "/img/logo.png",
					"type" => "upload");

$of_options[] = array( "name" => __( "Logo Text" , "color-theme-framework" ),
					"desc" => __( "Enter text for logo" , "color-theme-framework" ),
					"id" => $shortname . "_logo_text",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => __( "Logo Slogan" , "color-theme-framework" ),
					"desc" => __( "Enter text for logo slogan" , "color-theme-framework" ),
					"id" => $shortname . "_logo_slogan",
					"std" => "",
					"type" => "text");

/*$of_options[] = array( "name" => __( "Custom Favicon" , "color-theme-framework" ),
					"desc" => __( "Upload a 16px x 16px Png/Gif image that will represent your website's favicon." , "color-theme-framework" ),
					"id" => $shortname . "_custom_favicon",
					"std" => $favico_urls . "/favicon.ico",
					"type" => "upload"); */

$of_options[] = array( "name" => __( "Tracking Code" , "color-theme-framework" ),
					"desc" => __( "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme." , "color-theme-framework" ),
					"id" => $shortname . "_google_analytics",
					"std" => "",
					"type" => "textarea");        

/*
=====================================================================================================================
					STYLING SETTINGS
=====================================================================================================================	
*/
					
$of_options[] = array( "name" => "Styling Settings",
					"type" => "heading");

$of_options[] = array( "name" =>  __( "Body Background Color" , "color-theme-framework" ),
					"desc" => __( "Pick a background color (default: #f7ede4)." , "color-theme-framework" ), 
					"id" => $shortname . "_body_background",
					"std" => "#FFFFFF",
					"type" => "color");

$of_options[] = array( "name" =>  __( "Links color" , "color-theme-framework"),
					"desc" => __("Pick a color for the links (default: #E64946)" , "color-theme-framework"),
					"id" => $shortname . "_links_color",
					"std" => "#08C",
					"type" => "color");

$of_options[] = array( "name" =>  __( "Header background color" , "color-theme-framework" ),
					"desc" => __( "Pick a background color (default: #FFF)." , "color-theme-framework" ), 
					"id" => $shortname . "_header_background",
					"std" => "#FFF",
					"type" => "color");

$of_options[] = array( "name" =>  __( "Background color for main menu (applies only for drop-down menu)" , "color-theme-framework"),
					"desc" => __("Pick a background color (default: #FFF)" , "color-theme-framework"),
					"id" => $shortname . "_ddmenu_bg_color",
					"std" => "#FFF",
					"type" => "color");

$of_options[] = array( "name" =>  __( "Theme border color" , "color-theme-framework" ),
					"desc" => __( "Pick a border color, for widgets, etc. (default: #A5A5A5)." , "color-theme-framework" ), 
					"id" => $shortname . "_theme_border_color",
					"std" => "#A5A5A5",
					"type" => "color");

$of_options[] = array( "name" =>  __( "Background color for title of standard or third-party widgets" , "color-theme-framework" ),
					"desc" => __( "Pick a background color, for widgets (default: #FF0000)." , "color-theme-framework" ), 
					"id" => $shortname . "_widget_title_color",
					"std" => "#FF0000",
					"type" => "color");

$of_options[] = array( "name" => "Default Background Settings",
					"desc" => "",
					"id" => "introduction",
					"std" => "<h3 style=\"margin: 0 0 10px;\">Default Background Settings.</h3>
					The following settings allow you to set the default background behavior for each page. Each of these options can be overridden on the individual post/page/ level. You are in complete control.",
					"icon" => true,
					"type" => "info");

$of_options[] = array( "name" => __( "Use Predefined Background Image / BG Color / Upload Your Image" , "color-theme-framework" ),
					"desc" => __( "Select the type of usage background" , "color-theme-framework" ),
					"id" => $shortname . "_default_bg_type",
					"std" => 'Uploaded',
					"type" => "select",
					"options" => $theme_bg_type);

$of_options[] = array( "name" => __( "Background Attachment" , "color-theme-framework" ),
					"desc" => __( "Select the background image property" , "color-theme-framework" ),
					"id" => $shortname . "_default_bg_attachment",
					"std" => 'Fixed',
					"type" => "select",
					"options" => $theme_bg_attachment);

$of_options[] = array( "name" => __( "Background Repeat" , "color-theme-framework" ),
					"desc" => __( "Select the default background repeat for the background image" , "color-theme-framework" ),
					"id" => $shortname . "_default_bg_repeat",
					"std" => 'Repeat',
					"type" => "select",
					"options" => $theme_bg_repeat);

$of_options[] = array( "name" => __( "Background Position" , "color-theme-framework" ),
					"desc" => __( "Select the default background position for the background image" , "color-theme-framework" ),
					"id" => $shortname . "_default_bg_position",
					"std" => 'Full Screen',
					"type" => "select",
					"options" => $theme_bg_position);

$of_options[] = array( "name" => __( "Uploaded Background Image" , "color-theme-framework" ),
					"desc" => __( "Upload image for background using the native media uploader, or define the URL directly" , "color-theme-framework" ),
					"id" => $shortname . "_default_bg_image",
					"std" => $default_bg . "default-bg.jpg",
					"type" => "upload");

$of_options[] = array( "name" => __( "Predefined Background Images" , "color-theme-framework" ),
					"desc" => __( "Select a background pattern." , "color-theme-framework" ),
					"id" => $shortname . "_default_predefined_bg",
					"std" => $bg_images_url."bg01.jpg",
					"type" => "tiles",
					"options" => $bg_images,
					);		

$of_options[] = array( "name" => __( "Custom CSS" , "color-theme-framework" ),
					"desc" => __( "Quickly add some CSS to your theme by adding it to this block." , "color-theme-framework" ),
					"id" => $shortname . "_custom_css",
					"std" => "",
					"type" => "textarea");

$of_options[] = array( "name" => __( "Use Google Fonts For Headings" , "color-theme-framework" ),
					"desc" => __( "Enable/Disable Google fonts" , "color-theme-framework" ),
					"id" => $shortname . "_google_enable",
					"std" => 'No',
					"type" => "select",
					"options" => $ct_yes_no);

$of_options[] = array( "name" => __( "Google Fonts Link Stylesheet" , "color-theme-framework" ),
					"desc" => __( "Paste code for stylesheet from Google Fonts" , "color-theme-framework" ),
					"id" => $shortname . "_google_stylesheet",
					"std" => "",
					"type" => "textarea");

$of_options[] = array( "name" => __( "Google Fonts Family" , "color-theme-framework" ),
					"desc" => __( "Paste code for Fonts from Google" , "color-theme-framework" ),
					"id" => $shortname . "_google_fontfamily",
					"std" => "",
					"type" => "text");

/*
=====================================================================================================================
					Blog Settings
=====================================================================================================================	
*/


$of_options[] = array( "name" => __( "Blog Settings" , "color-theme-framework" ),
					"type" => "heading");

$of_options[] = array( "name" => __( "Select a layout for Single post template" , "color-theme-framework" ),
					"desc" => "Select single post content and sidebars alignment.",
					"id" =>  $shortname . "_single_layout",
					"std" => "l_c_r",
					"type" => "images",
					"options" => array(
						'l_c_r' => $url . '3cm.png', // left + content + right
						'c_l_r' => $url . '3cr.png', // content + left + right
						'l_r_c' => $url . '3lc.png', // left + right + content
						'c_r' => $url . '2cr.png',  // content + right
						'l_c' => $url . '2cl.png'  // left + content
						)
					);
					
$of_options[] = array( "name" => __( "Select a layout for Blog template" , "color-theme-framework" ),
					"desc" => "Select blog content and sidebars alignment.",
					"id" =>  $shortname . "_blog_layout",
					"std" => "l_c_r",
					"type" => "images",
					"options" => array(
						'l_c_r' => $url . '3cm.png', // left + content + right
						'c_l_r' => $url . '3cr.png', // content + left + right
						'l_r_c' => $url . '3lc.png', // left + right + content
						'c_r' => $url . '2cr.png',  // content + right
						'l_c' => $url . '2cl.png'  // left + content
						)
					);					

$of_options[] = array( "name" => __( "Select a layout for Category template" , "color-theme-framework" ),
					"desc" => __( "Select category content and sidebars alignment." , "color-theme-framework" ),
					"id" =>  $shortname . "_category_layout",
					"std" => "l_c_r",
					"type" => "images",
					"options" => array(
						'l_c_r' => $url . '3cm.png', // left + content + right
						'c_l_r' => $url . '3cr.png', // content + left + right
						'l_r_c' => $url . '3lc.png', // left + right + content
						'c_r' => $url . '2cr.png',  // content + right
						'l_c' => $url . '2cl.png'  // left + content
						)
					);

/*$of_options[] = array( "name" =>  __( "Category (tag, archive, etc) pages show at most" , "color-theme-framework"),
					"desc" => __("Specify how many posts to show" , "color-theme-framework"),
					"id" => $shortname . "_cat_posts_show",
					"std" => "3",
					"type" => "text");*/

$of_options[] = array( 
    				"name" => __( "Meta info" , "color-theme-framework" ),
   					"desc" => __( "Display on the category, tag, archives, search pages." , "color-theme-framework" ),
    				"id" => $shortname . "_show_meta",
    				"std" => array("likes","comments","views", "date", "category"),
    				"type" => "multicheck",
    				"options" => $show_meta);


$of_options[] = array( "name" => __( "Number of posts to display for a Blog widget:" , "color-theme-framework" ),
					//"desc" => __( "Paste code for bookmarking and sharing services" , "color-theme-framework" ),
					"id" => $shortname . "_blog_num_posts",
					"std" => "3",
					"type" => "text");

$of_options[] = array( "name" => __( "Type of pagination" , "color-theme-framework" ),
					"desc" => __( "Select a pagination type for category, tags, etc." , "color-theme-framework" ),
					"id" => $shortname . "_pagination_type",
					"std" => "featured",
					"type" => "select",
					"options" => $pagination_type
					);

$of_options[] = array( "name" => __( "Type of divider (below the post meta)" , "color-theme-framework" ),
					"desc" => __( "Select a divider type for category, tags, etc." , "color-theme-framework" ),
					"id" => $shortname . "_divider_type",
					"std" => "featured",
					"type" => "select",
					"options" => $divider_type
					);

$of_options[] = array( "name" => __( "Thumb type for video posts" , "color-theme-framework" ),
					"desc" => __( "Select a thumb type for video posts" , "color-theme-framework" ),
					"id" => $shortname . "_video_thumb_type",
					"std" => "featured",
					"type" => "select",
					"options" => $post_video_thumb
					);

$of_options[] = array( "name" => __( "Use Excerpt or Content Function?" , "color-theme-framework" ),
					"desc" => __( "Select a Excerpt (automatically) or Content (More tag)" , "color-theme-framework" ),
					"id" => $shortname . "_excerpt_function",
					"std" => "Excerpt",
					"type" => "select",
					"options" => $post_content_excerpt
					);

$of_options[] = array( "name" => __( "Length of post excerpt (chars)" , "color-theme-framework" ),
					"desc" => __( "Enter  the length of excerpt" , "color-theme-framework" ),
					"id" => $shortname . "_excerpt_length",
					"std" => "230",
					"type" => "text",
					);

$of_options[] = array( "name" => __( "About the author" , "color-theme-framework" ),
					"desc" => __( "Show or Hide info about the author in the single post" , "color-theme-framework" ),
					"id" => $shortname . "_about_author",
					"std" => 'Show',
					"type" => "select",
					"options" => $ct_show_hide);

$of_options[] = array( "name" => __( "Featured image" , "color-theme-framework" ),
					"desc" => __( "Show or Hide featured image in the single post" , "color-theme-framework" ),
					"id" => $shortname . "_featured_image_post",
					"std" => 'Show',
					"type" => "select",
					"options" => $ct_show_hide);

$of_options[] = array( "name" => __( "Stretch thumbnail post images" , "color-theme-framework" ),
					"desc" => __( "Stretch or Not thumbnail post images" , "color-theme-framework" ),
					"id" => $shortname . "_thumb_posts_stretch",
					"std" => 'Yes',
					"type" => "select",
					"options" => $ct_yes_no);

$of_options[] = array( "name" => __( "Add PrettyPhoto feature to all post images" , "color-theme-framework" ),
					"desc" => __( "Add PrettyPhoto feature to all post images with links" , "color-theme-framework" ),
					"id" => $shortname . "_add_prettyphoto",
					"std" => 'No',
					"type" => "select",
					"options" => $ct_yes_no);

$of_options[] = array( "name" => __( "Code for bookmarking and sharing services" , "color-theme-framework" ),
					"desc" => __( "Paste code for bookmarking and sharing services" , "color-theme-framework" ),
					"id" => $shortname . "_blog_sharing",
					"std" => "",
					"type" => "textarea");

$of_options[] = array( 
    				"name" => __( "Choose the comments type" , "color-theme-framework" ),
   					"desc" => "",
    				"id" => $shortname . "_comments_type",
    				"std" => array("facebook","disqus"),
    				"type" => "multicheck",
    				"options" => $comments_type);

$of_options[] = array( "name" =>  __( "Facebook App ID" , "color-theme-framework"),
					"desc" => __("Enter the Facebook App ID of your app (required if Facebook comments type selected)" , "color-theme-framework"),
					"id" => $shortname . "_facebook_appid",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" =>  __( "Disqus shortname " , "color-theme-framework"),
					"desc" => __("Enter the your website's shortname (required if Disqus comments type selected)" , "color-theme-framework"),
					"id" => $shortname . "_disqus_shortname",
					"std" => "",
					"type" => "text");


/*
=====================================================================================================================
					Ads &Banner Settings
=====================================================================================================================	
*/
$of_options[] = array( "name" => __( "Ads Banner Settings" , "color-theme-framework" ),
					"type" => "heading");

$of_options[] = array( "name" => __( "Show banner: " , "color-theme-framework" ),
					"desc" => __( "Show or hide banner" , "color-theme-framework" ),
					"id" => $shortname . "_top_banner",
					"std" => 'Upload',
					"type" => "select",
					"options" => $show_top_banner);

$of_options[] = array( "name" => __( "Site Header Banner Upload" , "color-theme-framework" ),
					"desc" => __( "Upload images using the native media uploader, or define the URL directly" , "color-theme-framework" ),
					"id" => $shortname . "_banner_upload",
					"std" => get_template_directory_uri() . "/img/tf_728x90_v5.gif",
					"type" => "upload");

$of_options[] = array( "name" => __( "Site Header Banner URL" , "color-theme-framework" ),
					"desc" => __( "Enter clickthrough url for banner in top section" , "color-theme-framework" ),
					"id" => $shortname . "_banner_link",
					"std" => "",
					"type" => "text");

$of_options[] = array( "name" => __( "Site Header Ads\Banner Code" , "color-theme-framework" ),
					"desc" => __( "Paste your Google Adsense (or other) code here." , "color-theme-framework" ),
					"id" => $shortname . "_banner_code",
					"std" => "",
					"type" => "textarea");

/*
=====================================================================================================================
					Twitter Settings
=====================================================================================================================	
*/

$of_options[] = array(	"name"		=> __( "Twitter Settings" , "color-theme-framework" ),
						"type"		=> "heading"
				);

$of_options[] = array( "name"		=> "OAuth Settings",
					"desc"			=> "",
					"id"			=> "introduction_oauth_settings",
					"std"			=> "<h3 style=\"margin: 0;\">OAuth Settings</h3> Visit <a target=\"_target\" href=\"https://dev.twitter.com/apps/\" title=\"Twitter\" rel=\"nofollow\">this link</a> in a new tab, sign in with your account, click on \"Create a new application\" and create your own keys in case you don't have already.",
					"icon"			=> true,
					"type"			=> "info"
				);

$of_options[] = array(	"name"		=> __( "Consumer Key:" , "color-theme-framework" ),
						"desc"		=> __( "Enter Your Twitter App Consumer Key" , "color-theme-framework" ),
						"id"		=> "{$prefix}consumer_key",
						"std"		=> "",
						"type"		=> "text"
				);

$of_options[] = array(	"name"		=> __( "Consumer Secret:" , "color-theme-framework" ),
						"desc"		=> __( "Enter Your Twitter App Consumer Key" , "color-theme-framework" ),
						"id"		=> "{$prefix}consumer_secret",
						"std"		=> "",
						"type"		=> "text"
				);

$of_options[] = array(	"name"		=> __( "Access Token:" , "color-theme-framework" ),
						"desc"		=> __( "Enter Your Twitter App Consumer Key" , "color-theme-framework" ),
						"id"		=> "{$prefix}user_token",
						"std"		=> "",
						"type"		=> "text"
				);

$of_options[] = array(	"name"		=> __( "Access Token Secret:" , "color-theme-framework" ),
						"desc"		=> __( "Enter Your Twitter App Consumer Key" , "color-theme-framework" ),
						"id"		=> "{$prefix}user_secret",
						"std"		=> "",
						"type"		=> "text"
				);
                    

					
// Backup Options
$of_options[] = array( "name" => __( "Backup Options" , "color-theme-framework" ),
					"type" => "heading");
					
$of_options[] = array( "name" => __( "Backup and Restore Options" , "color-theme-framework" ),
                    "id" => "of_backup",
                    "std" => "",
                    "type" => "backup",
					"desc" => 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
					);
					
$of_options[] = array( "name" => __( "Transfer Theme Options Data" , "color-theme-framework" ),
                    "id" => "of_transfer",
                    "std" => "",
                    "type" => "transfer",
					"desc" => 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".
						',
					);
					
	}
}
?>
