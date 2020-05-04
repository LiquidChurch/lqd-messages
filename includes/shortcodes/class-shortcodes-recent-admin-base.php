<?php
/**
 * Liquid Messages Recent Series Shortcode - Admin
 *
 * @package Liquid Messages
 */
abstract class LQDMS_Recent_Admin_Base extends LQDM_Shortcodes_Admin_Base
{

	/**
	 * Constructor
	 *
     * @since 0.1.0
     *
	 * @param LQDM_Shortcodes_Run_Base  $run  Main plugin object.
	 */
    public function __construct( LQDM_Shortcodes_Run_Base $run)
    {
        parent::__construct($run);

        add_filter("shortcode_button_before_modal_{$this->shortcode}", array($this, 'enqueue_js'));

        // Do this super late.
        add_filter("{$this->shortcode}_shortcode_fields", array($this, 'maybe_remove_recent_attribute'), 100000);
    }

	/**
	 * Enqueue JS
	 */
    public function enqueue_js()
    {
        wp_register_script(
            'lqdm-recent-admin',
            GC_Sermons_Plugin::$url . 'assets/js/lqdm-recent-admin.js',
            array('jquery'),
            GC_Sermons_Plugin::VERSION,
            true
        );
        wp_localize_script('lqdm-recent-admin', 'php_vars', array(
                'postID' => $_GET['post'],
                'nonce' => wp_create_nonce('scripterz-nonce')
            )
        );
        wp_enqueue_script(
            'lqdm-recent-admin'
        );
    }

    /**
     * Removes 'recent' shortcode attribute when it isn't applicable.
     *
     * @since  0.1.3
     *
     * @param  array $updated Array of shortcode attributes.
     *
     * @return array           Modified array of shortcode attributes.
     */
    public function maybe_remove_recent_attribute($updated)
    {

        // If recent is set, but shouldn't be, let's remove it.
        if (isset($updated['recent'], $updated['sermon_id'])) {
            if ($updated['sermon_id'] && '0' !== $updated['sermon_id'] && 0 !== $updated['sermon_id'] && 'recent' !== $updated['sermon_id']) {
                unset($updated['recent']);
            }
        }

        return $updated;
    }
}
