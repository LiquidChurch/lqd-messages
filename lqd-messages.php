<?php
    /**
     * Plugin Name: Liquid Church Messages
     * Plugin URI:  https://liquidchurch.com
     * Description: Manage messages and message content in WordPress
     * Version:     0.9.1
     * Author:      jtsternberg, surajprgupta, davidshq, liquidchurch
     * Author URI:  https://liquidchurch.com
     * Donate link: https://liquidchurch.com
     * License:     GPLv2
     * Text Domain: lqdm
     * Domain Path: /languages
     */

    /**
     * Copyright (c) 2016 jtsternberg (email : justin@dsgnwrks.pro)
     * Copyright (c) 2016 surajprgupta (email : suraj.gupta@scripterz.in)
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
     * @var  string $basename Plugin basename
     * @var  string $url      Plugin URL
     * @var  string $path     Plugin Path
     */
    class Lqd_Messages_Plugin
    {

        /**
         * Current version
         *
         * @var  string
         * @since  0.1.0
         */
        const VERSION = '0.9.1';

        /**
         * URL of plugin directory
         *
         * @var string
         * @since  0.1.0
         */
        public static $url = '';

        /**
         * Path of plugin directory
         *
         * @var string
         * @since  0.1.0
         */
        public static $path = '';

        /**
         * Plugin basename
         *
         * @var string
         * @since  0.1.0
         */
        public static $basename = '';

        /**
         * Array of plugin requirements.
         *
         * @var array
         * @since  0.1.0
         */
        protected $requirements = array();

        /**
         * Array of plugin requirements which are not met.
         *
         * @var array
         * @since  0.1.0
         */
        protected $missed_requirements = array();

        /**
         * Singleton instance of plugin
         *
         * @var Lqd_Messages_Plugin
         * @since  0.1.0
         */
        protected static $single_instance = null;

        /**
         * Instance of Messages Post Type
         *
         * @var LqdM_Messages
         */
        protected $messages;

        /**
         * Instance of Messages Taxonomies
         *
         * @since 0.1.0
         * @var LqdM_Taxonomies
         */
        protected $taxonomies;

        /**
         * Instance of Messages Shortcodes
         *
         * @since 0.1.0
         * @var LqdM_Shortcodes
         */
        protected $shortcodes;

        /**
         * Instance of Messages Async
         *
         * @since 0.1.1
         * @var LqdM_Async
         */
        protected $async;

        /**
         * Messages Options Settings Key
         *
         * @var string
         */
        public static $plugin_option_key = 'lc-plugin-settings';

        /**
         * Instance of Messages Metaboxes
         *
         * @var LqdM_Metaboxes
         */
        protected $metaboxes;

        /**
         * Instance of Messages Config Page
         *
         * @var LqdM_Config_Page
         */
        protected $config_page;

        /**
         * Instance of Messages Option Page
         *
         * @var LqdM_Option_Page
         */
        protected $option_page;

        /**
         * Get Plugin Settings
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

        /**
         * Creates or returns an instance of the Lqd_Messages_Plugin class.
         *
         * @return Lqd_Messages_Plugin A single instance of this class.
         * @since  0.1.0
         */
        public static function get_instance()
        {
            if (null === self::$single_instance) {
                self::$single_instance = new self();
            }

            return self::$single_instance;
        }

        /**
         * Sets up our plugin
         *
         * @since  0.1.0
         */
        protected function __construct()
        {
            self::$basename = plugin_basename(__FILE__);
            self::$url      = plugin_dir_url(__FILE__);
            self::$path     = plugin_dir_path(__FILE__);
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

            $this->messages = new LqdM_Messages($this);
            $this->taxonomies = new LqdM_Taxonomies($this->messages);
            $this->async = new LqdM_Async($this);


            // Only create the full metabox object if user is in admin.
            if (is_admin()) {
                $this->metaboxes = new LqdM_Metaboxes($this);
                $this->metaboxes->hooks();
            } else {
                $this->metaboxes = (object) array();
            }

            // Set these properties for metaboxes, no matter what.
            $this->metaboxes->resources_box_id = 'lqdm_addtl_resources_metabox';
            $this->metaboxes->resources_meta_id = 'lqdm_addtl_resources';
            $this->metaboxes->display_ordr_box_id = 'lqdm_display_order_metabox';
            $this->metaboxes->display_ordr_meta_id = 'lqdm_display_order';
            $this->metaboxes->exclude_msg_meta_id = 'lqdm_exclude_msg';
            $this->metaboxes->video_msg_appear_pos = 'lqdm_video_msg_pos';

            $this->shortcodes = new LqdM_Shortcodes($this);

            $this->config_page = new LqdM_Config_Page($this);
            $this->config_page->hooks();

            $this->option_page = new LqdM_Option_Page($this);
            $this->option_page->hooks();
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
         * Require CMB2 to be installed
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
                'domain'       => 'lqdm',
                'parent_slug'  => 'plugins.php',
                'capability'   => 'install_plugins',
                'menu'         => 'install-required-plugins',
                'has_notices'  => true,
                'is_automatic' => true,
                'message'      => '',
                'strings'      => array(
                    'page_title'                      => __('Install Required Plugins', 'lqdm'),
                    'menu_title'                      => __('Install Plugins', 'lqdm'),
                    'installing'                      => __('Installing Plugin: %s', 'lqdm'),
                    // %1$s = plugin name
                    'oops'                            => __('Something went wrong with the plugin API.', 'lqdm'),
                    'notice_can_install_required'     => _n_noop('The "WDS Shortcodes" plugin requires the following plugin: %1$s.',
                        'This plugin requires the following plugins: %1$s.'),
                    // %1$s = plugin name(s)
                    'notice_can_install_recommended'  => _n_noop('This plugin recommends the following plugin: %1$s.',
                        'This plugin recommends the following plugins: %1$s.'),
                    // %1$s = plugin name(s)
                    'notice_cannot_install'           => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.',
                        'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.'),
                    // %1$s = plugin name(s)
                    'notice_can_activate_required'    => _n_noop('The following required plugin is currently inactive: %1$s.',
                        'The following required plugins are currently inactive: %1$s.'),
                    // %1$s = plugin name(s)
                    'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.',
                        'The following recommended plugins are currently inactive: %1$s.'),
                    // %1$s = plugin name(s)
                    'notice_cannot_activate'          => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.',
                        'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.'),
                    // %1$s = plugin name(s)
                    'notice_ask_to_update'            => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this plugin: %1$s.',
                        'The following plugins need to be updated to their latest version to ensure maximum compatibility with this plugin: %1$s.'),
                    // %1$s = plugin name(s)
                    'notice_cannot_update'            => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.',
                        'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.'),
                    // %1$s = plugin name(s)
                    'install_link'                    => _n_noop('Begin installing plugin',
                        'Begin installing plugins'),
                    'activate_link'                   => _n_noop('Activate installed plugin',
                        'Activate installed plugins'),
                    'return'                          => __('Return to Required Plugins Installer', 'lqdm'),
                    'plugin_activated'                => __('Plugin activated successfully.', 'lqdm'),
                    'complete'                        => __('All plugins installed and activated successfully. %s', 'lqdm'),
                    // %1$s = dashboard link
                ),
            );

            tgmpa($plugins, $config);
        }

        /**
         * Activate Liquid Messages Plugin
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
         * Deactivate Liquid Messages Plugin
         *
         * If uninstall routines are added, they should go in uninstall.php
         *
         * @since  0.1.0
         * @return void
         */
        public static function deactivate()
        {
            flush_rewrite_rules();
        }

        /**
         * Init hooks
         *
         * In our case, load the textdomain.
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
                case 'basename':
                case 'url':
                case 'path':
                case 'metaboxes':
                case 'messages':
                case 'taxonomies':
                case 'shortcodes':
                case 'plugin_option_key':
                case 'async':
                    return $this->{$field};
                case 'series':
                case 'speaker':
                case 'topic':
                case 'tag':
                    return $this->taxonomies->{$field};
                default:
                    throw new Exception('Invalid ' . __CLASS__ . ' property: ' . $field);
            }
        }
    }

    /**
     * Grab the Liquid_Messages_Plugin object and return it.
     * Wrapper for Liquid_Messages_Plugin::get_instance()
     *
     * @return Lqd_Messages_Plugin  Singleton instance of plugin class.
     * @since  0.1.0
     */
    function lqd_messages()
    {
        return Lqd_Messages_Plugin::get_instance();
    }

    // Kick it off.
    add_action('plugins_loaded', array(lqd_messages(), 'hooks'));
    register_activation_hook(__FILE__, array('Lqd_Messages_Plugin', 'activate'));
    register_deactivation_hook(__FILE__, array('Lqd_Messages_Plugin', 'deactivate'));

