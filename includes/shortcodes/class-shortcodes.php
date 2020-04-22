<?php
/**
 * Liquid Messages Shortcodes
 *
 * @package Liquid Messages
 */

class GCS_Shortcodes {

	// Instance of GCS_Shortcodes_Sermons
	protected $sermons;

	// Instance of GCS_Shortcodes_Recent_Series
	protected $recent_series;

	// Instance of GCS_Shortcodes_Recent_Speaker
	protected $recent_speaker;

	// Instance of GCS_Series
	protected $series;

	// Instance of GCS_Shortcodes_Sermon_Search
	protected $search;

	// Instance of GCS_Shortcodes_Resources
	protected $resources;

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
		$this->search         = new GCS_Shortcodes_Sermon_Search( $plugin );
		$this->resources      = new GCS_Shortcodes_Resources( $plugin );
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
