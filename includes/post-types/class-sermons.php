<?php
/**
 * Liquid Messages CPT: Individual Messages
 *
 * Built using CPT_Core.
 *
 * @link https://github.com/WebDevStudios/CPT_Core
 *
 * @version 0.1.6
 * @package Liquid Messages
 */
class LQDM_Sermons extends LQDM_Post_Types_Base
{

    /** @var bool $flush Bypass temporary cache */
    public $flush = false;

    /** @var string $id Identifier for this object */
    protected $id = 'sermon';

    /** @var null $plugin Parent plugin class */
    protected $plugin;

    /** @var array $query_args Array of default WP_Query args */
    protected $query_args = array(
        'post_type'      => 'THIS(REPLACE)',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'no_found_rows'  => true,
    );

    /**
     * Constructor
     *
     * @since  0.1.0
     * @param  object $plugin Main plugin object.
     * @return void
     */
    public function __construct($plugin)
    {
        parent::__construct($plugin, array(
            'labels' => array(__('Message', 'lqdm'), __('Messages', 'lqdm'), 'gc-sermons'),
            'args' => array(
                'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
                'menu_icon' => 'dashicons-playlist-video',
                'rewrite' => array(
                    'slug' => '%gc-sermon-series%-series',
                    'with_front' => false,
                    'ep_mask' => EP_ALL,

                ),
                'show_in_rest' => true,
                'show_in_graphql' => true,
                'graphql_single_name' => 'lqdmMessage',
                'graphql_plural_name' => 'lqdmMessages'
            ),
        ));
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
        add_action('cmb2_admin_init', array($this, 'fields'));
        add_filter('cmb2_override_excerpt_meta_value', array($this, 'get_excerpt'), 10, 2);
        add_filter('cmb2_override_excerpt_meta_save', '__return_true');
        add_filter('admin_init', array($this, 'admin_hooks'));

        /**
         * Enable image fallback. If Message does not have a featured image, fall back
         * to the Series image (if it exists).
         *
         * To disable:
         *    add_filter( 'gc_do_sermon_series_fallback_image', '__return_false' );
         *
         */
        if (apply_filters('gc_do_sermon_series_fallback_image', true)) {
            add_filter('get_post_metadata', array($this, 'featured_image_fallback_to_series_image'), 10, 3);
        }

        /**
         * Enable future posts to be displayed.
         *
         * If false, future posts will be 'scheduled', WordPress' default behavior.
         *
         * To disable:
         *    add_filter( 'gc_display_future_sermons', '__return_false' );
         *
         */
        if (apply_filters('gc_display_future_sermons', true)) {
            add_filter('wp_insert_post_data', array($this, 'save_future_as_published'), 10, 2);
            if (!is_admin()) {
                add_filter('the_title', array($this, 'label_coming_soon'), 10, 2);
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
        add_action('dbx_post_advanced', array($this, 'remove_default_boxes_for_sermons'));
        add_filter("manage_edit-{$this->post_type()}_columns", array($this, 'columns'));
        add_filter("manage_edit-{$this->post_type()}_sortable_columns", array($this, 'columns_sortable'), 10, 1);
        add_filter('posts_clauses', array($this, 'columns_sort_func'), 10, 2);
    }

    /**
     * Remove default excerpt/featured image metaboxes for Messages
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
	 * Provides a backup featured image for messages by checking the message's series
	 * for the series featured image.
     *
     * If a message has a featured image set, that will be used.
	 *
	 * @since  0.1.3
	 *
	 * @param  null|array|string $meta       Value that get_metadata() should return - either single or array.
	 * @param  int               $object_id  Object ID.
	 * @param  string            $meta_key   Meta key.
	 *
	 * @return mixed Message featured image id, or Series image id, or nothing.
	 * @throws Exception
	 */
    public function featured_image_fallback_to_series_image($meta, $object_id, $meta_key)
    {

        // Override thumbnail_id check and get the series image id as a fallback.
        if ( $meta_key === '_thumbnail_id' && $this->post_type() === get_post_type($object_id)) {

            // Have to remove this filter to get the actual value to see if we need to do the work.
            remove_filter('get_post_metadata', array($this, 'featured_image_fallback_to_series_image'), 10);
            $id = get_post_thumbnail_id($object_id);
            add_filter('get_post_metadata', array($this, 'featured_image_fallback_to_series_image'), 10, 3);

            // Ok, no feat img id.
            if (!$id || !get_post($id)) {

                // Get message.
                $sermon = new LQDM_Sermon_Post(get_post($object_id));

                // Get series.
                $series = $sermon->get_series();

                // Send series image id.
                return $series->image_id ?? $id;
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
     * @return array          Modified post data array.
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
	 * Add a "Coming Soon" prefix to future message titles.
	 *
     * @since  0.2.1
     *
	 * @param string $title
	 * @param int    $post_id
	 *
	 * @return mixed|string
	 */
    public function label_coming_soon($title, $post_id = 0)
    {
        static $now = null;
        static $done = array();

        $post_id = $post_id ?: get_the_id();

        if (isset($done[$post_id])) {
            return $done[$post_id];
        }

        $now = $now ?? gmdate( 'Y-m-d H:i:59' );

        if (mysql2date('U', get_post($post_id)->post_date_gmt, false) > mysql2date('U', $now, false)) {

            $coming_soon_prefix = apply_filters('gcs_sermon_coming_soon_prefix', '<span class="coming-soon-prefix">' . __('Coming Soon:', 'lqdm') . '</span> ', $post_id, $this);
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
        $fields = array(
            'gc_sermon_video_url' => array(
                'id'   => 'gc_sermon_video_url',
                'name' => __('Video URL', 'lqdm'),
                'desc' => __('Enter an oembed-supported video URL such as YouTube or Vimeo.', 'lqdm'),
                'type' => 'oembed',
            ),
            'gc_sermon_video_src' => array(
                'id'      => 'gc_sermon_video_src',
                'name'    => __('Video File', 'lqdm'),
                'desc'    => __('Alternatively upload/select video from your media library.', 'lqdm'),
                'type'    => 'file',
                'options' => array('url' => false),
            ),
            'gc_sermon_audio_url' => array(
                'id'   => 'gc_sermon_audio_url',
                'name' => __('Audio URL', 'lqdm'),
                'desc' => __('Enter a SoundCloud, Spotify, or other oembed-supported web audio URL.', 'lqdm'),
                'type' => 'oembed',
            ),
            'gc_sermon_audio_src' => array(
                'id'      => 'gc_sermon_audio_src',
                'name'    => __('Audio File', 'lqdm'),
                'desc'    => __('Alternatively upload/select audio from your media library.', 'lqdm'),
                'type'    => 'file',
                'options' => array('url' => false),
            ),
            'excerpt' => array(
                'id'        => 'excerpt',
                'name'      => __('Excerpt', 'lqdm'),
                'desc'      => __('Excerpts are optional hand-crafted summaries of your content that can be used in your theme.'),
                'type'      => 'textarea',
                'escape_cb' => false,
            ),
            '_thumbnail' => array(
                'id'   => '_thumbnail',
                'name' => __('Image', 'lqdm'),
                'desc' => __('Select an image if you want to override the series image for this message.', 'lqdm'),
                'type' => 'file',
            ),
            'gc_sermon_notes' => array(
                'id'   => 'gc_sermon_notes',
                'name' => __('Message Notes', 'lqdm'),
                'type' => 'wysiwyg',
            ),
        );

        $this->new_cmb2(array(
            'id'           => 'gc_sermon_metabox',
            'title'        => __('Message Details', 'lqdm'),
            'object_types' => array($this->post_type()),
            'fields'       => $fields,
        ));
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
     *
     * @since  0.1.0
     * @param  array $columns  Array of registered column names/labels
     * @return array           Modified array
     */
    public function columns($columns)
    {
        $last = array_splice($columns, 2);
        $columns['thumb-' . $this->post_type()] = __('Message Feature', 'lqdm');
        $columns['tax-' . $this->plugin->series->id] = $this->plugin->series->taxonomy('singular');

        // placeholder
        return array_merge($columns, $last);
    }

	/**
	 * Handles admin column display.
     *
     * Hooked in via CPT_Core.
	 *
	 * @since  0.1.0
	 *
	 * @param  array  $column   Column currently being rendered.
	 * @param  int    $post_id  ID of post to display column for.
	 *
	 * @throws Exception
	 */
    public function columns_display($column, $post_id)
    {
        if ('tax-' . $this->plugin->series->id === $column) {
            add_action('admin_footer', array($this, 'admin_column_css'));

            // Get message post object
            $sermon = new LQDM_Sermon_Post(get_post($post_id));

            // If we have message series...
            if (is_array($sermon->series)) {

                // Then loop them (typically only one)
                foreach ($sermon->series as $series) {

                    // Get augmented term object to get the thumbnail url
                    $series = $this->plugin->series->get($series, array('image_size' => 'thumb'));

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
            the_post_thumbnail(array(155, 55));
        }
    }

    /**
     * Make custom columns sortable
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
            $clauses['where'] .= "AND (taxonomy = 'gc-sermon-series' OR taxonomy IS NULL)";
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
        LQDM_Style_Loader::output_template('admin-column');
    }

	/**
	 * Retrieve the most recent message with video media.
	 *
     * @since 0.1.0
     *
	 * @return  LQDM_Sermon_Post|false  GC Sermon post object if successful.
	 * @throws  Exception
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
	 * Retrieve the most recent message.
	 *
     * @since 0.1.0
     *
	 * @return  LQDM_Sermon_Post|false  GC Sermon post object if successful.
	 * @throws  Exception
	 */
    public function most_recent()
    {
        static $sermon = null;

        if (null === $sermon || $this->flush) {
            $sermons = new WP_Query(apply_filters('gcs_recent_sermon_args', $this->query_args));
            $sermon = false;
            if ($sermons->have_posts()) {
                $sermon = new LQDM_Sermon_Post( $sermons->post);
            }
        }

        return $sermon;
    }

	/**
	 * Retrieve the most recent message with media.
	 *
	 * @since  0.1.0
	 *
	 * @param   string  $type Media type (audio or video)
	 *
	 * @return  LQDM_Sermon_Post|false  GC Sermon post object if successful.
	 * @throws  Exception
	 */
    protected function most_recent_with_media($type = 'video')
    {
        $sermon = false;

        // Only audio/video allowed.
        $type = $type === 'video' ? $type : 'audio';

        $args = $this->query_args;
        $args['meta_query'] = array(
            'relation' => 'OR',
            array(
                'key' => "gc_sermon_{$type}_url",
            ),
            array(
                'key' => "gc_sermon_{$type}_src",
            ),
        );

        $sermons = new WP_Query(apply_filters("gcs_recent_sermon_with_{$type}_args", $args));

        if ($sermons->have_posts()) {
            $sermon = new LQDM_Sermon_Post( $sermons->post);
        }

        return $sermon;
    }

	/**
	 * Retrieve the most recent message with audio media.
	 *
     * @since 0.1.0
     *
	 * @return  LQDM_Sermon_Post|false  GC Sermon post object if successful.
	 * @throws  Exception
	 */
    public function most_recent_with_audio()
    {
        static $sermon = null;

        if ( $sermon === null || $this->flush) {
            $sermon = $this->most_recent();

            if (empty($sermon->media['audio'])) {
                $sermon = $this->most_recent_with_media('audio');
            }
        }

        return $sermon;
    }

	/**
	 * Retrieve a specific message.
	 *
	 * @since  0.1.0
	 *
	 * @param $args
	 *
	 * @return  LQDM_Sermon_Post|false  GC Sermon post object if successful.
	 * @throws  Exception
	 */
    public function get($args)
    {
        $args = wp_parse_args($args, $this->query_args);
        $sermons = new WP_Query(apply_filters('gcs_get_sermon_args', $args));
        $sermon = false;
        if ($sermons->have_posts()) {
            $sermon = new LQDM_Sermon_Post( $sermons->post);
        }

        return $sermon;
    }

	/**
	 * Retrieve messages.
	 *
	 * @since  0.1.0
	 *
	 * @param $args
	 *
	 * @return  WP_Query  WP_Query object
	 * @throws  Exception
	 */
    public function get_many($args)
    {
        $defaults = $this->query_args;
        unset( $defaults['posts_per_page'], $defaults['no_found_rows'] );
        $args['augment_posts'] = true;

        $args = apply_filters('gcs_get_sermons_args', wp_parse_args($args, $defaults));
        $sermons = new WP_Query($args);

        if (
            isset($args['augment_posts'])
            && $args['augment_posts']
            && $sermons->have_posts()
            // Don't augment for queries w/ greater than 100 posts, for perf. reasons.
            && $sermons->post_count < 100
        ) {
            foreach ($sermons->posts as $key => $post) {
                $sermons->posts[$key] = new LQDM_Sermon_Post( $post);
            }
        }

        return $sermons;
    }

	/**
	 * Retrieve the most recent message which has terms in specified taxonomy.
	 *
     * @param   string $taxonomy_id LQDM_Taxonomies_Base taxonomy id
	 *
	 * @return false|LQDM_Sermon_Post|WP_Error
     * @throws Exception
     *@since 0.1.0
     *
     */
    public function most_recent_with_taxonomy($taxonomy_id)
    {
        $sermon = $this->most_recent();

        // No message post found at all
        if (!$sermon) {
            return false;
        }

        try {
            $terms = $sermon->{$taxonomy_id};
        } catch (Exception $e) {
            return new WP_Error(__('"%s" is not a valid taxonomy for %s.', 'lqdm'), $taxonomy_id, $this->post_type('plural'));
        }

        if (!$terms || is_wp_error($terms)) {
            $sermon = $this->find_sermon_with_taxonomy($taxonomy_id, array($sermon->ID));
        }

        return $sermon;
    }

	/**
	 * Searches for posts which have terms in a given taxonomy, while excluding previous tries.
	 *
     * @since 0.1.0
     *
	 * @param  string  $taxonomy_id  LQDM_Taxonomies_Base taxonomy id
	 * @param  array   $exclude      Array of excluded post IDs
	 *
	 * @return  LQDM_Sermon_Post|false  GC Sermon post object if successful.
	 * @throws  Exception
	 */
    protected function find_sermon_with_taxonomy($taxonomy_id, $exclude)
    {
        static $count = 0;

        $args = $this->query_args;
        $args['post__not_in'] = $exclude;
        $args = apply_filters('gcs_find_sermon_with_taxonomy_args', $args);

        $sermons = new WP_Query($args);

        if (!$sermons->have_posts()) {
            return false;
        }

        $sermon = new LQDM_Sermon_Post( $sermons->post);

        $terms = $sermon ? $sermon->{$taxonomy_id} : false;

        if (!$terms || is_wp_error($terms)) {
            // Only try this up to 5 times
            if (++$count > 6) {
                return false;
            }

            $exclude = array_merge($exclude, array($sermon->ID));
            $sermon = $this->find_sermon_with_taxonomy($taxonomy_id, $exclude);
        }

        return $sermon;
    }
}
