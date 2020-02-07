<?php
    /**
     *  GC Sermons Shortcodes Sermon.
     *
     * @since 0.11.0
     * @package GC Sermons
     */
    class LqdM_Shortcodes_Sermon extends LqdM_Shortcodes_Base
    {

        /**
         * Constructor
         *
         * @since  0.11.0
         * @param  object $plugin Main plugin object.
         * @return void
         */
        public function __construct($plugin)
        {
            $this->run   = new LqdM_Shortcodes_Sermon_Run( $plugin->sermons );
            $this->admin = new LqdM_Shortcodes_Sermon_Admin( $this->run );

            parent::hooks();

        }

    }
