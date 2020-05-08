<?php
/**
 * Liquid Messages Shortcode Admin Base
 *
 * @package Liquid Messages
 */
abstract class LQDM_Shortcodes_Admin_Base extends WDS_Shortcode_Admin {
	/** @var LQDM_Shortcodes_Run_Base $run Parent plugin class */
	protected $run;

	/** @var string $prefix Shortcode prefix for field ids */
	protected $prefix = '';

	/**
	 * Constructor
	 *
     * @since 0.1.0
     *
	 * @param LQDM_Shortcodes_Run_Base  $run  Main plugin object.
	 */
	public function __construct( LQDM_Shortcodes_Run_Base $run ) {
		$this->run = $run;

		parent::__construct(
			$this->run->shortcode,
			LQDM_Plugin::VERSION,
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

				if ( strpos( $key, $this->prefix ) === 0 ) {
				    $key = substr( $key, $prefix_length );
				}

				$new_updated[ $key ] = $value;
			}

			$updated = $new_updated;
		}

		return $updated;
	}
}
