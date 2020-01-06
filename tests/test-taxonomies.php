<?php

/**
 * GCS_Taxonomies Taxonomy Tests
 *
 * @since   0.0.0
 * @package GCS_Sermons
 */
class GCS_Taxonomies_Test extends WP_UnitTestCase {

	/**
	 * Test if our class exists.
	 *
	 * @since   0.0.0
	 */
	function test_class_exists() {
		$this->assertTrue( class_exists( 'GCS_Taxonomies') );
	}

	/**
	 * Test that we can access our class through our helper function.
	 *
	 * @since   0.0.0
	 */
	function test_class_access() {
		$this->assertInstanceOf( GCS_Taxonomies::class, gc_sermons()->taxonomies );
	}
}
