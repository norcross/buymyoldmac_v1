<?php
/* 
This file handles the admin area and functions.
You can use this file to make changes to the
dashboard. Updates to this page are coming soon.
It's turned off by default, but you can call it
via the functions file.

Developed by: Eddie Machado
URL: http://themble.com/bones/

Special Thanks for code & inspiration to:
@jackmcconnell - http://www.voltronik.co.uk/
Digging into WP - http://digwp.com/2010/10/customize-wordpress-dashboard/

*/

/************* DASHBOARD WIDGETS *****************/

// disable default dashboard widgets
function disable_default_dashboard_widgets() {
	// remove_meta_box('dashboard_right_now', 'dashboard', 'core');    // Right Now Widget
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  // Incoming Links Widget
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');         // Plugins Widget

	// remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  // Quick Press Widget
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');   // Recent Drafts Widget
	remove_meta_box('dashboard_primary', 'dashboard', 'core');         // 
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');       //
	
	// removing plugin dashboard boxes 
	remove_meta_box('yoast_db_widget', 'dashboard', 'normal');         // Yoast's SEO Plugin Widget
}

// removing the dashboard widgets
add_action('admin_menu', 'disable_default_dashboard_widgets');



/************* CUSTOM LOGIN PAGE *****************/

// calling your own login css so you can style it 
function bones_login_css() {
	/* i couldn't get wp_enqueue_style to work :( */
	echo '<link rel="stylesheet" href="'. CHILD_URL . '/lib/css/login.css">';
}

// changing the logo link from wordpress.org to your site 
function bones_login_url() { echo bloginfo('url'); }

// changing the alt text on the logo to show your site name 
function bones_login_title() { echo get_option('blogname'); }

// calling it only on the login page
add_action('login_head', 'bones_login_css');
add_filter('login_headerurl', 'bones_login_url');
add_filter('login_headertitle', 'bones_login_title');


function rkv_custom_menu_order($menu_ord) {
	if (!$menu_ord) return true;
		return array(
        'index.php', // this represents the dashboard link
		'edit.php?post_type=listings', // custom post type
		'edit.php', // this is the default POST admin menu 
		'edit.php?post_type=page', // custom post type
		'upload.php',
	);
}
add_filter('custom_menu_order', 'rkv_custom_menu_order');
add_filter('menu_order', 'rkv_custom_menu_order');

// Custom Backend Footer
function bones_custom_admin_footer() {
	echo '<span id="footer-thankyou">Developed by <a href="http://yoursite.com" target="_blank">Your Site Name</a></span>. Built using <a href="http://themble.com/genesis/bones" target="_blank">Bones for the Genesis Framework</a>.';
}

// adding it to the admin area
add_filter('admin_footer_text', 'bones_custom_admin_footer');

// change favicon
function rkv_favicon( $favicon) {
    //replace this with the path of your favicon file
    $favicon = CHILD_URL . '/lib/img/favicon.ico';
    return $favicon;
}
add_filter( 'genesis_pre_load_favicon', 'rkv_favicon' );

// remove taxonomy box
function rkv_listing_clean() {
	remove_meta_box( 'tagsdiv-listing-type' , 'listings' , 'side' ); 
}
add_action( 'admin_menu' , 'rkv_listing_clean' );