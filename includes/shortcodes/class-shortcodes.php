<?php
/**
 * Liquid Messages Shortcodes
 *
 * @package Liquid Messages
 */
class LqdM_Shortcodes {

	/**
	 * Instance of Play Button Shortcode
	 *
	 * @var LqdM_Shortcodes_Play_Button
	 * @since 0.1.0
	 */
	protected $play_button;

	/**
	 * Instance of Messages Shortcode
	 *
	 * @var LqdM_Shortcodes_Messages
	 * @since 0.1.4
	 */
	protected $messages;

	/**
	 * Instance of Recent Series Shortcode
	 *
	 * @var LqdM_Shortcodes_Recent_Series
	 * @since 0.1.4
	 */
	protected $recent_series;

	/**
	 * Instance of Recent Speaker Shortcode
	 *
	 * @var LqdM_Shortcodes_Recent_Speaker
	 * @since 0.1.4
	 */
	protected $recent_speaker;

	/**
	 * Instance of Video Player Shortcode
	 *
	 * @var LqdM_Shortcodes_Video_Player
	 * @since 0.1.4
	 */
	protected $video_player;

	/**
	 * Instance of Audio Player Shortcode
	 *
	 * @var LqdM_Shortcodes_Audio_Player
	 * @since 0.1.4
	 */
	protected $audio_player;

	/**
	 * Instance of Message Search Shortcode
	 *
	 * @var LqdM_Shortcodes_Message_Search
	 * @since 0.1.5
	 */
	protected $search;

    /**
     * Instance of Resources Shortcode
     *
     * @var LqdM_Shortcodes_Resources
     */
    protected $resources;

    /**
     * Instances of Series Shortcode
     *
     * @var LqdM_Shortcodes_Series
     */
    protected $series;

	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->play_button    = new LqdM_Shortcodes_Play_Button( $plugin );
		$this->messages       = new LqdM_Shortcodes_Messages( $plugin );
		$this->recent_series  = new LqdM_Shortcodes_Recent_Series( $plugin );
		$this->recent_speaker = new LqdM_Shortcodes_Recent_Speaker( $plugin );
		$this->series         = new LqdM_Shortcodes_Series( $plugin );
		$this->video_player   = new LqdM_Shortcodes_Video_Player( $plugin );
		$this->audio_player   = new LqdM_Shortcodes_Audio_Player( $plugin );
		$this->search         = new LqdM_Shortcodes_Message_Search( $plugin );
		$this->resources      = new LqdM_Shortcodes_Resources( $plugin );
	}

	/**
	 * Magic getter for our object. Allows getting but not setting.
	 *
	 * @param string $field
	 * @throws Exception Throws an exception if the field is invalid.
	 * @return mixed
	 */
	public function __get( $field ) {
		return $this->{$field};
	}
}
