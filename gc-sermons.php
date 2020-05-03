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
require 'vendor/autoload.php';

/**
 * Main initiation class
 */
class GC_Sermons_Plugin
{
    /** @var string VERSION Current version */
    const VERSION = '1.0.0';

    /** @var string $url URL of plugin directory */
    public static $url = '';

    /** @var string $path Path of plugin directory */
    public static $path = '';

    /** @var string $basename Plugin basename */
    public static $basename = '';

    /** @var null $single_instance Single instance of plugin object */
    protected static $single_instance = null;

    /** @var array $requirements Array of plugin requirements, keyed by admin notice label. */
    protected $requirements = array();

    /** @var array $missed_requirements Array of plugin requirements which are not met. */
    protected $missed_requirements = array();

    /** @var GCS_Sermons $sermons GCS_Sermons Object */
    protected $sermons;

    /** @var GCS_Taxonomies $taxonomies GCS_Taxonomies Object */
    protected $taxonomies;

    /** @var GCS_Shortcodes $shortcodes GCS_Shortcodes Object */
    protected $shortcodes;

    /** @var GCS_Async $async GCS_Async Object */
    protected $async;

    /** @var string $plugin_option_key Plugin options settings key */
    public static $plugin_option_key = 'lc-plugin-settings';

    /** @var LQDM_Metaboxes Instance of LQDM_Metaboxes */
    protected $metaboxes;

    /** @var LQDM_Shortcodes Instance of LQDM_Shortcodes */
    protected $shortcodes;

    /** @var LQDM_Settings_Page $option_page Instance of LQDM_Option_Page */
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
     * @since  0.1.0
     * @return GC_Sermons_Plugin A single instance of this class.
     */
    public static function get_instance()
    {
        if (null === self::$single_instance) {
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
    public function hooks()
    {
        if (!defined('CMB2_LOADED') || !defined('WDS_SHORTCODES_LOADED')) {
            add_action('tgmpa_register', array($this, 'register_required_plugin'));
        } else {
            add_action('init', array($this, 'init'));
            $this->plugin_classes();
        }
    }

    /**
     * Attach other plugin classes to the base plugin class.
     *
     * @since  0.1.0
     * @return void
     * @throws Exception
     */
    public function plugin_classes()
    {
        require_once self::$path . 'functions.php';

        // Attach other plugin classes to the base plugin class.
        $this->sermons = new GCS_Sermons($this);
        $this->taxonomies = new GCS_Taxonomies($this->sermons);
        $this->async = new GCS_Async($this);
        $this->shortcodes = new GCS_Shortcodes($this);
    }

    /**
     * Requires CMB2 to be installed
     */
    public function register_required_plugin()
    {
        $plugins = array(
            array(
                'name'     => 'CMB2',
                'slug'     => 'cmb2',
                'required' => true,
                'version'  => '2.2.1',
            ),
        );

        $config = array(
            'domain'       => 'gc-sermons',
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
    public function init()
    {
        load_plugin_textdomain('gc-sermons', false, dirname(self::$basename) . '/languages/');
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
                throw new Exception('Invalid ' . __CLASS__ . ' property: ' . $field);
        }
    }
}

/**
 * Wrapper for GC_Sermons_Plugin::get_instance()
 *
 * Grab and return instance.
 *
 * @since  0.1.0
 * @return GC_Sermons_Plugin  Singleton instance of plugin class.
 */
function gc_sermons()
{
    return GC_Sermons_Plugin::get_instance();
}

// Kick it off.
add_action('plugins_loaded', array(gc_sermons(), 'hooks'));
register_activation_hook(__FILE__, array('GC_Sermons_Plugin', 'activate'));
register_deactivation_hook(__FILE__, array('GC_Sermons_Plugin', 'deactivate'));
