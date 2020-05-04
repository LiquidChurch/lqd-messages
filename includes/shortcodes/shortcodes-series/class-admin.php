<?php
/**
 * Liquid Messages Series Shortcode - Admin
 *
 * @package Liquid Messages
 */
class LQDMS_Series_Admin extends LQDM_Shortcodes_Admin_Base {
	/** @var string $prefix Shortcode prefix for field ids */
	protected $prefix = 'series_';

	/**
	 * Sets up the JS button
	 *
	 * @return array
	 */
	function js_button_data() {
		return array(
			'qt_button_text' => __( 'Message Series', 'lqdm' ),
			'button_tooltip' => __( 'Message Series', 'lqdm' ),
			'icon'           => 'dashicons-images-alt',
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
			'name'    => __( 'Number of Series to Show Per-Page', 'lqdm' ),
			'type'    => 'text_small',
			'id'      => $this->prefix . 'per_page',
			'default' => get_option( 'posts_per_page', $this->atts_defaults['per_page'] ),
		);

		$fields[] = array(
			'name'    => __( 'Remove Year Date Separators', 'lqdm' ),
			'type'    => 'checkbox',
			'id'      => $this->prefix . 'remove_dates',
			'default' => false,
		);

		$fields[] = array(
			'name'    => __( 'Remove Pagination', 'lqdm' ),
			'type'    => 'checkbox',
			'id'      => $this->prefix . 'remove_pagination',
			'default' => false,
		);

		$fields[] = array(
			'name'    => __( 'Remove Thumbnail', 'lqdm' ),
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

		$fields[] = array(
			'name'            => __( 'Offset', 'lqdm' ),
			'desc'            => __( 'Changes which series starts the list', 'lqdm' ),
			'type'            => 'text_small',
			'id'              => $this->prefix . 'list_offset',
			'sanitization_cb' => 'absint',
			'default'         => $this->atts_defaults['list_offset'],
		);

		$fields[] = array(
			'name'    => __( 'Extra Wrap CSS Classes', 'lqdm' ),
			'desc'    => __( 'Enter classes separated by spaces (e.g. "class1 class2")', 'lqdm' ),
			'type'    => 'text',
			'id'      => $this->prefix . 'wrap_classes',
			'default' => $this->atts_defaults['wrap_classes'],
		);

		$fields[] = array(
			'name'    => __( 'Pagination by per_year or per_page', 'lqdm' ),
			'type'    => 'text',
			'id'      => $this->prefix . 'paging_by',
			'default' => 'per_page',
		);

		$fields[] = array(
			'name'    => __( 'Pagination number of years in the first page if paging_by is per_year', 'lqdm' ),
			'type'    => 'text',
			'id'      => $this->prefix . 'show_num_years_first_page',
			'default' => 0,
		);

		$fields[] = array(
			'name'    => __( 'Pagination initial years if paging_by is per_year', 'lqdm' ),
            'desc'    => __( 'This is only applicable if `show_num_years_first_page` is empty or 0', 'lqdm' ),
			'type'    => 'text',
			'id'      => $this->prefix . 'paging_init_year',
			'default' => array(date('Y' )),
		);

		return $fields;
	}
}
