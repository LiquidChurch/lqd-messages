<li class="message-config-list-single">
    <form action="" method="post" class="message-config-form" name="series-<?php $this->output('id') ?>" id="series-<?php $this->output('id') ?>">
        <input type="hidden" name="series_id" value="<?php $this->output('id') ?>" />
        <h2 class="series-name"><?php $this->output('series_title') ?></h2>
        <ul class="message-list">
            <?php $this->output('items') ?>
        </ul>
		<div class="config-section">
			<button type="button" class="single sort-btn"><?php echo __('Auto Sort', 'lc-func') ?></button>
			<button type="submit" class="single update-btn"><?php echo __('Update', 'lc-func') ?></button>
			<button type="reset" class="single reset-btn"><?php echo __('Reset', 'lc-func') ?></button>
		</div>
    </form>
</li>