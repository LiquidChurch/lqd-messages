<?php
/**
 * Liquid Messages Play Button Admin Shortcodes
 *
 * @package Liquid Messages
 */
class LqdM_Play_Button_Admin extends LqdM_Shortcodes_Admin_Base {

	/**
	 * Shortcode prefix for field ids.
	 *
	 * @var   string
	 * @since 0.1.3
	 */
	protected $prefix = 'lqdm_pl_btn_';

	/**
	 * Sets up the button
	 *
	 * @return array
	 */
	function js_button_data() {
		return [
			'qt_button_text' => __( 'Message Play Button', 'lqdm' ),
			'button_tooltip' => __( 'Message Play Button', 'lqdm' ),
			'icon'           => 'dashicons-controls-play',
			'mceView'        => true, // The future
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
			'name'            => __( 'Message to play', 'lqdm' ),
			'desc'            => __( 'Blank, "recent", or "0" will play the most recent video. Otherwise enter a post ID. Click the magnifying glass to search for a message.', 'lqdm' ),
			'id'              => $this->prefix . 'sermon_id',
			'type'            => 'post_search_text',
			'post_type'       => $this->run->sermons->post_type(),
			'select_type'     => 'radio',
			'select_behavior' => 'replace',
        ];

		$fields[] = [
			'name'    => __( 'Icon Color', 'lqdm' ),
			'type'    => 'colorpicker',
			'id'      => $this->prefix . 'icon_color',
			'default' => $this->atts_defaults['icon_color'],
        ];

		$fields[] = [
			'name'    => __( 'Icon Size', 'lqdm' ),
			'desc'    => __( 'Select a font-size (in <code>em</code>s, <strong>or</strong> enter either "medium", "large", or "small".', 'lqdm' ),
			'type'    => 'text',
			'id'      => $this->prefix . 'icon_size',
			'default' => $this->atts_defaults['icon_size'],
        ];

		$fields[] = [
			'name'    => __( 'Extra CSS Classes', 'lqdm' ),
			'desc'    => __( 'Enter classes separated by spaces (e.g. "class1 class2")', 'lqdm' ),
			'type'    => 'text',
			'id'      => $this->prefix . 'icon_class',
			'default' => $this->atts_defaults['icon_class'],
        ];

		return $fields;
	}
}
