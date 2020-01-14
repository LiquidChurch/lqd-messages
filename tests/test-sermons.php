<?php

/**
 * Test GCS_Sermons Tests.
 *
 * @since   0.0.0
 * @package GCS_Sermons
 */
class GCS_Sermons_Test extends WP_UnitTestCase {

	/**
	 * Test if our class exists.
	 *
	 * @since   0.0.0
	 */
	function test_class_exists() {
		$this->assertTrue( class_exists( 'GCS_Sermons') );
	}

	/**
	 * Test that we can access our class through our helper function.
	 *
	 * @since   0.0.0
	 */
	function test_class_access() {
		$this->assertInstanceOf( GCS_Sermons::class, gc_sermons()->sermons );
	}

	/**
	 * Test to make sure the CPT now exists.
	 *
	 * @since   0.0.0
	 */
	function test_cpt_exists() {
		$this->assertTrue(post_type_exists('gc-sermons'));
	}
}
