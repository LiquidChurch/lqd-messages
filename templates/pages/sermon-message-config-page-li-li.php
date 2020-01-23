<li class="message-item">
    <input type="hidden" name="" value="<?php $this->output('id') ?>" />
    <div class="align left">
        <td>
            <a target="_blank" href="<?php $this->output('permalink') ?>">
                <?php $this->output('title') ?>
            </a>
            &nbsp;
            &nbsp;
            <small><?php $this->output('date') ?></small>
        </td>
    </div>
    <div class="align right">
        <input type="number" required min="0" name="post[<?php $this->output('id') ?>][<?php $this->output('display_ordr_meta_id') ?>]" placeholder="Display order # (required)" value="<?php $this->output('display_order') ?>"/>
        <label class="hidden" data-post-id="<?php $this->output('id') ?>"></label>
    </div>
	<div style="clear:both;"></div>
</li>