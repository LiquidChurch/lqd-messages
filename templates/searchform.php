<form role="search" method="get" class="search-form lqdm-msgs-search"
      action="<?php $this->output('action_url', 'esc_url'); ?>" <?php echo (true == $this->get('separate_results')) ? 'target="_blank"' : '' ?>>

    <div class="row lqdm-first-row">
        <div class="col-md-12">
            <label class="screen-reader-text"><?php _ex('Search for :', 'label'); ?></label>
            <div class="form-inline">
                <div class="form-group">
                    <input type="search" class="search-field"
                           placeholder="<?php echo esc_attr_x('Search for Series &amp; Individual Messages &hellip;', 'placeholder'); ?>"
                           value="<?php $this->output('search_query', 'esc_attr'); ?>" name="sermon-search"/>

                    <input type="submit" class="search-submit"
                           value="<?php echo esc_attr_x('Search', 'submit button'); ?>"/>
                </div>
            </div>
        </div>
    </div>

    <?php if ($this->get('show_filter')) : ?>
        <div class="row lqdm-second-row">
            <div class="col-md-2">
                <label style="font-size:2rem"><?php _ex('Show:', 'Search results filter', 'lqdm'); ?></label>
            </div>
            <div class="col-md-10">
                <div class="form-inline">
                    <div class="form-group" style="width:100%;">
                        <div class="col-md-3">
                            <input type="radio" class="search-field-radio" name="results-for"
                                   value="" <?php checked($this->get('show_results'), ''); ?>/>
                            <span><?php _ex('All', 'Show search results for both messages and series.', 'lqdm'); ?></span>
                        </div>
                        <div class="col-md-3">
                            <input type="radio" class="search-field-radio" name="results-for"
                                   value="<?php $this->output('sermons_value', 'esc_attr'); ?>" <?php checked($this->get('show_results'), $this->get('sermons_value', 'esc_attr')); ?>/>
                            <span><?php $this->output('sermons_label', 'esc_attr'); ?></span>
                        </div>
                        <div class="col-md-3">
                            <input type="radio" class="search-field-radio" name="results-for"
                                   value="<?php $this->output('series_value', 'esc_attr'); ?>" <?php checked($this->get('show_results'), $this->get('series_value', 'esc_attr')); ?>/>
                            <span><?php $this->output('series_label', 'esc_attr'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


</form>
