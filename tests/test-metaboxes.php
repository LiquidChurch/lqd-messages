<?php

class LQDM_Metaboxes_Test extends WP_UnitTestCase {

	function test_sample() {
		// replace this with some actual testing code
		$this->assertTrue( true );
	}

	function test_class_exists() {
		$this->assertTrue( class_exists( 'LQDM_Metaboxes') );
	}

	function test_class_access() {
		$this->assertInstanceOf( LQDM_Metaboxes::class, lqdm()->metaboxes );
	}
}
