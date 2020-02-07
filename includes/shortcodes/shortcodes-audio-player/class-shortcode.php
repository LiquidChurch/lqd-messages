<?php
/**
 * GC Sermons Audio Player Shortcode
 *
 * @package Liquid Messages
 */
class LqdM_Shortcodes_Audio_Player extends LqdM_Shortcodes_Base {

	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->run   = new LqdM_Shortcodes_Audio_Player_Run( $plugin->sermons );
		$this->admin = new LqdM_Shortcodes_Audio_Player_Admin( $this->run );

		parent::hooks();
	}

}
