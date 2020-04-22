<?php
/**
 * Liquid Messages Resources Shortcode
 *
 * @package Liquid Messages
 */
class GCS_Shortcodes_Resources extends GCS_Shortcodes_Base {

	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->run   = new GCSS_Resources_Run( $plugin->sermons, $plugin->metaboxes->resources_meta_id );
		$this->admin = new GCSS_Resources_Admin( $this->run );

		parent::hooks();
	}
}
