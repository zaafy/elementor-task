<?php
// Load styles of both parent and child themes
add_action( 'wp_enqueue_scripts', 'emt_enqueue_styles' );

function emt_enqueue_styles() {
	$parenthandle = 'twentytwenty-style';
	$theme = wp_get_theme();
	wp_enqueue_style( $parenthandle,
		get_template_directory_uri() . '/style.css',
		array()
	);
	wp_enqueue_style( 'child-style',
		get_stylesheet_uri(),
		array( $parenthandle )
	);
	wp_enqueue_style( 'child-style-products',
		get_stylesheet_directory_uri() . '/css/styles.css',
		[]
	);
}

// 3.1 Create a new user
add_action('init', 'emt_create_user_with_role');

function emt_create_user_with_role() {
	define( 'IN_CODE', '1' );
	include( 'includes/passwd.php' );

    $username = 'wp-test';
    $email = 'wptest@elementor.com';
    $password = WP_TEST_PASS;

    $user_id = username_exists( $username );
    if ( !$user_id && email_exists($email) == false ) {
        $user_id = wp_create_user( $username, $password, $email );
        if( !is_wp_error($user_id) ) {
            $user = get_user_by( 'id', $user_id );
            $user->set_role( 'editor' );
        }
    }
}

// 3.2 Disable admin bar for wp-test user
add_action('after_setup_theme', 'emt_remove_admin_bar_for_wptest_user');

function emt_remove_admin_bar_for_wptest_user() {
	$user = wp_get_current_user();
	if ($user->user_login == 'wp-test') {
        show_admin_bar(false);
	}
}

// 4.1 Create CPT Products
add_action( 'init', 'emt_create_post_type_products', 0 );

function emt_create_post_type_products() {
	$labels = array(
		'name'                  => _x( 'Products', 'Post Type General Name', 'emt_task_domain' ),
		'singular_name'         => _x( 'Product', 'Post Type Singular Name', 'emt_task_domain' ),
		'menu_name'             => __( 'Products', 'emt_task_domain' ),
		'name_admin_bar'        => __( 'Products', 'emt_task_domain' ),
		'archives'              => __( 'Item Archives', 'emt_task_domain' ),
		'attributes'            => __( 'Item Attributes', 'emt_task_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'emt_task_domain' ),
		'all_items'             => __( 'All Items', 'emt_task_domain' ),
		'add_new_item'          => __( 'Add New Item', 'emt_task_domain' ),
		'add_new'               => __( 'Add New', 'emt_task_domain' ),
		'new_item'              => __( 'New Item', 'emt_task_domain' ),
		'edit_item'             => __( 'Edit Item', 'emt_task_domain' ),
		'update_item'           => __( 'Update Item', 'emt_task_domain' ),
		'view_item'             => __( 'View Item', 'emt_task_domain' ),
		'view_items'            => __( 'View Items', 'emt_task_domain' ),
		'search_items'          => __( 'Search Item', 'emt_task_domain' ),
		'not_found'             => __( 'Not found', 'emt_task_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'emt_task_domain' ),
		'featured_image'        => __( 'Featured Image', 'emt_task_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'emt_task_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'emt_task_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'emt_task_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'emt_task_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'emt_task_domain' ),
		'items_list'            => __( 'Items list', 'emt_task_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'emt_task_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'emt_task_domain' ),
	);

	$args = array(
		'label'                 => __( 'Product', 'emt_task_domain' ),
		'description'           => __( 'Elementor Task Products', 'emt_task_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'taxonomies'            => array( 'category' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);

	register_post_type( 'emt_products', $args );
}

// Register JS file to work on sidebar
add_action( 'enqueue_block_editor_assets', function(){
	wp_enqueue_script(
		'emt_scripts',
		get_stylesheet_directory_uri() . '/build/index.js',
		array( 'wp-edit-post', 'wp-element', 'wp-components', 'wp-plugins', 'wp-data' ),
		filemtime( get_stylesheet_directory() . '/build/index.js' )
	);
});

// include custom fields
include( 'includes/fields.php' );
