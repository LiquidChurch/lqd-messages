<?php
/**
 * Liquid Messages Tags Custom Taxonomy
 *
 * @package Liquid Messages
 */

class GCS_Tag extends GCS_Taxonomies_Base {
	/** @var string $id The identifier for this object */
	protected $id = 'tag';

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
			'labels' => array( __( 'Tag', 'lqdm' ), __( 'Tags', 'lqdm' ), 'gcs-tag' ),
			'args'   => array(
				'hierarchical' => false,
				'rewrite' => array( 'slug' => 'sermon-tag' ),
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
