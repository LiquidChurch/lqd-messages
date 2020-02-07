<?php
/**
 * Liquid Messages Shortcodes Base - Run
 *
 * @package Liquid Messages
 */
abstract class LqdM_Shortcodes_Run_Base extends WDS_Shortcodes {

	/**
	 * LqdM_Messages object
	 *
	 * @var   LqdM_Messages
	 * @since 0.1.0
	 */
	public $messages;

	/**
	 * Constructor
	 *
	 * @param LqdM_Messages $messages
     *
     * @since 0.1.3
	 *
	 */
	public function __construct( LqdM_Messages $messages ) {
		$this->messages = $messages;
		parent::__construct();
	}

	/**
	 * Get Message
	 *
	 * @return mixed
	 * @throws Exception
	 */
	protected function get_message() {
		$message_id = $this->att( 'message_id' );

		if ( ! $message_id || 'recent' === $message_id || '0' === $message_id || 0 === $message_id ) {

			$this->shortcode_object->set_att( 'message', $this->most_recent_message() );

		} elseif ( 'this' === $message_id ) {

			$this->shortcode_object->set_att( 'message', lqdm_get_message_post( get_queried_object_id() ) );

		} elseif ( is_numeric( $message_id ) ) {

			$this->shortcode_object->set_att( 'message', lqdm_get_message_post( $message_id ) );

		}

		return $this->att( 'message' );
	}

	/**
	 * Get most recent message
	 *
	 * @return false|LqdM_Message_Post
	 * @throws Exception
	 */
	protected function most_recent_message() {
		switch ( $this->att( 'recent', 'recent' ) ) {
			case 'audio':
				return $this->messages->most_recent_with_audio();

			case 'video':
				return $this->messages->most_recent_with_video();
		}

		return $this->messages->most_recent();
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

		return array( $style, $has_icon_font_size );
	}

}
