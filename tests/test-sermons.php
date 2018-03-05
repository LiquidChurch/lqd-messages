<?php

class GCS_Sermons_Test extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'GCS_Sermons') );
	}

	function test_class_access() {
		$this->assertInstanceOf( GCS_Sermons::class, gc_sermons()->sermons );
	}

  function test_cpt_exists() {
    $this->assertTrue( post_type_exists( 'gc-sermons' ) );
  }
}
