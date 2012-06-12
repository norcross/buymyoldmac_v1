<?php

// Register Custom Taxonomy and Post Type 

add_action( 'init', '_init_rkv_post_types' );
function _init_rkv_post_types() {
	register_post_type( 'listings',
		array(
			'labels' => array(
				'name'					=> __( 'Listings' ),
				'singular_name'			=> __( 'Listing' ),
				'add_new'				=> __( 'Add New' ),
				'add_new_item'			=> __( 'Add New Listing' ),
				'edit'					=> __( 'Edit' ),
				'edit_item'				=> __( 'Edit Listing' ),
				'new_item'				=> __( 'New Listing' ),
				'view'					=> __( 'View Listing' ),
				'view_item'				=> __( 'View Listing' ),
				'search_items'			=> __( 'Search Listings' ),
				'not_found'				=> __( 'No Listings found' ),
				'not_found_in_trash'	=> __( 'No Listings found in Trash' ),
			),
			'public' => true,
			'show_ui' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'menu_position' => 10,
			'capability_type' => 'post',
			'menu_icon' => get_stylesheet_directory_uri() . '/lib/img/menu_listings.png',
			'query_var' => true,
			'rewrite'	=> array( 'slug' => 'listings', 'with_front' => false ),
			'has_archive' => 'listings',
			'supports' => array('title', 'editor'),
		)
	);
	register_taxonomy(
		'listing-type',
		array( 'listings' ),
		array(
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'rewrite' => true,
			'hierarchical' => false,
			'query_var' => true,
			'labels' => array(
				'name' => __('Listing Type'),
				'singular_name' => __('Listing Type'),
				'search_items' => __('Search Listing Types'),
				'popular_items' => __('Popular Listing Types'),
				'all_items' => __('All Listing Types'),
				'parent_item' => __('Parent Type'),
				'parent_item_colon' => __('Parent Type:'),
				'edit_item' => __('Edit Type'),
				'update_item' => __('Update Type'),
				'add_new_item' => __('Add New Type'),
				'new_item_name' => __('New Type'),
			),
		)
	);
	register_taxonomy(
		'listing-accessory',
		array( 'listings' ),
		array(
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'rewrite' => true,
			'hierarchical' => false,
			'query_var' => true,
			'labels' => array(
				'name' => __('Accessories'),
				'singular_name' => __('Accessory'),
				'search_items' => __('Search Accessories'),
				'popular_items' => __('Popular Accessories'),
				'all_items' => __('All Accessories'),
				'parent_item' => __('Parent Accessory'),
				'parent_item_colon' => __('Parent Accessory:'),
				'edit_item' => __('Edit Accessory'),
				'update_item' => __('Update Accessory'),
				'add_new_item' => __('Add New Accessory'),
				'new_item_name' => __('New Accessory'),
			),
		)
	);		
register_taxonomy_for_object_type('listings', 'listing-type');
register_taxonomy_for_object_type('listings', 'listing-accessory');
}



// change post title box text
function rkv_change_post_text( $title ) {
     $screen = get_current_screen();
 
     if  ( 'listings' == $screen->post_type ) :
          $title = 'Enter Listing ID Here';
     endif;

return $title;
}

add_filter('enter_title_here', 'rkv_change_post_text');

// add to page

function rkv_page_indicate( $columns ) {
	$columns['genside'] = __( 'Sidebar' );
 	return $columns;
}
add_filter( 'manage_edit-page_columns', 'rkv_page_indicate' );

// resource column
add_filter('manage_edit-resources_columns', 'rkv_resource_columns');

	function rkv_resource_columns($resc_columns) {
		$new_columns['cb'] = '<input type="checkbox" />';
		$new_columns['title'] = _x('Name', 'column name');
		$new_columns['rs_type'] = __('Resource Type');
 	return $new_columns;
	}


// set columns for all post types
add_action('manage_posts_custom_column', 'manage_custom_columns', 10, 2);
 
	function manage_custom_columns($column_name, $id) {
		global $post;
		switch ($column_name) {
		case 'id':
			echo $id;
		        break;
 		case 'rs_type':
			$rs_types = get_the_term_list( $post->ID, 'resource-type', '', ', ', '');
			if (!empty ($rs_types) ) {
				echo $rs_types;
			} else {
				echo '<em>None entered</em>';
			}
		        break;
 		default:
			break;
		} // end switch
	}

add_action('manage_pages_custom_column', 'manage_page_columns', 10, 2);
 
	function manage_page_columns($column_name, $id) {
		global $post;
		switch ($column_name) {
 		case 'genside':
			$sidegen = get_post_meta($post->ID, '_rkv_pg_generic', true);
			if (!empty($sidegen) ) 
				echo '<span id="meta_answer" class="meta_yes">Yes</span>';
        break;
 		default:
			break;
		} // end switch
	}