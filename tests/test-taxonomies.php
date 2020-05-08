<?php

class LQDM_Taxonomies_Test extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'LQDM_Taxonomies' ) );
	}

	function test_class_access() {
		$this->assertInstanceOf( LQDM_Taxonomies::class, lqdm()->taxonomies );
	}
}
