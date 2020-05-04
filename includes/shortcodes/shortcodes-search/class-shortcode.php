<?php
/**
 * Liquid Messages Search Shortcode
 *
 * @package Liquid Messages
 */
class LQDM_Shortcodes_Sermon_Search extends LQDM_Shortcodes_Base {
	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->run   = new LQDM_Shortcodes_Sermon_Search_Run( $plugin->sermons, $plugin->taxonomies );
		$this->admin = new LQDM_Shortcodes_Sermon_Search_Admin( $this->run, $plugin->taxonomies );

		parent::hooks();
	}
}
