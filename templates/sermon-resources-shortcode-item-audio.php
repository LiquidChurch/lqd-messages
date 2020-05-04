<?php if ( $audio_player = wp_audio_shortcode( array( 'src' => esc_url( $this->get( 'file' ) ) ) ) ) : ?>
	<div class="lqdm-audio-wrapaudio-wrap"><?php echo $audio_player; ?></div><!-- .lqdm-audio-wrapaudio-wrap -->
<?php endif; ?>

