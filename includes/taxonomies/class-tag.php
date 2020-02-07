<?php
/**
 * Liquid Messages Tags Taxonomy
 *
 * @package Liquid Messages
 */

class LqdM_Tag extends LqdM_Taxonomies_Base {

	/**
	 * The identifier for this object
	 *
	 * @var string
	 */
	protected $id = 'tag';

	/**
	 * Constructor
	 * Register Taxonomy. See documentation in Taxonomy_Core, and in wp-includes/taxonomy.php
	 *
	 * @since 0.1.0
	 * @param  object $sermons Messages object.
	 * @return void
	 */
	public function __construct( $sermons ) {
		parent::__construct( $sermons, [
			'labels' => [ __( 'Tag', 'lqdm' ), __( 'Tags', 'lqdm' ), 'lqdm-tag' ],
			'args'   => [
				'hierarchical' => false,
				'rewrite' => [ 'slug' => 'sermon-tag' ],
            ],
        ] );
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
