<?php
/**
 * Liquid Messages Shortcodes
 *
 * @package GC Sermons
 */
class LqdM_Shortcodes {

	/**
	 * Instance of GCS_Shortcodes_Play_Button
	 *
	 * @var LqdM_Shortcodes_Play_Button
	 * @since 0.1.0
	 */
	protected $play_button;

	/**
	 * Instance of GCS_Shortcodes_Sermons
	 *
	 * @var LqdM_Shortcodes_Sermons
	 * @since 0.1.4
	 */
	protected $sermons;

	/**
	 * Instance of GCS_Shortcodes_Recent_Series
	 *
	 * @var LqdM_Shortcodes_Recent_Series
	 * @since 0.1.4
	 */
	protected $recent_series;

	/**
	 * Instance of GCS_Shortcodes_Recent_Speaker
	 *
	 * @var LqdM_Shortcodes_Recent_Speaker
	 * @since 0.1.4
	 */
	protected $recent_speaker;

	/**
	 * Instance of GCS_Shortcodes_Video_Player
	 *
	 * @var LqdM_Shortcodes_Video_Player
	 * @since 0.1.4
	 */
	protected $video_player;

	/**
	 * Instance of GCS_Shortcodes_Audio_Player
	 *
	 * @var LqdM_Shortcodes_Audio_Player
	 * @since 0.1.4
	 */
	protected $audio_player;

	/**
	 * Instance of GCS_Shortcodes_Sermon_Search
	 *
	 * @var LqdM_Shortcodes_Sermon_Search
	 * @since 0.1.5
	 */
	protected $search;

    /**
     * Instance of GCS_Shortcodes_Resources
     *
     * @var LqdM_Shortcodes_Resources
     */
    protected $resources;

    /**
     * Instances of GCS_Shortcodes_Series
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
		$this->sermons        = new LqdM_Shortcodes_Sermons( $plugin );
		$this->recent_series  = new LqdM_Shortcodes_Recent_Series( $plugin );
		$this->recent_speaker = new LqdM_Shortcodes_Recent_Speaker( $plugin );
		$this->series         = new LqdM_Shortcodes_Series( $plugin );
		$this->video_player   = new LqdM_Shortcodes_Video_Player( $plugin );
		$this->audio_player   = new LqdM_Shortcodes_Audio_Player( $plugin );
		$this->search         = new LqdM_Shortcodes_Sermon_Search( $plugin );
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
