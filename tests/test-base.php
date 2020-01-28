<?php

/**
 * Class BaseTest
 */
class BaseTest extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'GC_Sermons_Plugin') );
	}

	function test_get_instance() {
		$this->assertInstanceOf( GC_Sermons_Plugin::class, gc_sermons() );
	}
}
