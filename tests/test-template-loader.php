<?php

class LQDM_Template_Loader_Test extends WP_UnitTestCase {
	function test_class_exists() {
		$this->assertTrue( class_exists( 'LQDM_Template_Loader') );
	}

	function test_class_access() {
		$this->assertTrue( gc_sermons()->template-loader instanceof LQDM_Template_Loader );
	}
}
