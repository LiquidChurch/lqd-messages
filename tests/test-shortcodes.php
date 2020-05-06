<?php

class LQDM_Shortcodes_Test extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'LQDM_Shortcodes' ) );
	}

	function test_class_access() {
		gc_sermons()->hooks();
		$this->assertInstanceOf( LQDM_Shortcodes::class, gc_sermons()->shortcodes );
	}
}
