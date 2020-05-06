<?php
/**
 * Liquid Messages Recent Speaker Shortcode - Admin
 *
 * @package Liquid Messages
 */
class LQDMS_Recent_Speaker_Admin extends LQDMS_Recent_Admin_Base {
	/** @var string $prefix Shortcode prefix for field ids */
	protected $prefix = 'speaker_';

	/**
	 * Sets up the JS button
	 *
	 * @return array
	 */
	function js_button_data() {
		return array(
			'qt_button_text' => __( 'Recent Speaker', 'lqdm' ),
			'button_tooltip' => __( 'Recent Speaker', 'lqdm' ),
			'icon'           => 'dashicons-businessman'
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
			'name'            => __( 'Message ID', 'lqdm' ),
			'desc'            => __( 'Blank, "recent", or "0" will get the most recent message\'s speaker info. Otherwise enter a post ID. Click the magnifying glass to search for a Message post.', 'lqdm' ),
			'id'              => $this->prefix . 'sermon_id',
			'type'            => 'post_search_text',
			'post_type'       => $this->run->sermons->post_type(),
			'select_type'     => 'radio',
			'select_behavior' => 'replace',
			'row_classes'     => 'check-if-recent',
		);

		$fields[] = array(
			'name'    => __( 'Filter Most Recent Message By:', 'lqdm' ),
			'desc'    => __( 'If setting "Message ID" above to blank, "recent", or "0", this setting determines which type of most recent message to get the speaker info for.', 'lqdm' ),
			'type'    => 'select',
			'id'      => $this->prefix . 'recent',
			'default' => $this->atts_defaults['recent'],
			'row_classes' => 'hide-if-not-recent',
			'options' => array(
				'recent' => __( 'Most Recent', 'lqdm' ),
				'audio' => __( 'Most Recent with Audio', 'lqdm' ),
				'video' => __( 'Most Recent with Video', 'lqdm' ),
			),
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

		return $fields;
	}
}
