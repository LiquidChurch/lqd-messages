<?php

class GCS_Async_Test extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'GCS_Async') );
	}

	function test_class_access() {
		$this->assertTrue( gc_sermons()->async instanceof GCS_Async );
	}
}
