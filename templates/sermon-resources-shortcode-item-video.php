<?php if ( $video_player = wp_video_shortcode( $this->get( 'embed_args', array() ) ) ) : ?>
	<div class="gc-video-wrap"><?php echo $video_player; ?></div><!-- .gc-video-wrap -->
<?php endif; ?>
