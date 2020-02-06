<?php
/**
 * Liquid Messages Play Button Shortcode
 *
 * @package GC Sermons
 */
class LqdM_Shortcodes_Play_Button extends LqdM_Shortcodes_Base {

	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->run = new LqdM_Play_Button_Run( $plugin->sermons );
		$this->admin = new LqdM_Play_Button_Admin( $this->run );

		parent::hooks();
	}

}
