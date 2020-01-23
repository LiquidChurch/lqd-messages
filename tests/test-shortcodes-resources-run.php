<?php

/**
 * Class LCF_Shortcodes_Resources_Run_Test
 */
class LCF_Shortcodes_Resources_Run_Test extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'GCS_Shortcodes_Resources_Run' ) );
	}

	function test_class_access() {
		$this->assertInstanceOf( GCS_Shortcodes_Resources_Run::class, gc_sermons()->shortcodes_resources_run );
	}
}
