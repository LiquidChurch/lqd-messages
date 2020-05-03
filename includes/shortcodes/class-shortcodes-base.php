<?php
/**
 * Liquid Messages Shortcode Base
 *
 * @package Liquid Messages
 */
abstract class GCS_Shortcodes_Base {
	/** @var GCS_Shortcodes_Run_Base $run Instance of GCS_Shortcodes_Run_Base */
	public $run;

	/** @var GCS_Shortcodes_Admin_Base Instances of GCS_Shortcodes_Admin_Base  */
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
