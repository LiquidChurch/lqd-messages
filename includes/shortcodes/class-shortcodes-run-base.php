<?php
/**
 * Liquid Messages Shortcodes Base
 *
 * @package Liquid Messages
 */
abstract class LqdM_Shortcodes_Run_Base extends WDS_Shortcodes {

	/**
	 * Liquid Messages object
	 *
	 * @var   LqdM_Messages
	 * @since 0.1.0
	 */
	public $sermons;

	/**
	 * Constructor
	 *
	 * @param LqdM_Messages $sermons
     *
     * @since 0.1.3
	 *
	 */
	public function __construct( LqdM_Messages $sermons ) {
		$this->sermons = $sermons;
		parent::__construct();
	}

	/**
	 * Get Sermon
	 *
	 * @return mixed
	 * @throws Exception
	 */
	protected function get_sermon() {
		$sermon_id = $this->att( 'sermon_id' );

		if ( ! $sermon_id || 'recent' === $sermon_id || '0' === $sermon_id || 0 === $sermon_id ) {

			$this->shortcode_object->set_att( 'sermon', $this->most_recent_sermon() );

		} elseif ( 'this' === $sermon_id ) {

			$this->shortcode_object->set_att( 'sermon', lqdm_get_sermon_post( get_queried_object_id() ) );

		} elseif ( is_numeric( $sermon_id ) ) {

			$this->shortcode_object->set_att( 'sermon', lqdm_get_sermon_post( $sermon_id ) );

		}

		return $this->att( 'sermon' );
	}

	/**
	 * Get most recent sermon
	 *
	 * @return false|LqdM_Message_Post
	 * @throws Exception
	 */
	protected function most_recent_sermon() {
		switch ( $this->att( 'recent', 'recent' ) ) {
			case 'audio':
				return $this->sermons->most_recent_with_audio();

			case 'video':
				return $this->sermons->most_recent_with_video();
		}

		return $this->sermons->most_recent();
	}

	/**
	 * Get Inline Styles
	 *
	 * @return array
	 */
	public function get_inline_styles() {
		$style = '';
		$has_icon_font_size = false;

		if ( $this->att( 'icon_color' ) || $this->att( 'icon_size' ) ) {
			$style = ' style="';
			// Get/check our text_color attribute
			if ( $this->att( 'icon_color' ) ) {
				$text_color = sanitize_text_field( $this->att( 'icon_color' ) );
				$style .= 'color: ' . $text_color .';';
			}
			if ( is_numeric( $this->att( 'icon_size' ) ) ) {
				$has_icon_font_size = absint( $this->att( 'icon_size' ) );
				$style .= 'font-size: ' . $has_icon_font_size .'em;';
			}
			$style .= '"';
		}

		return [ $style, $has_icon_font_size ];
	}

}
