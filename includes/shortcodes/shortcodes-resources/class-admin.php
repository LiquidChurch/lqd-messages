<?php
/**
 * Liquid Messages Resources Shortcode - Admin
 *
 * @package Liquid Messages
 */
class LQDMS_Resources_Admin extends LQDM_Shortcodes_Admin_Base
{

	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 *
	 * @param LQDM_Shortcodes_Run_Base $run Main plugin object.
	 */
	public function __construct( LQDM_Shortcodes_Run_Base $run ) {
		$this->run = $run;
		parent::__construct( $run );
	}

	/**
	 * Sets up the JS button
	 *
	 * @return array
	 */
	function js_button_data(): array {
		return array(
			'qt_button_text' => __( 'Message Resources', 'lqdm' ),
			'button_tooltip' => __( 'Message Resources', 'lqdm' ),
			'icon'           => 'dashicons-media-interactive'
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
	function fields( $fields, $button_data ): array {
		$fields[] = array(
			'name'      => __( 'Resource Type', 'lqdm' ),
			'desc'      => __( 'Select the type of resource to display.', 'lqdm' ),
			'id'        => 'resource_type',
			'type'      => 'multicheck_inline',
			'default'   => $this->atts_defaults['resource_type'],
			'options'   => array(
				'files' => __( 'Files', 'lqdm' ),
				'urls'  => __( 'URLs', 'lqdm' ),
			),
		);

		$fields[] = array(
			'name'      => __( 'File Type', 'lqdm' ),
			'desc'      => __( 'Only applies if checking "Files" as the Resource Type.', 'lqdm' ),
			'id'        => 'resource_file_type',
			'type'      => 'multicheck_inline',
			'default'   => $this->atts_defaults['resource_file_type'],
			'options'   => array(
				'image' => __( 'Image', 'lqdm' ),
				'video' => __( 'Video', 'lqdm' ),
				'audio' => __( 'Audio', 'lqdm' ),
				'pdf'   => __( 'PDF', 'lqdm' ),
				'zip'   => __( 'Zip', 'lqdm' ),
				'other' => __( 'Other', 'lqdm' ),
			),
		);

		$fields[] = array(
			'name' => __( 'Use the Display Name', 'lqdm' ),
			'desc' => __( 'By default, the Resource Name will be used.', 'lqdm' ),
			'id'   => 'resource_display_name',
			'type' => 'checkbox',
		);

		$fields[] = array(
			'name'            => __( 'Message ID', 'lqdm' ),
			'desc'            => __( 'If nothing is selected, it will use <code>get_the_id()</code>', 'lqdm' ),
			'id'              => 'resource_post_id',
			'type'            => 'post_search_text',
			'post_type'       => gc_sermons()->sermons->post_type(),
			'select_type'     => 'radio',
			'select_behavior' => 'replace',
		);

		$fields[] = array(
			'name'    => __( 'Extra CSS Classes', 'lqdm' ),
			'desc'    => __( 'Enter classes separated by spaces (e.g. "class1 class2")', 'lqdm' ),
			'type'    => 'text',
			'id'      => 'resource_extra_classes',
		);

		$fields[] = array(
			'name'    => __( 'Resource Language', 'lqdm' ),
			'desc'    => __( 'Please select the resource language', 'lqdm' ),
			'type'    => 'multicheck_inline',
			'id'      => 'resource_lang',
			'default' => array_keys(LQDM_Metaboxes::get_lng_fld_option()),
			'options' => LQDM_Metaboxes::get_lng_fld_option(),
		);

		return $fields;
	}
}
