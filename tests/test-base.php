<?php

/**
 * Class BaseTest
 */
class BaseTest extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'Lqd_Messages_Plugin' ) );
	}

	function test_get_instance() {
		$this->assertInstanceOf( Lqd_Messages_Plugin::class, lqd_messages() );
	}
}
