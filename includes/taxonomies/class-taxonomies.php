<?php
/**
 * Liquid Messages Taxonomies
 *
 * @package Liquid Messages
 */
class LqdM_Taxonomies {

	/**
	 * Instance of Message Series
	 *
	 * @var LqdM_Series
	 */
	protected $series;

	/**
	 * Instance of Message Speaker
	 *
	 * @var LqdM_Speaker
	 */
	protected $speaker;

	/**
	 * Instance of Message Topic
	 *
	 * @var LqdM_Topic
	 */
	protected $topic;

	/**
	 * Instance of Message Tag
	 *
	 * @var LqdM_Tag
	 */
	protected $tag;

	/**
	 * Instance of Message Scripture
	 *
	 * @var LqdM_Scripture
	 */
	protected $scripture;

	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $messages LqdM_Messages object.
	 * @return void
	 */
	public function __construct( $messages ) {
		$this->series    = new LqdM_Series( $messages );
		$this->speaker   = new LqdM_Speaker( $messages );
		$this->topic     = new LqdM_Topic( $messages );
		$this->tag       = new LqdM_Tag( $messages );
		$this->scripture = new LqdM_Scripture( $messages );
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
