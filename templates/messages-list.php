<div class="<?php $this->output( 'wrap_classes', 'esc_attr' ); ?>">
	<ul class="lqdm-messages-list">
	<?php foreach ( $this->get( 'messages' ) as $year => $message ) : ?>
		<?php LqdM_Template_Loader::output_template( 'list-item-message', array_merge((array) $message, array( 'plugin_option' => $this->get('plugin_option'))) ); ?>
	<?php endforeach; ?>
	</ul>

	<?php LqdM_Template_Loader::output_template( 'nav', $this->args ); ?>
</div>
