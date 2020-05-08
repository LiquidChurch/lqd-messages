<?php

class LQDM_Series_Test extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'LQDM_Series' ) );
	}

	function test_class_access() {
		$this->assertInstanceOf( LQDM_Series::class, lqdm()->series );
	}

  function test_taxonomy_exists() {
    $this->assertTrue( taxonomy_exists( 'gc-sermon-series' ) );
  }
}
