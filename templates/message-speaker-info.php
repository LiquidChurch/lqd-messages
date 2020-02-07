<div
    class="lqdm-speaker lqdm-<?php if (!$this->get('image')) : ?>no-<?php endif; ?>thumb <?php $this->output('classes', 'esc_attr'); ?>">
    <div class="row">
        <div class="col-sm-3">
            <span><?php _e('Speaker', 'lqdm'); ?>:</span>
        </div>
        <div class="col-sm-9">
            <a href="<?php $this->output('term_link', 'esc_url'); ?>"><?php $this->output('name'); ?></a>
        </div>
    </div>

</div>
