<?php

/**
 * Class LCF_Shortcodes_Resources_Admin_Test
 */
class LCF_Shortcodes_Resources_Admin_Test extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'GCS_Shortcodes_Resources_Admin' ) );
	}

	function test_class_access() {
		$this->assertTrue( GCS_Shortcodes_Resources_Admin::class, gc_sermons()->shortcodes_resources_admin );
	}
}
