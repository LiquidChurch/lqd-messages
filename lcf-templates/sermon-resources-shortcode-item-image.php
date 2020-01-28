<a href="<?php $this->output( 'file', 'esc_url' ); ?>">
	<img src="<?php $this->output( 'file', 'esc_url' ); ?>" alt="
	<?php if ( $this->get( 'do_display_name' ) ) : ?>
		<?php $this->output( 'display_name', 'esc_attr' ); ?>
	<?php else : ?>
		<?php $this->output( 'name', 'esc_attr' ); ?>
	<?php endif; ?>
	"/>
</a>
