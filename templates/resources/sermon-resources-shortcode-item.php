<a target="_blank" href="<?php $this->output( 'file', 'esc_url' ); ?>">
	<?php if ( $this->get( 'do_display_name' ) ) : ?>
		<?php $this->output( 'display_name' ); ?>
	<?php else : ?>
		<?php $this->output( 'name' ); ?>
	<?php endif; ?>
</a>
