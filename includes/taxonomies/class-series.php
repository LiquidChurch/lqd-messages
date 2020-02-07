<?php
/**
 * Liquid Messages Series Taxonomy
 *
 * @package Liquid Messages
 */
class LqdM_Series extends LqdM_Taxonomies_Base {

	/**
	 * The identifier for this object
	 *
	 * @var string
	 */
	protected $id = 'series';

	/**
	 * The image meta key for this taxonomy, if applicable
	 *
	 * @var string
	 * @since  0.1.1
	 */
	protected $image_meta_key = 'lqdm_message_series_image';

	/**
	 * The default args array for self::get()
	 *
	 * @var array
	 * @since  0.1.1
	 */
	protected $term_get_args_defaults = array(
		'image_size' => 'medium',
	);

	/**
	 * Constructor
	 *
     * Register Message Series Taxonomy.
     *
     * See documentation in Taxonomy_Core, and in wp-includes/taxonomy.php
	 *
	 * @since 0.1.0
	 * @param  object $messages LqdM_Messages object.
	 * @return void
	 */
	public function __construct( $messages ) {
		parent::__construct( $messages, array(
			'labels' => array( __( 'Message Series', 'lqdm' ), __( 'Message Series', 'lqdm' ), 'lqdm-message-series' ),
			'args'   => array(
				'hierarchical' => false,
				'show_admin_column' => false,
				'rewrite' => array(
				    'slug' => 'message-series', // TODO: Change to series?
					'with_front' => false,
					'ep_mask' => EP_CATEGORIES,
                ),
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
	 * Add custom fields to the Custom Taxonomy
	 *
	 * @since  0.1.0
	 * @return void
	 */
	public function fields() {
		$cmb = $this->new_cmb2( array(
			'id'           => 'lqdm_message_series_metabox',
			'taxonomies'   => array( $this->taxonomy() ),
			'object_types' => array( 'term' ),
			'fields'       => array(
				$this->image_meta_key => array(
					'name' => __( 'Series Image', 'lqdm' ),
					'desc' => __( 'Select the series\' branding image', 'lqdm' ),
					'id'   => $this->image_meta_key,
					'type' => 'file'
				),
			),
		) );

		$this->add_image_column( __( 'Series Image', 'lqdm' ) );
	}
}
