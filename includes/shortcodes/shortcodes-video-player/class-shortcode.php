<?php
/**
 * GC Sermons Video Player Shortcode
 *
 * @package GC Sermons
 */
class GCS_Shortcodes_Video_Player extends GCS_Shortcodes_Base {

	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->run   = new GCS_Shortcodes_Video_Player_Run( $plugin->sermons );
		$this->admin = new GCS_Shortcodes_Video_Player_Admin( $this->run );

		parent::hooks();
	}

}




