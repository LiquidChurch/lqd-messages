<?php
/**
 * Liquid Messages Search Shortcode - Admin
 *
 * @package Liquid Messages
 */
class GCS_Shortcodes_Sermon_Search_Admin extends GCSS_Recent_Admin_Base {
	/** @var string $prefix Shortcode prefix for field ids */
	protected $prefix = 'gc_search_';

	/** @var GCS_Taxonomies $taxonomies Instance of GCS Taxonomies */
	protected $taxonomies;

	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 *
	 * @param GCS_Shortcodes_Run_Base $run Main plugin object.
	 * @param GCS_Taxonomies $taxonomies GCS_Taxonomies object.
	 */
	public function __construct( GCS_Shortcodes_Run_Base $run, GCS_Taxonomies $taxonomies ) {
		$this->taxonomies = $taxonomies;
		parent::__construct( $run );
	}

	/**
	 * Sets up the JS button
	 *
	 * @return array
	 */
	function js_button_data() {
		return array(
			'qt_button_text' => __( 'Messages Search', 'lqdm' ),
			'button_tooltip' => __( 'Messages Search', 'lqdm' ),
			'icon'           => 'dashicons-search'
		);
	}

	/**
	 * Adds fields to the button modal using CMB2
	 *
	 * @param $fields
	 * @param $button_data
	 *
	 * @return array
	 */
	function fields( $fields, $button_data ) {
		$fields[] = array(
			'name'    => __( 'Search:', 'lqdm' ),
			'desc'    => sprintf( __( 'Select whether form allows searching %s, %s, or both.', 'lqdm' ), $this->run->sermons->post_type( 'plural' ), $this->taxonomies->series->taxonomy( 'plural' ) ),
			'id'      => $this->prefix . 'search',
			'type'    => 'select',
			'default' => $this->atts_defaults['search'],
			'options' => array(
				'sermons' => $this->run->sermons->post_type( 'plural' ),
				'series' => $this->taxonomies->series->taxonomy( 'plural' ),
				'' => __( 'Both', 'lqdm' ),
			),
		);

		$fields[] = array(
			'name'    => __( 'Number of results to show per-page', 'lqdm' ),
			'type'    => 'text_small',
			'id'      => $this->prefix . 'per_page',
			'default' => get_option( 'posts_per_page', $this->atts_defaults['per_page'] ),
		);

		$fields[] = array(
			'name'    => __( 'Content', 'lqdm' ),
			'type'    => 'radio',
			'id'      => $this->prefix . 'content',
			'default' => $this->atts_defaults['content'],
			'options' => array(
				''        => __( 'None', 'lqdm' ),
				'content' => __( 'Message Post Content', 'lqdm' ),
				'excerpt' => __( 'Message Post Excerpt', 'lqdm' ),
			),
		);

		$fields[] = array(
			'name'    => __( 'Remove Thumbnails', 'lqdm' ),
			'type'    => 'checkbox',
			'id'      => $this->prefix . 'remove_thumbnail',
			'default' => false,
		);

		$fields[] = array(
			'name'    => __( 'Thumbnail Size (if included)', 'lqdm' ),
			'type'    => 'text',
			'id'      => $this->prefix . 'thumbnail_size',
			'default' => $this->atts_defaults['thumbnail_size'],
		);

		$fields[] = array(
			'name'    => __( 'Max number of columns', 'lqdm' ),
			'desc'    => __( 'Will vary on device screen width', 'lqdm' ),
			'type'    => 'radio_inline',
			'options' => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4 ),
			'id'      => $this->prefix . 'number_columns',
			'default' => $this->atts_defaults['number_columns'],
		);

		return $fields;
	}
}
