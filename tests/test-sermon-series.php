<?php
/**
 * GCS_Series Taxonomy Tests
 *
 * @since   0.0.0
 * @package GCS_Sermons
 */
class GCS_Series_Test extends WP_UnitTestCase {

	/**
	 * Test if our class exists.
	 *
	 * @since   0.0.0
	 */
	function test_class_exists() {
		$this->assertTrue( class_exists( 'GCS_Series') );
	}

	/**
	 * Test that we can access our class through our helper function.
	 *
	 * @since   0.0.0
	 */
	function test_class_access() {
		$this->assertInstanceOf( GCS_Series::class, gc_sermons()->series );
	}

	/**
	 * Test that our taxonomy now exists.
	 *
	 * @since   0.0.0
	 */
	function test_taxonomy_exists() {
		$this->assertTrue( taxonomy_exists( 'gc-sermon-series' ) );
	}
}
