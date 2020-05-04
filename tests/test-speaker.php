<?php

class LQDM_Speaker_Test extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'LQDM_Speaker' ) );
	}

	function test_class_access() {
		$this->assertInstanceOf( LQDM_Speaker::class, gc_sermons()->speaker );
	}

  function test_taxonomy_exists() {
    $this->assertTrue( taxonomy_exists( 'gcs-speaker' ) );
  }
}
