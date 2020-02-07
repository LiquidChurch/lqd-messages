<?php
/**
 * Liquid Messages Resources Shortcode.
 *
 * @package Liquid Messages
 */
class LqdM_Shortcodes_Resources extends LqdM_Shortcodes_Base {


	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->run = new LqdM_Shortcodes_Resources_Run($plugin->sermons, $plugin->metaboxes->resources_meta_id);
		$this->run->hooks();

		if ( is_admin() ) {
			$this->admin = new LqdM_Shortcodes_Resources_Admin( $this->run );
			$this->admin->hooks();
		}
	}

}
