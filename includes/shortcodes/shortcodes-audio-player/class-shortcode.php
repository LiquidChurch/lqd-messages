<?php
/**
 * Liquid Messages Audio Player Shortcode
 * @version 0.1.6
 * @package Liquid Messages
 */
class LQDM_Shortcodes_Audio_Player extends LQDM_Shortcodes_Base {

	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->run   = new LQDM_Shortcodes_Audio_Player_Run( $plugin->sermons );
		$this->admin = new LQDM_Shortcodes_Audio_Player_Admin( $this->run );

		parent::hooks();
	}

}

/**
 * Liquid Messages Audio Player Shortcode
 *
 * @version 0.1.3
 * @package Liquid Messages
 */
class LQDM_Shortcodes_Audio_Player_Run extends LQDM_Shortcodes_Run_Base {
	/** @var string $shortcode The shortcode tag */
	public $shortcode = 'gc_audio_player';

	/** @var int[] $atts_defaults Array of default attributes applied to the shortcode. */
	public $atts_defaults = array(
		'sermon_id' => 0, // 'Blank, "recent", or "0" will play the most recent audio.
	);

	/**
	 * Shortcode Output
	 *
	 * @throws Exception
	 */
	public function shortcode() {
		return gc_get_sermon_audio_player( $this->get_sermon() );
	}

}


/**
 * Liquid Messages Audio Player Shortcode - Admin
 * @version 0.1.3
 * @package Liquid Messages
 */
class LQDM_Shortcodes_Audio_Player_Admin extends LQDMS_Recent_Admin_Base {
	/** @var string $prefix Shortcode prefix for field ids. */
	protected $prefix = 'gc_audplayer_';

	/**
	 * Sets up the button
	 *
	 * @return array
	 */
	function js_button_data() {
		return array(
			'qt_button_text' => __( 'GC Sermon Audio Player', 'lqdm' ),
			'button_tooltip' => __( 'GC Sermon Audio Player', 'lqdm' ),
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
			'name'            => __( 'Sermon ID', 'lqdm' ),
			'desc'            => __( 'Blank, "recent", or "0" will get the most recent sermon\'s audio player. Otherwise enter a post ID. Click the magnifying glass to search for a Sermon post.', 'lqdm' ),
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
