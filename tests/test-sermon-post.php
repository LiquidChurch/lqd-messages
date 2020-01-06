<?php

/**
 * GCS_Sermon Post Tests.
 *
 * @since   0.0.0
 * @package GCS_Sermons
 */
class GCS_Sermon_Post_Test extends WP_UnitTestCase {

	/**
	 * Test if our class exists.
	 *
	 * @since  0.0.0
	 */
	function test_class_exists() {
		$this->assertTrue( class_exists( 'GCS_Sermon_Post') );
	}

	/**
	 * Test that we can access our class through our helper function.
	 *
	 * @since  0.0.0
	 */
	function test_class_access() {
		$sermons = gc_sermons()->sermons;
		$this->assertFalse( $sermons->most_recent() );
		$this->assertEquals( 'gc-sermons', $sermons->post_type() );

		// Create a post
		$this->factory->post->create( array(
			'post_type' => $sermons->post_type(),
		) );

		$sermons->flush = true;

		// And check if we found an instance
		$this->assertTrue( $sermons->most_recent() instanceof GCS_Sermon_Post );
	}
}
