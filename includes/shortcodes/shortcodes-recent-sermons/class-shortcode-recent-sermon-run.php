<?php
    /**
     *  GC Sermons Recent Sermon Shortcodes Run
     *
     * @since   0.10.0
     * @package  GC Sermons
     */

    /**
     *  GC Sermons Shortcodes Recent Sermon Run.
     *
     * @property string $inception_levels Keeps track of inception levels
     * @property string $shortcode        Shortcode tag (gc_recent_sermon)
     * @property array  $atts_defaults    Default attributes of shortcode
     *
     * @since 0.10.0
     */
    class GCS_Shortcodes_Recent_Sermon_Run extends GCS_Shortcodes_Run_Base
    {
        /**
         * Keep track of the levels of inception.
         *
         * @var   string
         * @since 0.10.0
         */
        protected static $inception_levels = 0;

        /**
         * The Shortcode Tag
         *
         * @var string
         * @since 0.10.0
         */
        public $shortcode = 'gc_recent_sermon';

        /**
         * Default attributes applied to the shortcode.
         *
         * @var array
         * @since 0.10.0
         */
        public $atts_defaults
            = array(
                'per_page'          => 10,
                'remove_pagination' => false,
                'thumbnail_size'    => 'medium',
                'number_columns'    => 2,
            );

        /**
         * Shortcode Output
         */
        public function shortcode()
        {
            $output = $this->_shortcode();

            return apply_filters('gc_sermon_recent_sermon_shortcode_output', $output, $this);
        }

	    /**
	     *
	     * @return string
	     * @throws Exception
	     */
        protected function _shortcode()
        {
        /*
         * Because it's possible to trigger inception, we need to keep track which
         * level we are in, and reset the shortcode object accordingly.
         *
         * Clever alert. The ++ happens AFTER the value is read, So $my_level starts at 0.
         */
            $my_level = self::$inception_levels++;

            $args = $this->get_initial_query_args();

            $sermons = $this->sermons->get_many($args);

            if (!$sermons->have_posts()) {
                return '';
            }

            $max = $sermons->max_num_pages;
            $sermons = $this->map_sermon_args($sermons, $my_level);

            $content = '';
            if (0 === $my_level) {
                $content .= GCS_Style_Loader::get_template('list-item-style');
            }

            $args = $this->get_pagination($max);
            $args['wrap_classes'] = $this->get_wrap_classes();
            $args['sermons'] = $sermons;
            $args['plugin_option'] = get_plugin_settings_options('single_message_view');

            $content .= GCS_Template_Loader::get_template('sermons-list', $args);

            return $content;
        }

	    /**
	     * Get Initial Query Arguments
	     *
	     * @return array
	     */
        public function get_initial_query_args()
        {
            $posts_per_page = (int)$this->att('per_page', get_option('posts_per_page'));
            $paged = (int)get_query_var('paged') ? get_query_var('paged') : 1;
            $offset = (($paged - 1) * $posts_per_page) + $this->att('list_offset', 0);
            $order = 'DESC';
            $orderby = 'date';


            return compact('posts_per_page', 'paged', 'offset', 'order', 'orderby');
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

	    /**
	     * Get Pagination
	     *
	     * @param $total_pages
	     *
	     * @return array
	     */
        protected function get_pagination($total_pages)
        {
            $nav = array('prev_link' => '', 'next_link' => '');

            if (!$this->bool_att('remove_pagination')) {
                $nav['prev_link'] = get_previous_posts_link(__('<span>&larr;</span> Newer', 'gc-sermons'), $total_pages);
                $nav['next_link'] = get_next_posts_link(__('Older <span>&rarr;</span>', 'gc-sermons'), $total_pages);
            }

            return $nav;
        }

	    /**
	     * Get Wrap Classes
	     *
	     * @return string
	     */
        protected function get_wrap_classes()
        {
            $columns = absint($this->att('number_columns'));
            $columns = $columns < 1 ? 1 : $columns;

            return $this->att('wrap_classes') . ' gc-' . $columns . '-cols gc-sermons-wrap';
        }

    }
