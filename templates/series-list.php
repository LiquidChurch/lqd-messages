<div class="<?php $this->output( 'wrap_classes', 'esc_attr' ); ?>">
	<?php foreach ( $this->get( 'terms' ) as $year => $terms ) : ?>
		<?php if ( ! $this->get( 'remove_dates' ) ) : ?>
		<h4><?php echo $year; ?></h4>
		<?php endif; ?>
		<ul class="lqdm-list">
		<?php foreach ( $terms as $term ) : ?>
			<?php LqdM_Template_Loader::output_template( 'list-item-series', array_merge((array) $term, array( 'plugin_option' => $this->get('plugin_option'))) ); ?>
		<?php endforeach; ?>
		</ul>
	<?php endforeach; ?>

	<?php LqdM_Template_Loader::output_template( 'nav', $this->args ); ?>
</div>
