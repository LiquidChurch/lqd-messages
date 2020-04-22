<?php
/**
 * Liquid Messages Topic Custom Taxonomy
 *
 * @package Liquid Messages
 */

class GCS_Topic extends GCS_Taxonomies_Base {

	// Identifier for this object
	protected $id = 'topic';

	/**
	 * Constructor
	 * Register Taxonomy. See documentation in Taxonomy_Core, and in wp-includes/taxonomy.php
	 *
	 * @since 0.1.0
	 * @param  object $sermons GCS_Sermons object.
	 * @return void
	 */
	public function __construct( $sermons ) {
		parent::__construct( $sermons, array(
			'labels' => array( __( 'Topic', 'lqdm' ), __( 'Topics', 'lqdm' ), 'gcs-topic' ),
			'args' => array(
				'rewrite' => array( 'slug' => 'sermon-topic' ),
			),
		) );
	}

	/**
	 * Initiate our hooks
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function hooks() {
	}
}
