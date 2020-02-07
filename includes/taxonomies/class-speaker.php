<?php
/**
 * Liquid Messages Speakers Taxonomy
 *
 * @package Liquid Messages
 */
class LqdM_Speaker extends LqdM_Taxonomies_Base {

	/**
	 * The identifier for this object
	 *
	 * @var string
	 */
	protected $id = 'speaker';

	/**
	 * The image meta key for this taxonomy, if applicable
	 *
	 * @var string
	 * @since  0.1.1
	 */
	protected $image_meta_key = 'gc_sermon_speaker_image';

	/**
	 * Constructor
	 * Register Speaker Taxonomy. See documentation in Taxonomy_Core, and in wp-includes/taxonomy.php
	 *
	 * @since 0.1.0
	 * @param  object $sermons Messages object.
	 * @return void
	 */
	public function __construct( $sermons ) {
		parent::__construct( $sermons, [
			'labels' => [ __( 'Speaker', 'lqdm' ), __( 'Speakers', 'lqdm' ), 'lqdm-speaker' ],
			'args'   => [
				'hierarchical' => false,
				'rewrite' => [ 'slug' => 'speaker' ],
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
		add_action( 'cmb2_admin_init', [ $this, 'fields' ] );
	}

	/**
	 * Add custom fields to the CPT
	 *
	 * @since  0.1.0
	 * @return void
	 */
	public function fields() {
		$fields = [
			$this->image_meta_key => [
				'name' => __( 'Speaker Avatar', 'lqdm' ),
				'desc' => __( 'Select the speaker\'s avatar. Will only show if "Connected User" is not chosen, or if the "Connected User" does not have an avatar.', 'lqdm' ),
				'id'   => $this->image_meta_key,
				'type' => 'file'
            ],
        ];

		$this->add_image_column( __( 'Speaker Avatar', 'lqdm' ) );

		$cmb = $this->new_cmb2( [
			'id'           => 'gc_sermon_speaker_metabox',
			'taxonomies'   => [ $this->taxonomy() ], // Tells CMB2 which taxonomies should
			'object_types' => [ 'term' ], // Tells CMB2 to use term_meta vs post_meta
			'fields'       => $fields,
        ] );
	}

}
