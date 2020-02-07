<?php
/**
 *  Liquid Messages Recent Message Shortcode.
 *
 * @since 0.10.0
 * @package Liquid Messages
 */
class LqdM_Shortcodes_Recent_Message extends LqdM_Shortcodes_Base
{
    /**
     * Constructor
     *
     * @since  0.10.0
     * @param  object $plugin Main plugin object.
     * @return void
     */
    public function __construct($plugin)
    {
        $this->run   = new LqdM_Shortcodes_Recent_Message_Run( $plugin->messages );
        $this->admin = new LqdM_Shortcodes_Recent_Message_Admin( $this->run );

        parent::hooks();

    }

}
