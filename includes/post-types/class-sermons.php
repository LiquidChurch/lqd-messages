<?php
/**
 * Liquid Messages Message Post Type
 *
 * @package Liquid Messages
 */
class LqdM_Messages extends LqdM_Post_Types_Base
{
    /**
     * The identifier for this object
     *
     * @var string
     */
    protected $id = 'sermon';

    /**
     * Parent plugin class
     *
     * @since  0.1.0
     */
    protected $plugin = null;

    /**
     * Bypass temporary cache
     *
     * @var    boolean
     * @since  0.1.0
     */
    public $flush = false;

    /**
     * Default WP_Query args
     *
     * @var   array
     * @since 0.1.0
     */
    protected $query_args = [
        'post_type'      => 'THIS(REPLACE)',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'no_found_rows'  => true,
    ];

    /**
     * Constructor
     * Register Custom Post Types. See documentation in CPT_Core, and in wp-includes/post.php
     *
     * @since  0.1.0
     * @param  object $plugin Main plugin object.
     * @return void
     */
    public function __construct($plugin)
    {
        // First parameter should be an array with Singular, Plural, and Registered name.
        parent::__construct($plugin, [
            'labels' => [ __('Sermon', 'lqdm'), __('Sermons', 'lqdm'), 'lqd-messages' ],
            'args' => [
                'supports' => [ 'title', 'editor', 'excerpt', 'thumbnail' ],
                'menu_icon' => 'dashicons-playlist-video',
                'rewrite' => [
                    'slug' => 'sermons', // TODO: Change to messages?
                    'with_front' => false,
                    'ep_mask' => EP_ALL,
                ],
            ],
        ] );
        $this->query_args['post_type'] = $this->post_type();
    }

    /**
     * Initiate our hooks
     *
     * @since  0.1.0
     * @return void
     */
    public function hooks()
    {
        add_action('cmb2_admin_init', [ $this, 'fields' ] );
        add_filter('cmb2_override_excerpt_meta_value', [ $this, 'get_excerpt' ], 10, 2);
        add_filter('cmb2_override_excerpt_meta_save', '__return_true');
        add_filter('admin_init', [ $this, 'admin_hooks' ] );

        /**
         * Enable image fallback. If Sermon does not have a featured image, fall back
         * to the sermon series image (if it exists).
         *
         * To disable:
         *    add_filter( 'lqdm_do_sermon_series_fallback_image', '__return_false' );
         *
         */
        if (apply_filters('lqdm_do_sermon_series_fallback_image', true))
        {
            add_filter('get_post_metadata', [ $this, 'featured_image_fallback_to_series_image' ], 10, 3);
        }

        /**
         * Enable future posts to be displayed.
         *
         * If false, future posts will be 'scheduled', WordPress' default behavior.
         *
         * To disable:
         *    add_filter( 'lqdm_display_future_sermons', '__return_false' );
         *
         */
        if (apply_filters('lqdm_display_future_sermons', true)) {
            add_filter('wp_insert_post_data', [ $this, 'save_future_as_published' ], 10, 2);
            if (!is_admin()) {
                add_filter('the_title', [ $this, 'label_coming_soon' ], 10, 2);
            }
        }
    }

    /**
     * Initiate our admin hooks
     *
     * @since  0.1.1
     * @return void
     */
    public function admin_hooks()
    {
        add_action('dbx_post_advanced', [ $this, 'remove_default_boxes_for_sermons' ] );
        add_filter("manage_edit-{$this->post_type()}_columns", [ $this, 'columns' ] );
        add_filter("manage_edit-{$this->post_type()}_sortable_columns", [ $this, 'columns_sortable' ], 10, 1);
        add_filter('posts_clauses', [ $this, 'columns_sort_func' ], 10, 2);
        add_action('wp_ajax_check_sermon_duplicate_video', [ $this, 'check_sermon_duplicate_video' ] );
        add_action('wp_ajax_nopriv_check_sermon_duplicate_video', [ $this, 'check_sermon_duplicate_video' ] );
    }

    /**
     * Remove default excerpt and featured image metaboxes for Sermons
     *
     * @since  0.1.3
     *
     * @return void
     */
    public function remove_default_boxes_for_sermons()
    {
        $screen = get_current_screen();

        if (isset($screen->post_type) && $this->post_type() === $screen->post_type) {
            remove_meta_box('postexcerpt', null, 'normal');
            remove_meta_box('postimagediv', null, 'side');
        }
    }

	/**
	 * This provides a backup featured image for sermons by checking the sermon series
	 * for the series featured image. If a sermon has a featured image set, that will be used.
	 *
	 * @since  0.1.3
	 *
	 * @param         $meta
	 * @param  int    $object_id  Object ID.
	 * @param  string $meta_key   Meta key.
	 *
	 * @return mixed Sermon featured image id, or Series image id, or nothing.
	 * @throws Exception
	 */
    public function featured_image_fallback_to_series_image($meta, $object_id, $meta_key)
    {

        // Override thumbnail_id check and get the series image id as a fallback.
        if ('_thumbnail_id' === $meta_key && $this->post_type() === get_post_type($object_id)) {

            // Have to remove this filter to get the actual value to see if we need to do the work.
            remove_filter('get_post_metadata', [ $this, 'featured_image_fallback_to_series_image' ], 10);
            $id = get_post_thumbnail_id($object_id);
            add_filter('get_post_metadata', [ $this, 'featured_image_fallback_to_series_image' ], 10, 3);

            // If no featured image exists...
            if (!$id || !get_post($id)) {

                // Get sermon.
                $sermon = new LqdM_Message_Post(get_post($object_id));

                // Get series.
                $series = $sermon->get_series();

                // Send series image id.
                return isset($series->image_id) ? $series->image_id : $id;
            }
        }

        return $meta;
    }

    /**
     * When a scheduled message post is saved, change the status back to 'publish'.
     * This allows the future-date messages to show on the front-end.
     *
     * @since  0.1.3
     *
     * @param  array $data    Array of post data for update.
     * @param  array $postarr Full array of post data.
     *
     * @return array           Modified post data array.
     */
    public function save_future_as_published($data, $postarr)
    {
        if (
            !isset($postarr['ID'], $data['post_status'], $data['post_type'])
            || 'future' !== $data['post_status']
            || $this->post_type() !== $data['post_type']
        ) {
            return $data;
        }

        $data['post_status'] = 'publish';

        return $data;
    }

	/**
	 * Possibly add a "Coming Soon" prefix to future message titles.
	 *
     * @since  0.2.1
     *
	 * @param string $title
	 * @param int    $post_id
	 *
	 * @return string
	 */
    public function label_coming_soon($title, $post_id = 0)
    {
        static $now = null;
        static $done = [];

        $post_id = $post_id ? $post_id : get_the_ID();

        if (isset($done[$post_id])) {
            return $done[$post_id];
        }

        $now = null === $now ? gmdate('Y-m-d H:i:59') : $now;

        if (mysql2date('U', get_post($post_id)->post_date_gmt, false) > mysql2date('U', $now, false)) {

            $coming_soon_prefix = apply_filters('lqdm_coming_soon_prefix', '<span class="lqdm-coming-soon-prefix">' . __('Coming Soon:', 'lqdm') . '</span> ', $post_id, $this);
            $title = $coming_soon_prefix . $title;
        }

        $done[$post_id] = $title;

        return $title;
    }

    /**
     * Add custom fields to the CPT
     *
     * @since  0.1.0
     * @return void
     */
    public function fields()
    {
        $fields = [
            'lqdm_video_url' => [
                'id'   => 'lqdm_video_url',
                'name' => __('Video URL', 'lqdm'),
                'desc' => __('Enter a youtube, or vimeo URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.', 'lqdm'),
                'type' => 'oembed',
            ],
            'lqdm_video_src' => [
                'id'      => 'lqdm_video_src',
                'name'    => __('Video File', 'lqdm'),
                'desc'    => __('Alternatively upload/select video from your media library.', 'lqdm'),
                'type'    => 'file',
                'options' => [ 'url' => false ],
            ],
            'lqdm_audio_url' => [
                'id'   => 'lqdm_audio_url',
                'name' => __('Audio URL', 'lqdm'),
                'desc' => __('Enter a soundcloud, spotify, or other oembed-supported web audio URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.', 'lqdm'),
                'type' => 'oembed',
            ],
            'lqdm_audio_src' => [
                'id'      => 'lqdm_audio_src',
                'name'    => __('Audio File', 'lqdm'),
                'desc'    => __('Alternatively upload/select audio from your media library.', 'lqdm'),
                'type'    => 'file',
                'options' => [ 'url' => false ],
            ],
            'excerpt' => [
                'id'        => 'excerpt',
                'name'      => __('Excerpt', 'lqdm'),
                'desc'      => __('Excerpts are optional hand-crafted summaries of your content that can be used in your theme. <a href="https://codex.wordpress.org/Excerpt" target="_blank">Learn more about manual excerpts.</a>'),
                'type'      => 'textarea',
                'escape_cb' => false,
            ],
            '_thumbnail' => [
                'id'   => '_thumbnail',
                'name' => __('Image', 'lqdm'),
                'desc' => __('Select an image if you want to override the series image for this sermon.', 'lqdm'),
                'type' => 'file',
            ],
            'lqdm_notes' => [
                'id'   => 'lqdm_notes',
                'name' => __('Sermon Notes', 'lqdm'),
                'type' => 'wysiwyg',
            ],
        ];

        $this->new_cmb2( [
            'id'           => 'lqdm_metabox',
            'title'        => __('Sermon Details', 'lqdm'),
            'object_types' => [ $this->post_type() ],
            'fields'       => $fields,
        ] );
    }

	/**
	 * Gets Excerpt for Selected Post
	 *
	 * @param $data
	 * @param $post_id
	 *
	 * @return string
	 */
    public function get_excerpt($data, $post_id)
    {
        return get_post_field('post_excerpt', $post_id);
    }

    /**
     * Registers admin columns to display.
     * @since  0.1.0
     * @param  array $columns Array of registered column names/labels
     * @return array           Modified array
     */
    public function columns($columns)
    {
        $last = array_splice($columns, 2);
        $columns['thumb-' . $this->post_type()] = __('Message Feature', 'lqdm');
        $columns['tax-' . $this->plugin->series->id] = $this->plugin->series->taxonomy('singular'); // TODO: Why is this?

        // placeholder
        return array_merge($columns, $last);
    }

	/**
	 * Handles admin column display. Hooked in via CPT_Core.
	 *
	 * @since  0.1.0
	 *
	 * @param array $column  Column currently being rendered.
	 * @param int   $post_id ID of post to display column for.
	 *
	 * @throws Exception
	 */
    public function columns_display($column, $post_id)
    {
        if ('tax-' . $this->plugin->series->id === $column) {
            add_action('admin_footer', [ $this, 'admin_column_css' ] );

            // Get sermon post object
            $sermon = new LqdM_Message_Post(get_post($post_id));

            // If we have sermon series...
            if (is_array($sermon->series)) {

                // Then loop them (typically only one)
                foreach ($sermon->series as $series) {

                    // Get augmented term object to get the thumbnail url
                    $series = $this->plugin->series->get($series, [ 'image_size' => 'thumb' ] );

                    // Edit-term link
                    $edit_link = get_edit_term_link($series->term_id, $series->taxonomy, $this->post_type());

                    // Add the image, or the term name.
                    if ($series->image_url) {
                        $class = ' with-image';
                        $title = ' title="' . esc_attr($series->name) . '"';
                        $term = '<img style="max-width: 100px;" src="' . esc_url($series->image_url) . '" /></a>';
                    } else {
                        $class = $title = '';
                        $term = $series->name;
                    }

                    echo '<div class="lqdm-series' . $class . '"><a' . $title . ' href="' . esc_url($edit_link) . '">' . $term . '</a></div>';
                }
            }
        } elseif ('thumb-' . $this->post_type() === $column) {
            echo the_post_thumbnail( [ 155, 55 ] );
        }
    }

    /**
     * For making custom columns sortable
     *
     * @since  0.1.7
     *
     * @param $columns
     * @return mixed
     */
    public function columns_sortable($columns)
    {
        $columns['tax-series'] = 'tax-series';
        return $columns;
    }

    /**
     * Sort functionality for custom columns
     *
     * TODO: Do we need to use raw SQL here?
     *
     * @since  0.1.7
     *
     * @param $clauses
     * @param $wp_query
     * @return mixed
     */
    public function columns_sort_func($clauses, $wp_query)
    {
        global $wpdb;
        if (isset($wp_query->query['orderby']) && $wp_query->query['orderby'] == 'tax-series') {
            $clauses['join'] .= <<<SQL
LEFT OUTER JOIN {$wpdb->term_relationships} ON {$wpdb->posts}.ID={$wpdb->term_relationships}.object_id
LEFT OUTER JOIN {$wpdb->term_taxonomy} USING (term_taxonomy_id)
LEFT OUTER JOIN {$wpdb->terms} USING (term_id)
SQL;
            $clauses['where'] .= "AND (taxonomy = 'lqdm-series' OR taxonomy IS NULL)";
            $clauses['groupby'] = "object_id";
            $clauses['orderby'] = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC)";
            if (strtoupper($wp_query->get('order')) == 'ASC') {
                $clauses['orderby'] .= 'ASC';
            } else {
                $clauses['orderby'] .= 'DESC';
            }
        }
        return $clauses;
    }

	/**
	 * Admin Column CSS
	 *
	 * @throws Exception
	 */
    public function admin_column_css()
    {
        LqdM_Style_Loader::output_template('admin-column');
    }

	/**
	 * Retrieve the most recent sermon with video media.
	 *
	 * @return LqdM_Message_Post|false  Message post object if successful.
	 * @throws Exception
	 *@since  0.1.0
	 *
	 */
    public function most_recent_with_video()
    {
        static $sermon = null;

        if (null === $sermon || $this->flush) {
            $sermon = $this->most_recent();

            if (empty($sermon->media['video'])) {
                $sermon = $this->most_recent_with_media('video');
            }
        }

        return $sermon;
    }

	/**
	 * Retrieve the most recent sermon with audio media.
	 *
	 * @return LqdM_Message_Post|false  Message post object if successful.
	 * @throws Exception
	 *@since  0.1.0
	 *
	 */
    public function most_recent_with_audio()
    {
        static $sermon = null;

        if (null === $sermon || $this->flush) {
            $sermon = $this->most_recent();

            if (empty($sermon->media['audio'])) {
                $sermon = $this->most_recent_with_media('audio');
            }
        }

        return $sermon;
    }

    /**
     * Retrieve the most recent sermon.
     *
     * @return LqdM_Message_Post|false  Message post object if successful.
     * @throws Exception
     *@since  0.1.0
     *
     */
    public function most_recent()
    {
        static $sermon = null;

        if (null === $sermon || $this->flush) {
            $sermons = new WP_Query(apply_filters('lqdm_recent_sermon_args', $this->query_args));
            $sermon = false;
            if ($sermons->have_posts()) {
                $sermon = new LqdM_Message_Post( $sermons->post);
            }
        }

        return $sermon;
    }

	/**
	 * Retrieve a specific sermon.
	 *
	 * @param $args
	 *
	 * @return LqdM_Message_Post|false  Message post object if successful.
	 * @throws Exception
	 *@since  0.1.0
	 *
	 */
    public function get($args)
    {
        $args = wp_parse_args($args, $this->query_args);
        $sermons = new WP_Query(apply_filters('lqdm_get_sermon_args', $args));
        $sermon = false;
        if ($sermons->have_posts()) {
            $sermon = new LqdM_Message_Post( $sermons->post);
        }

        return $sermon;
    }

	/**
	 * Retrieve sermons.
	 *
	 * @since  0.1.0
	 *
	 * @param $args
	 *
	 * @return WP_Query WP_Query object
	 * @throws Exception
	 */
    public function get_many($args)
    {
        $defaults = $this->query_args;
        unset($defaults['posts_per_page']);
        unset($defaults['no_found_rows']);
        $args['augment_posts'] = true;

        $args = apply_filters('lqdm_get_sermons_args', wp_parse_args($args, $defaults));
        $sermons = new WP_Query($args);

        if (
            isset($args['augment_posts'])
            && $args['augment_posts']
            && $sermons->have_posts()
            // Don't augment for queries w/ greater than 100 posts, for perf. reasons.
            && $sermons->post_count < 100
        ) {
            foreach ($sermons->posts as $key => $post) {
                $sermons->posts[$key] = new LqdM_Message_Post( $post);
            }
        }

        return $sermons;
    }

    /**
     * Retrieve the most recent sermon with audio media.
     *
     * @param  string $type Media type (audio or video)
     *
     * @return LqdM_Message_Post|false  Message post object if successful.
     * @throws Exception
     *@since  0.1.0
     *
     */
    protected function most_recent_with_media($type = 'video')
    {
        $sermon = false;

        // Only audio/video allowed.
        $type = 'video' === $type ? $type : 'audio';

        $args = $this->query_args;
        $args['meta_query'] = [
            'relation' => 'OR',
            [
                'key' => "lqdm_{$type}_url",
            ],
            [
                'key' => "lqdm_{$type}_src",
            ],
        ];

        $sermons = new WP_Query(apply_filters("lqdm_recent_sermon_with_{$type}_args", $args));

        if ($sermons->have_posts()) {
            $sermon = new LqdM_Message_Post( $sermons->post);
        }

        return $sermon;
    }

	/**
	 * Retrieve the most recent sermon which has terms in specified taxonomy.
	 *
	 * @param  string $taxonomy_id LqdM_Taxonomies_Base taxonomy id
	 *
	 * @return LqdM_Message_Post|false|WP_Error  Message post object if successful.
	 * @throws Exception
	 *@since  0.1.0
	 *
	 */
    public function most_recent_with_taxonomy($taxonomy_id)
    {
        $sermon = $this->most_recent();

        // No sermon post found at all.. oops
        if (!$sermon) {
            return false;
        }

        try {
            $terms = $sermon->{$taxonomy_id};
        } catch (Exception $e) {
            return new WP_Error(__('"%s" is not a valid taxonomy for %s.', 'lqdm'), $taxonomy_id, $this->post_type('plural'));
        }

        if (!$terms || is_wp_error($terms)) {
            $sermon = $this->find_sermon_with_taxonomy($taxonomy_id, [ $sermon->ID ] );
        }

        return $sermon;
    }

	/**
	 * Searches for posts which have terms in a given taxonomy, while excluding previous tries.
	 *
	 * @param  string  $taxonomy_id LqdM_Taxonomies_Base taxonomy id
	 * @param  array   $exclude     Array of excluded post IDs
	 *
	 * @return LqdM_Message_Post|false  Message post object if successful.
	 * @throws Exception
	 *@since  0.1.0
	 *
	 */
    protected function find_sermon_with_taxonomy($taxonomy_id, $exclude)
    {
        static $count = 0;

        $args = $this->query_args;
        $args['post__not_in'] = $exclude;
        $args = apply_filters('lqdm_find_sermon_with_taxonomy_args', $args);

        $sermons = new WP_Query($args);

        if (!$sermons->have_posts()) {
            return false;
        }

        $sermon = new LqdM_Message_Post( $sermons->post);

        $terms = $sermon ? $sermon->{$taxonomy_id} : false;

        if (!$terms || is_wp_error($terms)) {
            // Only try this up to 5 times
            if (++$count > 6) {
                return false;
            }

            $exclude = array_merge($exclude, [ $sermon->ID ] );
            $sermon = $this->find_sermon_with_taxonomy($taxonomy_id, $exclude);
        }

        return $sermon;
    }

    /**
     * check duplicate post with same video meta url
     *
     * @since  0.1.7
     *
     */
    public function check_sermon_duplicate_video()
    {
        $response = [];
        $response['success'] = true;
        $nonce_verify = wp_verify_nonce($_POST['nonce'], 'scripterz-nonce');

        if (!empty($_POST['video_url']) && $nonce_verify == true) {

            $the_query = new WP_Query(
                [
                    'post_type' => 'lqd-messages',
                    'meta_key' => 'lqdm_video_url',
                    'meta_value' => $_POST['video_url'],
                    'order' => 'ASC',
                    'post__not_in' => [ $_POST['curr_post_id'] ],
                ]
            );


            if ($the_query->have_posts()) {
                $response['success'] = false;
                $response['data'] = __('<div class="lqdm-duplicate-notice"><p>There are other posts exists, containing the same meta video URL', 'lqdm');
                while ($the_query->have_posts()) {
                    $the_query->the_post();
                    $response['data'] .= ', <a target="_blank" href="' . admin_url("post.php?post=" . get_the_ID() . "&action=edit") . '">' . get_the_title() . '</a>';
                }
                $response['data'] .= "</p></div>";

                wp_reset_postdata();
            }
        }

        echo json_encode($response);
        die();
    }

}
