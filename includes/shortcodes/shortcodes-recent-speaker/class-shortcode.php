<?php
/**
 * GC Sermons Recent Speaker Shortcode
 *
 * @package GC Sermons
 */
class LqdM_Shortcodes_Recent_Speaker extends LqdM_Shortcodes_Base {
	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->run   = new LqdM_Recent_Speaker_Run( $plugin->sermons );
		$this->admin = new LqdM_Recent_Speaker_Admin( $this->run );

		parent::hooks();
	}
}
