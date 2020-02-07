<?php
    /**
     *  Liquid Messages Single Message Shortcode - Run.
     *
     * @since 0.11.0
     * @package Liquid Messages
     */
    class LqdM_Shortcodes_Message_Run extends LqdM_Shortcodes_Run_Base
    {
        /**
         * The Shortcode Tag
         *
         * @var string
         * @since 0.11.0
         */
        public $shortcode = 'lqdm_message';

        /**
         * Default attributes applied to the shortcode.
         *
         * @var array
         * @since 0.11.0
         */
        public $atts_defaults
            = array(
                'message_id'                 => 0,
                'show_title'                => true,
                'show_content'              => true,
                'show_image'                => 'featured_image',
                'show_media'                => 'video_player',
                'show_series'               => false,
                'show_part_of_series'       => false,
                'show_speakers'             => false,
                'show_others_in_series'     => false,
                'show_topics'               => false,
                'show_tags'                 => false,
                'show_date_published'       => false,
                'show_additional_resource'  => false,
                'show_scripture_references' => false,


                // no admin
                'do_scripts'                => true,
            );

        /**
         * Shortcode Output
         */
        public function shortcode()
        {
            $output = $this->_shortcode();

            return apply_filters('lqdm_message_shortcode_output', $output, $this);
        }

	    /**
	     * Shortcode
	     *
	     * @return string
	     * @throws Exception
	     */
        protected function _shortcode()
        {
            $message = $this->get_message();

            if (empty($message)) {
                return '';
            }

            if ($this->att('do_scripts')) {
                $this->do_scripts();
            }

            $args['message'] = $message;
            $args['atts'] = [
                'show_title'                => $this->atts['show_title'],
                'show_content'              => $this->atts['show_content'],
                'show_image'                => $this->atts['show_image'],
                'show_media'                => $this->atts['show_media'],
                'show_series'               => $this->atts['show_series'],
                'show_part_of_series'       => $this->atts['show_part_of_series'],
                'show_speakers'             => $this->atts['show_speakers'],
                'show_others_in_series'     => $this->atts['show_others_in_series'],
                'show_topics'               => $this->atts['show_topics'],
                'show_tags'                 => $this->atts['show_tags'],
                'show_date_published'       => $this->atts['show_date_published'],
                'show_additional_resource'  => $this->atts['show_additional_resource'],
                'show_scripture_references' => $this->atts['show_scripture_references'],
            ];
            $args['plugin_option'] = lqdm_get_plugin_settings_options('single_message_view');
            $args['inline_style'] = $this->inline_style();

            $content = LqdM_Template_Loader::get_template('messages-single', $args);

            return $content;
        }

	    /**
	     * Do Scripts
	     */
        public function do_scripts()
        {

            wp_enqueue_script(
                'fitvids',
                Lqd_Messages_Plugin::$url . 'assets/js/vendor/jquery.fitvids.js',
                array('jquery'),
                '1.1',
                true
            );
        }

	    /**
	     * Inline Style
	     *
	     * @return string
	     */
        public function inline_style()
        {
            return '<style type="text/css">' .
                   '#lqdm-single-message-player img {width: 100%;}' .
                   '</style>';
        }

	    /**
	     * Map Message Args
	     *
	     * @param $all_messages
	     * @param $my_level
	     *
	     * @return array
	     */
        protected function map_message_args($all_messages, $my_level)
        {
            global $post;

            $messages = array();

            $thumb_size = $this->att('thumbnail_size');

            while ($all_messages->have_posts()) {
                $all_messages->the_post();

                $obj = $all_messages->post;

                $message = array();
                $message['url'] = $obj->permalink();
                $message['name'] = $obj->title();
                $message['image'] = $obj->featured_image($thumb_size);
                $message['do_image'] = (bool)$message['image'];
                $message['description'] = '';

                $messages[] = $message;
            }

            wp_reset_postdata();

            return $messages;
        }


    }
