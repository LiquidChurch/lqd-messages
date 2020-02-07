<div class="wrap lqdm-config-wrap">
    <button type="button" id="all-sort-btn" class="sort-btn">
        <?php echo __('Auto Sort all', 'lqdm') ?>
    </button>
    <button type="submit" id="all-update-btn" class="update-btn">
        <?php echo __('Update all', 'lqdm') ?>
    </button>
    <button type="reset" id="all-reset-btn" class="reset-btn">
        <?php echo __('Reset all', 'lqdm') ?>
    </button>
    <ul class="message-config-list">
        <?php $this->output('items'); ?>
    </ul>
</div>
