<?php
/**
 *  Liquid Messages Recent Message Admin Shortcodes.
 *
 * @since 0.10.0
 *
 * @package Liquid Messages
 */
class LqdM_Shortcodes_Recent_Sermon_Admin extends LqdM_Recent_Admin_Base
{
    /**
     * Sets up the button
     *
     * @return array
     */
    function js_button_data()
    {
        return [
            'qt_button_text' => __('Recent Message', 'lqdm'),
            'button_tooltip' => __('Recent Message', 'lqdm'),
            'icon'           => 'dashicons-media-interactive'
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
    function fields($fields, $button_data)
    {
        $fields[] = [
            'name' => __( 'Per Page', 'lqdm' ),
            'desc' => __( '', 'lqdm' ),
            'id'   => 'per_page',
            'type' => 'text',
            'default' => '10',
            'attributes' => [
                'type' => 'number',
                'pattern' => '\d*',
                'min' => '1',
                'max' => '25',
            ],
            'sanitization_cb' => 'absint',
            'escape_cb'       => 'absint',
        ];

        $fields[] = [
            'name' => 'Remove Pagination',
            'desc' => '',
            'id'   => 'remove_pagination',
            'type' => 'checkbox',
            'default' => false,
        ];

        $fields[] = [
            'name'             => 'Thumbnail Size',
            'desc'             => '',
            'id'               => 'thumbnail_size',
            'type'             => 'select',
            'show_option_none' => false,
            'default'          => 'thumbnail',
            'options'          => $this->get_thumb_size_list(),
        ];

        $fields[] = [
            'name' => __( 'Number of Columns', 'lqdm' ),
            'desc' => __( '', 'lqdm' ),
            'id'   => 'number_columns',
            'type' => 'text',
            'default' => '2',
            'attributes' => [
                'type' => 'number',
                'pattern' => '\d*',
                'min' => '1',
                'max' => '4',
            ],
            'sanitization_cb' => 'absint',
            'escape_cb'       => 'absint',
        ];

        return $fields;
    }

    /**
     * Get thumb size list
     *
     * @return array
     */
    public function get_thumb_size_list() {
        $image_sizes = get_intermediate_image_sizes();
        $return = [];
        foreach ($image_sizes as $index => $image_size) {
            $return[$image_size] = $image_size;
        }
        return $return;
    }
}
