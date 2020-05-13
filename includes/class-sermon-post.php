<?php
/**
 * Liquid Messages Custom Post Type: Message
 *
 * @package Liquid Messages
 */
class LQDM_Sermon_Post {
    /** @var mixed|WP_Post $post Post object to wrap */
    protected $post;

    /** @var array $media Media data for the message post */
    protected $media = array();

    /** @var array $images Image data for the message post */
    protected $images = array();

    /** @var array $series Series terms for the message post */
    protected $series = array();

    /** @var array $scripture Scripture terms for the message post */
    protected $scripture = array();

    /** @var null $single_series Single series term for the message post (array?) */
    protected $single_series;

    /** @var array $speakers Speaker terms for the message post */
    protected $speakers = array();

    /** @var null $speaker Single speaker term for the message post */
    protected $speaker;

    /** @var array $topics Topic terms for the message post */
    protected $topics = array();

    /** @var array $tags Tag terms for the message post */
    protected $tags = array();

	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 *
	 * @param  mixed $post Post object to wrap
	 *
	 * @throws Exception
	 * @return void
	 */
	public function __construct( $post ) {
	    if (!($post instanceof WP_Post)) {
	        throw new RuntimeException( 'Sorry, ' . __CLASS__ . ' expects a WP_Post object.');
	    }

	    $post_type = lqdm()->sermons->post_type();

	    if ($post->post_type !== $post_type) {
			throw new RuntimeException( 'Sorry, ' . __CLASS__ . ' expects a ' . $post_type . ' object.' );
	    }

	    $this->post = $post;
	}

	/**
     * Initiate the video/audio media object
     *
     * @since  0.1.0
     *
     * @return array|array[] Array of video/audio media info.
     */
	protected function init_media() {
	    $this->media = array(
	        'video' => array(),
            'audio' => array(),
        );
	    $this->add_media_type('video');
	    $this->add_media_type('audio');
	    return $this->media;
	}

	/**
	 * Add media info to the media array for $type
	 *
     * @since 0.1.0
     *
	 * @param string $type type of media
	 *
	 * @return LQDM_Sermon_Post $this
	 */
	protected function add_media_type( $type = 'video' ) {
	    // Only audio/video allowed.
        $type = $type === 'video' ? $type : 'audio';
        $media = false;

        if ($media_url = get_post_meta($this->ID, "gc_sermon_{$type}_url", 1)) {
            $media = array(
                'type'  => 'url',
                'value' => $media_url
            );
        } elseif ($media_src = get_post_meta($this->ID, "gc_sermon_{$type}_src_id", 1)) {
            $media = array(
                'type'           => 'attachment_id',
                'value'          => $media_src,
                'attachment_url' => get_post_meta($this->ID, "gc_sermon_{$type}_src", 1)
            );
        } elseif ($media_url = get_post_meta($this->ID, "gc_sermon_{$type}_src", 1)) {
            $media = array(
                'type'  => 'url',
                'value' => $media_url,
            );
        }

        if ($media) {
            $this->media[$type] = $media;
        }

        return $this;
	}

	/**
     * Wrapper for wp_oembed_get/wp_video_shortcode
     *
     * @since  0.1.1
     *
     * @param  array $args Optional. Args are passed to either WP_Embed::shortcode,
     *                     or wp_video_shortcode.
     * @return mixed       The video player if successful.
     */
	public function get_video_player( $args = array() ) {
	    global $wp_embed;

	    $media = empty($this->media) ? $this->init_media() : $this->media;
	    $video = $media['video'] ?? array();
	    if (!isset($video['type'])) {
	        return '';
	    }

	    if ( $video['type'] === 'url' ) { // If the video is a url
	        $wp_embed->post_ID = $this->ID;
	        $video_player = $wp_embed->shortcode($args, $video['value']);
	    } elseif ( $video['type'] === 'attachment_id' ) { // If the video is an attachment
	        $args['src'] = $video['attachment_url'];
	        if ($video_player = wp_video_shortcode($args)) {
	            $video_player = '<div class="lqdm-video-wrap">' . $video_player . '</div><!-- .lqdm-video-wrap -->';
	        }
	    }

	    return $video_player;
	}

	/**
     * Wrapper for wp_audio_shortcode
     *
     * @since  0.1.1
     *
     * @return string|void The audio player if successful.
     */
	public function get_audio_player() {
	    // Lazy-load the media-getting
        if (empty($this->media)) {
            $this->init_media();
        }

        $audio = $this->media['audio'];
        if (!isset($audio['type'])) {
            return '';
        }

        $audio_url = '';
        if ( $audio['type'] === 'url' ) {
            $audio_url = $audio['value'];
        } elseif ( $audio['type'] === 'attachment_id' ) {
            $audio_url = $audio['attachment_url'];
        }

        if ($audio_player = wp_audio_shortcode(array('src' => $audio_url))) {
			$audio_player = '<div class="lqdm-audio-wrap">' . $audio_player . '</div><!-- .lqdm-audio-wrap -->';
        }

        return $audio_player;
	}

	/**
     * Wrapper for get_permalink.
     *
     * @since  0.1.1
     *
     * @return string Message post permalink.
     */
	public function permalink() {
	    return get_permalink($this->ID);
	}

	/**
     * Wrapper for get_the_title.
     *
     * @since  0.1.1
     *
     * @return string Message post title.
     */
	public function title() {
	    return get_the_title($this->ID);
	}

	/**
     * Wrapper for the_excerpt. Returns value. Must be used in loop.
     *
     * @since  0.1.3
     *
     * @return string Message post excerpt.
     */
	public function loop_excerpt() {
	    ob_start();
	    the_excerpt();
	    // grab the data from the output buffer and add it to our $content variable
        return ob_get_clean();
	}

	/**
     * Wrapper for get_the_post_thumbnail which stores the results to the object
     *
     * @since  0.1.0
     *
     * @param  string|array $size     Optional. Image size to use. Accepts any valid image size, or
     *                                an array of width and height values in pixels (in that order).
     *                                Default 'full'.
     * @param  string|array $attr     Optional. Query string or array of attributes. Default empty.
     * @return mixed                  The post thumbnail image tag.
     */
	public function featured_image( $size = 'full', $attr = '' ) {
	    // Unique id for the passed-in attributes.
        $id = md5($attr);

		if ( ! isset( $attr['series_image_fallback'] ) || $attr['series_image_fallback'] !== false ) {
		    $series_image_fallback = true;
		    if (isset($attr['series_image_fallback'])) {
		        unset($attr['series_image_fallback']);
		    }
		}

        // If we got it already, then send it back
        if ( isset( $this->images[ $size ][ $id ] ) ) {
            return $this->images[$size][$id];
        }

        $this->images[$size][$id] = array();

        $img = get_the_post_thumbnail($this->ID, $size, $attr);
		$this->images[$size][$id] = $img ?: $this->series_image($size);

		return $this->images[$size][$id];
	}

	/**
     * Wrapper for get_post_thumbnail_id
     *
     * @since  0.1.0
     *
     * @return string|int Post thumbnail ID or empty string.
     */
	public function featured_image_id() {
	    return get_post_thumbnail_id($this->ID);
	}

	/**
     * Get the series image.
     *
     * @since  0.1.0
     *
     * @param  string|array $size     Optional. Image size to use. Accepts any valid image size, or
     *                                an array of width and height values in pixels (in that order).
     *                                Default 'full'.
     * @return string             The series image tag.
     */
	public function series_image( $size = 'full' ) {
	    $args = array('image_size' => $size);

        return $this->get_series($args)->image;
	}

	/**
     * Get all speakers for this message
     *
     * @param  array         Args to pass to LQDM_Taxonomies_Base::get()
     *
     * @return array|bool
     * @since  0.1.7
     *
     */
	public function get_speakers( $args = array() ) {
	    $speakers = $this->speakers();
	    if (empty($speakers)) {
	        return false;
	    }

	    $speaker = array();
	    foreach ($speakers as $key => $val) {
	        $speaker[] = lqdm()->taxonomies->speaker->get($val, $args);
	    }

	    return $speaker;
	}

	/**
     * Get single speaker for this message
     *
     * @since  0.1.1
     *
     * @param  array   Args to pass to LQDM_Taxonomies_Base::get()
     *
     * @return mixed   Speaker term object.
     */
	public function get_speaker( $args = array() ) {
	    $speakers = $this->speakers();
	    if (empty($speakers)) {
	        return false;
	    }

	    if ( $this->speaker === null ) {
	        $this->speaker = lqdm()->taxonomies->speaker->get($speakers[0], $args);
	    }

	    return $this->speaker;
	}

	/**
     * Get single series for this message
     *
     * @since  0.1.1
     *
     * @param  array $args Args to pass to LQDM_Taxonomies_Base::get()
     *
     * @return mixed       Series term object.
     */
	public function get_series( $args = array() ) {
	    $series = $this->series();
	    if (empty($series)) {
	        return false;
	    }

	    if ( $this->single_series === null ) {
	        $this->single_series = lqdm()->taxonomies->series->get($series[0], $args);
	    }

	    return $this->single_series;
	}

	/**
     * Get scripture for this message
     *
     * @param  array  $args       Args to pass to LQDM_Taxonomies_Base::get()
     *
     * @return array|false|WP_Term
     * @since  0.1.7
     */
	public function get_scriptures( $args = array() ) {
	    $scriptures = $this->scripture();
	    if (empty($scriptures)) {
	        return false;
	    }

	    $scripture = array();
	    foreach ($scriptures as $key => $val) {
	        $scripture[] = lqdm()->taxonomies->scripture->get($val, $args);
	    }

	    return $scripture;
	}

	/**
	 * Get other messages in the same series.
	 *
	 * @since  0.1.1
	 *
	 * @param  string|array|object      $args  Array of WP_Query arguments.
	 *
	 * @return WP_Error|WP_Query        WP_Query instance if successful.
	 * @throws Exception
	 */
	public function get_others_in_series( $args = array() ) {
	    $series = $this->get_series();
	    if (!$series) {
	        return new WP_Error( 'no_series_for_sermon', __( 'There is no series associated with this sermon.', 'lqdm' ), $this->ID );
	    }

	    $parse_args = array(
            'post__not_in'   => array($this->ID),
            'posts_per_page' => 10,
            'no_found_rows'  => true,
        );
	    $args = wp_parse_args($args, $parse_args);

	    $args['tax_query'] = array(
	        array(
	            'taxonomy' => $series->taxonomy,
                'field'    => 'slug',
                'terms'    => $series->slug,
            ),
        );

	    return lqdm()->sermons->get_many($args);
	}

	/**
	 * Get other messages by the same speaker.
	 *
	 * @since  0.1.1
	 *
	 * @param  array|object            $args  Array of WP_Query arguments.
	 *
	 * @return mixed|WP_Error|WP_Query        WP_Query instance if successful.
	 * @throws Exception
	 */
	public function get_others_by_speaker( $args = array() ) {
	    $speaker = $this->get_speaker();
	    if (!$speaker) {
	        return new WP_Error( 'no_speaker_for_sermon', __( 'There is no speaker associated with this sermon.', 'lqdm' ), $this->ID );
	    }

	    $parse_args = array(
            'post__not_in'   => array($this->ID),
            'posts_per_page' => 10,
            'no_found_rows'  => true,
        );

	    $args = wp_parse_args($args, $parse_args);

	    $args['tax_query'] = array(
	        array(
	            'taxonomy' => $speaker->taxonomy,
                'field'    => 'slug',
                'terms'    => $speaker->slug,
            ),
        );

	    return lqdm()->sermons->get_many($args);
	}

	/**
     * Wrapper for get_the_terms for the series taxonomy
     *
     * @since  0.1.0
     *
     * @return array  Array of series terms
     */
	public function series() {
	    if (empty($this->series)) {
	        $this->series = $this->init_taxonomy('series');
	    }

	    return $this->series;
	}

	/**
     * Wrapper for get_the_terms for the scripture taxonomy
     *
     * @since  0.1.7
     *
     * @return array  Array of scripture terms
     */
	public function scripture() {
	    if (empty($this->scripture)) {
	        $this->scripture = $this->init_taxonomy('scripture');
	    }

	    return $this->scripture;
	}

	/**
     * Wrapper for get_the_terms for the speaker taxonomy
     *
     * @since  0.1.0
     *
     * @return array  Array of speaker terms
     */
	public function speakers() {
	    if (empty($this->speakers)) {
	        $this->speakers = $this->init_taxonomy('speaker');
	    }

	    return $this->speakers;
	}

	/**
     * Wrapper for get_the_terms for the topic taxonomy
     *
     * @since  0.1.0
     *
     * @return array  Array of topic terms
     */
	public function topics() {
	    if (empty($this->topics)) {
	        $this->topics = $this->init_taxonomy('topic');
	    }

	    return $this->topics;
	}

	/**
     * Wrapper for get_the_terms for the tag taxonomy
     *
     * @since  0.1.0
     *
     * @return array  Array of tag terms
     */
	public function tags() {
	    if (empty($this->tags)) {
	        $this->tags = $this->init_taxonomy('tag');
	    }

	    return $this->tags;
	}

	/**
     * Initiate the taxonomy.
     *
     * @since  0.1.0
     *
     * @param  string $taxonomy Taxonomy to initiate
     *
     * @return array             Array of terms for this taxonomy.
     */
	protected function init_taxonomy( $taxonomy ) {
	    $tax_slug = lqdm()->taxonomies->{$taxonomy}->taxonomy();
	    return get_the_terms($this->ID, $tax_slug);
	}

	/**
     * Wrapper for get_post_meta
     *
     * @since  0.1.1
     *
     * @param  string $key Meta key
     *
     * @return mixed        Value of post meta
     */
	public function get_meta( $key ) {
	    return get_post_meta($this->ID, $key, 1);
	}

	/**
     * Magic getter for our object.
     *
     * @param string $property
     * @throws Exception Throws an exception if the field is invalid.
     * @return mixed
     */
	public function __get( $property ) {
	    $property = $this->translate_property($property);

	    // Automate
        switch ($property) {
            case 'series':
            case 'speakers':
            case 'topics':
            case 'tags':
                return $this->{$property}();
            case 'post':
                return $this->{$property};
            case 'media':
                // Lazy-load the media-getting
                if (empty($this->media)) {
                    return $this->init_media();
                }
                return $this->media;
            default:
                // Check post object for property
                // In general, we'll avoid using same-named properties,
                // so the post object properties are always available.
                if (isset($this->post->{$property})) {
                    return $this->post->{$property};
                }
                throw new RuntimeException( 'Invalid ' . __CLASS__ . ' property: ' . $property);
        }
	}

	/**
     * Magic isset checker for our object.
     *
     * @param string $property
     * @throws Exception Throws an exception if the field is invalid.
     * @return mixed
     */
	public function __isset( $property ) {
	    $property = $this->translate_property($property);

	    // Automate
        switch ($property) {
            case 'series':
            case 'speakers':
            case 'topics':
            case 'tags':
                $terms = $this->{$property}();
                return !empty($terms);
            default:
                // Check post object for property
                // In general, we'll avoid using same-named properties,
                // so the post object properties are always available.
                return isset($this->post->{$property});
        }
	}

   /**
    * Allow some variations on the object __getter
    *
    * @since  0.9.1
    *
    * @param  string $property Object property to fetch
    *
    * @return string            Maybe-modified property name
    */
	protected function translate_property( $property ) {
	    // Translate
        switch ($property) {
            case 'speaker':
                $property = 'speakers';
                break;
            case 'topic':
                $property = 'topics';
                break;
            case 'tag':
                $property = 'tags';
                break;
        }

        return $property;
	}
}
