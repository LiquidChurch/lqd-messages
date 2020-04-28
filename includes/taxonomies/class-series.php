<?php
/**
 * Liquid Messages Series Custom Taxonomy
 *
 * @package Liquid Messages
 */

class GCS_Series extends GCS_Taxonomies_Base {

    /** @var string $id Identifier for this object */
	protected $id = 'series';

    /** @var string $image_meta_key Image meta key for this taxonomy */
	protected $image_meta_key = 'gc_sermon_series_image';

    /** @var string[] $term_get_args_defaults Default arguments array for self::get() */
	protected $term_get_args_defaults = array(
		'image_size' => 'medium',
	);


	/**
	 * Constructor
	 * Register Series Taxonomy. See documentation in Taxonomy_Core, and in wp-includes/taxonomy.php
	 *
	 * @since 0.1.0
	 * @param  object $sermons GCS_Sermons object.
	 * @return void
	 */
	public function __construct( $sermons ) {
		parent::__construct( $sermons, array(
			'labels' => array( __( 'Message Series', 'lqdm' ), __( 'Message Series', 'lqdm' ), 'gc-sermon-series' ),
			'args'   => array(
				'hierarchical' => false,
				'show_admin_column' => false,
				'rewrite' => array(
				    'slug' => 'series',
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
	 * Add custom fields to the Series Taxonomy
	 *
	 * @since  0.1.0
	 * @return void
	 */
	public function fields() {
		$cmb = $this->new_cmb2( array(
			'id'           => 'gc_sermon_series_metabox',
			'taxonomies'   => array( $this->taxonomy() ),
			'object_types' => array( 'term' ),
			'fields'       => array(
				$this->image_meta_key => array(
					'name' => __( 'Sermon Series Image', 'lqdm' ),
					'desc' => __( 'Select the series\' branding image', 'lqdm' ),
					'id'   => $this->image_meta_key,
					'type' => 'file'
				),
			),
		) );

		$this->add_image_column( __( 'Series Image', 'lqdm' ) );
	}
}
