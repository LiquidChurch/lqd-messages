<?php
/**
 * Plugin Name: Liquid Messages
 * Plugin URI:  https://github.com/liquidchurch/lqd-messages/
 * Description: Manage messages and message content in WordPress.
 * Version:     1.0.0
 * Author:      liquidchurch, jtsternberg, surajprgupta, davidshq
 * Author URI:  https://liquidchurch.com
 * Donate link: https://liquidchurch.com
 * License:     GPLv2
 * Text Domain: lqdm
 * Domain Path: /languages
 */

/**
 * Copyright (c) 2016 jtsternberg (email : justin@dsgnwrks.pro)
 * Copyright (c) 2016 jtsternberg (email : suraj.gupta@scripterz.in)
 * Copyright (c) 2016-2020 liquidchurch (email : webmaster@liquidchurch.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

// Use composer autoload.
require __DIR__ . '/vendor/autoload.php';

/**
 * Main initiation class
 */
class LQDM_Plugin
{
    /** @var string VERSION Current version */
    public const VERSION = '1.0.0';

    /** @var string $url URL of plugin directory */
    public static $url = '';

    /** @var string $path Path of plugin directory */
    public static $path = '';

    /** @var string $basename Plugin basename */
    public static $basename = '';

    /** @var null $single_instance Single instance of plugin object */
    protected static $single_instance;

    /** @var array $requirements Array of plugin requirements, keyed by admin notice label. */
    protected $requirements = array();

    /** @var LQDM_Sermons $sermons LQDM_Sermons Object */
    protected $sermons;

    /** @var LQDM_Taxonomies $taxonomies LQDM_Taxonomies Object */
    protected $taxonomies;

    /** @var LQDM_Shortcodes $shortcodes LQDM_Shortcodes Object */
    protected $shortcodes;

    /** @var LQDM_Async $async LQDM_Async Object */
    protected $async;

    /** @var string $plugin_option_key Plugin options settings key */
    public static $plugin_option_key = 'lc-plugin-settings';

    /** @var LQDM_Metaboxes Instance of LQDM_Metaboxes */
    protected $metaboxes;

    /** @var LQDM_Settings_Page $option_page Instance of LQDM_Settings_Page */
    protected $option_page;


    /**
     * Constructs our plugin object
     *
     * @since  0.1.0
     */
    protected function __construct()
    {
        self::$basename = plugin_basename(__FILE__);
        self::$url = plugin_dir_url(__FILE__);
        self::$path = plugin_dir_path(__FILE__);
    }

    /**
     * Activate the plugin
     *
     * This occurs once upon plugin activation.
     *
     * @since  0.1.0
     * @return void
     */
    public static function activate()
    {
        self::get_instance();
        flush_rewrite_rules();
    }

    /**
     * Deactivate the plugin
     *
     * This occurs once on plugin deactivation.
     *
     * Uninstall routines should be in uninstall.php
     *
     * @since  0.1.0
     * @return void
     */
    public static function deactivate()
    {
        flush_rewrite_rules();
    }

    /**
     * Creates or returns an instance of this class (GC_Sermons_Plugin).
     *
     * @return LQDM_Plugin A single instance of this class.
     *@since  0.1.0
     */
    public static function get_instance(): ?LQDM_Plugin {
        if ( self::$single_instance === null ) {
            self::$single_instance = new self();
        }

        return self::$single_instance;
    }

    /**
     * Add hooks and filters
     *
     * @since  0.1.0
     * @return void
     * @throws Exception
     */
    public function hooks(): void {
        //if (!defined('CMB2_LOADED') || !defined('WDS_SHORTCODES_LOADED')) {
          //  add_action('tgmpa_register', array($this, 'register_required_plugin'));
        //} else {
            add_action('init', array($this, 'init'));
            $this->attach_plugin_classes();
        //}
    }

    /**
     * Attach other plugin classes to the base plugin class.
     *
     * @since  0.1.0
     * @return void
     * @throws Exception
     */
    public function attach_plugin_classes(): void {
        require_once self::$path . 'functions.php';

        // Attach other plugin classes to the base plugin class.
        $this->sermons = new LQDM_Sermons($this);
        $this->taxonomies = new LQDM_Taxonomies($this->sermons);
        $this->async = new LQDM_Async($this);

        // Only create the full metabox object if in admin.
        if (is_admin()) {
            $this->metaboxes = new LQDM_Metaboxes( $this );
            $this->metaboxes->hooks();
        } else {
            $this->metaboxes = (object)array();
        }

        // But set these properties of the object always.
        $this->metaboxes->resources_box_id = 'gc_addtl_resources_metabox';
        $this->metaboxes->resources_meta_id = 'gc_addtl_resources';
        $this->metaboxes->display_ordr_box_id = 'gc_display_order_metabox';
        $this->metaboxes->display_ordr_meta_id = 'gc_display_order';
        $this->metaboxes->exclude_msg_meta_id = 'gc_exclude_msg';
        $this->metaboxes->video_msg_appear_pos = 'gc_video_msg_pos';

        $this->shortcodes = new LQDM_Shortcodes($this);

        $this->option_page = new LQDM_Settings_Page($this);
        $this->option_page->hooks();
    }

    /**
     * Requires CMB2 to be installed
     */
    public function register_required_plugin(): void {
        $plugins = array(
            array(
                'name'     => 'CMB2',
                'slug'     => 'cmb2',
                'required' => true,
                'version'  => '2.2.1',
            ),
        );

        $config = array(
            'domain'       => 'lqdm',
            'parent_slug'  => 'plugins.php',
            'capability'   => 'install_plugins',
            'menu'         => 'install-required-plugins',
            'has_notices'  => true,
            'is_automatic' => true,
            'message'      => '',
            'strings'      => array(),
        );

        tgmpa($plugins, $config);
    }

    /**
     * Init hooks
     *
     * @since  0.1.0
     * @return void
     */
    public function init(): void {
        load_plugin_textdomain('lqdm', false, dirname(self::$basename) . '/languages/');
    }

    /**
     * Magic getter for our object.
     *
     * @since  0.1.0
     * @param string $field Field to get.
     * @throws Exception Throws an exception if the field is invalid.
     * @return mixed
     */
    public function __get($field)
    {
        switch ($field) {
            case 'version':
                return self::VERSION;
            case 'sermons':
            case 'taxonomies':
            case 'shortcodes':
            case 'metaboxes':
                return $this->{$field};
            case 'series':
            case 'speaker':
            case 'topic':
            case 'tag':
                return $this->taxonomies->{$field};
            case 'plugin_option_key':
                return $this->$field;
            default:
                throw new RuntimeException( 'Invalid ' . __CLASS__ . ' property: ' . $field);
        }
    }

	/**
	 * Get Plugin Settings Options
	 *
	 * @param string $arg
	 * @param string $sub_arg
	 *
	 * @return bool|mixed|void
	 */
	public static function get_plugin_settings_options($arg = '', $sub_arg = '')
	{
		$options = get_option(self::$plugin_option_key);
		if (empty($options)) {
			return false;
		}

		if (!empty($arg)) {
			if (!isset($options[$arg])) {
				return false;
			}

			if (!empty($sub_arg)) {
				if (!isset($options[$arg][$sub_arg])) {
					return false;
				}

				return $options[$arg][$sub_arg];
			}

			return $options[$arg];
		}

		return $options;
	}
}

/**
 * Wrapper for GC_Sermons_Plugin::get_instance()
 *
 * Grab and return instance.
 *
 * @return LQDM_Plugin  Singleton instance of plugin class.
 *@since  0.1.0
 */
function lqdm()
{
    return LQDM_Plugin::get_instance();
}

// Kick it off.
add_action('plugins_loaded', array(lqdm(), 'hooks'));
register_activation_hook(__FILE__, array('LQDM_Plugin', 'activate'));
register_deactivation_hook(__FILE__, array('LQDM_Plugin', 'deactivate'));
