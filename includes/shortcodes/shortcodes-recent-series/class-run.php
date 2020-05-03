<?php
/**
 * Liquid Messages Recent Series Shortcode
 *
 * @package Liquid Messages
 */

class GCSS_Recent_Series_Run extends GCS_Shortcodes_Run_Base {
	/** @var string $shortcode The shortcode tag */
	public $shortcode = 'gc_recent_series';

	/** @var array $atts_defaults Array of default attributes applied to the shortcode */
	public $atts_defaults = array(
		'sermon_id'          => 0, // 'Blank, "recent", or "0" will play the most recent video.
		'recent'             => 'recent', // Options: 'recent', 'audio', 'video'
		'remove_thumbnail'   => true,
		'thumbnail_size'     => 'medium',

		// No admin
		'remove_description' => true,
		'wrap_classes'       => '',
	);

	/**
	 * Shortcode Output
     *
	 * @throws Exception
	 */
	public function shortcode() {
		$args = array();
		foreach ( $this->atts_defaults as $key => $default_value ) {
			$args[ $key ] = is_bool( $this->atts_defaults[ $key ] )
				? $this->bool_att( $key, $default_value )
				: $this->att( $key, $default_value );
		}

		$args['wrap_classes'] .= ' gc-recent-series';

		return gc_get_sermon_series_info( $this->get_sermon(), $args );
	}

}
