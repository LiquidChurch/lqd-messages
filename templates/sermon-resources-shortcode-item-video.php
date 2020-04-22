<?php if ( $video_player = wp_video_shortcode( $this->get( 'embed_args', array() ) ) ) : ?>
	<div class="lqdm-video-wrap"><?php echo $video_player; ?></div><!-- .lqdm-video-wrap -->
<?php endif; ?>
