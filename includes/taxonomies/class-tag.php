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
     *
	 * Register Taxonomy.
     *
     * See documentation in Taxonomy_Core, and in wp-includes/taxonomy.php
	 *
	 * @since 0.1.0
	 * @param  object $messages LqdM_Messages object.
	 * @return void
	 */
	public function __construct( $messages ) {
		parent::__construct( $messages, array(
			'labels' => array( __( 'Tag', 'lqdm' ), __( 'Tags', 'lqdm' ), 'lqdm-tag' ),
			'args'   => array(
				'hierarchical' => false,
				'rewrite' => array( 'slug' => 'message-tag' ),  // TODO: Rewrite to tag?
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
