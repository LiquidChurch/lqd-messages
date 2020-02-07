<?php

/**
 * Class LqdM_Metaboxes_Test
 */
class LqdM_Metaboxes_Test extends WP_UnitTestCase {

	function test_sample() {
		// replace this with some actual testing code
		$this->assertTrue( true );
	}

	function test_class_exists() {
		$this->assertTrue( class_exists( 'LqdM_Metaboxes' ) );
	}

	function test_class_access() {
	    // todo: How to tell it to check if either it is a class or an array object?
		$this->assertInstanceOf( LqdM_Metaboxes::class, lqd_messages()->metaboxes );
	}
}
