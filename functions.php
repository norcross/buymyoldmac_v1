<?php
/*
Child Theme Name: Bones for Genesis
Author: Eddie Machado
URL: htp://themble.com/genesis/bones/

Change the above info to reflect the
name, author, and url of your child
theme.
*/

/************* BEGIN GENESIS (DO NOT DELETE) *************/
require_once( get_template_directory() . '/lib/init.php' );

/************* REGISTER CHILD THEME (DO NOT DELETE) ******/
define( 'CHILD_THEME_NAME', 'Buy My Old Mac' );
define( 'CHILD_THEME_URL', 'http://buymyoldmac.com' );

/************* ADDING FEATURE SUPPORT ********************/


/************* ADMIN & DASHBOARD CUSTOMIZATION **********/

require_once('lib/rkv-admin.php');		// admin customization
require_once('lib/rkv-types.php');		// custom post type and taxonomy
require_once('lib/rkv-widgets.php');	// custom widgets
require_once('lib/rkv-meta.php');		// metabox class and calls
require_once('lib/rkv-builds.php');		// called functions
require_once('lib/rkv-cleanup.php');	// cleanup

/* custom scripts */

function bfg_scripts() { 
	wp_enqueue_script('bfg_custom_scripts', CHILD_URL.'/lib/js/bmm.init.js', array('jquery'), null, TRUE);
}

// adding it to the header
add_action('wp_enqueue_scripts', 'bfg_scripts');


/************* CUSTOM POST TYPE EXAMPLE *****************/

/************* CHILD THEME IMAGE SIZES ******************/
add_image_size( 'bfg_large_img', 620, 240, TRUE );
add_image_size( 'bfg_medium_img', 225, 225, TRUE );
add_image_size( 'bfg_tiny_img', 45, 45, TRUE );


/************* CHILD THEME FUNCTIONS ********************/


// Customizes Footer text
function bfg_footer_cred($bfg_ft) {
    $bfg_ft = '&copy; ' . date("Y") . ' ' . get_bloginfo("name") .' &middot; Built by <a href="http://andrewnorcross.com/" target="_blank">Andrew Norcross</a> using the <a href="http://andrewnorcross.com/go/genesis/" target="_blank" rel="nofollow">Genesis Framework</a>.';
    return $bfg_ft;
}

// apply it to genesis
add_filter('genesis_footer_creds_text', 'bfg_footer_cred');


/************* FORM FUNCTIONS ********************/

// image resize function: http://chopapp.com/#n9bqd41c

function rkv_listing_title_fix ($form){

    $price		= $_POST['input_11'];
    // taxonomy is field 2
    $tax_term	= $_POST['input_28'];
	$tax_disp	= str_replace('-', ' ', $tax_term);
	$tax_name	= ucwords($tax_disp);

	// build custom title
	$cs_title	= $tax_name .' - '. $price;

	// add data to admin-only fields
	$_POST['input_23'] = $cs_title;
}


function rkv_close_comments($post_data){
    $post_data['comment_status'] = 'closed';
    return $post_data;
}

function rkv_set_taxonomy($entry, $form){

    //getting post
    $post = get_post($entry['post_id']);

	if($post->post_type != 'listings')
        return false;

	// taxonomies
    $mac_term	= $_POST['input_28'];
    $accessor	= $_POST['input_20'];
	
    //changing post content
	wp_set_post_terms( $post->ID, $mac_term, 'listing-type', false );
	wp_set_post_terms( $post->ID, $accessor, 'listing-accessory', true );	
}

function rkv_upload_path($path_info, $form_id){
     $path_info['path'] = '/home/bandvine/public_html/buymyoldmac.com/listing_img/';
     $path_info['url']	= 'http://buymyoldmac.com/listing_img/';
     return $path_info;
}

add_action('gform_pre_submission', 'rkv_listing_title_fix', 10, 2);
add_action('gform_post_data', 'rkv_close_comments');
add_action('gform_post_submission', 'rkv_set_taxonomy', 10, 2);
add_filter('gform_upload_path', 'rkv_upload_path', 20, 2);