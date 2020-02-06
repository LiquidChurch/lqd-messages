<?php

/**
 * Class GCS_Taxonomies_Test
 */
class GCS_Taxonomies_Test extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'LqdM_Taxonomies' ) );
	}

	function test_class_access() {
		$this->assertTrue( lqd_messages()->taxonomies instanceof LqdM_Taxonomies );
	}
}
