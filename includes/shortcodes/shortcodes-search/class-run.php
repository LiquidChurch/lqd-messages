<?php
/**
 * Liquid Messages Search Shortcode - Run.
 *
 * @package Liquid Messages
 */
class LqdM_Shortcodes_Message_Search_Run extends LqdM_Shortcodes_Run_Base {

	/**
	 * The Shortcode Tag
	 * @var string
	 * @since 0.1.0
	 */
	public $shortcode = 'lqdm_messages_search';

	/**
	 * Default attributes applied to the shortcode.
     *
	 * @var array
	 * @since 0.1.0
	 */
	public $atts_defaults = array(
		'search'             => '',
		'per_page'           => 10, // Will use WP's per-page option.
		'content'            => 'excerpt',
		'remove_thumbnail'   => false,
		'thumbnail_size'     => 'medium',
		'number_columns'     => 2,

		// No admin UI.

		// Message specific
		'list_offset'        => 0,
		'wrap_classes'       => '',
		'remove_pagination'  => false,
		'related_speaker'    => 0,
		'related_series'     => 0,

		// Series specific
		'remove_description' => true,

		'message_search_args' => array(),
		'series_search_args' => array(),

		// this option will allow one to decide whether
		// the results of the search show on the same page
		// below the search box or whether they show on a separate page.
		'separate_results' => false,
	);

    /**
     * Taxonomies Object
     *
     * @var LqdM_Taxonomies
     * @since 0.1.0
     */
	public $taxonomies;

	/**
	 * The current search query.
	 *
	 * @var string
	 */
	protected $search_query = '';

	/**
	 * Constructor
	 *
	 * @param LqdM_Messages $messages
	 * @param LqdM_Taxonomies $taxonomies
     *
     * @since 0.1.3
	 *
	 */
	public function __construct( LqdM_Messages $messages, LqdM_Taxonomies $taxonomies ) {

		$this->taxonomies = $taxonomies;
		parent::__construct( $messages );
	}

	/**
	 * Shortcode Output
	 */
	public function shortcode() {
		$this->search_query = lqdm__get_arg( 'message-search', '' );
		$show_results = lqdm__get_arg( 'results-for', '' );

		$series_slug = $this->taxonomies->series->taxonomy();
		$cpt_slug    = $this->messages->post_type();

		$to_search   = $this->att( 'search' );
		$separate_results   = $this->att( 'separate_results' );
		$search_both = ! $to_search;

		$format      = current_theme_supports( 'html5', 'search-form' ) ? 'html5' : 'xhtml';
		$format      = apply_filters( 'search_form_format', $format );
		$template    = 'searchform' . ( 'xhtml' === $format ? '-' . $format : '' );

		$args = array(
			'search_query'  => $this->search_query,
			'action_url'    => home_url('/messages/search/?message-search=1'),
			'messages_value' => $cpt_slug,
			'messages_label' => $this->messages->post_type( 'singular' ),
			'series_value'  => $series_slug,
			'series_label'  => $this->taxonomies->series->taxonomy( 'singular' ),
			'show_filter'   => $search_both,
			'show_results'  => $show_results,
			'separate_results'  => $separate_results,
		);

		$content = LqdM_Template_Loader::get_template( $template, $args );

		// If a search was performed, let's get the results.
		if ( $this->search_query ) {

			if ( strlen( $this->search_query ) < 3 ) {
				// Uh-oh, we need at least 3 characters.
				$content .= LqdM_Template_Loader::get_template( 'search-query-error' );
			} else {

				$show_message_results = ! $show_results || $cpt_slug === $show_results;
				$show_series_results = ! $show_results || $series_slug === $show_results;

				$search_messages = $search_both || in_array( $to_search, array( 'messages' ), 1 );
				$search_series  = $search_both || in_array( $to_search, array( 'series' ), 1 );

				if ( $search_messages && $show_message_results ) {
					$content .= $this->message_search_results();
				}

				if ( $search_series && $show_series_results ) {
					$content .= $this->series_search_results();
				}

			}
		}

		return $content;
	}

	/**
	 * Message Search Results
	 *
	 * @return LqdM_Messages_Search_Run|string
	 * @throws Exception
	 */
	protected function message_search_results() {
		$atts = $this->atts;
		unset( $atts['search'] );
		unset( $atts['wrap_classes'] );

		$atts = wp_parse_args( $atts, $this->att( 'message_search_args', array() ) );

		$search = new LqdM_Messages_Search_Run( $this->search_query, $atts, $this->messages, $this->taxonomies );
		$search->get_search_results( );

		return LqdM_Template_Loader::get_template( 'message-search-results', array(
			'wrap_classes'  => $this->att( 'wrap_classes' ),
			'results'       => empty( $search->results ) ? __( 'No results.', 'lqdm' ) : $search->results,
			'search_notice' => sprintf(
				__( '%s search results for: <em>%s</em>', 'lqdm' ),
				$this->messages->post_type( 'singular' ),
				esc_html( $this->search_query )
			),
		) );
	}

	/**
	 * Series Search Results
	 *
	 * @return string
	 * @throws Exception
	 */
	protected function series_search_results() {
		$atts = $this->atts;
		unset( $atts['search'] );
		unset( $atts['wrap_classes'] );

		$atts = wp_parse_args( $atts, $this->att( 'series_search_args', array() ) );

		$search = new LqdM_Series_Search_Run( $this->search_query, $atts, $this->messages, $this->taxonomies->series );
		$search->get_search_results();

		return LqdM_Template_Loader::get_template( 'series-search-results', array(
			'wrap_classes'  => $this->att( 'wrap_classes' ),
			'results'       => empty( $search->results ) ? __( 'No results.', 'lqdm' ) : $search->results,
			'search_notice' => sprintf(
				__( '%s search results for: <em>%s</em>', 'lqdm' ),
				$this->taxonomies->series->taxonomy( 'singular' ),
				esc_html( $this->search_query )
			),
		) );
	}

}
