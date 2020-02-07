<?php
/**
 * Liquid Messages Post Types Base
 *
 * @package Liquid Messages
 */
abstract class LqdM_Post_Types_Base extends CPT_Core {

	/**
	 * Parent plugin class
	 *
	 * @since  0.1.0
	 */
	protected $plugin = null;

	/**
	 * The identifier for this object
	 *
	 * @var string
	 */
	protected $id = '';

    /**
     * Have Overrides Been Processed?
     *
     * @var bool
     */
	protected $overrides_processed = false;

    /**
     * Constructor
     *
     * Register CPT. See documentation in CPT_Core
     *
     * @param object $plugin Main plugin object.
     * @param $args
     *
     * @since 0.1.0
     *
     */
	public function __construct( $plugin, $args ) {
		$this->plugin = $plugin;

		// First parameter should be an array with Singular, Plural, and Registered name.
		parent::__construct(
			$args['labels'],
			$args['args']
		);

		$this->hooks();
		add_action( 'plugins_loaded', array( $this, 'filter_values' ), 4 );
	}

    /**
     * Filter Values
     */
	public function filter_values() {
		if ( $this->overrides_processed ) {
			return;
		}

		$args = array(
			'singular'      => $this->singular,
			'plural'        => $this->plural,
			'post_type'     => $this->post_type,
			'arg_overrides' => $this->arg_overrides,
		);

		$filtered_args = apply_filters( 'lqdm_post_types_'. $this->id, $args, $this );

		if ( $filtered_args !== $args ) {
			foreach ( $args as $arg => $val ) {
				if ( isset( $filtered_args[ $arg ] ) ) {
					$this->{$arg} = $filtered_args[ $arg ];
				}
			}
		}

		$this->overrides_processed = true;
	}

	/**
	 * Provides access to protected class properties.
     *
	 * @since  0.2.0
	 *
	 * @param string $key Specific CPT parameter to return
	 *
	 * @return mixed      Specific CPT parameter or array of singular, plural and registered name
	 */
	public function post_type( $key = 'post_type' ) {
		if ( ! $this->overrides_processed ) {
			$this->filter_values();
		}

		return parent::post_type( $key );
	}

	/**
	 * Initiate our hooks
	 *
	 * @since 0.1.0
	 * @return void
	 */
	abstract function hooks();

	/**
	 * Wrapper for new_cmb2_box
	 *
	 * @since  0.1.1
	 *
	 * @param  array  $args Array of CMB2 args
	 *
	 * @return CMB2
	 */
	public function new_cmb2( $args ) {
		$cmb_id = $args['id'];
		return new_cmb2_box( apply_filters( "lqdm_cmb2_box_args_{$this->id}_{$cmb_id}", $args ) );
	}

	/**
	 * Magic getter for our object. Allows getting but not setting.
	 *
	 * @param string $field
	 * @throws Exception Throws an exception if the field is invalid.
	 * @return mixed
	 */
	public function __get( $field ) {
		switch ( $field ) {
			case 'id':
			case 'arg_overrides':
			case 'cpt_args':
				return $this->{$field};
			default:
				throw new Exception( 'Invalid ' . __CLASS__ . ' property: ' . $field );
		}
	}
}
