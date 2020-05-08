<?php

class BaseTest extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'LQDM_Plugin' ) );
	}

	function test_get_instance() {
		$this->assertInstanceOf( LQDM_Plugin::class, lqdm() );
	}
}
