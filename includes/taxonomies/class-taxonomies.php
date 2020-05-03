<?php
/**
 * Liquid Messages Custom Taxonomies
 *
 * @package Liquid Messages
 */

class GCS_Taxonomies {
	/** @var GCS_Series $series Instance of GCS_Series */
	protected $series;

	/** @var GCS_Speaker $speaker Instance of GCS_Speaker */
	protected $speaker;

	/** @var GCS_Topic $topic Instance of GCS_Topic */
	protected $topic;

	/** @var GCS_Tag $tag Instance of GCS_Tag */
	protected $tag;

	/** @var GCS_Scripture $scripture Instance of GCS_Scripture */
	protected $scripture;

	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $sermons GCS_Sermons object.
	 * @return void
	 */
	public function __construct( $sermons ) {
		$this->series    = new GCS_Series( $sermons );
		$this->speaker   = new GCS_Speaker( $sermons );
		$this->topic     = new GCS_Topic( $sermons );
		$this->tag       = new GCS_Tag( $sermons );
		$this->scripture = new GCS_Scripture( $sermons );
	}

	/**
	 * Magic getter for our object. Allows getting but not setting.
	 *
	 * @param string $field
	 * @throws Exception Throws an exception if the field is invalid.
	 * @return mixed
	 */
	public function __get( $field ) {
		switch ( $field ) {
			case 'series':
			case 'speaker':
			case 'topic':
			case 'tag':
			case 'scripture':
				return $this->{$field};
			default:
				throw new Exception( 'Invalid ' . __CLASS__ . ' property: ' . $field );
		}
	}
}
