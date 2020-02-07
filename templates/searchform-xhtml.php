<form role="search" method="get" id="searchform" class="searchform lqdm-search" action="<?php $this->output( 'action_url', 'esc_url' ); ?>" <?php echo (true == $this->get('separate_results')) ? 'target="_blank"' : '' ?>>
	<div>
		<?php if ( $this->get( 'show_filter' ) ) : ?>
		<div class="lqdm-search-results-filter">
			<span><?php _ex( 'Show search results for:', 'Search results filter', 'lqdm' ); ?></span>
			<input type="radio" class="search-field-radio" id="results-for-both" name="results-for" value="" <?php checked( $this->get( 'show_results' ), '' ); ?>/> <label for="results-for-both"><?php _ex( 'Both', 'Show search results for both sermons and sermon series.', 'lqdm' ); ?></label>
			<input type="radio" class="search-field-radio" id="results-for-sermons" name="results-for" value="<?php $this->output( 'sermons_value', 'esc_attr' ); ?>" <?php checked( $this->get( 'show_results' ), $this->get( 'sermons_value', 'esc_attr' ) ); ?>/> <label for="results-for-sermons"><?php $this->output( 'sermons_label', 'esc_attr' ); ?></label>
			<input type="radio" class="search-field-radio" id="results-for-series" name="results-for" value="<?php $this->output( 'series_value', 'esc_attr' ); ?>" <?php checked( $this->get( 'show_results' ), $this->get( 'series_value', 'esc_attr' ) ); ?>/> <label for="results-for-series"><?php $this->output( 'series_label', 'esc_attr' ); ?></label>
		</div>
		<?php endif; ?>

		<label class="screen-reader-text" for="sermon-search"><?php _ex( 'Search for:', 'label' ); ?></label>
		<input type="text" value="<?php $this->output( 'search_query' ); ?>" name="lqdm-search" id="lqdm-search" />

		<input type="submit" id="searchsubmit" value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>" />
	</div>
</form>
