<?php
/**
 * Liquid Messages Recent Speaker Shortcode
 *
 * @package Liquid Messages
 */

class LQDMS_Recent_Speaker_Run extends LQDM_Shortcodes_Run_Base {
	/** @var string $shortcode The shortcode tag */
	public $shortcode = 'gc_recent_speaker';

	/** @var array Array of default attributes applied to the shortcode */
	public $atts_defaults = array(
		'sermon_id'        => 0, // 'Blank, "recent", or "0" will play the most recent video.
		'recent'           => 'recent', // Options: 'recent', 'audio', 'video'
		'remove_thumbnail' => false,
		'thumbnail_size'   => 'medium',
	);

	/**
	 * Shortcode Output
	 * @throws Exception
	 */
	public function shortcode() {
        return gc_get_sermon_speaker_info( $this->get_sermon(), ! $this->bool_att( 'remove_thumbnail' ) );
	}

}
