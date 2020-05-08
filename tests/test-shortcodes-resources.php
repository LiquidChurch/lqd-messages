<?php

class LQDMSS_Shortcodes_Resources_Test extends WP_UnitTestCase {
	function test_class_exists() {
		$this->assertTrue( class_exists( 'LQDM_Shortcodes_Resources') );
	}

	function test_class_access() {
		$this->assertTrue( lqdm()->shortcodes - resources instanceof LQDMS_Shortcodes_Resources );
	}
}
