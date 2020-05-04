<div class="<?php $this->output( 'wrap_classes', 'esc_attr' ); ?>">
	<ul class="lqdm-msgs-list">
	<?php foreach ( $this->get( 'sermons' ) as $year => $sermon ) : ?>
		<?php LQDM_Template_Loader::output_template( 'list-item-sermon', array_merge((array) $sermon, array( 'plugin_option' => $this->get('plugin_option'))) ); ?>
	<?php endforeach; ?>
	</ul>

	<?php LQDM_Template_Loader::output_template( 'nav', $this->args ); ?>
</div>
