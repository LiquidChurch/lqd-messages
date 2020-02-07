<?php
/**
 * Liquid Messages Metaboxes
 *
 * @package Liquid Messages
 */
class LqdM_Metaboxes
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
		add_action( 'cmb2_admin_init', [ $this, 'add_metabox' ], 99 );
		add_action( 'cmb2_render_text_number', [ $this, 'meta_addtnl_type_text_number' ], 10, 5 );
	}

	/**
	 * Add Metabox
	 *
	 * @param $metabox
	 */
	public function add_metabox( $metabox ) {

		//display order field for messages

		$args = [
			'id'           => $this->display_ordr_box_id,
			'title'        => __( 'Display Conditions', 'lqdm' ),
			'object_types' => [ lqd_messages()->sermons->post_type() ],
        ];

		$cmb = new_cmb2_box( $args );

		$cmb->add_field( [
			'name' => __( 'Display Order', 'lqdm' ),
			'desc' => __( 'Post will appear in the series based on this order', 'lqdm' ),
			'id'   => $this->display_ordr_meta_id,
			'type' => 'text_number',
            'attributes'  => [
                'required'    => 'required',
            ],
        ] );

        $cmb->add_field( [
            'name' => __('Exclude as Message', 'lqdm'),
            'desc' => __('If selected the post will not appear as message in the message listing', 'lqdm'),
            'id' => $this->exclude_msg_meta_id,
            'type' => 'checkbox',
        ] );

        $cmb->add_field( [
            'name' => __('Position in Message Archive Page', 'lqdm'),
            'desc' => __('Based on this value, videos will appear above/below the normal messages listing', 'lqdm'),
            'id' => $this->video_msg_appear_pos,
            'type' => 'radio',
            'options' => [
                'top' => __('First', 'lqdm'),
                'bottom' => __('Last', 'lqdm'),
            ],
        ] );

		// Additional Resources Fields

		$args = [
			'id'           => $this->resources_box_id,
			'title'        => __( 'Additional Resources', 'lqdm' ),
			'object_types' => [ lqd_messages()->sermons->post_type() ],
        ];

		$field_group_args = [
			'id'      => $this->resources_meta_id,
			'type'    => 'group',
			'options' => [
				'group_title'   => __( 'Resource {#}', 'lqdm' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Resource', 'lqdm' ),
				'remove_button' => __( 'Remove Resource', 'lqdm' ),
				'sortable'      => true,
            ],
			'after_group' => [ $this, 'enqueu_box_js' ],
        ];

		$sub_fields = [
			[
				'name' => __( 'Resource Name', 'lqdm' ),
				'desc' => __( 'e.g., "Audio for Faces of Grace Sermon"', 'lqdm' ),
				'id'   => 'name',
				'type' => 'text',
            ],
            [
                'name' => __('Resource Language', 'lqdm'),
                'desc' => __('Please select the resource language', 'lqdm'),
                'id' => 'lang',
                'type' => 'select',
                'options' => $this->get_lng_fld_option()
            ],
			[
				'name'    => __( 'Display Name', 'lqdm' ),
				'desc'    => __( 'e.g., "Download Audio"', 'lqdm' ),
				'id'      => 'display_name',
                'type' => 'select',
                'options' => $this->get_disp_name_fld_option()
            ],
			[
				'name' => __( 'URL or File', 'lqdm' ),
				'desc' => __( 'Link to OR upload OR select resource"', 'lqdm' ),
				'id'   => 'file',
				'type' => 'file',
            ],
			[
				'name' => __( 'Type of Resource', 'lqdm' ),
				'desc' => __( 'e.g., image / video / audio / pdf / zip / embed / other. Will autopopulate if selecting media. Leave blank if adding a URL instead of a file.', 'lqdm' ),
				'id'   => 'type',
				'type' => 'text',
            ]
        ];

		$cmb = new_cmb2_box( $args );
		$group_field_id = $cmb->add_field( $field_group_args );
		foreach ( $sub_fields as $field ) {
			$cmb->add_group_field( $group_field_id, $field );
		}


		// Include the same fields for sermon series.

		$cmb = new_cmb2_box( [
			'id'           => $this->resources_box_id . '_series',
			'object_types' => [ 'term' ],
			'taxonomies'   => [ lqd_messages()->taxonomies->series->taxonomy() ],
        ] );

		$cmb->add_field( [
			'name' => $args['title'],
			'desc' => '<hr>',
			'id'   => 'series_resources_title',
			'type' => 'title',
        ] );

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
        $plugin_option = lqd_messages()->get_plugin_settings_options('addtnl_rsrc_option', 'display_name_fld_val');
        if (empty($plugin_option)) {
            return [ 'Video' => 'Video', 'Audio' => 'Audio', 'Notes' => 'Notes', 'Group Guide' => 'Group Guide' ]; // TODO: Make config option
        } else {
            $plugin_option_arr = array_map('trim', explode(',', $plugin_option));
            $option = [];
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
        $plugin_option = lqd_messages()->get_plugin_settings_options('addtnl_rsrc_option', 'addtnl_rsrc_lng_optn');
        if (empty($plugin_option)) {
            return [
                'eng' => 'English',
                'spa' => 'Spanish'
            ];
        } else {
            // We set $plugin_option_array equal to the results in $plugin_option, once parsed into an array.
            $plugin_option_arr = array_map('trim', explode(',', $plugin_option)); // "eng:English, \r\nspa:Spanish,\r\nspa:Espanol" w/tilde before $plugin_opt_arr
            // becomes 0 = "eng:English", 1 = "spa:Spanish", 2="spa:Espanol" once mapped into arr
            // Create an empty array
            $lng_option = [];
            // Iterate through our newly created $plugin_option_arr
            foreach ($plugin_option_arr as $item) {
                // We now create an array from the individual item in $plugin_option_arr, consists of for ex, eng:English, now eng, English

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
			'lqdm-admin',
            Lqd_Messages_Plugin::$url . "assets/js/lqdm-admin{$min}.js",
			array( 'cmb2-scripts' ),
			Lqd_Messages_Plugin::VERSION,
			1
		);

		wp_localize_script( 'lqdm-admin', 'LqdMAdmin', [ 'id' => $args['id'] ] );
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
		echo $field_type_object->input( [ 'type' => 'number', 'min' => 0 ] );
	}

}
