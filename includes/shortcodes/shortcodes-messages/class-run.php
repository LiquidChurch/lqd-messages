<?php
/**
 * Liquid Messages Shortcodes Messages Run.
 *
 * @package Liquid Messages
 */
class LqdM_Messages_Run extends LqdM_Shortcodes_Run_Base
{
    /**
     * The Shortcode Tag
     * @var string
     * @since 0.1.0
     */
    public $shortcode = 'lqdm_messages';

    /**
     * Default attributes applied to the shortcode.
     * @var array
     * @since 0.1.0
     */
    public $atts_defaults = array(
        'per_page'          => 10, // Will use WP's per-page option.
        'content'           => 'excerpt',
        'remove_thumbnail'  => false,
        'thumbnail_size'    => 'medium',
        'number_columns'    => 2,
        'list_offset'       => 0,
        'wrap_classes'      => '',
        'remove_pagination' => false,
        'related_speaker'   => 0,
        'related_series'   => 0,
    );

    /**
     * LqdM_Taxonomies object
     *
     * @var   LqdM_Taxonomies
     * @since 0.1.0
     */
    public $taxonomies;

    /**
     * Keep track of the levels of inception.
     *
     * @var   string
     * @since 0.1.5
     */
    protected static $inception_levels = 0;

    /**
     * Constructor
     *
     * @param LqdM_Messages $messages
     * @param LqdM_Taxonomies $taxonomies
     *
     * @since 0.1.3
     *
     */
    public function __construct(LqdM_Messages $messages, LqdM_Taxonomies $taxonomies)
    {
        $this->taxonomies = $taxonomies;
        parent::__construct($messages);
    }

    /**
     * Shortcode Output
     */
    public function shortcode()
    {
        /*
         * Because it's possible to trigger inception, we need to keep track which
         * level we are in, and reset the shortcode object accordingly.
         *
         * Clever alert. The ++ happens AFTER the value is read, So $my_level starts at 0.
         */
        $my_level = self::$inception_levels++;

        $args = $this->map_related_term_args($this->get_initial_query_args());

        if (!$args) {
            // We failed the related term check.
            return '';
        }

        if (!isset($args['post__not_in']) && is_singular($this->messages->post_type())) {
            $args['post__not_in'] = array(get_queried_object_id());
        } elseif(is_singular($this->messages->post_type())) {
            $get_video_post = get_posts(array(
                'post_type' => $this->messages->post_type(),
                'meta_key' => 'lqdm_exclude_msg',
                'meta_value' => 'on',
            ));

            $get_video_post_ids = wp_list_pluck($get_video_post, 'ID');

            $args['post__not_in'] = array_unique(array_merge($args['post__not_in'], $get_video_post_ids));
        }

        $messages = $this->messages->get_many($args);

        if (!$messages->have_posts()) {
            return '';
        }

        $max     = $messages->max_num_pages;
        $messages = $this->map_message_args($messages, $my_level);

        $content = '';
        if (0 === $my_level) {
            $content .= LqdM_Style_Loader::get_template('list-item-style');
        }

        $args = $this->get_pagination($max);
        $args['wrap_classes']  = $this->get_wrap_classes();
        $args['messages']       = $messages;
        $args['plugin_option'] = lqdm_get_plugin_settings_options('single_message_view');

        $content .= LqdM_Template_Loader::get_template('messages-list', $args);

        return $content;
    }

    /**
     * Get Initial Query Args
     *
     * @return array
     */
    public function get_initial_query_args()
    {
        $posts_per_page = (int)$this->att('per_page', get_option('posts_per_page'));
        $paged          = (int)get_query_var('paged') ? get_query_var('paged') : 1;
        $offset         = (($paged - 1) * $posts_per_page) + $this->att('list_offset', 0);

        return compact('posts_per_page', 'paged', 'offset');
    }

	/**
	 * Map Related Term Args
	 *
	 * @param $args
	 *
	 * @return bool
	 */
    protected function map_related_term_args($args)
    {
        $required = false;
        $passes   = false;
        $keys     = array(
            'series'  => 'related_series',
            'speaker' => 'related_speaker',
        );

        foreach ($keys as $key => $param) {

            if ($term_id = absint($this->att($param))) {

                $args['tax_query'][] = array(
                    'taxonomy' => $this->taxonomies->{$key}->taxonomy(),
                    'field'    => 'id',
                    'terms'    => $term_id,
                );

                continue;
            }

            if ('this' !== $this->att($param)) {
                continue;
            }

            $required = true;

            try {
                $message = lqdm_get_message_post(get_queried_object(), true);

                $args['post__not_in'] = array($message->ID);

                $method = 'get_' . $key;
                $term   = $message->$method();

                if (!$term) {
                    throw new Exception('No ' . $key . ' term.');
                }

            } catch(Exception $e) {
                continue;
            }

            $passes = true;

            $args['tax_query'][] = array(
                'taxonomy' => $this->taxonomies->{$key}->taxonomy(),
                'field'    => 'id',
                'terms'    => $term->term_id,
            );

        }

        if ($required && !$passes) {
            // They wanted messages associated to 'this', but that's not possible.
            return false;
        }

        return $args;
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

        $do_thumb        = !$this->bool_att('remove_thumbnail');
        $do_content      = $this->bool_att('content');
        $type_of_content = $this->att('content');
        $thumb_size      = $this->att('thumbnail_size');

        while ($all_messages->have_posts()) {
            $all_messages->the_post();

            $obj = $all_messages->post;

            $message = array();
            $message['url']            = $obj->permalink();
            $message['name']           = $obj->title();
            $message['image']          = $do_thumb ? $obj->featured_image($thumb_size) : '';
            $message['do_image']       = (bool)$message['image'];
            $message['description']    = '';
            $message['do_description'] = $do_content;
            if ($do_content) {
                $message['description'] = 'excerpt' === $type_of_content
                    ? $obj->loop_excerpt()
                    : apply_filters('the_content', $obj->post_content);
            }

            $messages[] = $message;
        }

        wp_reset_postdata();

        if ($do_content) {
            /*
             * Reset shortcode_object as well, as calling the content/excerpt
             * could trigger inception and change the object under us.
             */
            $this->shortcode_object = WDS_Shortcode_Instances::get($this->shortcode, $my_level);
        }

        return $messages;
    }
}
