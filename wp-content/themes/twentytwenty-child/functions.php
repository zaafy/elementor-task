<?php
// Load styles of both parent and child themes
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

function my_theme_enqueue_styles() {
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

