<?php
/**
 * Liquid Messages Search Shortcode - Run.
 *
 * @package Liquid Messages
 */
class LqdM_Messages_Search_Run extends LqdM_Messages_Run {

	/**
	 * The current search query.
	 *
	 * @var string
	 */
	protected $search_query = '';

	/**
	 * The current search results page number.
	 *
	 * @var int
	 */
	public $current_page = 0;

	/**
	 * The total number of search results pages.
	 *
	 * @var int
	 */
	public $total_pages = 0;

	/**
	 * Results of the call to shortcode_callback.
	 *
	 * @var mixed
	 */
	public $results = '';

	/**
	 * Constructor
	 *
	 * @param string          $search_query
	 * @param $atts
	 * @param LqdM_Messages   $messages
	 * @param LqdM_Taxonomies $taxonomies
     *
     * @since 0.1.3
	 *
	 */
	public function __construct( $search_query, $atts, LqdM_Messages $messages, LqdM_Taxonomies $taxonomies ) {
		$this->search_query = $search_query;
		$this->current_page = absint( lqdm__get_arg( 'results-page', 1 ) );

		parent::__construct( $messages, $taxonomies );

		$this->create_shortcode_object(
			shortcode_atts( $this->atts_defaults, $atts, $this->shortcode ),
			''
		);
	}

	/**
	 * Get Search Results
	 *
	 * @return mixed|string
	 * @throws Exception
	 */
	public function get_search_results() {
		add_filter( 'lqdm_get_messages_args', array( $this, 'filter_message_args' ) );

		$my_level = self::$inception_levels++;
		$args = $this->get_initial_query_args();

		if ( ! $args ) {
			// We failed the related term check.
			return '';
		}

		if ( ! isset( $args['post__not_in'] ) && is_singular( $this->messages->post_type() ) ) {
			$args['post__not_in'] = array( get_queried_object_id() );
		}

		$messages = $this->messages->get_many( $args );

		if ( ! $messages->have_posts() ) {
			return '';
		}

		$max     = $messages->max_num_pages;
		$messages = $this->map_message_args( $messages, $my_level );

		$this->results = '';
		if ( 0 === $my_level ) {
			$this->results .= LqdM_Style_Loader::get_template( 'list-item-style' );
		}

		$args = $this->get_pagination( $max );
		$args['wrap_classes'] = $this->get_wrap_classes();
		$args['messages']      = $messages;
		$args['plugin_option'] = lqdm_get_plugin_settings_options('search_view');

		$this->results .= LqdM_Template_Loader::get_template( 'messages-list', $args );

		remove_filter( 'lqdm_get_messages_args', array( $this, 'filter_message_args' ) );

		return $this->results;
	}

	/**
	 * Filter Message Args
	 *
	 * @param $args
	 *
	 * @return mixed
	 */
	public function filter_message_args( $args ) {
		$args['s'] = sanitize_text_field( $this->search_query );
		return $args;
	}

	/**
	 * Get Initial Query Args
	 *
	 * @return array
	 */
	public function get_initial_query_args() {
		$posts_per_page = (int) $this->att( 'per_page', get_option( 'posts_per_page' ) );
		$paged          = $this->current_page;
		$offset         = ( ( $paged - 1 ) * $posts_per_page ) + $this->att( 'list_offset', 0 );

		return compact( 'posts_per_page', 'paged', 'offset' );
	}

	/**
	 * Get Pagination
	 *
	 * @param $total_pages
	 *
	 * @return array
	 */
	protected function get_pagination( $total_pages ) {
		$this->total_pages = $total_pages;
		$nav = array( 'prev_link' => '', 'next_link' => '' );

		if ( ! $this->bool_att( 'remove_pagination' ) ) {
			$nav['prev_link'] = lqdm_search_get_previous_results_link();
			$nav['next_link'] = lqdm_search_get_next_results_link( $total_pages );
		}

		return $nav;
	}

	/**
	 * Get Wrap Classes
	 *
	 * @return string
	 */
	protected function get_wrap_classes() {
		return parent::get_wrap_classes() . ' lqdm-messages-search-wrap';
	}

}
