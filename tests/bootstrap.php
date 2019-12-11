<?php

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

require_once $_tests_dir . '/functions.php';

function _manually_load_plugin() {
	require dirname( __FILE__, 3 ) . '/cmb2/init.php';
	require dirname( __FILE__, 3 ) . '/wds-shortcodes/wds-shortcodes.php';
	require dirname( __FILE__, 2 ) . '/gc-sermons.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

require $_tests_dir . '/includes/bootstrap.php';
