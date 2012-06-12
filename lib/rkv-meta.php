<?php
/**
 * Include and setup custom metaboxes and fields.
 */

add_filter( 'cmb_meta_boxes', 'rkv_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function rkv_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_rkv_';

	// meta boxes for home page
	$meta_boxes[] = array(
		'id'         => 'listing_details',
		'title'      => 'Listing Details',
		'pages'      => array( 'listings' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name'     => 'Model',
				'desc'     => 'select the Mac model',
				'id'       => $prefix . 'bmm_model',
				'type'     => 'taxonomy_select',
				'taxonomy' => 'listing-type', // Taxonomy Slug
			),
			array(
				'name' => 'Screen Size',
				'desc' => '',
				'id'   => $prefix . 'bmm_ssize',
				'type' => 'text_small',
			),
			array(
				'name'    => 'Display Type',
				'desc'    => '',
				'id'      => $prefix . 'bmm_display',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Standard', 	'value' => 'standard', ),
					array( 'name' => 'Retina',		'value' => 'retina', ),
					array( 'name' => 'Other',		'value' => 'other', ),
					array( 'name' => 'No Screen',	'value' => 'noscreen', ),
				),
			),
			array(
				'name'    => 'Condition',
				'desc'    => '',
				'id'      => $prefix . 'bmm_cond',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Like New', 	'value' => 'like-new', ),
					array( 'name' => 'Good',		'value' => 'good', ),
					array( 'name' => 'Fair',		'value' => 'fair', ),
				),
			),			
			array(
				'name' => 'First Name',
				'desc' => '',
				'id'   => $prefix . 'bmm_fname',
				'type' => 'text',
			),
			array(
				'name' => 'Last Name',
				'desc' => '',
				'id'   => $prefix . 'bmm_lname',
				'type' => 'text',
			),

			array(
				'name' => 'Seller Email',
				'desc' => '',
				'id'   => $prefix . 'bmm_email',
				'type' => 'text',
			),
			array(
				'name' => 'Seller Phone',
				'desc' => '',
				'id'   => $prefix . 'bmm_phone',
				'type' => 'text',
			),
			array(
				'name' => 'Price',
				'desc' => '',
				'id'   => $prefix . 'bmm_price',
				'type' => 'text_medium',
			),
			array(
				'name'    => 'Seller Terms',
				'desc'    => '',
				'id'      => $prefix . 'bmm_pterms',
				'type'    => 'multicheck',
				'options' => array(
					'paypal'	=> 'PayPal',
					'amazon'	=> 'Amazon Payments',
					'stripe'	=> 'Stripe',
					'bank'		=> 'Bank Transfer',
					'check'		=> 'Check',

				),
			),	
/*								
			array(
				'name' => 'Image One',
				'desc' => 'Upload an image or enter an URL.',
				'id'   => $prefix . 'bmm_image_1',
				'type' => 'file',
			),
			array(
				'name' => 'Image Two',
				'desc' => 'Upload an image or enter an URL.',
				'id'   => $prefix . 'bmm_image_2',
				'type' => 'file',
			),
			array(
				'name' => 'Image Three',
				'desc' => 'Upload an image or enter an URL.',
				'id'   => $prefix . 'bmm_image_3',
				'type' => 'file',
			),
			array(
				'name' => 'Image Four',
				'desc' => 'Upload an image or enter an URL.',
				'id'   => $prefix . 'bmm_image_4',
				'type' => 'file',
			),
*/
			array(
				'name' => 'Custom Title',
				'desc' => 'Used for SEO title tag',
				'id'   => $prefix . 'bmm_titlefix',
				'type' => 'text',
			),

		)
	);
	$meta_boxes[] = array(
		'id'         => 'listing_status',
		'title'      => 'Listing Status',
		'pages'      => array( 'listings' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => false, // Show field names on the left
		'fields' => array(
			array(
				'name'    => 'Listing Status',
				'desc'    => '',
				'id'      => $prefix . 'bmm_status',
				'type'    => 'radio',
				'std'	  => 'active',	
				'options' => array(
					array( 'name' => 'Active',	'value' => 'active', ),
					array( 'name' => 'Sold',	'value' => 'sold', ),
				),
			),
		)
	);

	// display boxes
	return $meta_boxes;
}

add_action( 'init', 'rkv_initialize_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function rkv_initialize_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'metabox/init.php';

}


// pre-populating form
function rkv_form_title($value){
		$title_id = time();
	return $title_id;
	}

add_filter('gform_field_value_listing_title', 'rkv_form_title');	