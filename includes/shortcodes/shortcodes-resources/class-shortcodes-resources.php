<?php
/**
 * LiquidChurch Functionality Shortcodes Resources.
 *
 * @package LiquidChurch Functionality
 */
class LCF_Shortcodes_Resources {

	/**
	 * Instance of LCF_Shortcodes_Resources_Run
	 *
	 * @var LCF_Shortcodes_Resources_Run
	 */
	protected $run;

	/**
	 * Instance of LCF_Shortcodes_Resources_Admin
	 *
	 * @var LCF_Shortcodes_Resources_Admin
	 */
	protected $admin;

	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->run = new LCF_Shortcodes_Resources_Run();
		$this->run->init( $plugin->metaboxes->resources_meta_id );
		$this->run->hooks();

		if ( is_admin() ) {
			$this->admin = new LCF_Shortcodes_Resources_Admin( $this->run );
			$this->admin->hooks();
		}
	}

}
