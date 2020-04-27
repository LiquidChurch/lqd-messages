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
 *
 * @since  0.1.0
 * @var  string $version  Plugin version
 * @var  string $basename Plugin basename
 * @var  string $url      Plugin URL
 * @var  string $path     Plugin Path
 */
class GC_Sermons_Plugin
{
	/** @var string Current Version of Plugin */
	const VERSION = '1.0.0';

    /** @var string URL of plugin directory */
	public static $url = '';

    /** @var string Path of plugin */
	public static $path = '';

	/** @var string Plugin basename */
	public static $basename = '';

	/** @var null Singleton instance of plugin */
	protected static $single_instance = null;

	/** @var GCS_Sermons Instance of GCS_Sermons */
	protected $sermons;

	/** @var GCS_Taxonomies Instances of GCS_Taxonomies */
	protected $taxonomies;

	/** @var GCS_Shortcodes Instance of GCS_Shortcodes */
	protected $shortcodes;

	/** @var GCS_Async Instance of GCS_Async */
	protected $async;

	/** @var string Plugin options setting key */
	public static $plugin_option_key = 'lc-plugin-settings';

	/** @var GCS_Metaboxes Instance of GCS_Metaboxes */
	protected $metaboxes;

	/** @var GCS_Option_Page Instance of GCS_Option_Page */
	protected $option_page;

	/**
	 * Plugin Constructor
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
	 * Uninstall routines should be placed in uninstall.php, deactivate and uninstall are not the same.
	 *
	 * @since  0.1.0
	 * @return void
	 */
	public static function deactivate()
	{
		flush_rewrite_rules();
	}

	/**
	 * Creates or returns an instance of GC_Sermons_Plugin.
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
			add_action('init', array($this, 'init'));
			$this->attach_plugin_classes();
	}

	/**
	 * Attach other plugin classes to the base plugin class.
	 *
	 * @since  0.1.0
	 * @return void
	 * @throws Exception
	 */
	public function attach_plugin_classes()
	{
		require_once self::$path . 'functions.php';

		// Attach other plugin classes to the base plugin class.
		$this->sermons = new GCS_Sermons($this);
		$this->taxonomies = new GCS_Taxonomies($this->sermons);
		$this->async = new GCS_Async($this);

		// Only create the full metabox object if in admin.
		if (is_admin()) {
			$this->metaboxes = new GCS_Metaboxes( $this );
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

		$this->shortcodes = new GCS_Shortcodes($this);

		$this->option_page = new GCS_Option_Page($this);
		$this->option_page->hooks();
	}

	/**
	 * Init hooks
	 *
	 * @since  0.1.0
	 * @return void
	 */
	public function init()
	{
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
            	throw new Exception('Invalid ' . __CLASS__ . ' property: ' . $field);
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
 * Grab and return it.
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
