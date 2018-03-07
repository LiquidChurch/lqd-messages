<?php

namespace LiquidChurch\LqdMessages {

	use PHPUnit\Framework\TestCase;

	class GCS_Async_Test extends WP_UnitTestCase {

		function test_sample() {
			// replace this with some actual testing code
			$this->assertTrue( true );
		}

		function test_class_exists() {
			$this->assertTrue( class_exists( 'GCS_Async') );
		}

		function test_class_access() {
			$this->assertInstanceOf( GCS_Async::class, gc_sermons()->async );
		}
	}
}
