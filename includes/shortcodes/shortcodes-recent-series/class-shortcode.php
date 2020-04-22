<?php
/**
 * Liquid Messages Series Shortcode
 *
 * @package Liquid Messages
 */
class GCS_Shortcodes_Recent_Series extends GCS_Shortcodes_Base {
	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->run   = new GCSS_Recent_Series_Run( $plugin->sermons );
		$this->admin = new GCSS_Recent_Series_Admin( $this->run );

		parent::hooks();
	}
}
