<?php

/**
 * Class LqdM_Speaker_Test
 */
class LqdM_Speaker_Test extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'LqdM_Speaker' ) );
	}

	function test_class_access() {
		$this->assertTrue( lqd_messages()->speaker instanceof LqdM_Speaker );
	}

  function test_taxonomy_exists() {
    $this->assertTrue( taxonomy_exists( 'lqdm-speaker' ) );
  }
}
