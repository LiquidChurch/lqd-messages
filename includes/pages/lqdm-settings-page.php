<?php
$sections_config_arr = $this->get('sections_config_arr');
?>

<div class="wrap lqdm-settings-wrap">
    <h2><?php echo __('Settings', 'lqdm') ?></h2>
    <p> <?php echo __('Settings related to Liquid Messages.', 'lqdm') ?></p>
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
                <button class="lqdm-settings-save-btn" name="Submit" type="submit"><?php esc_attr_e('Save Changes'); ?></button>
            </div>
        </form>
    </div>
</div>
