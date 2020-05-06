<?php
/**
 * Liquid Messages Custom Taxonomies
 *
 * @package Liquid Messages
 */

class LQDM_Taxonomies {
	/** @var LQDM_Series $series Instance of LQDM_Series */
	protected $series;

	/** @var LQDM_Speaker $speaker Instance of LQDM_Speaker */
	protected $speaker;

	/** @var LQDM_Topic $topic Instance of LQDM_Topic */
	protected $topic;

	/** @var LQDM_Tag $tag Instance of LQDM_Tag */
	protected $tag;

	/** @var LQDM_Scripture $scripture Instance of LQDM_Scripture */
	protected $scripture;

	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $sermons LQDM_Sermons object.
	 * @return void
	 */
	public function __construct( $sermons ) {
		$this->series    = new LQDM_Series( $sermons );
		$this->speaker   = new LQDM_Speaker( $sermons );
		$this->topic     = new LQDM_Topic( $sermons );
		$this->tag       = new LQDM_Tag( $sermons );
		$this->scripture = new LQDM_Scripture( $sermons );
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
				throw new \RuntimeException( 'Invalid ' . __CLASS__ . ' property: ' . $field );
		}
	}
}
