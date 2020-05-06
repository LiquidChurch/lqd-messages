<?php

class LQDM_Async_Test extends WP_UnitTestCase {

	function test_sample() {
		// replace this with some actual testing code
		$this->assertTrue( true );
	}

	function test_class_exists() {
		$this->assertTrue( class_exists( 'LQDM_Async' ) );
	}

	function test_class_access() {
		$this->assertInstanceOf( LQDM_Async::class, gc_sermons()->async );
	}
}
