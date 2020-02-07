<?php
/**
 * GC Sermons Shortcode
 *
 * @package Liquid Messages
 */
class LqdM_Shortcodes_Sermons extends LqdM_Shortcodes_Base {
	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->run   = new LqdM_Sermons_Run( $plugin->sermons, $plugin->taxonomies );
		$this->admin = new LqdM_Sermons_Admin( $this->run, $plugin->taxonomies );

		parent::hooks();
	}
}
