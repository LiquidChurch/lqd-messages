<?php

/**
 * Class LCF_Shortcodes_Resources_Test
 */
class LCF_Shortcodes_Resources_Test extends WP_UnitTestCase {

	function test_sample() {
		// replace this with some actual testing code
		$this->assertTrue( true );
	}

	function test_class_exists() {
		$this->assertTrue( class_exists( 'LCF_Shortcodes_Resources') );
	}

	function test_class_access() {
		$this->assertInstanceOf( LCF_Shortcodes_Resources::class, gc_sermons()->shortcodes->resources );
	}
}
