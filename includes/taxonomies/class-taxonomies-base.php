<?php
/**
 * Liquid Messages Custom Taxonomies Base
 *
 * @package Liquid Messages
 */

abstract class LQDM_Taxonomies_Base extends Taxonomy_Core {
	/** @var string $id The identifier for this object */
	protected $id = '';

	/** @var object|null $sermons LQDM_Sermons object */
	protected $sermons;

	/** @var string $image_meta_key The image meta key for this taxonomy */
	protected $image_meta_key = '';

	/** @var int[] $term_get_args_defaults The default args array for self::get() */
	protected $term_get_args_defaults = array(
		'image_size' => 512,
	);

	/** @var array $term_get_many_args_defaults The default args array for self::get_many() */
	protected $term_get_many_args_defaults = array(
		'orderby'       => 'name',
		'augment_terms' => true,
	);

	/** @var string $img_col_title The image column title, if applicable */
	protected $img_col_title = '';

	/**
	 * Constructor
	 * Register Taxonomy. See documentation in Taxonomy_Core, and in wp-includes/taxonomy.php
	 *
	 * @since 0.1.0
	 *
	 * @param  object $sermons LQDM_Sermons object.
	 * @param $args
	 */
	public function __construct( $sermons, $args ) {
		$this->sermons = $sermons;
		$this->hooks();

		$this->flush_cache = isset( $_GET['flush_cache'] ) && date( 'Y-m-d' ) === $_GET['flush_cache'];

		parent::__construct(
			$args['labels'],
			$args['args'],
			array( $this->sermons->post_type() )
		);

		add_action( 'plugins_loaded', array( $this, 'filter_values' ), current_filter() === 'plugins_loaded' ? 12 : 4 );
		add_action( 'wp_async_set_sermon_terms', array( $this, 'trigger_cache_flush' ), 10, 2 );
	}

	/**
	 * Filter values before taxonomy is officially registered.
	 *
	 * @since  0.1.0
	 *
	 * @return void
	 */
	public function filter_values() {
		$args = array(
			'singular'      => $this->singular,
			'plural'        => $this->plural,
			'taxonomy'      => $this->taxonomy,
			'arg_overrides' => $this->arg_overrides,
			'object_types'  => $this->object_types,
		);

		$filtered_args = apply_filters( 'gcs_taxonomies_'. $this->id, $args, $this );
		if ( $filtered_args !== $args ) {
			foreach ( $args as $arg => $val ) {
				if ( isset( $filtered_args[ $arg ] ) ) {
					$this->{$arg} = $filtered_args[ $arg ];
				}
			}
		}
	}

	/** Columns ***************************************************************/

	/**
	 * Register image columns for $this->taxonomy().
	 *
	 * @since 0.1.3
	 *
	 * @param string  $img_col_title The title for the Image column.
	 */
	protected function add_image_column( $img_col_title ) {
		$this->img_col_title = $img_col_title ?: __( 'Image', 'lqdm' );

		$tax = $this->taxonomy();

		add_filter( "manage_edit-{$tax}_columns", array( $this, 'add_column_header' ) );
		add_filter( "manage_{$tax}_custom_column", array( $this, 'add_column_value'  ), 10, 3 );
	}

	/**
	 * Add the "tax-image" column to taxonomy terms list-tables.
	 *
	 * @since 0.1.3
	 *
	 * @param array $columns
	 *
	 * @return array
	 */
	public function add_column_header( $columns = array() ) {
		$columns['tax-image'] = $this->img_col_title;

		return $columns;
	}

	/**
	 * Output the value for the custom column.
	 *
	 * @since 0.1.3
	 *
	 * @param string $empty
	 * @param string $custom_column
	 * @param int    $term_id
	 *
	 * @return mixed
	 */
	public function add_column_value( $empty = '', $custom_column = '', $term_id = 0 ) {

		// Bail if no taxonomy passed or not on the `tax-image` column
		if ( empty( $_REQUEST['taxonomy'] ) || ( $custom_column !== 'tax-image' ) || ! empty( $empty ) ) {
			return;
		}

		$retval = '&#8212;';

		// Get the term data.
		$term = $this->get( $term_id, array( 'image_size' => 'thumb' ) );

		// Output image if not empty.
		if ( isset( $term->image_id ) && $term->image_id ) {
			$retval = wp_get_attachment_image( $term->image_id, 'thumb', false, array(
				'style' => 'max-width:100%;height: auto;',
			) );

			$link = get_edit_term_link( $term->term_id, $this->taxonomy(), $this->sermons->post_type() );

			if ( $link ) {
				$retval = '<a href="'. $link .'">'. $retval .'</a>';
			}
		}

		echo $retval;

		return null;
	}

	/** Required by Extended Classes  *****************************************/

	/**
	 * Initiate our hooks
	 *
	 * @since 0.1.0
	 * @return void
	 */
	abstract function hooks();

	/** Helper Methods  ******************************************************
	 *
	 * @param $args
	 *
	 * @return object new_cmb2_box
	 */

	public function new_cmb2( $args ) {
		$cmb_id = $args['id'];
		return new_cmb2_box( apply_filters( "gcs_cmb2_box_args_{$this->id}_{$cmb_id}", $args ) );
	}

	/**
	 * Retrieve the terms for the most recent post which has this taxonomy set.
	 *
	 * @since  0.1.0
	 *
	 * @param  boolean $get_single_term Whether to get the first term or all of them.
	 *
	 * @return LQDM_Sermon_Post|false  GC Sermon post object if successful.
	 * @throws Exception
	 */
	public function most_recent( $get_single_term = false ) {
		static $terms = null;

		if ( $terms === null ) {
			$sermon = $this->most_recent_sermon();

			if ( ! $sermon ) {
				$terms = false;
				return $terms;
			}

			$terms = $sermon->{$this->id};
			$terms = $terms && $get_single_term && is_array( $terms ) ? array_shift( $terms ) : $terms;
		}

		return $terms;
	}

	/**
	 * Retrieve the most recent message which has terms in this taxonomy.
	 *
     * @since  0.2.0
	 * @return LQDM_Sermon_Post|false  GC Sermon post object if successful.
	 * @throws Exception
	 *
	 */
	public function most_recent_sermon() {
		return $this->sermons->most_recent_with_taxonomy( $this->id );
	}

	/**
	 * Wrapper for get_terms
	 *
	 * @since  0.1.1
	 *
	 * @param  string|array|object $args Array of arguments (passed to get_terms).
	 * @param  array $single_term_args Array of arguments for LQDM_Taxonomies_Base::get().
	 *
	 * @return array|false Array of term objects or false
	 * @throws Exception
	 */
	public function get_many( $args = array(), $single_term_args = array() ) {
		$args = wp_parse_args( $args, $this->term_get_many_args_defaults );
		$args = apply_filters( "gcs_get_{$this->id}_args", $args );

		if ( isset( $args['orderby'] ) && $args['orderby'] === 'sermon_date' ) {
			$terms = $this->get_terms_in_sermon_date_order();
		} else {
			$terms = self::get_terms( $this->taxonomy(), $args );
		}

		if ( ! $terms || is_wp_error( $terms ) ) {
			return false;
		}

		if (
			isset( $args['augment_terms'] )
			&& $args['augment_terms']
			&& ! empty( $terms )
			// Don't augment for queries w/ greater than 100 terms, for performance reasons.
			&& 100 < count( $terms )
		) {
			foreach ( $terms as $key => $term ) {
				$terms[ $key ] = $this->get( $term, $single_term_args );
			}
		}

		return $terms;
	}

	/**
	 * Wrapper for get_terms that allows searching using a wildcard name.
	 *
	 * @since  0.1.5
	 *
	 * @param  string|array $search_term      The search term.
	 * @param  array        $args             Array of arguments for LQDM_Taxonomies_Base::get_many().
	 * @param  array        $single_term_args Array of arguments for LQDM_Taxonomies_Base::get().
	 *
	 * @return array|bool|false Array of term objects or false
	 * @throws Exception
	 */
	public function search( $search_term, $args = array(), $single_term_args = array() ) {
	    $parse_args = array(
            'name__like'   => sanitize_text_field( $search_term ),
            'hide_empty'   => false,
            'orderby'      => 'term_id',
            'order'        => 'DESC',
            'cache_domain' => 'gc_sermons_search_' . $this->id,
        );
		$args = wp_parse_args( $args, $parse_args );

		return $this->get_many( $args, $single_term_args );
	}

	/**
	 * Get a single term object
	 *
	 * @since  0.1.1
	 *
	 * @param  object|int $term Term id or object
	 * @param  array      $args Array of arguments.
	 *
	 * @return WP_Term|false    Term object or false
	 */
	public function get( $term, $args = array() ) {
		$term = isset( $term->term_id ) ? $term : get_term_by( 'id', $term, $this->taxonomy() );
		if ( ! isset( $term->term_id ) ) {
			return false;
		}

		$args = wp_parse_args( $args, $this->term_get_args_defaults );
		$args = apply_filters( "gcs_get_{$this->id}_single_args", $args, $term, $this );

		$term->term_link = get_term_link( $term );
		$term = $this->extra_term_data( $term, $args );

		return $term;
	}

	/**
	 * Sets extra term data on the the term object, including the image, if applicable
	 *
	 * @since  0.1.1
	 *
	 * @param  WP_Term $term Term object
	 * @param  array   $args Array of arguments.
	 *
	 * @return WP_Term|false
	 */
	protected function extra_term_data( $term, $args ) {
		if ( $this->image_meta_key ) {
			$term = $this->add_image( $term, $args['image_size'] );
		}

		return $term;
	}

	/**
	 * Add term's image
	 *
	 * @since  0.1.1
	 *
	 * @param  WP_Term $term Term object
	 * @param  string  $size Size of the image to retrieve
	 *
	 * @return mixed         URL if successful or set
	 */
	protected function add_image( $term, $size = '' ) {
		if ( ! $this->image_meta_key ) {
			return $term;
		}

		$term->image_id = get_term_meta( $term->term_id, $this->image_meta_key . '_id', 1 );
		if ( ! $term->image_id ) {

			$term->image_url = get_term_meta( $term->term_id, $this->image_meta_key, 1 );

			$term->image = $term->image_url ? '<img src="'. esc_url( $term->image_url ) .'" alt="'. $term->name .'"/>' : '';

			return $term;
		}

		if ( $size ) {
			$size = is_numeric( $size ) ? array( $size, $size ) : $size;
		}

		$term->image = wp_get_attachment_image( $term->image_id, $size ?: 'thumbnail' );

		$src = wp_get_attachment_image_src( $term->image_id, $size ?: 'thumbnail' );
		$term->image_url = $src[0] ?? '';

		return $term;
	}

	/**
	 * Gets terms in the message date order. Result is cached for a max. of a day.
	 *
	 * @since  0.1.1
	 *
	 * @param  bool $flush_cache Whether to get fresh results (flush cache)
	 *
	 * @return mixed Array of terms on success
	 * @throws Exception
	 */
	protected function get_terms_in_sermon_date_order( $flush_cache = false ) {
		$this->flush_cache = $this->flush_cache || $flush_cache;

		$terms = get_transient( $this->id . '_in_sermon_date_order' );

		if ( ! $terms || $this->flush_cache ) {
			$sermons = $this->sermons->get_many( array(
				'posts_per_page' => 1000,
				'cache_results' => false,
			) );

			$taxonomy = $this->taxonomy();
			$terms = array();
			if ( $sermons->have_posts() ) {
				foreach ( $sermons->posts as $post ) {
					$year = get_the_date( 'Y', $post );
					if ( $post_terms = get_the_terms( $post, $taxonomy ) ) {
						foreach ( $post_terms as $term ) {
							if ( ! isset( $terms[ $term->term_id ] ) ) {
								$term->year = $year;
								$terms[ $term->term_id ] = $term;
							}
						}
					}
				}
			}

			set_transient( $this->id . '_in_sermon_date_order', $terms, DAY_IN_SECONDS );
		}

		return $terms;
	}

	/**
	 * Hooks into the wp_async_set_sermon_terms action, which is triggered when a post is saved.
	 *
	 * @since 0.1.1
	 *
	 * @param int    $post_id  Post ID
	 * @param string $taxonomy Taxonomy
	 *
	 * @throws Exception
	 */
	public function trigger_cache_flush( $post_id, $taxonomy ) {
		if (
			$this->taxonomy() !== $taxonomy
			|| $this->sermons->post_type() !== get_post_type( $post_id )
		) {
			return;
		}

		$this->get_terms_in_sermon_date_order( 1 );
	}

	/**
	 * Wrapper for `get_terms` to account for changes in WP 4.5 where taxonomy
	 * is expected as part of the arguments.
	 *
	 * @since  0.1.5
	 *
	 * @param $taxonomy
	 * @param array $args
	 *
	 * @return mixed Array of terms on success
	 */
	protected static function get_terms( $taxonomy, $args = array() ) {
		unset( $args['augment_terms'] );
		if ( version_compare( $GLOBALS['wp_version'], '4.5.0', '>=' ) ) {
			$args['taxonomy'] = $taxonomy;
			$terms = get_terms( $args );
		} else {
			$terms = get_terms( $taxonomy, $args );
		}

		return $terms;
	}

	/**
	 * Magic getter for our terms object.
	 *
	 * @param string $field
	 * @throws Exception Throws an exception if the field is invalid.
	 * @return mixed
	 */
	public function __get( $field ) {
		switch ( $field ) {
			case 'id':
				return $this->id;
			default:
				throw new RuntimeException( 'Invalid ' . __CLASS__ . ' property: ' . $field );
		}
	}
}
