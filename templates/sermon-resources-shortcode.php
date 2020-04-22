<div class="lqdm-msg-resources-wrap <?php $this->output( 'resource_extra_classes', 'esc_attr' ); ?>">
	<ul class="lqdm-msg-resources-list">
        <?php
        $items = $this->get('items');
        $lc_list_style = '1' == count($items) ? 'width: 100%;' : '';
        $lc_container_class = '1' == count($items) ? 'lqdm-single-lng-resources' : '';
        $resource_lang = $this->get('resource_lang');
        $lang_plugin_option = $this->get('lang_plugin_option');
        foreach ($resource_lang as $key => $val) {
            if (empty($items[$val]))
                continue;
            printf('<li class="lqdm-list" style="%s">', $lc_list_style);
            printf('<ul class="lqdm-container %s">', $lc_container_class);
            printf('<li class="lqdm-resources-lang">%s</li>', $lang_plugin_option[$val]);
            foreach ($items[$val] as $ik => $iv) {
                echo $iv;
            }
            printf('</ul>');
            printf('</li>');
        }
        ?>
	</ul>
</div>
