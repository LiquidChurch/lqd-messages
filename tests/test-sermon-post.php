<?php

/**
 * Class GCS_Sermon_Post_Test
 */
class LqdM_Sermon_Post_Test extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'LqdM_Message_Post' ) );
	}

	function test_class_access() {
		$sermons = lqd_messages()->sermons;
		$this->assertFalse( $sermons->most_recent() );
		$this->assertEquals( 'gc-sermons', $sermons->post_type() );

		// Create a post
		$this->factory->post->create( array(
			'post_type' => $sermons->post_type(),
		) );

		$sermons->flush = true;

		// And check if we found an instance
		$this->assertTrue( $sermons->most_recent() instanceof LqdM_Message_Post );
	}
}
