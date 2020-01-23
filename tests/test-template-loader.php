<?php

/**
 * Class LCF_Template_Loader_Test
 */
class LCF_Template_Loader_Test extends WP_UnitTestCase {

	public function test_sample() {
		// replace this with some actual testing code
		$this->assertTrue( true );
	}

	public function test_class_exists() {
		$this->assertTrue( class_exists( 'LCF_Template_Loader') );
	}

	public function test_class_access() {
		$this->assertInstanceOf( LCF_Template_Loader::class, gc_sermons()->template_loader );
	}
}
