<?php
/**
 * Liquid Messages Video Player Shortcode
 * @version 0.1.6
 * @package Liquid Messages
 */

class LQDM_Shortcodes_Video_Player extends LQDM_Shortcodes_Base {

	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->run   = new LQDM_Shortcodes_Video_Player_Run( $plugin->sermons );
		$this->admin = new LQDM_Shortcodes_Video_Player_Admin( $this->run );

		parent::hooks();
	}

}

/**
 * Liquid Messages Video Player Shortcode
 *
 * @version 0.1.3
 * @package Liquid Messages
 */
class LQDM_Shortcodes_Video_Player_Run extends LQDM_Shortcodes_Run_Base {

	/**
	 * The Shortcode Tag
	 * @var string
	 * @since 0.1.0
	 */
	public $shortcode = 'gc_video_player';

	/**
	 * Default attributes applied to the shortcode.
	 * @var array
	 * @since 0.1.0
	 */
	public $atts_defaults = array(
		'sermon_id' => 0, // 'Blank, "recent", or "0" will play the most recent video.
	);

	/**
	 * Shortcode Output
	 *
	 * @throws Exception
	 */
	public function shortcode() {
		return gc_get_sermon_video_player( $this->get_sermon() );
	}

}

/**
 * Liquid Messages Video Player Shortcode - Admin
 * @version 0.1.3
 * @package Liquid Messages
 */
class LQDM_Shortcodes_Video_Player_Admin extends LQDMS_Recent_Admin_Base {

	/**
	 * Shortcode prefix for field ids.
	 *
	 * @var   string
	 * @since 0.1.3
	 */
	protected $prefix = 'gc_vidplayer_';

	/**
	 * Sets up the button
	 *
	 * @return array
	 */
	public function js_button_data() {
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
	public function fields( $fields, $button_data ) {

		$fields[] = array(
			'name'            => __( 'Sermon ID', 'lqdm' ),
			'desc'            => __( 'Blank, "recent", or "0" will get the most recent message\'s video player. Otherwise enter a message ID. Click the magnifying glass to search for a message.', 'lqdm' ),
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
