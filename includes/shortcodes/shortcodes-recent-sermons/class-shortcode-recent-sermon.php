<?php
    /**
     *  GC Sermons Recent Sermon Shortcodes
     *
     * @since   0.10.0
     * @package  GC Sermons
     */

    /**
     *  GC Sermons Shortcodes Recent Sermon.
     *
     * @since 0.10.0
     */
    class GCS_Shortcodes_Recent_Sermon extends GCS_Shortcodes_Base
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
            $this->run   = new GCS_Shortcodes_Recent_Sermon_Run( $plugin->sermons );
            $this->admin = new GCS_Shortcodes_Recent_Sermon_Admin( $this->run );

            parent::hooks();

        }

    }
