<?php
/**
 * Liquid Messages Shortcode Base
 *
 * @package Liquid Messages
 */
abstract class LQDM_Shortcodes_Run_Base extends WDS_Shortcodes {
	/** @var LQDM_Sermons LQDM_Sermons object */
	public $sermons;

	/**
	 * Constructor
	 *
     * @since 0.1.3
     *
	 * @param LQDM_Sermons $sermons
	 */
	public function __construct( LQDM_Sermons $sermons ) {
		$this->sermons = $sermons;
		parent::__construct();
	}

	/**
	 * Get Sermon
	 *
	 * @return mixed
	 * @throws Exception
	 */
	protected function get_sermon() {
		$sermon_id = $this->att( 'sermon_id' );

		if ( ! $sermon_id || $sermon_id === 'recent' || $sermon_id === '0' || $sermon_id === 0 ) {

			$this->shortcode_object->set_att( 'sermon', $this->most_recent_sermon() );

		} elseif ( $sermon_id === 'this' ) {

			$this->shortcode_object->set_att( 'sermon', gc_get_sermon_post( get_queried_object_id() ) );

		} elseif ( is_numeric( $sermon_id ) ) {

			$this->shortcode_object->set_att( 'sermon', gc_get_sermon_post( $sermon_id ) );

		}

		return $this->att( 'sermon' );
	}

	/**
	 * Get most recent sermon
	 *
	 * @return false|LQDM_Sermon_Post
	 * @throws Exception
	 */
	protected function most_recent_sermon() {
		switch ( $this->att( 'recent', 'recent' ) ) {
			case 'audio':
				return $this->sermons->most_recent_with_audio();

			case 'video':
				return $this->sermons->most_recent_with_video();
		}

		return $this->sermons->most_recent();
	}
}
