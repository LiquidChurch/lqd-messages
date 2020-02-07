<?php
/**
 * Liquid Messages Topics Taxonomy
 *
 * @package Liquid Messages
 */

class LqdM_Topic extends LqdM_Taxonomies_Base {

	/**
	 * The identifier for this object
	 *
	 * @var string
	 */
	protected $id = 'topic';

	/**
	 * Constructor
	 * Register Taxonomy. See documentation in Taxonomy_Core, and in wp-includes/taxonomy.php
	 *
	 * @since 0.1.0
	 * @param  object $messages LqdM_Messages object.
	 * @return void
	 */
	public function __construct( $messages ) {
		parent::__construct( $messages, array(
			'labels' => array( __( 'Topic', 'lqdm' ), __( 'Topics', 'lqdm' ), 'lqdm-topic' ),
			'args' => array(
				'rewrite' => array( 'slug' => 'message-topic' ), // TODO: Rewrite to topic?
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
