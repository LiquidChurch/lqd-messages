<?php

class LQDMS_Shortcodes_Resources_Run_Test extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'LQDMS_Shortcodes_Resources_Run') );
	}

	function test_class_access() {
		$this->assertTrue( gc_sermons()->shortcodes-resources-run instanceof LQDMS_Shortcodes_Resources_Run );
	}
}
