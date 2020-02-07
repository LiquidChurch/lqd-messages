<?php
    /**
     *  Liquid Messages Message Admin Shortcodes.
     *
     * @since 0.11.0
     *
     * @package Liquid Messages
     */
    class LqdM_Shortcodes_Sermon_Admin extends LqdM_Shortcodes_Admin_Base
    {
        /**
         * Sets up the button
         *
         * @return array
         */
        function js_button_data()
        {
            return array(
                'qt_button_text' => __('GC Sermon Single', 'lqdm'),
                'button_tooltip' => __('GC Sermon Single', 'lqdm'),
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
                'name'            => __( 'Sermon to show', 'lqdm' ),
                'desc'            => __( 'Blank, "recent", or "0" will display the most recent sermon. Otherwise enter a post ID. Click the magnifying glass to search for a Sermon post.', 'lqdm' ),
                'id'              => $this->prefix . 'sermon_id',
                'type'            => 'post_search_text',
                'post_type'       => $this->run->sermons->post_type(),
                'select_type'     => 'radio',
                'select_behavior' => 'replace',
            );

            $fields[] = array(
                'name' => 'Show Title',
                'desc' => '',
                'id' => $this->prefix . 'show_title',
                'type' => 'checkbox',
                'default' => true
            );

            $fields[] = array(
                'name' => 'Show Content',
                'desc' => '',
                'id' => $this->prefix . 'show_content',
                'type' => 'checkbox',
                'default' => true
            );

            $fields[] = array(
                'name' => 'Image to display',
                'desc' => '',
                'id' => $this->prefix . 'show_image',
                'type'    => 'radio_inline',
                'options' => array(
                    'featured_image' => __( 'Featured Image', 'lqdm' ),
                    'series_image'   => __( 'Series Image', 'lqdm' ),
                ),
                'default' => 'featured_image'
            );

            $fields[] = array(
                'name' => 'Header Media',
                'desc' => '',
                'id' => $this->prefix . 'show_media',
                'type'    => 'radio_inline',
                'options' => array(
                    'video_player'   => __( 'Video Player', 'lqdm' ),
                    'audio_player' => __( 'Audio Player', 'lqdm' ),
                    'featured_image' => __( 'Featured Image', 'lqdm' ),
                    'series_image' => __( 'Series Image', 'lqdm' ),
                ),
                'default' => 'video_player'
            );

            $fields[] = array(
                'name' => 'Show Series',
                'desc' => '',
                'id' => $this->prefix . 'show_series',
                'type' => 'checkbox'
            );

            $fields[] = array(
                'name' => 'Show Part of Series',
                'desc' => '',
                'id' => $this->prefix . 'show_part_of_series',
                'type' => 'checkbox'
            );

            $fields[] = array(
                'name' => 'Show Speaker',
                'desc' => '',
                'id' => $this->prefix . 'show_speakers',
                'type' => 'checkbox'
            );

            $fields[] = array(
                'name' => 'Show Others in Series',
                'desc' => '',
                'id' => $this->prefix . 'show_others_in_series',
                'type' => 'checkbox'
            );

            $fields[] = array(
                'name' => 'Show Topics',
                'desc' => '',
                'id' => $this->prefix . 'show_topics',
                'type' => 'checkbox'
            );

            $fields[] = array(
                'name' => 'Show Tags',
                'desc' => '',
                'id' => $this->prefix . 'show_tags',
                'type' => 'checkbox'
            );

            $fields[] = array(
                'name' => 'Show Date Published',
                'desc' => '',
                'id' => $this->prefix . 'show_date_published',
                'type' => 'checkbox'
            );

            $fields[] = array(
                'name' => 'Show Additional Resource',
                'desc' => '',
                'id' => $this->prefix . 'show_additional_resource',
                'type' => 'checkbox'
            );

            $fields[] = array(
                'name' => 'Show Scripture References',
                'desc' => '',
                'id' => $this->prefix . 'show_scripture_references',
                'type' => 'checkbox'
            );

            return $fields;
        }

    }
