<?php
/**
 * PHPUnit bootstrap file
 *
 * @since   0.0.0
 * @package Lqd-Messages
 */

// Get our tests directory.
$_tests_dir = ( getenv( 'WP_TESTS_DIR' ) ) ? getenv( 'WP_TESTS_DIR' ) : '/tmp/wordpress-tests-lib';

// Include our tests functions.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually require our plugin for testing.
 *
 * @since 0.0.0
 */
function _manually_load_lqd_messages_plugin() {

	// Require our plugin.
	require dirname( dirname( __FILE__ ) ) . '/gc-sermons.php';
}

// Inject in our plugin.
tests_add_filter( 'muplugins_loaded', '_manually_load_lqd_messages_plugin' );

// Include the main tests bootstrapper.
require $_tests_dir . '/includes/bootstrap.php';
