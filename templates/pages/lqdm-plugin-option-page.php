<?php
$sections_config_arr = $this->get('sections_config_arr');
?>

<div class="wrap lqdm-message-config-wrap">
    <h2><?php echo __('Plugin Options', 'lqdm') ?></h2>
    <p> <?php echo __('Options related to the Plugin.', 'lqdm') ?></p>
    <div id="tabs">
        <ul>
            <?php
            foreach ($sections_config_arr as $key => $val) {
                print('<li><a href="#tabs-' . $key . '">' . $val['title'] . '</a></li>');
            }
            ?>
        </ul>

        <form action="options.php" method="post">
            <?php settings_fields($this->get('plugin_option_key')); ?>
            <?php
            foreach ($sections_config_arr as $key => $val) {
                ?>
                <div id="tabs-<?php echo $key ?>">

                    <?php do_settings_sections($key); ?>

                </div>
                <?php
            }
            ?>

            <div class="clearfix">
                <button class="option-save-button" name="Submit" type="submit"><?php esc_attr_e('Save Changes'); ?></button>
            </div>
        </form>
    </div>
</div>
