<?php

/**
 * Test Messages Class
 */
class LqdM_Messages_Test extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'LqdM_Messages' ) );
	}

	function test_class_access() {
		$this->assertTrue( lqd_messages()->messages instanceof LqdM_Messages );
	}

  function test_cpt_exists() {
    $this->assertTrue( post_type_exists( 'lqdmmessages' ) );
  }
}
