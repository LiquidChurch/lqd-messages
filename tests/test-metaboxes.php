<?php

/**
 * Class GCS_Metaboxes_Test
 */
class GCS_Metaboxes_Test extends WP_UnitTestCase {

	function test_sample() {
		// replace this with some actual testing code
		$this->assertTrue( true );
	}

	function test_class_exists() {
		$this->assertTrue( class_exists( 'GCS_Metaboxes' ) );
	}

	function test_class_access() {
	    // todo: How to tell it to check if either it is a class or an array object?
		$this->assertInstanceOf( GCS_Metaboxes::class, gc_sermons()->metaboxes );
	}
}
