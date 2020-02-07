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
	protected $image_meta_key = 'lqdm_message_speaker_image';

	/**
	 * Constructor
     *
	 * Register Speaker Taxonomy.
     *
     * See documentation in Taxonomy_Core, and in wp-includes/taxonomy.php
	 *
	 * @since 0.1.0
	 * @param  object $messages LqdM_Messages object.
	 * @return void
	 */
	public function __construct( $messages ) {
		parent::__construct( $messages, array(
			'labels' => array( __( 'Speaker', 'lqdm' ), __( 'Speakers', 'lqdm' ), 'lqdm-speaker' ),
			'args'   => array(
				'hierarchical' => false,
				'rewrite' => array( 'slug' => 'speaker' ),
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
		add_action( 'cmb2_admin_init', array( $this, 'fields' ) );
	}

	/**
	 * Add custom fields to the CPT
	 *
	 * @since  0.1.0
	 * @return void
	 */
	public function fields() {
		$fields = array(
			$this->image_meta_key => array(
				'name' => __( 'Speaker Avatar', 'lqdm' ),
				'desc' => __( 'Select the speaker\'s avatar.', 'lqdm' ),
				'id'   => $this->image_meta_key,
				'type' => 'file'
			),
		);

		$this->add_image_column( __( 'Speaker Avatar', 'lqdm' ) );

		$cmb = $this->new_cmb2( array(
			'id'           => 'lqdm_message_speaker_metabox',
			'taxonomies'   => array( $this->taxonomy() ), // Tells CMB2 which taxonomies should
			'object_types' => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
			'fields'       => $fields,
		) );
	}

}
