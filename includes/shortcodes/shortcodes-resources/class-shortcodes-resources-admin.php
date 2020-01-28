<?php
/**
 * Liquid Messages Resources Admin Shortcodes.
 *
 * @since 0.1.0
 *
 * @package GC Sermons
 */
class GCS_Shortcodes_Resources_Admin extends WDS_Shortcode_Admin {
	/**
	 * Shortcode Run object
	 *
	 * @var   GCS_Shortcodes_Resources_Run
	 * @since 0.1.0
	 */
	protected $run;

	/**
	 * Constructor
	 *
	 * @param GCS_Shortcodes_Resources_Run $run GCS_Shortcodes_Resources_Run object.
	 *
	 *@since  0.1.0
	 *
	 */
	public function __construct( GCS_Shortcodes_Resources_Run $run ) {
		$this->run = $run;

		parent::__construct(
			$this->run->shortcode,
			GC_Sermons_Plugin::VERSION,
			$this->run->atts_defaults
		);
	}

	/**
	 * Sets up the button
	 *
	 * @return array
	 */
	function js_button_data() {
		return array(
			'qt_button_text' => __( 'Sermon Resources', 'gc-sermons' ),
			'button_tooltip' => __( 'Sermon Resources', 'gc-sermons' ),
			'icon'           => 'dashicons-media-interactive',
			// 'mceView'        => true, // The future
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
			'name'    => __( 'Resource Type', 'gc-sermons' ),
			'desc'    => __( 'Select the type of resource to display.', 'gc-sermons' ),
			'id'      => 'resource_type',
			'type'    => 'multicheck_inline',
			'default' => $this->atts_defaults['resource_type'],
			'options' => array(
				'files' => __( 'Files', 'gc-sermons' ),
				'urls'  => __( 'URLs', 'gc-sermons' ),
			),
		);

		$fields[] = array(
			'name'    => __( 'File Type', 'gc-sermons' ),
			'desc'    => __( 'Only applies if checking "Files" as the Resource Type.', 'gc-sermons' ),
			'id'      => 'resource_file_type',
			'type'    => 'multicheck_inline',
			'default' => $this->atts_defaults['resource_file_type'],
			'options' => array(
				'image' => __( 'Image', 'gc-sermons' ),
				'video' => __( 'Video', 'gc-sermons' ),
				'audio' => __( 'Audio', 'gc-sermons' ),
				'pdf'   => __( 'PDF', 'gc-sermons' ),
				'zip'   => __( 'Zip', 'gc-sermons' ),
				'other' => __( 'Other', 'gc-sermons' ),
			),
		);

		$fields[] = array(
			'name' => __( 'Use the Display Name', 'gc-sermons' ),
			'desc' => __( 'By default, the Resource Name will be used.', 'gc-sermons' ),
			'id'   => 'resource_display_name',
			'type' => 'checkbox',
		);

		$fields[] = array(
			'name'            => __( 'Sermon ID', 'gc-sermons' ),
			'desc'            => __( 'If nothing is selected, it will use <code>get_the_id()</code>', 'gc-sermons' ),
			'id'              => 'resource_post_id',
			'type'            => 'post_search_text',
			'post_type'       => gc_sermons()->sermons->post_type(),
			'select_type'     => 'radio',
			'select_behavior' => 'replace',
		);

		$fields[] = array(
			'name'    => __( 'Extra CSS Classes', 'gc-sermons' ),
			'desc'    => __( 'Enter classes separated by spaces (e.g. "class1 class2")', 'gc-sermons' ),
			'type'    => 'text',
			'id'      => 'resource_extra_classes',
		);

		$fields[] = array(
			'name'    => __( 'Resource Language', 'gc-sermons' ),
			'desc'    => __( 'Please select the resource language', 'gc-sermons' ),
			'type'    => 'multicheck_inline',
			'id'      => 'resource_lang',
			'default' => array_keys(GCS_Metaboxes::get_lng_fld_option()),
			'options' => GCS_Metaboxes::get_lng_fld_option(),
		);

		return $fields;
	}
}
