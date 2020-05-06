<?php
/**
 * Liquid Messages Message Shortcode
 *
 * @package Liquid Messages
 */
class LQDM_Shortcodes_Sermons extends LQDM_Shortcodes_Base {
	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->run   = new LQDMS_Sermons_Run( $plugin->sermons, $plugin->taxonomies );
		$this->admin = new LQDMS_Sermons_Admin( $this->run, $plugin->taxonomies );

		parent::hooks();
	}
}
