<?php
// include composer autoloader (make sure you run `composer install`!)
require_once WDS_SHORTCODES_DIR . 'vendor/autoload.php';

/**
 * Built using generator-plugin-wp
 */

/**
 * Main initiation class
 *
 * @since  0.1.0
 * @var  string $version  Plugin version
 * @var  string $basename Plugin basename
 * @var  string $url      Plugin URL
 * @var  string $path     Plugin Path
 */
class WDS_Shortcodes_Base {

	/**
	 * Current version
	 *
	 * @var  string
	 * @since  0.1.0
	 */
	const VERSION = WDS_SHORTCODES_VERSION;

	/**
	 * URL of plugin directory
	 *
	 * @var string
	 * @since  0.1.0
	 */
	protected $url = WDS_SHORTCODES_URL;

	/**
	 * Path of plugin directory
	 *
	 * @var string
	 * @since  0.1.0
	 */
	protected $path = WDS_SHORTCODES_DIR;

	/**
	 * Plugin basename
	 *
	 * @var string
	 * @since  0.1.0
	 */
	protected $basename = WDS_SHORTCODES_BASENAME;

	/**
	 * Singleton instance of plugin
	 *
	 * @var WDS_Shortcodes_Base
	 * @since  0.1.0
	 */
	protected static $single_instance = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since  0.1.0
	 * @return WDS_Shortcodes_Base A single instance of this class.
	 */
	public static function get_instance() {
		if ( null === self::$single_instance ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;
	}

	/**
	 * Add hooks and filters
	 *
	 * @since 0.1.0
	 * @return null
	 */
	public function hooks() {
		add_action( 'init', array( $this, 'init' ) );

		if ( ! defined( 'CMB2_Loaded' ) ) {
			add_action( 'tgmpa_register', array( $this, 'register_required_plugin' ) );
		}

		do_action( 'wds_shortcodes_loaded', $this );
	}

	/**
	 * Init hooks
	 *
	 * @since  0.1.0
	 * @return null
	 */
	public function init() {
		load_plugin_textdomain( 'wds-shortcodes', false, dirname( $this->basename ) . '/languages/' );
	}

	/**
	 * Magic getter for our object.
	 *
	 * @since  0.1.0
	 * @param string $field
	 * @throws Exception Throws an exception if the field is invalid.
	 * @return mixed
	 */
	public function __get( $field ) {
		switch ( $field ) {
			case 'version':
				return self::VERSION;
			case 'basename':
			case 'url':
			case 'path':
				return $this->$field;
			default:
				throw new Exception( 'Invalid '. __CLASS__ .' property: ' . $field );
		}
	}
}

/**
 * Grab the WDS_Shortcodes_Base object and return it.
 * Wrapper for WDS_Shortcodes_Base::get_instance()
 *
 * @since  0.1.0
 * @return WDS_Shortcodes_Base  Singleton instance of plugin class.
 */
function wds_shortcodes() {
	return WDS_Shortcodes_Base::get_instance();
}

// Kick it off
if ( ! did_action( 'plugins_loaded' ) ) {
	add_action( 'plugins_loaded', array( wds_shortcodes(), 'hooks' ) );
} else {
	wds_shortcodes()->hooks();
}
