<?php
/**
 * Register post type for custom feature of moztheme
 *
 * @package moztheme
 */

/**
 * Testimonial Post Type
 *
 * @since 0.1
 * @package moztheme
 */


function moztheme_reg_service() {

	$labels = array(
		'name'                => _x( 'Services', 'Post Type General Name', 'moztheme' ),
		'singular_name'       => _x( 'Service', 'Post Type Singular Name', 'moztheme' ),
		'menu_name'           => __( 'Service', 'moztheme' ),
		'parent_item_colon'   => __( 'Parent Item:', 'moztheme' ),
		'all_items'           => __( 'All service', 'moztheme' ),
		'view_item'           => __( 'View service', 'moztheme' ),
		'add_new_item'        => __( 'Add service', 'moztheme' ),
		'add_new'             => __( 'Add new', 'moztheme' ),
		'edit_item'           => __( 'Edit item', 'moztheme' ),
		'update_item'         => __( 'Update item', 'moztheme' ),
		'search_items'        => __( 'Search', 'moztheme' ),
		'not_found'           => __( 'Not found', 'moztheme' ),
		'not_found_in_trash'  => __( 'Not found in trash', 'moztheme' ),
	);
	$rewrite = array(
		'slug'                => 'service',
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true,
	);
	$args = array(
		'label'               => __( 'Service', 'moztheme' ),
		'description'         => __( 'Services Post Type', 'moztheme' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'trackbacks', 'revisions', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 10,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'page',
	);
	register_post_type( 'service', $args );

}

// Hook into the 'init' action
// add_action( 'init', 'moztheme_reg_service' );

function moztheme_reg_testimonial() {

	$labels = array(
		'name'                => _x( 'Testimonial', 'Post Type General Name', 'moztheme' ),
		'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'moztheme' ),
		'menu_name'           => __( 'Testimonial', 'moztheme' ),
		'parent_item_colon'   => __( 'Parent Item:', 'moztheme' ),
		'all_items'           => __( 'All testimonial', 'moztheme' ),
		'view_item'           => __( 'View testimonial', 'moztheme' ),
		'add_new_item'        => __( 'Add Testimonial', 'moztheme' ),
		'add_new'             => __( 'Add new', 'moztheme' ),
		'edit_item'           => __( 'Edit item', 'moztheme' ),
		'update_item'         => __( 'Update item', 'moztheme' ),
		'search_items'        => __( 'Search', 'moztheme' ),
		'not_found'           => __( 'Not found', 'moztheme' ),
		'not_found_in_trash'  => __( 'Not found in trash', 'moztheme' ),
	);
	$rewrite = array(
		'slug'                => 'y-kien-khach-hang',
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true,
	);
	$args = array(
		'label'               => __( 'Testimonial', 'moztheme' ),
		'description'         => __( 'Testimonail Post Type', 'moztheme' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'trackbacks', 'revisions', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 10,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'page',
	);
	register_post_type( 'testimonial', $args );

}

// Hook into the 'init' action
// add_action( 'init', 'moztheme_reg_testimonial' );

/**
 * FAQ Post Type
 *
 * @since 0.1
 * @package moztheme
 */

function moztheme_reg_faq() {

	$labels = array(
		'name'                => _x( 'FAQ', 'Post Type General Name', 'moztheme' ),
		'singular_name'       => _x( 'FAQ', 'Post Type Singular Name', 'moztheme' ),
		'menu_name'           => __( 'FAQ', 'moztheme' ),
		'parent_item_colon'   => __( 'Parent Item:', 'moztheme' ),
		'all_items'           => __( 'All question', 'moztheme' ),
		'view_item'           => __( 'View question', 'moztheme' ),
		'add_new_item'        => __( 'Add question', 'moztheme' ),
		'add_new'             => __( 'Add new', 'moztheme' ),
		'edit_item'           => __( 'Edit item', 'moztheme' ),
		'update_item'         => __( 'Update item', 'moztheme' ),
		'search_items'        => __( 'Search', 'moztheme' ),
		'not_found'           => __( 'Not found', 'moztheme' ),
		'not_found_in_trash'  => __( 'Not found in trash', 'moztheme' ),
	);
	$rewrite = array(
		'slug'                => 'hoi-dap',
		'with_front'          => true,
		'pages'               => true,
		'feeds'               => true,
	);
	$args = array(
		'label'               => __( 'FAQ', 'moztheme' ),
		'description'         => __( 'FAQ Post Type', 'moztheme' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'trackbacks', 'revisions', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 10,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'rewrite'             => $rewrite,
		'capability_type'     => 'page',
	);
	register_post_type( 'faq', $args );

}

// Hook into the 'init' action
// add_action( 'init', 'moztheme_reg_faq' );

if ( ! function_exists( 'moztheme_reg_faq_tax' ) ) {

// Register Custom Taxonomy
function moztheme_reg_faq_tax() {

	$labels = array(
		'name'                       => _x( 'faq Categories', 'Taxonomy General Name', 'moztheme' ),
		'singular_name'              => _x( 'faq Category', 'Taxonomy Singular Name', 'moztheme' ),
		'menu_name'                  => __( 'faq Category', 'moztheme' ),
		'all_items'                  => __( 'All Items', 'moztheme' ),
		'parent_item'                => __( 'Parent Item', 'moztheme' ),
		'parent_item_colon'          => __( 'Parent Item:', 'moztheme' ),
		'new_item_name'              => __( 'New Item Name', 'moztheme' ),
		'add_new_item'               => __( 'Add New Item', 'moztheme' ),
		'edit_item'                  => __( 'Edit Item', 'moztheme' ),
		'update_item'                => __( 'Update Item', 'moztheme' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'moztheme' ),
		'search_items'               => __( 'Search Items', 'moztheme' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'moztheme' ),
		'choose_from_most_used'      => __( 'Choose from the most used items', 'moztheme' ),
		'not_found'                  => __( 'Not Found', 'moztheme' ),
	);
	$rewrite = array(
		'slug'                       => 'chu-de',
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'faq_category', array( 'faq' ), $args );

}

// Hook into the 'init' action
//add_action( 'init', 'moztheme_reg_faq_tax', 0 );

}