<?php if ( $audio_player = wp_audio_shortcode( array( 'src' => esc_url( $this->get( 'file' ) ) ) ) ) : ?>
	<div class="gc-audio-wrap"><?php echo $audio_player; ?></div><!-- .gc-audio-wrap -->
<?php endif; ?>

