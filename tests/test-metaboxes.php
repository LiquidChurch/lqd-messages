<?php

/**
 * Class GCS_Metaboxes_Test
 */
class GCS_Metaboxes_Test extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'GCS_Metaboxes' ) );
	}

	function test_class_access() {
		$this->assertInstanceOf( GCS_Metaboxes::class, gc_sermons()->metaboxes );
	}
}
