<form role="search" method="get" class="search-form gc-sermons-search" action="<?php $this->output('action_url', 'esc_url'); ?>" <?php echo (true == $this->get('separate_results')) ? 'target="_blank"' : '' ?>>

	<div class="row first-row">
		<div class="col-md-3">
			<label class="screen-reader-text"><?php _ex('Search for :', 'label'); ?></label>
        </div>
        <div class="col-md-9">
            <div class="form-inline">
                <div class="form-group">
                    <input type="search" class="search-field"
                           placeholder="<?php echo esc_attr_x('Search for Series &amp; Sermons &hellip;', 'placeholder'); ?>"
                           value="<?php $this->output('search_query', 'esc_attr'); ?>" name="sermon-search"/>

                    <input type="submit" class="search-submit"
                           value="<?php echo esc_attr_x('Search', 'submit button'); ?>"/>
                </div>
            </div>
        </div>
    </div>

	<?php if ( $this->get( 'show_filter' ) ) : ?>
        <div class="row second-row">
            <div class="col-md-3">
                <label><?php _ex( 'Show search results for:', 'Search results filter', 'gc-sermons' ); ?></label>
            </div>
            <div class="col-md-9">
                <div class="form-inline">
                    <div class="form-group">
						<input type="radio" class="search-field-radio" name="results-for"
							   value="" <?php checked($this->get('show_results'), ''); ?>/>
                        <span><?php _ex('Both', 'Show search results for both sermons and sermon series.', 'gc-sermons'); ?></span>

                        <input type="radio" class="search-field-radio" name="results-for"
                               value="<?php $this->output('sermons_value', 'esc_attr'); ?>" <?php checked($this->get('show_results'), $this->get('sermons_value', 'esc_attr')); ?>/>
                        <span><?php $this->output('sermons_label', 'esc_attr'); ?></span>
                        <input type="radio" class="search-field-radio" name="results-for"
                               value="<?php $this->output('series_value', 'esc_attr'); ?>" <?php checked($this->get('show_results'), $this->get('series_value', 'esc_attr')); ?>/>
                        <span><?php $this->output('series_label', 'esc_attr'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</form>
