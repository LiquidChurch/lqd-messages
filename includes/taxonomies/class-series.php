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
	protected $image_meta_key = 'lqdm_series_image';

	/**
	 * The default args array for self::get()
	 *
	 * @var array
	 * @since  0.1.1
	 */
	protected $term_get_args_defaults = [
		'image_size' => 'medium',
    ];

	/**
	 * Constructor
	 * Register Sermon Series Taxonomy. See documentation in Taxonomy_Core, and in wp-includes/taxonomy.php
	 *
	 * @since 0.1.0
	 * @param  object $sermons Messages object.
	 * @return void
	 */
	public function __construct( $sermons ) {
		parent::__construct( $sermons, [
			'labels' => [ __( 'Sermon Series', 'lqdm' ), __( 'Sermon Series', 'lqdm' ), 'lqdm-series' ],
			'args'   => [
				'hierarchical' => false,
				'show_admin_column' => false,
				'rewrite' => [
				    'slug' => 'sermon-series',
					'with_front' => false,
					'ep_mask' => EP_CATEGORIES,
                ],
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
	 * Add custom fields to the Custom Taxonomy
	 *
	 * @since  0.1.0
	 * @return void
	 */
	public function fields() {
		$cmb = $this->new_cmb2( [
			'id'           => 'lqdm_series_metabox',
			'taxonomies'   => [ $this->taxonomy() ],
			'object_types' => [ 'term' ],
			'fields'       => [
				$this->image_meta_key => [
					'name' => __( 'Series Image', 'lqdm' ),
					'desc' => __( 'Select the series\' branding image', 'lqdm' ),
					'id'   => $this->image_meta_key,
					'type' => 'file'
                ],
            ],
        ] );

		$this->add_image_column( __( 'Series Image', 'lqdm' ) );
	}
}
