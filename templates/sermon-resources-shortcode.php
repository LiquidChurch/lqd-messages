<div class="lqdm-resources-wrap <?php $this->output( 'resource_extra_classes', 'esc_attr' ); ?>">
	<ul class="lqdm-resources-list">
        <?php
        $items = $this->get('items');
        $lqdm_list_style = count($items) == '1' ? 'width: 100%;' : '';
        $lqdm_container_class = count($items) == '1' ? 'single-item' : '';
        $resource_lang = $this->get('resource_lang');
        $lang_plugin_option = $this->get('lang_plugin_option');
        foreach ($resource_lang as $key => $val) {
            if (empty($items[$val])) {
                continue;
            }
            printf('<li class="lc-list" style="%s">', $lqdm_list_style);
            printf( '<ul class="lqdm-resources-wrapper %s">', $lqdm_container_class);
            printf('<li class="lqdm-resources-language">%s</li>', $lang_plugin_option[$val]);
            foreach ($items[$val] as $ik => $iv) {
                echo $iv;
            }
            printf('</ul>');
            printf('</li>');
        }
        ?>
	</ul>
</div>
