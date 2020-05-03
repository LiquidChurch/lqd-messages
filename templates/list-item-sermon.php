<?php
$plugin_option = $this->get('plugin_option');
?>
<li class="lqdm-item gc-<?php if ( ! $this->get( 'do_image' ) ) : ?>no-<?php endif; ?>thumb <?php $this->output( 'classes', 'esc_attr' ); ?>">

	<?php
	$hover_class = '';
	if(!empty($plugin_option['message_img_type']) && $plugin_option['message_img_type'] == 'on_hover_overlay') {
		$hover_class = 'lqdm-hover-opposite';
	}
	?>

	<a class="lqdm-item-link <?php echo $hover_class ?>" href="<?php $this->output( 'url', 'esc_url' ); ?>" title="<?php $this->output( 'name', 'esc_attr' ); ?>">
		<?php $this->maybe_output( 'image', '', 'do_image' ); ?>

		<?php
		if(!empty($plugin_option['message_img_type']) && ($plugin_option['message_img_type'] != 'no_overlay')) {
			echo '<div class="lqdm-msgs-shader"></div>';
		}
		?>

		<?php
		if(!empty($plugin_option['title_over_message_featured_img']) && ($plugin_option['title_over_message_featured_img'] == 'yes' || $plugin_option['title_over_message_featured_img'] == 'always_show')) {
			?>
			<div class="lqdm-msgs-table-wrapper <?php echo ($plugin_option['title_over_message_featured_img'] == 'always_show') ? 'lqdm-always-show-title' : '' ?>">
				<table>
					<tbody>
					<tr>
						<td>
							<h3 class=""><?php $this->output('name'); ?></h3>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
			<?php
		}
		?>
	</a>

	<div class="gc-list-item-description">
		<?php $this->maybe_output( 'description', '', 'do_description' ); ?>
	</div>

</li>
