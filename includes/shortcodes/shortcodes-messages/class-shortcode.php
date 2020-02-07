<?php
/**
 * Liquid Messages Shortcode
 *
 * @package Liquid Messages
 */
class LqdM_Shortcodes_Messages extends LqdM_Shortcodes_Base {
	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->run   = new LqdM_Messages_Run( $plugin->messages, $plugin->taxonomies );
		$this->admin = new LqdM_Messages_Admin( $this->run, $plugin->taxonomies );

		parent::hooks();
	}
}
