<?php
/**
 * Liquid Messages Admin Options Page
 *
 * @package Liquid Messages
 */
class LqdM_Option_Page
{
    /**
     * Parent plugin class
     *
     * @since 0.1.0
     */
    protected $plugin = null;

    /**
     * Array for Sections Config
     *
     * @var array
     */
    protected $sections_config_arr = array();

    /**
     * Option Key for Plugin
     *
     * @var string
     */
    protected $plugin_option_key = '';

    /**
     * Constructor
     *
     * @param  object $plugin Main plugin object.
     * @return void
     */
    public function __construct($plugin)
    {
        $this->plugin = $plugin;

        $this->plugin_option_key = Lqd_Messages_Plugin::$plugin_option_key;

        $this->sections_config_arr = $this->_get_sections_config_arr();
    }

	/**
	 * Get Sections Config Array
	 *
	 * @return array
	 */
    protected function _get_sections_config_arr()
    {
        return array(
            'series_view' => array(
                'title' => __('Series List View', 'lqdm'),
                'page' => 'series_view',
                'desc' => __('', 'lqdm'),
                'fields' => array(
                    array(
                        'title' => __('Display the Title of the Series Over the Series Featured Image', 'lqdm'),
                        'name' => 'title_over_series_featured_img',
                        'type' => 'select',
                        'value' => array(
                            '' => 'Select',
                            'always_show' => __('Always Show', 'lqdm'),
                            'yes' => __('Yes', 'lqdm'),
                            'no' => __('No', 'lqdm')
                        )
                    ),
                    array(
                        'title' => __('How Do You Want Each Series Image to Look', 'lqdm'),
                        'name' => 'series_img_type',
                        'type' => 'select',
                        'value' => array(
                            '' => __('Select', 'lqdm'),
                            'no_overlay' => __('No Overlay', 'lqdm'),
                            'on_hover_overlay' => __('Starts without Overlay, On Hover animates to Overlay', 'lqdm'),
                            'start_with_overlay' => __('Starts with Overlay, On Hover animates to No Overlay', 'lqdm')
                        )
                    ),
                    array(
                        'title' => __('Fit Entire Year of Series On One Page', 'lqdm'),
                        'name' => 'entire_year_series_one_page',
                        'type' => 'select',
                        'value' => array(
                            '' => 'Select',
                            'yes' => __('Yes', 'lqdm'),
                            'no' => __('No', 'lqdm')
                        )
                    )
                )
            ),
            'search_view' => array(
                'title' => __('Search Results View', 'lqdm'),
                'page' => 'search_view',
                'desc' => __('', 'lqdm'),
                'fields' => array(
                    array(
                        'title' => __('Display the Title of the Series Over the Series Featured Image', 'lqdm'),
                        'name' => 'title_over_series_featured_img',
                        'type' => 'select',
                        'value' => array(
                            '' => 'Select',
                            'always_show' => __('Always Show', 'lqdm'),
                            'yes' => __('Yes', 'lqdm'),
                            'no' => __('No', 'lqdm')
                        )
                    ),
                    array(
                        'title' => __('How Do You Want Each Series Image to Look', 'lqdm'),
                        'name' => 'series_img_type',
                        'type' => 'select',
                        'value' => array(
                            '' => __('Select', 'lqdm'),
                            'no_overlay' => __('No Overlay', 'lqdm'),
                            'on_hover_overlay' => __('Starts without Overlay, On Hover animates to Overlay', 'lqdm'),
                            'start_with_overlay' => __('Starts with Overlay, On Hover animates to No Overlay', 'lqdm')
                        )
                    ),
                    array(
                        'title' => __('Display the Title of the Message Over the Message Featured Image', 'lqdm'),
                        'name' => 'title_over_message_featured_img',
                        'type' => 'select',
                        'value' => array(
                            '' => 'Select',
                            'always_show' => __('Always Show', 'lqdm'),
                            'yes' => __('Yes', 'lqdm'),
                            'no' => __('No', 'lqdm')
                        )
                    ),
                    array(
                        'title' => __('How Do You Want Each Message Feature Image to Look', 'lqdm'),
                        'name' => 'message_img_type',
                        'type' => 'select',
                        'value' => array(
                            '' => __('Select', 'lqdm'),
                            'no_overlay' => __('No Overlay', 'lqdm'),
                            'on_hover_overlay' => __('Starts without Overlay, On Hover animates to Overlay', 'lqdm'),
                            'start_with_overlay' => __('Starts with Overlay, On Hover animates to No Overlay', 'lqdm')
                        )
                    )
                )
            ),
            'single_series_view' => array(
                'title' => __('Individual Series View', 'lqdm'),
                'page' => 'single_series_view',
                'desc' => __('', 'lqdm'),
                'fields' => array(
                    array(
                        'title' => __('Series Fields to Display on Front End', 'lqdm'),
                        'name' => 'series_field_to_display',
                        'type' => 'checkbox',
                        'value' => array(
                            'series_image' => __('Series Image', 'lqdm'),
                            'title' => __('Title', 'lqdm'),
                            'description' => __('Description', 'lqdm'),
                        )
                    ),
                    array(
                        'title' => __('Message Fields to Display on Front End', 'lqdm'),
                        'name' => 'message_field_to_display',
                        'type' => 'checkbox',
                        'value' => array(
                            'message_image' => __('Message Image', 'lqdm'),
                            'title' => __('Title', 'lqdm'),
                            'speakers' => __('Speaker(s)', 'lqdm'),
                            'date' => __('Date', 'lqdm'),
                            'part_of_series' => __('Part of Series', 'lqdm'),
                            'description' => __('Description', 'lqdm'),
                            'topics' => __('Topics', 'lqdm'),
                            'tags' => __('Tags', 'lqdm'),
                            'scripture_reference' => __('Scripture References', 'lqdm'),
                        )
                    ),
                    array(
                        'title' => __('Which Image Should be Displayed for Each Individual Message in the Series', 'lqdm'),
                        'name' => 'choose_image_type_to_display',
                        'type' => 'select',
                        'value' => array(
                            '' => __('Select', 'lqdm'),
                            'series_featured_image' => __('Series Featured Image', 'lqdm'),
                            'message_featured_image' => __('Message Featured Image', 'lqdm'),
                        )
                    ),
                    array(
                        'title' => __('Previous Resource(s) Minimize When One Moves to Create Another Resource.', 'lqdm'),
                        'name' => 'minimize_previous_resource',
                        'type' => 'select',
                        'value' => array(
                            '' => __('Select', 'lqdm'),
                            'yes' => __('Yes', 'lqdm'),
                            'no' => __('No', 'lqdm')
                        )
                    )
                )
            ),
            'single_message_view' => array(
                'title' => __('Individual Message View', 'lqdm'),
                'page' => 'single_message_view',
                'desc' => __('', 'lqdm'),
                'fields' => array(
                    array(
                        'title' => __('Message Fields to Display on Front End', 'lqdm'),
                        'name' => 'message_field_to_display',
                        'type' => 'checkbox',
                        'value' => array(
                            'message_image' => __('Message Image', 'lqdm'),
                            'title' => __('Title', 'lqdm'),
                            'speakers' => __('Speaker(s)', 'lqdm'),
                            'series' => __('Series(s)', 'lqdm'),
                            'date' => __('Date', 'lqdm'),
                            'part_of_series' => __('Part of Series', 'lqdm'),
                            'description' => __('Description', 'lqdm'),
                            'topics' => __('Topics', 'lqdm'),
                            'tags' => __('Tags', 'lqdm'),
                            'scripture_reference' => __('Scripture References', 'lqdm'),
                            'additional_resource' => __('Additional Resources', 'lqdm'),
                        )
                    ),
                    array(
                        'title' => __('Display the Title of the Message Over the Message Featured Image for Related Messages', 'lqdm'),
                        'name' => 'title_over_message_featured_img',
                        'type' => 'select',
                        'value' => array(
                            '' => __('Select', 'lqdm'),
                            'always_show' => __('Always Show', 'lqdm'),
                            'yes' => __('Yes', 'lqdm'),
                            'no' => __('No', 'lqdm')
                        )
                    ),
                    array(
                        'title' => __('How Do You Want Each Message Image to Look', 'lqdm'),
                        'name' => 'message_img_type',
                        'type' => 'select',
                        'value' => array(
                            '' => __('Select', 'lqdm'),
                            'no_overlay' => __('No Overlay', 'lqdm'),
                            'on_hover_overlay' => __('Starts without Overlay, On Hover animates to Overlay', 'lqdm'),
                            'start_with_overlay' => __('Starts with Overlay, On Hover animates to No Overlay', 'lqdm')
                        )
                    )
                )
            ),
            'addtnl_rsrc_option' => array(
                'title' => __('Additional Resource\'s Option', 'lqdm'),
                'page' => 'addtnl_rsrc_option',
                'desc' => __('', 'lqdm'),
                'fields' => array(
                    array(
                        'title' => __('Display Name Field Value', 'lqdm'),
                        'name' => 'display_name_fld_val',
                        'type' => 'textarea',
                        'placeholder' => __('Enter value like - Video, Audio, Notes, Group Guide', 'lqdm'),
                        'default' => "Video, \r\nAudio, \r\nNotes, \r\nGroup Guide",
                    ),
                    array(
                        'title' => __('Language Option', 'lqdm'),
                        'name' => 'addtnl_rsrc_lng_optn',
                        'type' => 'textarea',
                        'placeholder' => __('Enter value like - eng:English, spa:Spanish', 'lqdm'),
                        'default' => "eng:English, \r\nspa:Spanish",
                    )
                )
            ),
            'search_criteria' => array(
                'title' => __('Search Criteria', 'lqdm'),
                'page' => 'search_criteria',
                'desc' => __('', 'lqdm'),
                'fields' => array(
                    array(
                        'title' => __('Front-end Search Keys', 'lqdm'),
                        'name' => 'front_end_search_keys',
                        'type' => 'checkbox',
                        'value' => array(
                            'title' => __('Title', 'lqdm'),
                            'author' => __('Author', 'lqdm'),
                            'topic' => __('Topic', 'lqdm'),
                            'tag' => __('Tag', 'lqdm'),
                            'summary' => __('Summary', 'lqdm'),
                            'video' => __('Video', 'lqdm'),
                            'image' => __('Image', 'lqdm'),
                            'scripture_references' => __('Scripture References', 'lqdm'),
                        )
                    )
                )
            )
        );
    }

	/**
	 * Hooks
	 */
    public function hooks()
    {
        add_action('admin_menu', array($this, 'add_page'));
        add_action('admin_init', array($this, 'plugin_settings'));
    }

    /**
	 * Add Liquid Messages Plugin Admin Configuration Page
     *
     * Allows one to customize how the Liquid Messages plugin works.
	 */
    public function add_page()
    {
        add_submenu_page(
            'edit.php?post_type=lqdm-messages',
            __('Plugin Options', 'lqdm'),
            __('Plugin Options', 'lqdm'),
            'manage_options',
            'lqdm-plugin-option',
            array($this, 'plugin_option_page_view')
        );
    }

	/**
	 * Plugin Option Page View
	 *
	 * @throws Exception
	 */
    public function plugin_option_page_view()
    {
        $this->enqueu_css();
        $this->enqueu_js();

        $arg = array(
            'plugin_option_key' => $this->plugin_option_key,
            'sections_config_arr' => $this->sections_config_arr
        );

        $view = LqdM_Template_Loader::get_template('pages/message-plugin-option-page', $arg);
        echo $view;
    }

	/**
	 * Enqueue CSS
	 */
    public function enqueu_css()
    {
        $min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

        wp_enqueue_style(
            'lqdm-jquery-ui-css',
            "//code.jquery.com/ui/1.12.0/themes/base/jquery-ui{$min}.css",
            array(),
            Lqd_Messages_Plugin::VERSION
        );

        wp_enqueue_style(
            'lqdm-style-admin',
            Lqd_Messages_Plugin::$url . "assets/css/lqdm-style-admin{$min}.css",
            array(),
	        Lqd_Messages_Plugin::VERSION
        );
    }

	/**
	 * Enqueue JS
	 */
    public function enqueu_js()
    {
        $min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

        wp_enqueue_script(
            'lqdm-jquery-ui-js',
            "//code.jquery.com/ui/1.12.0/jquery-ui{$min}.js",
            array('jquery'),
	        Lqd_Messages_Plugin::VERSION
        );

        wp_enqueue_script(
            'lqdm-admin-option-page',
            Lqd_Messages_Plugin::$url . "assets/js/lqdm-page-option{$min}.js",
            array('jquery', 'lqdm-jquery-ui-js'),
	        Lqd_Messages_Plugin::VERSION
        );

        wp_localize_script('lqdm-admin-message-config', 'LqdMAdmin', array(
            'path' => Lqd_Messages_Plugin::$url,
        ));
    }

	/**
	 * Plugin Settings
	 */
    public function plugin_settings()
    {
        register_setting($this->plugin_option_key, $this->plugin_option_key, array($this, 'plugin_options_validate'));
        $this->add_settings_sections();
    }

	/**
	 * Add Settings Sections
	 */
    protected function add_settings_sections()
    {
        foreach ($this->sections_config_arr as $key => $val) {
            add_settings_section($key, $val['title'], array($this, 'plugin_section_text'), $val['page']);
            $this->add_settings_fields($key, $val);
        }
    }

	/**
	 * Add Settings Fields
	 *
	 * @param $sec_key
	 * @param $sectn_det
	 */
    protected function add_settings_fields($sec_key, $sectn_det)
    {
        if (!empty($sectn_det['fields'])) {
            foreach ($sectn_det['fields'] as $key => $val) {
                add_settings_field(
                	$sec_key . '_' . $val['name'],
	                $val['title'],
	                array($this, 'plugin_form_fields'),
	                $sectn_det['page'],
	                $sec_key,
	                array_merge(array('key' => $sec_key), $val)
                );
            }
        }
    }

	/**
	 * Plugin Options Validate
	 *
	 * @param $input
	 *
	 * @return mixed|void
	 */
    public function plugin_options_validate($input)
    {
        $prev_val = get_option($this->plugin_option_key);
        $run_external_setting_err = false;

        $type = '';
        if (is_array($input) && !empty($input)) {
            foreach ($input as $key => $val) {
                if (is_array($val) && !empty($val)) {
                    foreach ($val as $k => $v) {
                        if (!empty($v)) {
                            $type = 'updated';
                            $message = __('Successfully saved', 'lqdm');
                            $prev_val[$key][$k] = $v;
                        } else {
                            $type = 'error';
                            $message = __('Data can not be empty', 'lqdm');
                        }

                        add_settings_error(
                            esc_attr($key . '_' . $k),
                            esc_attr($key . '_' . $k),
                            $message,
                            $type
                        );
                    }
                } else {
                    $type = 'error';
                    $message = __('Data can not be empty', 'lqdm');
                    $run_external_setting_err = true;
                }
            }
        } else {
            $type = 'error';
            $message = __('Data can not be empty', 'lqdm');
            $run_external_setting_err = true;
        }

        if (empty($input['single_series_view']['series_field_to_display'])) {
            $type = 'error';
            $message = __('Data can not be empty', 'lqdm');
            add_settings_error(
                esc_attr('single_series_view_series_field_to_display'),
                esc_attr('single_series_view_series_field_to_display'),
                $message,
                $type
            );
        }

        if (empty($input['single_series_view']['message_field_to_display'])) {
            $type = 'error';
            $message = __('Data can not be empty', 'lqdm');
            add_settings_error(
                esc_attr('single_series_view_message_field_to_display'),
                esc_attr('single_series_view_message_field_to_display'),
                $message,
                $type
            );
        }

        if (empty($input['single_message_view']['message_field_to_display'])) {
            $type = 'error';
            $message = __('Data can not be empty', 'lqdm');
            add_settings_error(
                esc_attr('single_message_view_message_field_to_display'),
                esc_attr('single_message_view_message_field_to_display'),
                $message,
                $type
            );
        }

        if (empty($input['search_criteria']['front_end_search_keys'])) {
            $type = 'error';
            $message = __('Data can not be empty', 'lqdm');
            add_settings_error(
                esc_attr('search_criteria_front_end_search_keys'),
                esc_attr('search_criteria_front_end_search_keys'),
                $message,
                $type
            );
        }

        if ($run_external_setting_err == true) {
            add_settings_error(
                $this->plugin_option_key,
                esc_attr('settings_updated'),
                $message,
                $type
            );
        }

        return $prev_val;
    }

	/**
	 * Plugin Section Text
	 *
	 * @param $arg
	 */
    public function plugin_section_text($arg)
    {
        echo empty($this->sections_config_arr[$arg['id']]['desc']) ? '<hr />' : '<hr /><p>' . $this->sections_config_arr[$arg['id']]['desc'] . '</p>';
    }

	/**
	 * Plugin Form Fields
	 *
	 * @param $arg
	 *
	 * @return bool|void
	 */
    public function plugin_form_fields($arg)
    {
        $options = get_option($this->plugin_option_key);
        if (empty($arg['type'])) return false;

        if ($arg['type'] == 'select') {
            $element = $this->_get_form_select_element($arg, $options);
        } elseif ($arg['type'] == 'checkbox') {
            $element = $this->_get_form_checkbox_element($arg, $options);
        } elseif ($arg['type'] == 'textarea') {
            $element = $this->_get_form_textarea_element($arg, $options);
        } elseif ($arg['type'] == 'text') {
            $element = $this->_get_form_text_element($arg, $options);
        } else {
            return false;
        }
        return $element;
    }

	/**
	 * Get Form Textarea Element
	 *
	 * @param $arg
	 * @param $db_val
	 */
    protected function _get_form_textarea_element($arg, $db_val) {
        $default = empty($arg['default']) ? '' : $arg['default'];
        $saved_db_val = !empty($db_val[$arg['key']][$arg['name']]) ? $db_val[$arg['key']][$arg['name']] : $default;
        $id = $arg['key'] . '_' . $arg['name'];
        $name = $this->plugin_option_key . '[' . $arg['key'] . '][' . $arg['name'] . ']';
        $placeholder = empty($arg['placeholder']) ? '' : $arg['placeholder'];
        printf('<textarea cols="75" rows="10" id="%s" name="%s" placeholder="%s">%s</textarea>', $id, $name, $placeholder, $saved_db_val);
        $this->_get_errors($id);
    }

	/**
	 * Get Form Text Element
	 *
	 * @param $arg
	 * @param $db_val
	 */
    protected function _get_form_text_element($arg, $db_val) {
        $saved_db_val = !empty($db_val[$arg['key']][$arg['name']]) ? $db_val[$arg['key']][$arg['name']] : '';
        $id = $arg['key'] . '_' . $arg['name'];
        $name = $this->plugin_option_key . '[' . $arg['key'] . '][' . $arg['name'] . ']';
        printf('<input type="text" id="%s" name="%s" value="%s" />', $id, $name, $saved_db_val);
        $this->_get_errors($id);
    }

	/**
	 * Get Form Select Element
     *
     * TODO: This and other element functions may be consolidated into a single function?
	 *
	 * @param $arg
	 * @param $db_val
	 */
    protected function _get_form_select_element($arg, $db_val)
    {
        $saved_db_val = !empty($db_val[$arg['key']][$arg['name']]) ? $db_val[$arg['key']][$arg['name']] : '';
        $id = $arg['key'] . '_' . $arg['name'];
        $name = $this->plugin_option_key . '[' . $arg['key'] . '][' . $arg['name'] . ']';
        printf('<select id="%s" name="%s">', $id, $name);
        foreach ($arg['value'] as $key => $val) {
            $matched = ($key == $saved_db_val) ? 'selected' : '';
            printf('<option value="%s" %s>%s</option>', $key, $matched, $val);
        }
        printf('</select>');
        $this->_get_errors($id);
    }

	/**
	 * Get Errors
	 *
	 * @param $id
	 */
    protected function _get_errors($id)
    {
        $error = get_settings_errors($id);
        if (!empty($error[0])) {
            if ($error[0]['type'] == 'updated') {
                printf( '<div class="lqdm-notice"><p class="success">%s</p></div>', $error[0]['message']);
            } else {
                printf( '<div class="lqdm-notice"><p class="error">%s</p></div>', $error[0]['message']);
            }
        }
    }

	/**
	 * Get Form Checkbox Element
	 *
	 * @param $arg
	 * @param $db_val
	 */
    protected function _get_form_checkbox_element($arg, $db_val)
    {
        $saved_db_val = !empty($db_val[$arg['key']][$arg['name']]) ? $db_val[$arg['key']][$arg['name']] : array();
        $id = $arg['key'] . '_' . $arg['name'];
        $name = $this->plugin_option_key . '[' . $arg['key'] . '][' . $arg['name'] . ']';
        foreach ($arg['value'] as $key => $val) {
            $matched = in_array($key, $saved_db_val) ? 'checked' : '';
            printf( '<div class="lqdm-form-group">' );
            printf('<label for="%s">%s</label>', $id, $val);
            printf('<input type="checkbox" id="%s" name="%s[]" value="%s" %s />', $id, $name, $key, $matched);
            printf('</div>');
        }
        $this->_get_errors($id);
    }

}
