<?php
/**
 * GC Sermons Search
 *
 * @package GC Sermons
 */
class LqdM_Sermons_Search_Run extends LqdM_Sermons_Run {

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
	 * @param string         $search_query
	 * @param $atts
	 * @param LqdM_Messages    $sermons
	 * @param LqdM_Taxonomies $taxonomies
     *
     * @since 0.1.3
	 *
	 */
	public function __construct( $search_query, $atts, LqdM_Messages $sermons, LqdM_Taxonomies $taxonomies ) {
		$this->search_query = $search_query;
		$this->current_page = absint( gc__get_arg( 'results-page', 1 ) );

		parent::__construct( $sermons, $taxonomies );

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
		add_filter( 'gcs_get_sermons_args', array( $this, 'filter_sermon_args' ) );

		$my_level = self::$inception_levels++;
		$args = $this->get_initial_query_args();

		if ( ! $args ) {
			// We failed the related term check.
			return '';
		}

		if ( ! isset( $args['post__not_in'] ) && is_singular( $this->sermons->post_type() ) ) {
			$args['post__not_in'] = array( get_queried_object_id() );
		}

		$sermons = $this->sermons->get_many( $args );

		if ( ! $sermons->have_posts() ) {
			return '';
		}

		$max     = $sermons->max_num_pages;
		$sermons = $this->map_sermon_args( $sermons, $my_level );

		$this->results = '';
		if ( 0 === $my_level ) {
			$this->results .= LqdM_Style_Loader::get_template( 'list-item-style' );
		}

		$args = $this->get_pagination( $max );
		$args['wrap_classes'] = $this->get_wrap_classes();
		$args['sermons']      = $sermons;
		$args['plugin_option'] = get_plugin_settings_options('search_view');

		$this->results .= LqdM_Template_Loader::get_template( 'sermons-list', $args );

		remove_filter( 'gcs_get_sermons_args', array( $this, 'filter_sermon_args' ) );

		return $this->results;
	}

	/**
	 * Filter Sermon Args
	 *
	 * @param $args
	 *
	 * @return mixed
	 */
	public function filter_sermon_args( $args ) {
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
			$nav['prev_link'] = gc_search_get_previous_results_link();
			$nav['next_link'] = gc_search_get_next_results_link( $total_pages );
		}

		return $nav;
	}

	/**
	 * Get Wrap Classes
	 *
	 * @return string
	 */
	protected function get_wrap_classes() {
		return parent::get_wrap_classes() . ' lqdm-sermons-search-wrap';
	}

}
