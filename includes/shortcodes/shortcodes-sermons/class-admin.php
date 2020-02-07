<?php
/**
 * Liquid Messages Admin Shortcodes.
 *
 * @package Liquid Messages
 */
class LqdM_Sermons_Admin extends LqdM_Shortcodes_Admin_Base {

	/**
	 * Messages Taxonomies
	 *
	 * @var LqdM_Taxonomies
	 */
	protected $taxonomies;

	/**
	 * Shortcode prefix for field ids.
	 *
	 * @var   string
	 * @since 0.1.3
	 */
	protected $prefix = 'sermon_';

    /**
     * Constructor
     *
     * @param LqdM_Shortcodes_Run_Base $run Main plugin object.
     * @param LqdM_Taxonomies $taxonomies Messages Taxonomies object.
     *
     * @since  0.1.0
     */
	public function __construct( LqdM_Shortcodes_Run_Base $run, LqdM_Taxonomies $taxonomies ) {
		$this->taxonomies = $taxonomies;
		parent::__construct( $run );

		add_filter( "{$this->shortcode}_shortcode_fields", [ $this, 'return_taxonomy_term_id_only' ], 10 );
	}

	/**
	 * Sets up the button
	 *
	 * @return array
	 */
	function js_button_data() {
		return [
			'qt_button_text' => __( 'Liquid Messages', 'lqdm' ),
			'button_tooltip' => __( 'Liquid Messages', 'lqdm' ),
			'icon'           => $this->run->sermons->arg_overrides['menu_icon']
        ];
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

		$fields[] = [
			'name'    => __( 'Number of messages to show per-page', 'lqdm' ),
			'type'    => 'text_small',
			'id'      => $this->prefix . 'per_page',
			'default' => get_option( 'posts_per_page', $this->atts_defaults['per_page'] ),
        ];

		$fields[] = [
			'name'       => sprintf( _x( 'Optionally select to limit %1$s by %2$s', 'limit messages by series.', 'lqdm' ), $this->run->sermons->post_type( 'plural' ), $this->taxonomies->series->taxonomy( 'plural' ) ),
			'desc'       => sprintf( __( 'Start typing to search. Enter "this" to use this post\'s %s.', 'lqdm' ), $this->taxonomies->series->taxonomy( 'singular' ) ),
			'type'       => 'term_select',
			'apply_term' => false,
			'id'         => $this->prefix . 'related_series',
			'taxonomy'   => $this->taxonomies->series->taxonomy(),
			'attributes' => [
				'data-min-length' => 2,
				'data-delay'      => 100,
            ],
        ];

		$fields[] = [
			'name'       => sprintf( _x( 'Optionally select to limit %1$s by %2$s', 'limit messages by speaker.', 'lqdm' ), $this->run->sermons->post_type( 'plural' ), $this->taxonomies->speaker->taxonomy( 'plural' ) ),
			'desc'       => sprintf( __( 'Start typing to search. Enter "this" to use this post\'s %s.', 'lqdm' ), $this->taxonomies->speaker->taxonomy( 'singular' ) ),
			'type'       => 'term_select',
			'apply_term' => false,
			'id'         => $this->prefix . 'related_speaker',
			'taxonomy'   => $this->taxonomies->speaker->taxonomy(),
			'attributes' => [
				'data-min-length' => 2,
				'data-delay'      => 100,
            ],
        ];

		$fields[] = [
			'name'    => __( 'Remove Pagination', 'lqdm' ),
			'type'    => 'checkbox',
			'id'      => $this->prefix . 'remove_pagination',
			'default' => false,
        ];

		$fields[] = [
			'name'    => __( 'Content', 'lqdm' ),
			'type'    => 'radio',
			'id'      => $this->prefix . 'content',
			'default' => $this->atts_defaults['content'],
			'options' => [
				''        => __( 'None', 'lqdm' ),
				'content' => __( 'Message Post Content', 'lqdm' ),
				'excerpt' => __( 'Message Post Excerpt', 'lqdm' ),
            ],
        ];

		$fields[] = [
			'name'    => __( 'Remove Thumbnails', 'lqdm' ),
			'type'    => 'checkbox',
			'id'      => $this->prefix . 'remove_thumbnail',
			'default' => false,
        ];

		$fields[] = [
			'name'    => __( 'Thumbnail Size (if included)', 'lqdm' ),
			'type'    => 'text',
			'id'      => $this->prefix . 'thumbnail_size',
			'default' => $this->atts_defaults['thumbnail_size'],
        ];

		$fields[] = [
			'name'    => __( 'Max number of columns', 'lqdm' ),
			'desc'    => __( 'Will vary on device screen width', 'lqdm' ),
			'type'    => 'radio_inline',
			'options' => [ 1 => 1, 2 => 2, 3 => 3, 4 => 4 ],
			'id'      => $this->prefix . 'number_columns',
			'default' => $this->atts_defaults['number_columns'],
        ];

		$fields[] = [
			'name'            => __( 'Offset', 'lqdm' ),
			'desc'            => __( 'Changes which message starts the list', 'lqdm' ),
			'type'            => 'text_small',
			'id'              => $this->prefix . 'list_offset',
			'sanitization_cb' => 'absint',
			'default'         => $this->atts_defaults['list_offset'],
        ];

		$fields[] = [
			'name'    => __( 'Extra Wrap CSS Classes', 'lqdm' ),
			'desc'    => __( 'Enter classes separated by spaces (e.g. "class1 class2")', 'lqdm' ),
			'type'    => 'text',
			'id'      => $this->prefix . 'wrap_classes',
			'default' => $this->atts_defaults['wrap_classes'],
        ];

		return $fields;
	}

	/**
	 * Return Taxonomy Term ID Only
	 *
	 * @param $updated
	 *
	 * @return mixed
	 */
	public function return_taxonomy_term_id_only( $updated ) {
		$term_id_params = [ 'lqdm_related_series', 'lqdm_related_speaker' ];
		foreach ( $term_id_params as $param ) {
			if ( isset( $updated[ $param ], $updated[ $param ]['id'] ) ) {
				if ( isset( $updated[ $param ]['name'] ) && 'this' === $updated[ $param ]['name'] ) {
					$updated[ $param ] = $updated[ $param ]['name'];
				} else {
					$updated[ $param ] = $updated[ $param ]['id'];
				}
			}
		}

		return $updated;
	}

}
