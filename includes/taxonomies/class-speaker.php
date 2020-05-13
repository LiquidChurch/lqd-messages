<?php
/**
 * Liquid Messages Speaker Custom Taxonomy
 *
 * @package Liquid Messages
 */

class LQDM_Speaker extends LQDM_Taxonomies_Base {
	/** @var string $id The identifier for this object */
	protected $id = 'speaker';

	/** @var string $image_meta_key The image meta key for this taxonomy */
	protected $image_meta_key = 'gc_sermon_speaker_image';

	/**
	 * Constructor
	 * Register Speaker Taxonomy. See documentation in Taxonomy_Core, and in wp-includes/taxonomy.php
	 *
	 * @since 0.1.0
	 * @param  object $sermons LQDM_Sermons object.
	 * @return void
	 */
	public function __construct( $sermons ) {
		parent::__construct( $sermons, array(
			'labels' => array( __( 'Speaker', 'lqdm' ), __( 'Speakers', 'lqdm' ), 'gcs-speaker' ),
			'args'   => array(
				'hierarchical' => false,
				'rewrite' => array( 'slug' => 'speaker' ),
			),
            'show_in_rest' => true,
            'show_in_graphql' => true,
            'graphql_single_name' => 'lqdmSpeaker',
            'graphql_plural_name' => 'lqdmSpeakers'
		) );
	}

	/**
	 * Initiate our hooks
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function hooks() {
		add_action( 'cmb2_admin_init', array( $this, 'fields' ) );
	}

	/**
	 * Add custom fields to the CPT
	 *
	 * @since  0.1.0
	 * @return void
	 */
	public function fields() {
		$fields = array(
			'gc_sermon_speaker_connected_user' => array(
				'name'  => __( 'Connected User', 'lqdm' ),
				'id'    => 'gc_sermon_speaker_connected_user',
				'desc'  => __( 'Type the name of the WordPress user and select from the suggested options. By associating a speaker with a WordPress user, that WordPress user account details (first/last name, avatar, bio, etc) will be used as a fallback to the information here.', 'lqdm' ),
				'type'  => 'user_select_text',
				'options' => array(
					'minimum_user_level' => 0,
				),
			),
			$this->image_meta_key => array(
				'name' => __( 'Speaker Avatar', 'lqdm' ),
				'desc' => __( 'Select the speaker\'s avatar. Will only show if "Connected User" is not chosen, or if the "Connected User" does not have an avatar.', 'lqdm' ),
				'id'   => $this->image_meta_key,
				'type' => 'file'
			),
		);

		$this->add_image_column( __( 'Speaker Avatar', 'lqdm' ) );

		$cmb = $this->new_cmb2( array(
			'id'           => 'gc_sermon_speaker_metabox',
			'taxonomies'   => array( $this->taxonomy() ), // Tells CMB2 which taxonomies should
			'object_types' => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
			'fields'       => $fields,
		) );
	}

	/**
	 * Sets extra term data on the the term object, including the image and connected user object.
	 *
	 * @since  0.1.1
	 *
	 * @param  WP_Term $term Term object
	 * @param  array   $args Array of arguments.
	 *
	 * @return WP_Term|false
	 */
	protected function extra_term_data( $term, $args ) {
        $term->connected_staff = null;
        $term->connected_user  = $term->connected_staff;
        $term->nickname        = '';

		if (
		    ( $connected_user = get_term_meta( $term->term_id, 'gc_sermon_speaker_connected_user', 1 ) )
            && isset( $connected_user['id'] )
        ) {
		    $term = $this->augment_speaker_info( $term, $connected_user['id'], $args );
		    $term = $this->maybe_use_avatar( $term, $args );
		}

		// If not connected user, do the default setting
		if ( ! $term->connected_user || ! $term->connected_staff || ! isset( $term->image_url ) ) {
			$term = parent::extra_term_data( $term, $args );
		}

		return $term;
	}

	/**
	 * Takes a user ID and augments a speaker term object with user data.
	 *
	 * @since  0.1.1
	 *
	 * @param  WP_Term $speaker Speaker term object.
	 * @param  int     $user_id Connected user ID.
	 * @param  array   $args    Array of arguments.
	 *
	 * @return WP_Term          Augmented term object.
	 */
	protected function augment_speaker_info( $speaker, $user_id, $args ) {
		if ( ! $user_id ) {
			return $speaker;
		}

		$user = get_userdata( $user_id );

		if ( ! $user ) {
			return $speaker;
		}

		$speaker->connected_user = $user->data;
		$speaker->user_link = get_author_posts_url( $user->ID );

		// Fallback to user description
		if ( ! $speaker->description && ( $user_desc = $user->get( 'description' ) ) ) {
			$speaker->description = $user_desc;
		}

		// Override speaker name with user name
		if ( $first = $user->get( 'first_name' ) ) {
			$speaker->name = $first;
			if ( $last = $user->get( 'last_name' ) ) {
				$speaker->name .= ' ' . $last;
			}
		}

		// Add speaker nickname
		$speaker->nickname = $user->get( 'nickname' );

		return $speaker;
	}

	/**
	 * Maybe Use Avatar
	 *
	 * @param $speaker
	 * @param array $args
	 *
	 * @return mixed
	 */
	public function maybe_use_avatar( $speaker, $args = array() ) {
		$speaker = $this->add_image( $speaker, $args['image_size'] );

		if ( isset( $speaker->connected_user ) ) {
			if ( ! $speaker->image ) {
				// Add avatar
				$speaker->image = get_avatar( $speaker->connected_user->ID, $args['image_size'], '', $speaker->name );
			}

			if ( ! $speaker->image_url ) {
				$speaker->image_url = get_avatar_url( $speaker->connected_user->ID, array(
					'size'    => $args['image_size'],
				) );
			}
		}

		return $speaker;
	}
}
