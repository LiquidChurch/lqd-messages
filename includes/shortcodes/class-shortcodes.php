<?php
/**
 * Liquid Messages Shortcodes
 *
 * @package Liquid Messages
 */

class LQDM_Shortcodes {
	/** @var LQDM_Shortcodes_Sermons $sermons Instance of LQDM_Shortcodes_Sermons */
	protected $sermons;

	/** @var LQDM_Shortcodes_Recent_Series $recent_series Instance of LQDM_Shortcodes_Recent_Series */
	protected $recent_series;

	/** @var LQDM_Shortcodes_Recent_Speaker $recent_speaker Instance of LQDM_Shortcodes_Recent_Speaker */
	protected $recent_speaker;

	/** @var LQDM_Shortcodes_Video_Player $video_player Instance of LQDM_Shortcodes_Video_Player */
	protected $video_player;

	/** @var LQDM_Shortcodes_Audio_Player $audio_player Instance of LQDM_Shortcodes_Audio_Player */
	protected $audio_player;

	/** @var LQDM_Series $series Instance of LQDM_Series */
    protected $series;

	/** @var LQDM_Shortcodes_Sermon_Search $search Instance of LQDM_Shortcodes_Sermon_Search */
	protected $search;

	/** @var LQDM_Shortcodes_Resources $resources Instance of LQDM_Shortcodes_Resources */
    protected $resources;

	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->sermons        = new LQDM_Shortcodes_Sermons( $plugin );
		$this->recent_series  = new LQDM_Shortcodes_Recent_Series( $plugin );
		$this->recent_speaker = new LQDM_Shortcodes_Recent_Speaker( $plugin );
		$this->series         = new LQDM_Shortcodes_Series( $plugin );
		$this->video_player   = new LQDM_Shortcodes_Video_Player( $plugin );
		$this->audio_player   = new LQDM_Shortcodes_Audio_Player( $plugin );
		$this->search         = new LQDM_Shortcodes_Sermon_Search( $plugin );
		$this->resources      = new LQDM_Shortcodes_Resources( $plugin );
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
