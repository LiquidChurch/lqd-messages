<?php
/**
 * Liquid Messages Resources Shortcode Button/Modal.
 *
 * @since 0.1.0
 *
 * @package Liquid Messages
 */
class LqdM_Shortcodes_Resources_Admin extends LqdM_Shortcodes_Admin_Base {

    // TODO: Add a $prefix

	/**
	 * Constructor
	 *
	 * @param LqdM_Shortcodes_Resources_Run $run LqdM_Shortcodes_Resources_Run object.
	 *
	 *@since  0.1.0
	 *
	 */
	public function __construct( LqdM_Shortcodes_Resources_Run $run ) {
		parent::__construct($run);
	}

	/**
	 * Defines the Shortcode Button
	 *
	 * @return array
	 */
	function js_button_data() {
		return [
			'qt_button_text' => __( 'Sermon Resources', 'lqdm' ),
			'button_tooltip' => __( 'Sermon Resources', 'lqdm' ),
			'icon'           => 'dashicons-media-interactive'
        ];
	}

	/**
	 * Defines fields for Shortcode Modal
	 *
	 * @param $fields
	 * @param $button_data
	 *
	 * @return array
	 */
	function fields( $fields, $button_data ) {
		$fields[] = [
			'name'    => __( 'Resource Type', 'lqdm' ),
			'desc'    => __( 'Select the type of resource to display.', 'lqdm' ),
			'id'      => 'resource_type',
			'type'    => 'multicheck_inline',
			'default' => $this->atts_defaults['resource_type'],
			'options' => [
				'files' => __( 'Files', 'lqdm' ),
				'urls'  => __( 'URLs', 'lqdm' ),
            ],
        ];

		$fields[] = [
			'name'    => __( 'File Type', 'lqdm' ),
			'desc'    => __( 'Only applies if checking "Files" as the Resource Type.', 'lqdm' ),
			'id'      => 'resource_file_type',
			'type'    => 'multicheck_inline',
			'default' => $this->atts_defaults['resource_file_type'],
			'options' => [
				'image' => __( 'Image', 'lqdm' ),
				'video' => __( 'Video', 'lqdm' ),
				'audio' => __( 'Audio', 'lqdm' ),
				'pdf'   => __( 'PDF', 'lqdm' ),
				'zip'   => __( 'Zip', 'lqdm' ),
				'other' => __( 'Other', 'lqdm' ),
            ],
        ];

		$fields[] = [
			'name' => __( 'Use the Display Name', 'lqdm' ),
			'desc' => __( 'By default, the Resource Name will be used.', 'lqdm' ),
			'id'   => 'resource_display_name',
			'type' => 'checkbox',
        ];

		$fields[] = [
			'name'            => __( 'Sermon ID', 'lqdm' ),
			'desc'            => __( 'If nothing is selected, it will use <code>get_the_id()</code>', 'lqdm' ),
			'id'              => 'resource_post_id',
			'type'            => 'post_search_text',
			'post_type'       => $this->run->sermons->post_type(),
			'select_type'     => 'radio',
			'select_behavior' => 'replace',
        ];

		$fields[] = [
			'name'    => __( 'Extra CSS Classes', 'lqdm' ),
			'desc'    => __( 'Enter classes separated by spaces (e.g. "class1 class2")', 'lqdm' ),
			'type'    => 'text',
			'id'      => 'resource_extra_classes',
        ];

		$fields[] = [
			'name'    => __( 'Resource Language', 'lqdm' ),
			'desc'    => __( 'Please select the resource language', 'lqdm' ),
			'type'    => 'multicheck_inline',
			'id'      => 'resource_lang',
			'default' => array_keys( lqd_messages()->metaboxes->get_lng_fld_option()),
			'options' => lqd_messages()->metaboxes->get_lng_fld_option(),
        ];

		return $fields;
	}
}
