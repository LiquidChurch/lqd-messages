<?php
/**
 * Liquid Messages Series Shortcode - Run
 *
 * @package Liquid Messages
 */
class GCSS_Series_Run extends GCS_Shortcodes_Run_Base
{

	// The Shortcode Tag
	public $shortcode = 'gc_series';

	// GCS_Series Object
	public $series;

	// Array of default attributes applied to the shortcode.
	public $atts_defaults = array(
			'per_page'          => 10, // Will use WP's per-page option.
			'remove_dates'      => false,
			'remove_thumbnail'  => false,
			'thumbnail_size'    => 'medium',
			'number_columns'    => 2,
			'list_offset'       => 0,
			'wrap_classes'      => '',
			'remove_pagination' => false,

			'paging_by'                 => 'per_page',
			'show_num_years_first_page' => 0,
			'paging_init_year'          => '',

			// No admin
			'remove_description'        => true,
		);

	/**
	 * Constructor
	 *
	 * @since 0.1.3
	 *
	 * @param GCS_Sermons $sermons
	 * @param GCS_Series $series
	 */
	public function __construct(GCS_Sermons $sermons, GCS_Series $series)
	{
		$this->series = $series;
		$this->atts_defaults['paging_init_year'] = array(date('Y', time()));
		parent::__construct($sermons);
	}

	/**
	 * Shortcode Output
	 *
	 * @return string
	 * @throws Exception
	 */
	public function shortcode()
	{
		$allterms = $this->series->get_many(array('orderby' => 'sermon_date'));

		if (empty($allterms)) {
			return '';
		}

		$paging_by = $this->att('paging_by');

		$args = $paging_by ==
		        'per_page' ? $this->get_initial_query_args() : $this->get_initial_query_args_if_year();

		if ($paging_by == 'per_page') {
			$total_pages = ceil(count($allterms) / $args['posts_per_page']);
			$allterms    = array_splice($allterms, $args['offset'], $args['posts_per_page']);

			if (empty($allterms)) {
				return '';
			}

			$allterms = $this->add_year_index_and_augment_terms($allterms);
		} else {
			$allterms = $this->add_year_index_and_augment_terms($allterms);

			sort($args['year_config'], SORT_NUMERIC);
			$paging_init_year
				= $curr_year = array_flip(array_reverse($args['year_config']));

			$paging_init_year_tmp = array();
			$max_year = max(array_keys($paging_init_year));
			$min_year = min(array_keys($paging_init_year));

			if ($args['paged'] > 1) {
				for ($i = 1; $i < $args['paged']; $i++) {
					$tmp_year  = --$min_year;
					$curr_year = array($tmp_year => '');
					$paging_init_year_tmp[$tmp_year] = '';
				}
			}

			$diff_year   = array_diff_key($allterms, $paging_init_year, $paging_init_year_tmp);
			$total_pages = count($diff_year) + count($paging_init_year_tmp) + 1;
			$allterms    = array_intersect_key($allterms, $curr_year);

			if (empty($allterms)) {
				return '';
			}
		}

		$args = $this->get_pagination($total_pages);

		$args['terms']         = $allterms;
		$args['remove_dates']  = $this->bool_att('remove_dates');
		$args['wrap_classes']  = $this->get_wrap_classes();
		$args['plugin_option'] = get_plugin_settings_options('series_view');

		$content  = '';
		$content .= GCS_Style_Loader::get_template('list-item-style');
		$content .= GCS_Template_Loader::get_template('series-list', $args);

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
	 * Get Initial Query Args if Year
	 *
	 * @return array
	 */
	public function get_initial_query_args_if_year()
	{
		$year_config = '';
		$show_num_years_first_page = $this->att('show_num_years_first_page');
		if (empty($show_num_years_first_page)) {
			$year_config = $this->att('paging_init_year');
		} else {
			$year_config = [
				date('Y', time()),
				date('Y', time()) - 1,
			];
		}

		if (empty($year_config)) {
			$year_config = $this->atts_defaults['paging_init_year'];
		} else {
			if (!is_array($year_config)) {
				$year_config = explode(',', $year_config);
			}
		}
		$paged = (int)get_query_var('paged') ? get_query_var('paged') : 1;

		return compact('year_config', 'paged');
	}

	/**
	 * Add Year Index and Augment Terms
	 *
	 * @param $allterms
	 *
	 * @return array
	 */
	public function add_year_index_and_augment_terms($allterms)
	{
		$terms = array();

		$do_date  = !$this->bool_att('remove_dates');
		$do_thumb = !$this->bool_att('remove_thumbnail');
		$do_desc  = !$this->bool_att('remove_description');

		foreach ($allterms as $key => $term) {
			$term = $this->get_term_data($term);

			$term->do_image       = $do_thumb && $term->image;
			$term->do_description = $do_desc && $term->description;
			$term->url            = $term->term_link;

			$terms[$do_date ? $term->year : 0][] = $term;
		}

		return $terms;
	}

	/**
	 * Get Term Data
	 *
	 * @param $term
	 *
	 * @return bool|false|WP_Term
	 */
	public function get_term_data($term)
	{
		return $this->series->get($term, array('image_size' => $this->att('thumbnail_size')));
	}

	/**
	 * Get Pagination
	 *
	 * @param $total_pages
	 *
	 * @return string[]
	 */
	public function get_pagination($total_pages)
	{
		$nav = array('prev_link' => '', 'next_link' => '');

		if (!$this->bool_att('remove_pagination')) {
			$nav['prev_link'] = get_previous_posts_link(__('<span>&larr;</span> Newer', 'lqdm'));
			$nav['next_link'] = get_next_posts_link(__('Older <span>&rarr;</span>', 'lqdm'), $total_pages);
		}

		return $nav;
	}

	/**
	 * Get Wrap Classes
	 *
	 * @return string
	 */
	public function get_wrap_classes()
	{
		$columns = absint($this->att('number_columns'));
		$columns = $columns < 1 ? 1 : $columns;

		return $this->att('wrap_classes') . ' lqdm-' . $columns . '-cols lqdm-series-wrap';
	}
}
