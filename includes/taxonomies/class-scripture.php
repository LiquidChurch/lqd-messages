<?php
/**
 * Liquid Messages Scripture References Custom Taxonomy
 *
 * @package Liquid Messages
 */

class GCS_Scripture extends GCS_Taxonomies_Base {

	// Identifier for this object
	protected $id = 'scripture';

	/**
	 * Constructor
	 * Register Taxonomy. See documentation in Taxonomy_Core, and in wp-includes/taxonomy.php
	 *
	 * @since 0.1.3
	 * @param  object $sermons GCS_Sermons object.
	 * @return void
	 */
	public function __construct( $sermons ) {
		parent::__construct( $sermons, array(
			'labels' => array( __( 'Scripture Reference', 'lqdm' ), __( 'Scripture References', 'lqdm' ), 'gcs-scripture' ),
			'args' => array(
				'rewrite' => array( 'slug' => 'scripture-reference' ),
			),
		) );
	}

	/**
	 * Initiate our hooks
	 *
	 * @since 0.1.3
	 * @return void
	 */
	public function hooks() {
	}
}
