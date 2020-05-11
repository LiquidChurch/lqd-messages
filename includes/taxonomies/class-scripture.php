<?php
/**
 * Liquid Messages Scripture References Custom Taxonomy
 *
 * @package Liquid Messages
 */

/**
 * LQDM_Scripture
 * @since 0.1.3
 */
class LQDM_Scripture extends LQDM_Taxonomies_Base {
	/** @var string $id The identifier for this object */
	protected $id = 'scripture';

	/**
	 * Constructor
	 * Register Taxonomy. See documentation in Taxonomy_Core, and in wp-includes/taxonomy.php
	 *
	 * @since 0.1.3
	 * @param  object $sermons LQDM_Sermons object.
	 * @return void
	 */
	public function __construct( $sermons ) {
		parent::__construct( $sermons, array(
			'labels' => array( __( 'Scripture Reference', 'lqdm' ), __( 'Scripture References', 'lqdm' ), 'gcs-scripture' ),
			'args'   => array(
				'rewrite'             => array(
				    'slug' => 'scripture-reference'
                ),
                'show_in_rest'        => true,
                'show_in_graphql'     => true,
                'graphql_single_name' => 'lqdmScripture',
                'graphql_plural_name' => 'lqdmScriptures'
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
