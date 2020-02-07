<?php
/**
 * Liquid Messages Scripture References Taxonomy
 *
 * @package Liquid Messages
 */
class LqdM_Scripture extends LqdM_Taxonomies_Base {

	/**
	 * The identifier for this object
	 *
	 * @var string
	 */
	protected $id = 'scripture';

	/**
	 * Constructor
     *
	 * Register Taxonomy.
     *
     * See documentation in Taxonomy_Core, and in wp-includes/taxonomy.php
	 *
	 * @since 0.1.3
	 * @param  object $messages LqdM_Messages object.
	 * @return void
	 */
	public function __construct( $messages ) {
		parent::__construct( $messages, array(
			'labels' => array( __( 'Scripture Reference', 'lqdm' ), __( 'Scripture References', 'lqdm' ), 'lqdm-scripture' ),
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
