<?php
/**
 * Liquid Messages Metaboxes
 *
 * @package Liquid Messages
 */

class LQDM_Metaboxes
{
    /** @var string $resources_box_id Additional resources CMB2 id */
	public $resources_box_id = '';

    /** @var string $display_ordr_box_id Display order CMB2 id */
	public $display_ordr_box_id = '';

    /** @var string $resources_meta_id Additional resources meta id */
	public $resources_meta_id = '';

    /** @var string $display_ordr_meta_id Display order meta id */
	public $display_ordr_meta_id = '';

    /** @var string $exclude_msg_meta_id Exclude message meta id */
    public $exclude_msg_meta_id = '';

    /** @var string $video_msg_appear_pos Video message appears in position */
    public $video_msg_appear_pos = '';

    /** @var object|null $plugin Parent plugin class */
    protected $plugin;

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
	public function hooks(): void {
		add_action( 'cmb2_admin_init', array( $this, 'add_metabox' ), 99 );
		add_action( 'cmb2_render_text_number', array( $this, 'meta_addtnl_type_text_number' ), 10, 5 );
	}

	/**
	 * Add Metabox
	 *
	 * @param $metabox
	 */
	public function add_metabox( $metabox ): void {

		//display order field for messages
		$args = array(
			'id'           => $this->display_ordr_box_id,
			'title'        => __( 'Display Conditions', 'lqdm' ),
			'object_types' => array( gc_sermons()->sermons->post_type() ),
		);

		$cmb = new_cmb2_box( $args );

		$cmb->add_field( array(
			'name' => __( 'Display Order', 'lqdm' ),
			'desc' => __( 'Post will appear in the series based on this order', 'lqdm' ),
			'id'   => $this->display_ordr_meta_id,
			'type' => 'text_number',
            'attributes'  => array(
                'required'    => 'required',
            ),
		) );

        $cmb->add_field(array(
            'name' => __('Exclude as Message', 'lqdm'),
            'desc' => __('If selected the post will not appear as message in the message listing', 'lqdm'),
            'id' => $this->exclude_msg_meta_id,
            'type' => 'checkbox',
        ));

        $cmb->add_field(array(
            'name' => __('Position in Message Archive Page', 'lqdm'),
            'desc' => __('Based on this value, videos will appear above/below the normal messages listing', 'lqdm'),
            'id' => $this->video_msg_appear_pos,
            'type' => 'radio',
            'options' => array(
                'top' => __('First', 'lqdm'),
                'bottom' => __('Last', 'lqdm'),
            ),
        ));

		//additional resources fields

		$args = array(
			'id'           => $this->resources_box_id,
			'title'        => __( 'Additional Resources', 'lqdm' ),
			'object_types' => array( gc_sermons()->sermons->post_type() ),
		);

		$field_group_args = array(
			'id'      => $this->resources_meta_id,
			'type'    => 'group',
			'options' => array(
				'group_title'   => __( 'Resource {#}', 'lqdm' ), // {#} gets replaced by row number
				'add_button'    => __( 'Add Another Resource', 'lqdm' ),
				'remove_button' => __( 'Remove Resource', 'lqdm' ),
				'sortable'      => true,
			),
			'after_group' => array( $this, 'enqueue_box_js' ),
		);

		$sub_fields = array(
			array(
				'name' => __( 'Resource Name', 'lqdm' ),
				'desc' => __( 'e.g., "Audio for Faces of Grace Message"', 'lqdm' ),
				'id'   => 'name',
				'type' => 'text',
			),
            array(
                'name' => __('Resource Language', 'lqdm'),
                'desc' => __('Please select the resource language', 'lqdm'),
                'id' => 'lang',
                'type' => 'select',
                'options' => self::get_lng_fld_option()
            ),
			array(
				'name'    => __( 'Display Name', 'lqdm' ),
				'desc'    => __( 'e.g., "Download Audio"', 'lqdm' ),
				'id'      => 'display_name',
                'type' => 'select',
                'options' => self::get_disp_name_fld_option()
			),
			array(
				'name' => __( 'URL or File', 'lqdm' ),
				'desc' => __( 'Link to OR upload OR select resource"', 'lqdm' ),
				'id'   => 'file',
				'type' => 'file',
			),
			array(
				'name' => __( 'Type of Resource', 'lqdm' ),
				'desc' => __( 'e.g., image / video / audio / pdf / zip / embed / other. Will autopopulate if selecting media. Leave blank if adding a URL instead of a file.', 'lqdm' ),
				'id'   => 'type',
				'type' => 'text',
            )
		);

		$cmb = new_cmb2_box( $args );
		$group_field_id = $cmb->add_field( $field_group_args );
		foreach ( $sub_fields as $field ) {
			$cmb->add_group_field( $group_field_id, $field );
		}


		// Include the same field for message series.

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
	 * @return array|string[]
	 */
    public static function get_disp_name_fld_option(): ?array {
        $plugin_option = GC_Sermons_Plugin::get_plugin_settings_options('addtnl_rsrc_option', 'display_name_fld_val');
        if (empty($plugin_option)) {
            return array('Video' => 'Video', 'Audio' => 'Audio', 'Notes' => 'Notes', 'Group Guide' => 'Group Guide');
        }

        $plugin_option_arr = array_map('trim', explode(',', $plugin_option));
        $option            = array();
        foreach ($plugin_option_arr as $item) {
            $option[ucwords($item)] = ucwords($item);
        }

        return $option;
    }

	/**
	 * Get Language Field Option
	 *
	 * @return array|string[]
	 */
    public static function get_lng_fld_option(): ?array {
        $plugin_option = GC_Sermons_Plugin::get_plugin_settings_options('addtnl_rsrc_option', 'addtnl_rsrc_lng_optn');
        if (empty($plugin_option)) {
            return array(
                'eng' => 'English',
                'spa' => 'Spanish'
            );
        }

        $plugin_option_arr = array_map('trim', explode(',', $plugin_option));
        $lng_option        = array();
        foreach ($plugin_option_arr as $item) {
            $lng_arr = array_map('trim', explode(':', $item));
            $lng_option[$lng_arr[0]] = $lng_arr[1];
        }

        return $lng_option;
    }

	/**
	 * Enqueue Box JS
	 *
	 * @param $args
	 */
	public function enqueue_box_js( $args ): void {
		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script(
			'lqdm-admin',
			GC_Sermons_Plugin::$url . "assets/js/lqdm-admin{$min}.js",
			array( 'cmb2-scripts' ),
			GC_Sermons_Plugin::VERSION,
			1
		);

		wp_localize_script( 'lqdm-admin', 'LiquidChurchAdmin', array( 'id' => $args['id'] ) );
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
	function meta_addtnl_type_text_number( $field, $escaped_value, $object_id, $object_type, $field_type_object ): void {
		echo $field_type_object->input( array( 'type' => 'number', 'min' => 0 ) );
	}

}
