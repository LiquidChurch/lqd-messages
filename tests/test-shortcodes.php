<?php

/**
 * Class LqdM_Shortcodes_Test
 */
class LqdM_Shortcodes_Test extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'LqdM_Shortcodes' ) );
	}

	function test_class_access() {
		lqd_messages()->hooks();
		$this->assertTrue( lqd_messages()->shortcodes instanceof LqdM_Shortcodes );
	}
}
