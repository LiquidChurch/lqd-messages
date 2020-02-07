<?php
/**
 *  GC Sermons Shortcodes Recent Sermon.
 *
 * @since 0.10.0
 * @package GC Sermons
 */
class LqdM_Shortcodes_Recent_Sermon extends LqdM_Shortcodes_Base
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
        $this->run   = new LqdM_Shortcodes_Recent_Sermon_Run( $plugin->sermons );
        $this->admin = new LqdM_Shortcodes_Recent_Sermon_Admin( $this->run );

        parent::hooks();

    }

}
