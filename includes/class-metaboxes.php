<?php
/**
 * LiquidChurch Functionality Metaboxes
 *
 * @package GC Sermons
 */
class GCS_Metaboxes
{
	/**
	 * Additional Resources CMB2 id.
	 *
	 * @var   string
	 */
	public $resources_box_id = '';

	/**
	 * Display order CMB2 id.
	 *
	 * @var string
	 */
	public $display_ordr_box_id = '';

	/**
	 * Additional Resources meta id.
	 *
	 * @var   string
	 */
	public $resources_meta_id = '';

	/**
	 * Display order meta id.
	 *
	 * @var string
	 */
	public $display_ordr_meta_id = '';
    public $exclude_msg_meta_id = '';
    public $video_msg_appear_pos = '';

    /**
     * Parent plugin class
     *
     * @since 0.1.0
     */
    protected $plugin = null;

	/**
	 * Constructor
	 *
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Initiate our hooks
	 *
	 * @return void
	 */
	public function hooks() {
		add_action( 'cmb2_admin_init', array( $this, 'add_metabox' ), 99 );
		add_action( 'cmb2_render_text_number', array( $this, 'meta_addtnl_type_text_number' ), 10, 5 );
	}

	/**
	 * Add Metabox
	 *
	 * @param $metabox
	 */
	public function add_metabox( $metabox ) {

		//display order field for messages

		$args = array(
			'id'           => $this->display_ordr_box_id,
			'title'        => __( 'Display Conditions', 'gc-sermons' ),
			'object_types' => array( gc_sermons()->sermons->post_type() ),
		);

		$cmb = new_cmb2_box( $args );

		$cmb->add_field( array(
			'name' => __( 'Display Order', 'gc-sermons' ),
			'desc' => __( 'Post will appear in the series based on this order', 'gc-sermons' ),
			'id'   => $this->display_ordr_meta_id,
			'type' => 'text_number',
            'attributes'  => array(
                'required'    => 'required',
            ),
		) );

        $cmb->add_field(array(
            'name' => __('Exclude as Message', 'gc-sermons'),
            'desc' => __('If selected the post will not appear as message in the message listing', 'gc-sermons'),
            'id' => $this->exclude_msg_meta_id,
            'type' => 'checkbox',
        ));

        $cmb->add_field(array(
            'name' => __('Position in Message Archive Page', 'gc-sermons'),
            'desc' => __('Based on this value, videos will appear above/below the normal messages listing', 'gc-sermons'),
            'id' => $this->video_msg_appear_pos,
            'type' => 'radio',
            'options' => array(
                'top' => __('First', 'gc-sermons'),
                'bottom' => __('Last', 'gc-sermons'),
            ),
        ));

		// Additional Resources Fields

		$args = array(
			'id'           => $this->resources_box_id,
			'title'        => __( 'Additional Resources', 'gc-sermons' ),
			'object_types' => array( gc_sermons()->sermons->post_type() ),
		);

		$field_group_args = array(
			'id'      => $this->resources_meta_id,
			'type'    => 'group',
			'options' => array(
				'group_title'   => __( 'Resource {#}', 'gc-sermons' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Resource', 'gc-sermons' ),
				'remove_button' => __( 'Remove Resource', 'gc-sermons' ),
				'sortable'      => true,
			),
			'after_group' => array( $this, 'enqueu_box_js' ),
		);

		$sub_fields = array(
			array(
				'name' => __( 'Resource Name', 'gc-sermons' ),
				'desc' => __( 'e.g., "Audio for Faces of Grace Sermon"', 'gc-sermons' ),
				'id'   => 'name',
				'type' => 'text',
			),
            array(
                'name' => __('Resource Language', 'gc-sermons'),
                'desc' => __('Please select the resource language', 'gc-sermons'),
                'id' => 'lang',
                'type' => 'select',
                'options' => $this->get_lng_fld_option()
            ),
			array(
				'name'    => __( 'Display Name', 'gc-sermons' ),
				'desc'    => __( 'e.g., "Download Audio"', 'gc-sermons' ),
				'id'      => 'display_name',
                'type' => 'select',
                'options' => $this->get_disp_name_fld_option()
			),
			array(
				'name' => __( 'URL or File', 'gc-sermons' ),
				'desc' => __( 'Link to OR upload OR select resource"', 'gc-sermons' ),
				'id'   => 'file',
				'type' => 'file',
			),
			array(
				'name' => __( 'Type of Resource', 'gc-sermons' ),
				'desc' => __( 'e.g., image / video / audio / pdf / zip / embed / other. Will autopopulate if selecting media. Leave blank if adding a URL instead of a file.', 'gc-sermons' ),
				'id'   => 'type',
				'type' => 'text',
            )
		);

		$cmb = new_cmb2_box( $args );
		$group_field_id = $cmb->add_field( $field_group_args );
		foreach ( $sub_fields as $field ) {
			$cmb->add_group_field( $group_field_id, $field );
		}


		// Include the same fields for sermon series.

		$cmb = new_cmb2_box( array(
			'id'           => $this->resources_box_id . '_series',
			'object_types' => array( 'term' ),
			'taxonomies'   => array( gc_sermons()->taxonomies->series->taxonomy() ),
		) );

		$cmb->add_field( array(
			'name' => $args['title'],
			'desc' => '<hr>',
			'id'   => 'series_resources_title',
			'type' => 'title',
		) );

		$group_field_id = $cmb->add_field( $field_group_args );
		foreach ( $sub_fields as $field ) {
			$cmb->add_group_field( $group_field_id, $field );
		}

	}

	/**
	 * Get Display Name Field Option
	 *
	 * @return array
	 */
    public static function get_disp_name_fld_option()
    {
        $plugin_option = GC_Sermons_Plugin::get_plugin_settings_options('addtnl_rsrc_option', 'display_name_fld_val');
        if (empty($plugin_option)) {
            return array('Video' => 'Video', 'Audio' => 'Audio', 'Notes' => 'Notes', 'Group Guide' => 'Group Guide');
        } else {
            $plugin_option_arr = array_map('trim', explode(',', $plugin_option));
            $option = array();
            foreach ($plugin_option_arr as $item) {
                $option[ucwords($item)] = ucwords($item);
            }
            return $option;
        }
    }

	/**
	 * Get Language Field Option
	 *
	 * @return array
	 */
    public static function get_lng_fld_option()
    {
        $plugin_option = GC_Sermons_Plugin::get_plugin_settings_options('addtnl_rsrc_option', 'addtnl_rsrc_lng_optn');
        if (empty($plugin_option)) {
            return array(
                'eng' => 'English',
                'spa' => 'Spanish'
            );
        } else {
            $plugin_option_arr = array_map('trim', explode(',', $plugin_option));
            $lng_option = array();
            foreach ($plugin_option_arr as $item) {
                $lng_arr = array_map('trim', explode(':', $item));
                $lng_option[$lng_arr[0]] = $lng_arr[1];
            }
            return $lng_option;
        }
    }

	/**
	 * Enqueue Box JS
	 *
	 * @param $args
	 */
	public function enqueu_box_js( $args ) {
		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script(
			'lc-func-admin',
			GC_Sermons_Plugin::$url . 'assets/js/liquidchurch-functionality-admin{$min}.js',
			array( 'cmb2-scripts' ),
			GC_Sermons_Plugin::VERSION,
			1
		);

		wp_localize_script( 'lc-func-admin', 'LiquidChurchAdmin', array( 'id' => $args['id'] ) );
	}

	/**
	 * input type number for meta fields
	 *
	 * @param $field
	 * @param $escaped_value
	 * @param $object_id
	 * @param $object_type
	 * @param $field_type_object
	 */
	function meta_addtnl_type_text_number( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
		echo $field_type_object->input( array( 'type' => 'number', 'min' => 0 ) );
	}

}
