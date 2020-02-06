<?php
/**
 * Liquid Messages Admin Shortcodes Base.
 *
 * @package GC Sermons
 */
abstract class LqdM_Shortcodes_Admin_Base extends WDS_Shortcode_Admin {
	/**
	 * Parent plugin class
	 *
	 * @var   LqdM_Shortcodes_Run_Base
	 * @since 0.1.0
	 */
	protected $run;

	/**
	 * Shortcode prefix for field ids.
	 *
	 * @var   string
	 * @since 0.1.3
	 */
	protected $prefix = '';

    /**
     * Constructor
     *
     * @param LqdM_Shortcodes_Run_Base $run Main plugin object.
     *
     * @since   0.1.0
     */
	public function __construct( LqdM_Shortcodes_Run_Base $run ) {
		$this->run = $run;

		parent::__construct(
			$this->run->shortcode,
			Lqd_Messages_Plugin::VERSION,
			$this->run->atts_defaults
		);

		// Do this super late.
		add_filter( "{$this->shortcode}_shortcode_fields", array( $this, 'maybe_remove_prefixes' ), 99999 );
	}

	/**
	 * If the shortcode has a prefix property, we remove it from the shortcode attributes.
	 *
	 * @since  0.1.3
	 *
	 * @param  array  $updated Array of shortcode attributes.
	 *
	 * @return array           Modified array of shortcode attributes.
	 */
	public function maybe_remove_prefixes( $updated ) {
		if ( $this->prefix ) {
			$prefix_length = strlen( $this->prefix );
			$new_updated = array();

			foreach ( $updated as $key => $value) {

				if ( $this->prefix === substr( $key, 0, $prefix_length ) ) {
				    $key = substr( $key, $prefix_length );
				}

				$new_updated[ $key ] = $value;
			}

			$updated = $new_updated;
		}

		return $updated;
	}
}
