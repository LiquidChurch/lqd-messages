<?php
/**
 * Liquid Messages Topic Custom Taxonomy
 *
 * @package Liquid Messages
 */

class LQDM_Topic extends LQDM_Taxonomies_Base {
	/** @var string $id The identifier for this object */
	protected $id = 'topic';

	/**
	 * Constructor
	 * Register Taxonomy. See documentation in Taxonomy_Core, and in wp-includes/taxonomy.php
	 *
	 * @since 0.1.0
	 * @param  object $sermons LQDM_Sermons object.
	 * @return void
	 */
	public function __construct( $sermons ) {
		parent::__construct( $sermons, array(
			'labels' => array( __( 'Topic', 'lqdm' ), __( 'Topics', 'lqdm' ), 'gcs-topic' ),
			'args' => array(
				'rewrite' => array( 'slug' => 'message-topic' ),
			),
            'show_in_rest' => true,
            'show_in_graphql' => true,
            'graphql_single_name' => 'lqdmTopic',
            'graphql_plural_name' => 'lqdmTopics'
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
