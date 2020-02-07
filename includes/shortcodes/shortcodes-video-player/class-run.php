<?php
/**
 * Liquid Messages Video Player Shortcode - Run.
 *
 * @version 0.1.3
 * @package Liquid Messages
 */
class LqdM_Shortcodes_Video_Player_Run extends LqdM_Shortcodes_Run_Base {

    /**
     * The Shortcode Tag
     * @var string
     * @since 0.1.0
     */
    public $shortcode = 'lqdm_video_player';

    /**
     * Default attributes applied to the shortcode.
     * @var array
     * @since 0.1.0
     */
    public $atts_defaults = array(
        'message_id' => 0, // 'Blank, "recent", or "0" will play the most recent video.
    );

    /**
     * Shortcode Output
     *
     * @throws Exception
     */
    public function shortcode() {
        return lqdm_get_message_video_player( $this->get_message() );
    }

}
