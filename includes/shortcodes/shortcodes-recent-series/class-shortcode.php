<?php
/**
 * Liquid Messages Series Shortcode
 *
 * @package Liquid Messages
 */
class LQDM_Shortcodes_Recent_Series extends LQDM_Shortcodes_Base {
	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->run   = new LQDMS_Recent_Series_Run( $plugin->sermons );
		$this->admin = new LQDMS_Recent_Series_Admin( $this->run );

		parent::hooks();
	}
}
