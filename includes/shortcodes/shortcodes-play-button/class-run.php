<?php
/**
 * Liquid Messages Play Button Shortcodes Run.
 *
 * @todo Add overlay/video popup JS, etc
 * @todo Use dashicons as fallback.
 *
 * @package Liquid Messages
 */
class LqdM_Play_Button_Run extends LqdM_Shortcodes_Run_Base {

	/**
	 * The Shortcode Tag
	 * @var string
	 * @since 0.1.0
	 */
	public $shortcode = 'lqdm_play_button';

	/**
	 * Default attributes applied to the shortcode.
	 * @var array
	 * @since 0.1.0
	 */
	public $atts_defaults = [
		'sermon_id'  => 0,
		'icon_color' => '#000000',
		'icon_size'  => 'large',
		'icon_class' => 'fa-youtube-play',

		// no admin
		'do_scripts' => true,
    ];

	/**
	 * Shortcode Output
	 */
	public function shortcode() {

		$sermon = $this->get_sermon();

		if ( ! $sermon || ! isset( $sermon->ID ) ) {
			return apply_filters( 'lqdm_play_button_shortcode_output', LqdM_Template_Loader::get_template( 'play-button-shortcode-not-found' ), $this );
		}

		if ( $this->att( 'do_scripts' ) ) {
			$this->do_scripts();
		}

		$output = LqdM_Style_Loader::get_template( 'play-button-shortcode-style' );

		list( $style, $has_icon_font_size ) = $this->get_inline_styles();

		$output .= apply_filters( 'lqdm_play_button_shortcode_output', LqdM_Template_Loader::get_template(
			'play-button-shortcode',
			[
				// Get our extra_class attribute
				'extra_classes' => $this->get_extra_classes( $has_icon_font_size ),
				'sermon_id'    => $sermon->ID,
				'style'         => $style,
				'video_url'     => get_post_meta( $sermon->ID, 'lqdm_video_url', 1 ),
            ]
		), $this );

		return $output;
	}

	/**
	 * Get most Recent Sermon
	 *
	 * @return false|LqdM_Message_Post
	 * @throws Exception
	 */
	protected function most_recent_sermon() {
		return $this->sermons->most_recent_with_video();
	}

	/**
	 * Get inline styles
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

	/**
	 * Get extra classes
	 *
	 * @param bool $has_icon_font_size
	 *
	 * @return string
	 */
	public function get_extra_classes( $has_icon_font_size = false ) {
		$classes = ' ' . implode( ' ', array_map( 'esc_attr', explode( ' ', $this->att( 'icon_class' ) ) ) );

		if ( ! $has_icon_font_size ) {
			$classes .= ' icon-size-' . esc_attr( $this->att( 'icon_size', 'large' ) );
		}

		return $classes;
	}

	/**
	 * Do Scripts
	 */
	public function do_scripts() {

		// Enqueue whatever version of fontawesome that's registered (if it is registered)
		wp_enqueue_style( 'qode_font_awesome-css' );
		wp_enqueue_style( 'font_awesome' );
		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'fontawesome' );

		add_action( 'wp_footer', [ $this, 'video_modal' ] );

		wp_enqueue_script(
			'fitvids',
            Lqd_Messages_Plugin::$url . 'assets/js/vendor/jquery.fitvids.js',
			[ 'jquery' ],
			'1.1',
			true
		);

		wp_enqueue_script(
			'lqdm-videos',
            Lqd_Messages_Plugin::$url . 'assets/js/lqdm-videos.js',
			[ 'fitvids' ],
			Lqd_Messages_Plugin::VERSION,
			true
		);
	}

	/**
	 * Video Modal
	 *
	 * @throws Exception
	 */
	public function video_modal() {
		static $done;

		// Get shortcode instances
		$shortcodes = WDS_Shortcode_Instances::get( $this->shortcode );

		if ( $done || empty( $shortcodes ) ) {
			return;
		}

		$videos = [];
		foreach ( $shortcodes as $shortcode ) {
			// Check for found sermons
			if ( ! ( $sermon = $shortcode->att( 'sermon' ) ) ) {
				continue;
			}

			// Check for video player
			if ( ! ( $player = $sermon->get_video_player() ) ) {
				return;
			}

			// Ok, add the video player
			$videos[ $sermon->ID ] = $player;
		}

		if ( ! empty( $videos ) ) {
			echo new LqdM_Template_Loader( 'play-button-shortcode-modal-videos', [
				'videos' => $videos,
            ] );
		}

		$done = true;
	}

}
