<div id="lqdm-video-overlay" style="display:none;">
	<?php foreach ( $this->get( 'videos' ) as $sermon_id => $player ) : ?>
	<div id="lqdm-video-<?php echo absint( $sermon_id ); ?>" class="lqdm-modal lqdm-invisible">
		<div class="lqdm-video-container"></div>
		<script type="text/template" class="tmpl-videoModal">
			<?php echo $player; ?>
		</script>
	</div>
	<?php endforeach; ?>
</div><!-- #lqdm-video-overlay -->
