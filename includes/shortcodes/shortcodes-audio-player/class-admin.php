<?php
/**
 * Liquid Messages Audio Player Shortcode Button
 *
 * @version 0.1.3
 *
 * @package GC Sermons
 */
class GCS_Shortcodes_Audio_Player_Admin extends GCSS_Recent_Admin_Base {

    /**
     * Shortcode prefix for field ids.
     *
     * @var   string
     * @since 0.1.3
     */
    protected $prefix = 'gc_audplayer_';

    /**
     * Sets up the TinyMCE/Quicktags Button
     *
     * @return array
     */
    function js_button_data() {
        return array(
            'qt_button_text' => __( 'GC Sermon Audio Player', 'gc-sermons' ),
            'button_tooltip' => __( 'GC Sermon Audio Player', 'gc-sermons' ),
            'icon'           => 'dashicons-format-audio'
        );
    }

    /**
     * Adds fields to the button modal using CMB2
     *
     * @param $fields
     * @param $button_data
     *
     * @return array
     */
    function fields( $fields, $button_data ) {

        $fields[] = array(
            'name'            => __( 'Sermon ID', 'gc-sermons' ),
            'desc'            => __( 'Blank, "recent", or "0" will get the most recent sermon\'s audio player. Otherwise enter a post ID. Click the magnifying glass to search for a Sermon post.', 'gc-sermons' ),
            'id'              => $this->prefix . 'sermon_id',
            'type'            => 'post_search_text',
            'post_type'       => $this->run->sermons->post_type(),
            'select_type'     => 'radio',
            'select_behavior' => 'replace',
            'row_classes'     => 'check-if-recent',
        );

        return $fields;
    }
}
