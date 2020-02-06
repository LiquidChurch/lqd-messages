<div id="lqdm-video-overlay" style="display:none;">
	<?php foreach ( $this->get( 'videos' ) as $sermon_id => $player ) : ?>
	<div id="lqdm-sermons-video-<?php echo absint( $sermon_id ); ?>" class="lqdm-messages-modal lqdm-invisible">
		<div class="lqdm-sermons-video-container"></div>
		<script type="text/template" class="tmpl-videoModal">
			<?php echo $player; ?>
		</script>
	</div>
	<?php endforeach; ?>
</div><!-- #lqdm-video-overlay -->
