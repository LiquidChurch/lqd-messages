<?php

class LQDMS_Shortcodes_Resources_Admin_Test extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'LQDM_Shortcodes_Resources_Admin') );
	}

	function test_class_access() {
		$this->assertTrue( gc_sermons()->shortcodes-resources-admin instanceof LQDM_Shortcodes_Resources_Admin );
	}
}
