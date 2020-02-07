<?php
/**
 *  Liquid Messages Recent Message Shortcode - Run.
 *
 * @since 0.10.0
 * @package Liquid Messages
 */
class LqdM_Shortcodes_Recent_Message_Run extends LqdM_Shortcodes_Run_Base
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
    public $shortcode = 'lqdm_recent_message';

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

        return apply_filters('lqdm_recent_message_shortcode_output', $output, $this);
    }

    /**
     *
     * @return string
     * @throws Exception
     */
    protected function _shortcode()
    {
        /**
         * Because it's possible to trigger inception, we need to keep track which
         * level we are in, and reset the shortcode object accordingly.
         *
         * Clever alert. The ++ happens AFTER the value is read, So $my_level starts at 0.
         */
        $my_level = self::$inception_levels++;

        $args = $this->get_initial_query_args();

        $messages = $this->messages->get_many($args); // TODO: Dupe code?

        if (!$messages->have_posts()) {
            return '';
        }

        $max = $messages->max_num_pages;
        $messages = $this->map_message_args($messages, $my_level);

        $content = '';
        if (0 === $my_level) {
            $content .= LqdM_Style_Loader::get_template('list-item-style');
        }

        $args = $this->get_pagination($max);
        $args['wrap_classes'] = $this->get_wrap_classes();
        $args['messages'] = $messages;
        $args['plugin_option'] = lqdm_get_plugin_settings_options('single_message_view');

        $content .= LqdM_Template_Loader::get_template('messages-list', $args);

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
     * Map Message Arguments
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
            $nav['prev_link'] = get_previous_posts_link(__('<span>&larr;</span> Newer', 'lqdm'));
            $nav['next_link'] = get_next_posts_link(__('Older <span>&rarr;</span>', 'lqdm'));
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

        return $this->att('wrap_classes') . ' lqdm-' . $columns . '-cols lqdm-messages-wrap';
    }

}
