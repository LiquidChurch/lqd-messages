<?php

class LQDM_Sermons_Test extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'LQDM_Sermons' ) );
	}

	function test_class_access() {
		$this->assertInstanceOf( LQDM_Sermons::class, lqdm()->sermons );
	}

  function test_cpt_exists() {
    $this->assertTrue( post_type_exists( 'gc-sermons' ) );
  }
}
