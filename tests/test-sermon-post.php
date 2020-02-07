<?php

/**
 * Class LqdM_Message_Post_Test
 */
class LqdM_Message_Post_Test extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'LqdM_Message_Post' ) );
	}

	function test_class_access() {
		$messages = lqd_messages()->messages;
		$this->assertFalse( $messages->most_recent() );
		$this->assertEquals( 'lqdmmessages', $messages->post_type() );

		// Create a post
		$this->factory->post->create( array(
			'post_type' => $messages->post_type(),
		) );

		$messages->flush = true;

		// And check if we found an instance
		$this->assertTrue( $messages->most_recent() instanceof LqdM_Message_Post );
	}
}
