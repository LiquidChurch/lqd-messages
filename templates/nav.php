<nav class="lqdm-prev-next">
	<?php if ( $this->get( 'prev_link' ) ) : ?>
		<span class="lqdm-prev-link">
			<?php $this->output( 'prev_link' ); ?>
		</span>
	<?php endif; ?>
	<?php if ( $this->get( 'next_link' ) ) : ?>
		<span class="lqdm-next-link">
			<?php $this->output( 'next_link' ); ?>
		</span>
	<?php endif; ?>
</nav>
