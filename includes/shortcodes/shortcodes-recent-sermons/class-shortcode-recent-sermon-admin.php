<?php
    /**
     *  GC Sermons Shortcodes Recent Sermon Admin
     *
     * @since   0.10.0
     * @package  GC Sermons
     */
    
    /**
     *  GC Sermons Shortcodes Recent Sermon Admin.
     *
     * @since 0.10.0
     */
    class GCS_Shortcodes_Recent_Sermon_Admin extends GCSS_Recent_Admin_Base
    {
        /**
         * Sets up the button
         *
         * @return array
         */
        function js_button_data()
        {
            return array(
                'qt_button_text' => __('GCS Recent Sermon', 'lc-func'),
                'button_tooltip' => __('GCS Recent Sermon', 'lc-func'),
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
        function fields($fields, $button_data)
        {
            $fields[] = array(
                'name' => __( 'Per Page', 'lc-func' ),
                'desc' => __( '', 'lc-func' ),
                'id'   => 'per_page',
                'type' => 'text',
                'default' => '10',
                'attributes' => array(
                    'type' => 'number',
                    'pattern' => '\d*',
                    'min' => '1',
                    'max' => '25',
                ),
                'sanitization_cb' => 'absint',
                'escape_cb'       => 'absint',
            );
            
            $fields[] = array(
                'name' => 'Remove Pagination',
                'desc' => '',
                'id'   => 'remove_pagination',
                'type' => 'checkbox',
                'default' => false,
            );
    
            $fields[] = array(
                'name'             => 'Thumbnail Size',
                'desc'             => '',
                'id'               => 'thumbnail_size',
                'type'             => 'select',
                'show_option_none' => false,
                'default'          => 'thumbnail',
                'options'          => $this->get_thumb_size_list(),
            );
            
            $fields[] = array(
                'name' => __( 'Number of Coloumns', 'lc-func' ),
                'desc' => __( '', 'lc-func' ),
                'id'   => 'number_columns',
                'type' => 'text',
                'default' => '2',
                'attributes' => array(
                    'type' => 'number',
                    'pattern' => '\d*',
                    'min' => '1',
                    'max' => '4',
                ),
                'sanitization_cb' => 'absint',
                'escape_cb'       => 'absint',
            );
            
            return $fields;
        }
        
        public function get_thumb_size_list() {
            $image_sizes = get_intermediate_image_sizes();
            $return = [];
            foreach ($image_sizes as $index => $image_size) {
                $return[$image_size] = $image_size;
            }
            return $return;
        }
    }
