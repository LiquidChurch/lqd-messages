<?php
/**
 * Liquid Messages Audio Player Shortcode Button
 *
 * @version 0.1.3
 *
 * @package Liquid Messages
 */
class LqdM_Shortcodes_Audio_Player_Admin extends LqdM_Recent_Admin_Base {

    /**
     * Shortcode prefix for field ids.
     *
     * @var   string
     * @since 0.1.3
     */
    protected $prefix = 'lqdm_audio_player_';

    /**
     * Sets up the TinyMCE/Quicktags Button
     *
     * @return array
     */
    function js_button_data() {
        return array(
            'qt_button_text' => __( 'Message Audio Player', 'lqdm' ),
            'button_tooltip' => __( 'Message Audio Player', 'lqdm' ),
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
            'name'            => __( 'Message ID', 'lqdm' ),
            'desc'            => __( 'Blank, "recent", or "0" will get the most recent message\'s audio player. Otherwise enter a post ID. Click the magnifying glass to search for a Message post.', 'lqdm' ),
            'id'              => $this->prefix . 'message_id',
            'type'            => 'post_search_text',
            'post_type'       => $this->run->messages->post_type(),
            'select_type'     => 'radio',
            'select_behavior' => 'replace',
            'row_classes'     => 'check-if-recent',
        );

        return $fields;
    }
}
