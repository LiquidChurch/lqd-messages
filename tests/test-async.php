<?php
/**
 * Class GCS_Async_Test
 *
 * @package Lqd-Messages
 */

/**
 * Test Case.
 */
class GCS_Async_Test extends WP_UnitTestCase {

    /**
     * Test class exists.
     */
	function test_class_exists() {
		$this->assertTrue( class_exists( 'GCS_Async') );
	}

    /**
     * Test class access.
     */
	function test_class_access() {
		$this->assertInstanceOf( GCS_Async::class, gc_sermons()->async );
	}
}
