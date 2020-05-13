<?php
/**
 * Liquid Messages Resources Shortcode - Run
 *
 * @package Liquid Messages
 */
class LQDMS_Resources_Run extends LQDM_Shortcodes_Run_Base
{

    /** @var string $shortcode The shortcode tag */
	public $shortcode = 'sermon_resources';

    /** @var array $atts_defaults Array of default attributes applied to shortcode */
	public $atts_defaults = array(
        'data_type'              => 'sermon', // File or URL
		'resource_type'          => array( 'files', 'urls', ), // File or URL
		'resource_file_type'     => array( 'image', 'video', 'audio', 'pdf', 'zip', 'other', ), // Only applies if 'type' is 'file',
		'resource_display_name'  => false, // Uses Resource Name by default
		'resource_post_id'       => 0, // Uses `get_the_id()` by default
		'resource_extra_classes' => '', // For custom styling
        'resource_lang'          => array(), // For resource language
	);

    /** @var string $meta_id Additional resources meta id */
    protected $meta_id = '';

    /** @var string $default_lang Additional resources default language */
    protected $default_lang = 'eng';

	/**
	 * Constructor
	 *
	 * @param LQDM_Sermons $sermons
	 * @param string      $meta_id Resource meta id
	 */
	public function __construct(LQDM_Sermons $sermons, $meta_id)
	{
		$this->atts_defaults['resource_lang'] = array_keys(LQDM_Metaboxes::get_lng_fld_option());
		$this->meta_id = $meta_id;

		parent::__construct($sermons);
	}

    /**
     * Shortcode Output
     *
     * @throws Exception
     */
	public function shortcode()
	{
		$output = $this->_shortcode();

		return apply_filters( 'lc_sermon_resources_shortcode_output', $output, $this );
	}

	/**
	 * Shortcode
	 *
	 * @return string
	 * @throws Exception
	 */
    protected function _shortcode(): string {
        $data_type = $this->att('data_type');
        $post_id   = $this->att('resource_post_id', $data_type == 'sermon' ? get_the_id() : get_queried_object()->term_id);

		if ( $post_id === 'this' ) {
            $post_id = $data_type == 'sermon' ? get_the_id() : get_queried_object()->term_id;
		}

		if ( ! $post_id ) {
			return '<!-- no resources found -->';
		}

		$resources = $this->get_resources( $post_id );

		if ( empty( $resources ) || ! is_array( $resources ) ) {
			return '<!-- no resources found -->';
		}

		$args = array(
			'resources' => $resources,
			'items'     => $this->list_items( $resources, $this->att( 'resource_display_name' ) ),
		);

		// Get parsed attribute values
		foreach ( $this->shortcode_object->atts as $key => $value ) {
			$args[ $key ] = $this->att( $key );
		}

        $args['lang_plugin_option'] = LQDM_Metaboxes::get_lng_fld_option();

		return LQDM_Template_Loader::get_template( 'sermon-resources-shortcode', $args );
	}

	/**
	 * Get Resources
	 *
	 * @param $post_id
	 *
	 * @var $allowed_types string|array
	 * @var $allowed_file_types string|array
	 *
	 * @return array|mixed
	 */
    protected function get_resources($post_id)
    {
        $data_type = $this->att('data_type');

        if ($data_type == 'sermon') {
            $resources = !empty(get_post_meta($post_id, $this->meta_id, 1)) ? get_post_meta($post_id, $this->meta_id, 1) : array();
        } else {
            $resources = !empty(get_term_meta($post_id, $this->meta_id, 1)) ? get_term_meta($post_id, $this->meta_id, 1) : array();
        }

        $resource_empty = true;
        foreach ($resources as $rkey => $rval) {
            if (!empty($rval['file_id']) || !empty($rval['file'])) {
                $resource_empty = false;
            }
        }

        if (!empty($resource_empty)) {
            return array();
        }

        $resources = $this->resource_lang_check($resources);

        $allowed_types = !empty($this->att('resource_type')) ? $this->att('resource_type') : array();
        if (!is_array($allowed_types)) {
            $allowed_types = explode(',', $allowed_types);
        }

        $allowed_file_types = (!empty($this->att('resource_file_type'))) ? $this->att('resource_file_type') : array();
        if (!is_array($allowed_file_types)) {
            $allowed_file_types = explode(',', $allowed_file_types);
        }

		$diff_types      = array_diff( $this->atts_defaults['resource_type'], $allowed_types );
        $diff_file_types = array_diff($this->atts_defaults['resource_file_type'], $allowed_file_types);

		if ( empty( $diff_types ) && empty( $diff_file_types ) ) {
			// Ok, send it all back.
			return $resources;
		}

		$obj = $this->shortcode_object;
		$obj->wants_urls = in_array( 'urls', $allowed_types );
		$obj->wants_files = in_array( 'files', $allowed_types );

		if ( ! $obj->wants_files && ! $obj->wants_urls ) {
			// Ok.. you asked for it, send nothing back.
			return array();
		}

		if ( ! $obj->wants_files ) {

			// send only urls
			// we can ignore file types.
			return array_filter( $resources, array( $this, 'is_url_resource' ) );
		}

		// filter rest
		return array_filter( $resources, array( $this, 'filter_resources_by_types' ) );
	}

	/**
	 * Check Resource Language
	 *
	 * @param $resources
	 *
	 * @return mixed
	 */
    protected function resource_lang_check($resources)
    {
        foreach ($resources as $key => $val) {
            if (empty($val['lang'])) {
                $resources[$key]['lang'] = $this->default_lang;
            }
        }
        return $resources;
    }

	/**
	 * List Items
	 *
	 * @param $resources
	 * @param $resource_display_name
	 *
	 * @return array
	 * @throws Exception
	 */
    protected function list_items($resources, $resource_display_name): array {
        $items = array();

        foreach ($resources as $index => $resource) {

            $resource['do_display_name'] = $resource_display_name;

            $type = $resource['type'] ?? '';
            if ( $type === 'video' && isset($resource['file'])) {
                $resource['embed_args'] = array(
                    'url' => $resource['file'],
                    'src' => $resource['file']
                );
            }

            $resource['item'] = LQDM_Template_Loader::get_template('sermon-resources-shortcode-item', '', $resource);

            $resource['index'] = $index;

            $items[$resource['lang']][] = LQDM_Template_Loader::get_template('sermon-resources-shortcode-li', $resource);
        }

        return $items;
    }

	/**
	 * Filter Resources by Types
	 * @param $resource
	 *
	 * @return bool|mixed
	 */
	public function filter_resources_by_types( $resource ) {

		// If this is a url resource
		if ( $this->is_url_resource( $resource ) ) {
			// Then check if urls are allowed
			return $this->shortcode_object->wants_urls;
		}

		// Ok, we have a file type, but is it the requested file type?
		return in_array( $resource['type'], (array) $this->att( 'resource_file_type' ) );
	}

	/**
	 * Check if Resource is a URL
	 *
	 * @param $resource
	 *
	 * @return bool
	 */
	public function is_url_resource( $resource ): bool {
        return ! isset( $resource['type'] ) || ! trim( $resource['type'] );
	}

}
