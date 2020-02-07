<?php
/**
 * GC Sermons Series Shortcode
 *
 * @package Liquid Messages
 */
class LqdM_Shortcodes_Series extends LqdM_Shortcodes_Base {
	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->run   = new LqdM_Series_Run( $plugin->sermons, $plugin->series );
		$this->admin = new LqdM_Series_Admin( $this->run );

		parent::hooks();
	}
}
