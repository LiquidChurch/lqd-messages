<div id="lqdm-video-overlay" style="display:none;">
	<?php foreach ( $this->get( 'videos' ) as $message_id => $player ) : ?>
	<div id="lqdm-messages-video-<?php echo absint( $message_id ); ?>" class="lqdm-messages-modal lqdm-invisible">
		<div class="lqdm-messages-video-container"></div>
		<script type="text/template" class="tmpl-videoModal">
			<?php echo $player; ?>
		</script>
	</div>
	<?php endforeach; ?>
</div><!-- #lqdm-video-overlay -->
