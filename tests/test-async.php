<?php
/**
 * Tests Liquid Messages Async Test
 *
 * @package Lqd-Messages
 */

/**
 * Test Case.
 */
class LqdM_Async_Test extends WP_UnitTestCase {

    /**
     * Test class exists.
     */
	function test_class_exists() {
		$this->assertTrue( class_exists( 'LqdM_Async' ) );
	}

    /**
     * Test class access.
     */
	function test_class_access() {
		$this->assertInstanceOf( LqdM_Async::class, lqd_messages()->async );
	}
}
