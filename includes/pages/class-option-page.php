<?php
/**
 * Liquid Messages Admin Options Page
 *
 * @package GC Sermons
 */
class GCS_Option_Page
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

        $this->plugin_option_key = GC_Sermons_Plugin::$plugin_option_key;

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
                'title' => __('Series List View', 'gc-sermons'),
                'page' => 'series_view',
                'desc' => __('', 'gc-sermons'),
                'fields' => array(
                    array(
                        'title' => __('Display the Title of the Series Over the Series Featured Image', 'gc-sermons'),
                        'name' => 'title_over_series_featured_img',
                        'type' => 'select',
                        'value' => array(
                            '' => 'Select',
                            'always_show' => __('Always Show', 'gc-sermons'),
                            'yes' => __('Yes', 'gc-sermons'),
                            'no' => __('No', 'gc-sermons')
                        )
                    ),
                    array(
                        'title' => __('How Do You Want Each Series Image to Look', 'gc-sermons'),
                        'name' => 'series_img_type',
                        'type' => 'select',
                        'value' => array(
                            '' => __('Select', 'gc-sermons'),
                            'no_overlay' => __('No Overlay', 'gc-sermons'),
                            'on_hover_overlay' => __('Starts without Overlay, On Hover animates to Overlay', 'gc-sermons'),
                            'start_with_overlay' => __('Starts with Overlay, On Hover animates to No Overlay', 'gc-sermons')
                        )
                    ),
                    array(
                        'title' => __('Fit Entire Year of Series On One Page', 'gc-sermons'),
                        'name' => 'entire_year_series_one_page',
                        'type' => 'select',
                        'value' => array(
                            '' => 'Select',
                            'yes' => __('Yes', 'gc-sermons'),
                            'no' => __('No', 'gc-sermons')
                        )
                    )
                )
            ),
            'search_view' => array(
                'title' => __('Search Results View', 'gc-sermons'),
                'page' => 'search_view',
                'desc' => __('', 'gc-sermons'),
                'fields' => array(
                    array(
                        'title' => __('Display the Title of the Series Over the Series Featured Image', 'gc-sermons'),
                        'name' => 'title_over_series_featured_img',
                        'type' => 'select',
                        'value' => array(
                            '' => 'Select',
                            'always_show' => __('Always Show', 'gc-sermons'),
                            'yes' => __('Yes', 'gc-sermons'),
                            'no' => __('No', 'gc-sermons')
                        )
                    ),
                    array(
                        'title' => __('How Do You Want Each Series Image to Look', 'gc-sermons'),
                        'name' => 'series_img_type',
                        'type' => 'select',
                        'value' => array(
                            '' => __('Select', 'gc-sermons'),
                            'no_overlay' => __('No Overlay', 'gc-sermons'),
                            'on_hover_overlay' => __('Starts without Overlay, On Hover animates to Overlay', 'gc-sermons'),
                            'start_with_overlay' => __('Starts with Overlay, On Hover animates to No Overlay', 'gc-sermons')
                        )
                    ),
                    array(
                        'title' => __('Display the Title of the Message Over the Message Featured Image', 'gc-sermons'),
                        'name' => 'title_over_message_featured_img',
                        'type' => 'select',
                        'value' => array(
                            '' => 'Select',
                            'always_show' => __('Always Show', 'gc-sermons'),
                            'yes' => __('Yes', 'gc-sermons'),
                            'no' => __('No', 'gc-sermons')
                        )
                    ),
                    array(
                        'title' => __('How Do You Want Each Message Feature Image to Look', 'gc-sermons'),
                        'name' => 'message_img_type',
                        'type' => 'select',
                        'value' => array(
                            '' => __('Select', 'gc-sermons'),
                            'no_overlay' => __('No Overlay', 'gc-sermons'),
                            'on_hover_overlay' => __('Starts without Overlay, On Hover animates to Overlay', 'gc-sermons'),
                            'start_with_overlay' => __('Starts with Overlay, On Hover animates to No Overlay', 'gc-sermons')
                        )
                    )
                )
            ),
            'single_series_view' => array(
                'title' => __('Individual Series View', 'gc-sermons'),
                'page' => 'single_series_view',
                'desc' => __('', 'gc-sermons'),
                'fields' => array(
                    array(
                        'title' => __('Series Fields to Display on Front End', 'gc-sermons'),
                        'name' => 'series_field_to_display',
                        'type' => 'checkbox',
                        'value' => array(
                            'series_image' => __('Series Image', 'gc-sermons'),
                            'title' => __('Title', 'gc-sermons'),
                            'description' => __('Description', 'gc-sermons'),
                        )
                    ),
                    array(
                        'title' => __('Message Fields to Display on Front End', 'gc-sermons'),
                        'name' => 'message_field_to_display',
                        'type' => 'checkbox',
                        'value' => array(
                            'sermon_image' => __('Sermon Image', 'gc-sermons'),
                            'title' => __('Title', 'gc-sermons'),
                            'speakers' => __('Speaker(s)', 'gc-sermons'),
                            'date' => __('Date', 'gc-sermons'),
                            'part_of_series' => __('Part of Series', 'gc-sermons'),
                            'description' => __('Description', 'gc-sermons'),
                            'topics' => __('Topics', 'gc-sermons'),
                            'tags' => __('Tags', 'gc-sermons'),
                            'scripture_reference' => __('Scripture References', 'gc-sermons'),
                        )
                    ),
                    array(
                        'title' => __('Which Image Should be Displayed for Each Individual Message in the Series', 'gc-sermons'),
                        'name' => 'choose_image_type_to_display',
                        'type' => 'select',
                        'value' => array(
                            '' => __('Select', 'gc-sermons'),
                            'series_featured_image' => __('Series Featured Image', 'gc-sermons'),
                            'message_featured_image' => __('Message Featured Image', 'gc-sermons'),
                        )
                    ),
                    array(
                        'title' => __('Previous Resource(s) Minimize When One Moves to Create Another Resource.', 'gc-sermons'),
                        'name' => 'minimize_previous_resource',
                        'type' => 'select',
                        'value' => array(
                            '' => __('Select', 'gc-sermons'),
                            'yes' => __('Yes', 'gc-sermons'),
                            'no' => __('No', 'gc-sermons')
                        )
                    )
                )
            ),
            'single_message_view' => array(
                'title' => __('Individual Message View', 'gc-sermons'),
                'page' => 'single_message_view',
                'desc' => __('', 'gc-sermons'),
                'fields' => array(
                    array(
                        'title' => __('Message Fields to Display on Front End', 'gc-sermons'),
                        'name' => 'message_field_to_display',
                        'type' => 'checkbox',
                        'value' => array(
                            'sermon_image' => __('Sermon Image', 'gc-sermons'),
                            'title' => __('Title', 'gc-sermons'),
                            'speakers' => __('Speaker(s)', 'gc-sermons'),
                            'series' => __('Series(s)', 'gc-sermons'),
                            'date' => __('Date', 'gc-sermons'),
                            'part_of_series' => __('Part of Series', 'gc-sermons'),
                            'description' => __('Description', 'gc-sermons'),
                            'topics' => __('Topics', 'gc-sermons'),
                            'tags' => __('Tags', 'gc-sermons'),
                            'scripture_reference' => __('Scripture References', 'gc-sermons'),
                            'additional_resource' => __('Additional Resources', 'gc-sermons'),
                        )
                    ),
                    array(
                        'title' => __('Display the Title of the Message Over the Message Featured Image for Related Messages', 'gc-sermons'),
                        'name' => 'title_over_message_featured_img',
                        'type' => 'select',
                        'value' => array(
                            '' => __('Select', 'gc-sermons'),
                            'always_show' => __('Always Show', 'gc-sermons'),
                            'yes' => __('Yes', 'gc-sermons'),
                            'no' => __('No', 'gc-sermons')
                        )
                    ),
                    array(
                        'title' => __('How Do You Want Each Message Image to Look', 'gc-sermons'),
                        'name' => 'message_img_type',
                        'type' => 'select',
                        'value' => array(
                            '' => __('Select', 'gc-sermons'),
                            'no_overlay' => __('No Overlay', 'gc-sermons'),
                            'on_hover_overlay' => __('Starts without Overlay, On Hover animates to Overlay', 'gc-sermons'),
                            'start_with_overlay' => __('Starts with Overlay, On Hover animates to No Overlay', 'gc-sermons')
                        )
                    )
                )
            ),
            'addtnl_rsrc_option' => array(
                'title' => __('Additional Resource\'s Option', 'gc-sermons'),
                'page' => 'addtnl_rsrc_option',
                'desc' => __('', 'gc-sermons'),
                'fields' => array(
                    array(
                        'title' => __('Display Name Field Value', 'gc-sermons'),
                        'name' => 'display_name_fld_val',
                        'type' => 'textarea',
                        'placeholder' => __('Enter value like - Video, Audio, Notes, Group Guide', 'gc-sermons'),
                        'default' => "Video, \r\nAudio, \r\nNotes, \r\nGroup Guide",
                    ),
                    array(
                        'title' => __('Language Option', 'gc-sermons'),
                        'name' => 'addtnl_rsrc_lng_optn',
                        'type' => 'textarea',
                        'placeholder' => __('Enter value like - eng:English, spa:Spanish', 'gc-sermons'),
                        'default' => "eng:English, \r\nspa:Spanish",
                    )
                )
            ),
            'search_criteria' => array(
                'title' => __('Search Criteria', 'gc-sermons'),
                'page' => 'search_criteria',
                'desc' => __('', 'gc-sermons'),
                'fields' => array(
                    array(
                        'title' => __('Front-end Search Keys', 'gc-sermons'),
                        'name' => 'front_end_search_keys',
                        'type' => 'checkbox',
                        'value' => array(
                            'title' => __('Title', 'gc-sermons'),
                            'author' => __('Author', 'gc-sermons'),
                            'topic' => __('Topic', 'gc-sermons'),
                            'tag' => __('Tag', 'gc-sermons'),
                            'summary' => __('Summary', 'gc-sermons'),
                            'video' => __('Video', 'gc-sermons'),
                            'image' => __('Image', 'gc-sermons'),
                            'scripture_references' => __('Scripture References', 'gc-sermons'),
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
            'edit.php?post_type=gc-sermons',
            __('Plugin Options', 'gc-sermons'),
            __('Plugin Options', 'gc-sermons'),
            'manage_options',
            'lc-plugin-option',
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

        $view = GCS_Template_Loader::get_template('pages/sermon-plugin-option-page', $arg);
        echo $view;
    }

	/**
	 * Enqueue CSS
	 */
    public function enqueu_css()
    {
        $min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

        wp_enqueue_style(
            'lc-jquery-ui-css',
            "//code.jquery.com/ui/1.12.0/themes/base/jquery-ui{$min}.css",
            array(),
            GC_Sermons_Plugin::VERSION
        );

        wp_enqueue_style(
            'lc-style-admin',
            GC_Sermons_Plugin::$url . "assets/css/liquidchurch-style-admin{$min}.css",
            array(),
	        GC_Sermons_Plugin::VERSION
        );
    }

	/**
	 * Enqueue JS
	 */
    public function enqueu_js()
    {
        $min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

        wp_enqueue_script(
            'lc-jquery-ui-js',
            "//code.jquery.com/ui/1.12.0/jquery-ui{$min}.js",
            array('jquery'),
	        GC_Sermons_Plugin::VERSION
        );

        wp_enqueue_script(
            'lc-func-admin-option-page',
            GC_Sermons_Plugin::$url . "assets/js/liquidchurch-page-option{$min}.js",
            array('jquery', 'lc-jquery-ui-js'),
	        GC_Sermons_Plugin::VERSION
        );

        wp_localize_script('lc-func-admin-message-config', 'LiquidChurchAdmin', array(
            'path' => GC_Sermons_Plugin::$url,
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
                            $message = __('Successfully saved', 'gc-sermons');
                            $prev_val[$key][$k] = $v;
                        } else {
                            $type = 'error';
                            $message = __('Data can not be empty', 'gc-sermons');
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
                    $message = __('Data can not be empty', 'gc-sermons');
                    $run_external_setting_err = true;
                }
            }
        } else {
            $type = 'error';
            $message = __('Data can not be empty', 'gc-sermons');
            $run_external_setting_err = true;
        }

        if (empty($input['single_series_view']['series_field_to_display'])) {
            $type = 'error';
            $message = __('Data can not be empty', 'gc-sermons');
            add_settings_error(
                esc_attr('single_series_view_series_field_to_display'),
                esc_attr('single_series_view_series_field_to_display'),
                $message,
                $type
            );
        }

        if (empty($input['single_series_view']['message_field_to_display'])) {
            $type = 'error';
            $message = __('Data can not be empty', 'gc-sermons');
            add_settings_error(
                esc_attr('single_series_view_message_field_to_display'),
                esc_attr('single_series_view_message_field_to_display'),
                $message,
                $type
            );
        }

        if (empty($input['single_message_view']['message_field_to_display'])) {
            $type = 'error';
            $message = __('Data can not be empty', 'gc-sermons');
            add_settings_error(
                esc_attr('single_message_view_message_field_to_display'),
                esc_attr('single_message_view_message_field_to_display'),
                $message,
                $type
            );
        }

        if (empty($input['search_criteria']['front_end_search_keys'])) {
            $type = 'error';
            $message = __('Data can not be empty', 'gc-sermons');
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
                printf('<div class="lc-notice"><p class="success">%s</p></div>', $error[0]['message']);
            } else {
                printf('<div class="lc-notice"><p class="error">%s</p></div>', $error[0]['message']);
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
            printf('<div class="lc-form-group">');
            printf('<label for="%s">%s</label>', $id, $val);
            printf('<input type="checkbox" id="%s" name="%s[]" value="%s" %s />', $id, $name, $key, $matched);
            printf('</div>');
        }
        $this->_get_errors($id);
    }

}
