<?php
/**
 * Configure Message Order Page
 *
 * Allows one to reorder message pages in bulk.
 *
 * @package GC Sermons
 */
class GCS_Config_Page
{
    /**
     * Parent plugin class
     *
     * @since 0.1.0
     */
    protected $plugin = null;

    /**
     * ajax call detect
     *
     * @var bool|null
     */
    protected $ajax_call = null;

    /**
     * Constructor
     *
     * @param  object $plugin Main plugin object.
     * @return void
     */
    public function __construct($plugin)
    {
        $this->plugin = $plugin;
        $this->ajax_call = defined('DOING_AJAX') && DOING_AJAX;
    }

	/**
	 * Hooks
	 */
    public function hooks()
    {
        add_action('admin_menu', array($this, 'add_page'));

        if ($this->ajax_call == true) {
            add_action('wp_ajax_sermon_message_config_single_series_update', array($this, 'sermon_message_config_single_series_update_callback'));
            add_action('wp_ajax_sermon_message_config_all_series_update', array($this, 'sermon_message_config_all_series_update_callback'));
        }
    }

	/**
	 * Add Messages Config to Liquid Messages Admin Menu
	 */
    public function add_page()
    {
        add_submenu_page(
            'edit.php?post_type=gc-sermons',
            __('Messages Config', 'gc-sermons'),
            __('Messages Config', 'gc-sermons'),
            'manage_options',
            'sermon-message-config',
            array($this, 'config_page_view')
        );
    }

	/**
	 * Config Page View
	 *
	 * @throws Exception
	 */
    public function config_page_view()
    {
        $items = $this->get_all_sermon_messages_ord_by_series();
        $arg = array(
            'items' => $items
        );
        $view = GCS_Template_Loader::get_template('pages/sermon-message-config-page', $arg);

        $this->enqueu_css();
        $this->enqueu_js();
        echo $view;
    }

	/**
	 * Get all messages ordered by series
	 *
	 * @return string
	 * @throws Exception
	 */
    public function get_all_sermon_messages_ord_by_series()
    {
        $custom_terms = get_terms('gc-sermon-series');
        $items = '';

        foreach ($custom_terms as $custom_term) {
            wp_reset_query();

            $item = $this->get_message_by_series($custom_term);

            $series_resource = array(
                'id' => $custom_term->term_id,
                'series_title' => $custom_term->name,
                'items' => $item
            );
            $items .= GCS_Template_Loader::get_template('pages/sermon-message-config-page-li', $series_resource);
        }
        return $items;
    }

	/**
	 * Get Message by Series
	 *
	 * @param $term
	 *
	 * @return string
	 * @throws Exception
	 */
    public function get_message_by_series($term)
    {
        $item = '';
        $args = array(
            'post_type' => 'gc-sermons',
            'order' => 'ASC',
            'orderby' => 'date',
            'tax_query' => array(
                array(
                    'taxonomy' => 'gc-sermon-series',
                    'field' => 'slug',
                    'terms' => $term->slug,
                ),
            ),
        );

        $loop = new WP_Query($args);
        if ($loop->have_posts()) {
            while ($loop->have_posts()) : $loop->the_post();
                $message_resource = array(
                    'id' => get_the_ID(),
                    'permalink' => 'post.php?post=' . get_the_ID() . '&action=edit',
                    'title' => get_the_title(),
                    'date' => get_the_date(),
                    'display_order' => get_post_meta(get_the_ID(), 'gc_display_order', true),
                    'display_ordr_meta_id' => $this->plugin->metaboxes->display_ordr_meta_id,
                );
                $item .= GCS_Template_Loader::get_template('pages/sermon-message-config-page-li-li', $message_resource);
            endwhile;
        }
        return $item;
    }

	/**
	 * Enqueue JS
	 *
	 */
    public function enqueu_js()
    {
        $min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

        wp_enqueue_script(
            'lc-func-admin-message-config',
            GC_Sermons_Plugin::$url . "assets/js/liquidchurch-page-message-config{$min}.js",
            array(),
            GC_Sermons_Plugin::VERSION
        );

        wp_enqueue_script(
            'block-ui',
            '//cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js',
            array('jquery'),
            GC_Sermons_Plugin::VERSION
        );

        wp_localize_script('lc-func-admin-message-config', 'LiquidChurchAdmin', array(
            'path' => GC_Sermons_Plugin::$url,
            'blockui_message' => __('Please wait...', 'gc-sermons'),
            'required_message' => __('Please fill all the required values', 'gc-sermons'),
            'ajax_nonce' => wp_create_nonce('sermon_message_config_page'),
        ));
    }

	/**
	 * Enqueue CSS
	 */
    public function enqueu_css()
    {
        $min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

        wp_enqueue_style(
            'lc-style-admin',
            GC_Sermons_Plugin::$url . "assets/css/liquidchurch-style-admin{$min}.css",
            array(),
            GC_Sermons_Plugin::VERSION
        );
    }

	/**
	 * Sermon Message Config Single Series Update Callback
	 */
    public function sermon_message_config_single_series_update_callback()
    {
        $reponse = array();
        $nonce = $_POST['nonce'];

        if (true == wp_verify_nonce($nonce, 'sermon_message_config_page')) {
            $meta_key = $this->plugin->metaboxes->display_ordr_meta_id;
            parse_str($_POST['formData'], $formData);
            foreach ($formData['post'] as $key => $val) {
                if (empty($val[$meta_key])) continue;
                $reponse[$key] = array(
                    'status' => update_post_meta($key, $meta_key, $val[$meta_key]),
                    'message' => __('Successfully updated', 'gc-sermons')
                );
            }
        }

        echo json_encode($reponse);
        die();
    }

	/**
	 * Sermon Message Config All Series Update Callback
	 */
    public function sermon_message_config_all_series_update_callback()
    {
        $reponse = array();
        $nonce = $_POST['nonce'];

        if (true == wp_verify_nonce($nonce, 'sermon_message_config_page')) {
            $meta_key = $this->plugin->metaboxes->display_ordr_meta_id;
            foreach ($_POST['formData'] as $key => $val) {
                parse_str($val, $formData);

                foreach ($formData['post'] as $fkey => $fval) {
                    if (empty($fval[$meta_key])) continue;
                    $reponse[$formData['series_id']][$fkey] = array(
                        'status' => update_post_meta($fkey, $meta_key, $fval[$meta_key]),
                        'message' => __('Successfully updated', 'gc-sermons')
                    );
                }
            }
        }

        echo json_encode($reponse);
        die();
    }

}
