<?php

/**
 * Test Series Taxonomy
 */
class LqdM_Series_Test extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'LqdM_Series' ) );
	}

	function test_class_access() {
		$this->assertTrue( lqd_messages()->series instanceof LqdM_Series );
	}

  function test_taxonomy_exists() {
    $this->assertTrue( taxonomy_exists( 'lqdmmessage-series' ) );
  }
}
