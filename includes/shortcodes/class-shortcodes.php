<?php
/**
 * Liquid Messages Shortcodes
 *
 * @package Liquid Messages
 */

class GCS_Shortcodes {
	/** @var GCS_Shortcodes_Sermons $sermons Instance of GCS_Shortcodes_Sermons */
	protected $sermons;

	/** @var GCS_Shortcodes_Recent_Series $recent_series Instance of GCS_Shortcodes_Recent_Series */
	protected $recent_series;

	/** @var GCS_Shortcodes_Recent_Speaker $recent_speaker Instance of GCS_Shortcodes_Recent_Speaker */
	protected $recent_speaker;

	/** @var GCS_Shortcodes_Video_Player $video_player Instance of GCS_Shortcodes_Video_Player */
	protected $video_player;

	/**
	 * Instance of GCS_Shortcodes_Audio_Player
	 *
	 * @var GCS_Shortcodes_Audio_Player
	 * @since 0.1.4
	 */
	protected $audio_player;

	/** @var GCS_Shortcodes_Sermon_Search $search Instance of GCS_Shortcodes_Sermon_Search */
	protected $search;

	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->sermons        = new GCS_Shortcodes_Sermons( $plugin );
		$this->recent_series  = new GCS_Shortcodes_Recent_Series( $plugin );
		$this->recent_speaker = new GCS_Shortcodes_Recent_Speaker( $plugin );
		$this->series         = new GCS_Shortcodes_Series( $plugin );
		$this->video_player   = new GCS_Shortcodes_Video_Player( $plugin );
		$this->audio_player   = new GCS_Shortcodes_Audio_Player( $plugin );
		$this->search         = new GCS_Shortcodes_Sermon_Search( $plugin );
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
