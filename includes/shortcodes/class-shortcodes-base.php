<?php
/**
 * Liquid Messages Shortcode Base
 *
 * @package GC Sermons
 */
abstract class LqdM_Shortcodes_Base {

	/**
	 * Instance of GCS_Shortcodes_Run_Base
	 *
	 * @var LqdM_Shortcodes_Run_Base
	 */
	public $run;

	/**
	 * Instance of GCS_Shortcodes_Admin_Base
	 *
	 * @var LqdM_Shortcodes_Admin_Base
	 */
	public $admin;

	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->hooks();
	}

	/**
	 * Hooks
	 */
	public function hooks() {
		$this->run->hooks();
		$this->admin->hooks();
	}

}
