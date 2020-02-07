<?php
/**
 * Liquid Messages Recent Series Shortcode - Run
 *
 * @package Liquid Messages
 */
class LqdM_Recent_Series_Run extends LqdM_Shortcodes_Run_Base {

	/**
	 * The Shortcode Tag
	 * @var string
	 * @since 0.1.0
	 */
	public $shortcode = 'lqdm_recent_series';

	/**
	 * Default attributes applied to the shortcode.
	 * @var array
	 * @since 0.1.0
	 */
	public $atts_defaults = [
		'sermon_id'          => 0, // 'Blank, "recent", or "0" will play the most recent video.
		'recent'             => 'recent', // Options: 'recent', 'audio', 'video'
		'remove_thumbnail'   => true,
		'thumbnail_size'     => 'medium',

		// No admin
		'remove_description' => true,
		'wrap_classes'       => '',
    ];

	/**
	 * Shortcode Output
     *
	 * @throws Exception
	 */
	public function shortcode() {
		$args = [];
		foreach ( $this->atts_defaults as $key => $default_value ) {
			$args[ $key ] = is_bool( $this->atts_defaults[ $key ] )
				? $this->bool_att( $key, $default_value )
				: $this->att( $key, $default_value );
		}

		$args['wrap_classes'] .= ' lqdm-recent-series';

		return lqdm_get_sermon_series_info( $this->get_sermon(), $args );
	}

}
