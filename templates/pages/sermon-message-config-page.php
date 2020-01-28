<div class="wrap gc-sermon-message-config-wrap">
    <button type="button" id="all-sort-btn" class="sort-btn">
        <?php echo __('Auto Sort all', 'gc-sermons') ?>
    </button>
    <button type="submit" id="all-update-btn" class="update-btn">
        <?php echo __('Update all', 'gc-sermons') ?>
    </button>
    <button type="reset" id="all-reset-btn" class="reset-btn">
        <?php echo __('Reset all', 'gc-sermons') ?>
    </button>
    <ul class="message-config-list">
        <?php $this->output('items'); ?>
    </ul>
</div>
