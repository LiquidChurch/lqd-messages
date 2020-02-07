<?php
/**
 * Liquid Messages Video Player Admin Shortcodes.
 *
 * @version 0.1.3
 *
 * @package GC Sermons
 */
class LqdM_Shortcodes_Video_Player_Admin extends LqdM_Recent_Admin_Base {

    /**
     * Shortcode prefix for field ids.
     *
     * @var   string
     * @since 0.1.3
     */
    protected $prefix = 'lqdm_vidplayer_';

    /**
     * Sets up the button
     *
     * @return array
     */
    function js_button_data() {
        return array(
            'qt_button_text' => __( 'GC Sermon Video Player', 'lqdm' ),
            'button_tooltip' => __( 'GC Sermon Video Player', 'lqdm' ),
            'icon'           => 'dashicons-format-video',
            // 'mceView'        => true, // The future
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
            'name'            => __( 'Sermon ID', 'lqdm' ),
            'desc'            => __( 'Blank, "recent", or "0" will get the most recent sermon\'s video player. Otherwise enter a post ID. Click the magnifying glass to search for a Sermon post.', 'lqdm' ),
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
