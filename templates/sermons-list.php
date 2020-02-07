<div class="<?php $this->output( 'wrap_classes', 'esc_attr' ); ?>">
	<ul class="lqdm-list">
	<?php foreach ( $this->get( 'sermons' ) as $year => $sermon ) : ?>
		<?php LqdM_Template_Loader::output_template( 'list-item-sermon', array_merge((array) $sermon, [ 'plugin_option' => $this->get('plugin_option') ] ) ); ?>
	<?php endforeach; ?>
	</ul>

	<?php LqdM_Template_Loader::output_template( 'nav', $this->args ); ?>
</div>
