<?php
    /**
     *  GC Sermons Shortcodes Sermon Run.
     *
     * @since 0.11.0
     * @package GC Sermons
     */
    class LqdM_Shortcodes_Sermon_Run extends LqdM_Shortcodes_Run_Base
    {
        /**
         * The Shortcode Tag
         *
         * @var string
         * @since 0.11.0
         */
        public $shortcode = 'gc_sermon';

        /**
         * Default attributes applied to the shortcode.
         *
         * @var array
         * @since 0.11.0
         */
        public $atts_defaults
            = array(
                'sermon_id'                 => 0,
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

            return apply_filters('gc_sermon_shortcode_output', $output, $this);
        }

	    /**
	     * Shortcode
	     *
	     * @return string
	     * @throws Exception
	     */
        protected function _shortcode()
        {
            $sermon = $this->get_sermon();

            if (empty($sermon)) {
                return '';
            }

            if ($this->att('do_scripts')) {
                $this->do_scripts();
            }

            $args['sermon'] = $sermon;
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
            $args['plugin_option'] = get_plugin_settings_options('single_message_view');
            $args['inline_style'] = $this->inline_style();

            $content = LqdM_Template_Loader::get_template('sermons-single', $args);

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
                   '#single-sermon-player img {width: 100%;}' .
                   '</style>';
        }

	    /**
	     * Map Sermon Args
	     *
	     * @param $all_sermons
	     * @param $my_level
	     *
	     * @return array
	     */
        protected function map_sermon_args($all_sermons, $my_level)
        {
            global $post;
            $sermons = array();

            $thumb_size = $this->att('thumbnail_size');

            while ($all_sermons->have_posts()) {
                $all_sermons->the_post();

                $obj = $all_sermons->post;

                $sermon = array();
                $sermon['url'] = $obj->permalink();
                $sermon['name'] = $obj->title();
                $sermon['image'] = $obj->featured_image($thumb_size);
                $sermon['do_image'] = (bool)$sermon['image'];
                $sermon['description'] = '';

                $sermons[] = $sermon;
            }

            wp_reset_postdata();

            return $sermons;
        }


    }
