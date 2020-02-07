<?php

/**
 * Gets a Message Post object from a post object or ID.
 *
 * TODO: Is there a reason we want to offer these functions which aren't part of a class? Is there an advantage
 * to calling `lqdm_get_message_post()` over...?
 *
 * @param  mixed $message         Post object or ID or (LqdM_Message_Post object).
 * @param  bool  $throw_on_error Use if you have exception handling in place.
 *
 * @return LqdM_Message_Post|false LqdM_Message_Post object if successful
 * @throws Exception
 *@since  0.1.3
 *
 */
function lqdm_get_message_post($message = 0, $throw_on_error = false)
{
    if ($message instanceof LqdM_Message_Post ) {
        return $message;
    }

    $message = $message ? $message : get_the_ID();

    try {
        $message = $message instanceof WP_Post ? $message : get_post($message);
        $message = new LqdM_Message_Post($message);

    } catch (Exception $e) {
        if ($throw_on_error) {
            throw $e;
        }
        $message = false;
    }

    return $message;
}

/**
 * Get's info for a series attached to the message.
 *
 * TODO: Here we are offering lqdm_get_message_series_info() and then under the hood using $message->get_series, why?
 *
 * @since  0.1.3
 *
 * @param  mixed  $message          Post object or ID or (LqdM_Message_Post object).
 * @param  array  $args            Args array
 * @param  array  $get_series_args Args for LqdM_Message_Post::get_series()
 *
 * @return string Message series info output.
 * @throws Exception
 */
function lqdm_get_message_series_info($message = 0, $args = array(), $get_series_args = array())
{
    if (!($message = lqdm_get_message_post($message))) {
        // If no message, bail.
        return '';
    }

    $args = wp_parse_args($args, array(
        'remove_thumbnail'   => false,
        'remove_description' => true,
        'thumbnail_size'     => 'medium',
        'wrap_classes'       => '',
    ));

    $get_series_args['image_size'] = isset($get_series_args['image_size'])
        ? $get_series_args['image_size']
        : $args['thumbnail_size'];

    if (!($series = $message->get_series($get_series_args))) {
        // If no series, bail.
        return '';
    }

    $series->classes        = $args['wrap_classes'];
    $series->do_image       = ! $args['remove_thumbnail'] && $series->image;
    $series->do_description = ! $args['remove_description'] && $series->description;
    $series->url            = $series->term_link;
    $series->plugin_option  = lqdm_get_plugin_settings_options('series_view');

    $content = '';
    $content .= LqdM_Style_Loader::get_template('list-item-style');
    $content .= LqdM_Template_Loader::get_template('list-item-series', (array) $series);

    // Not a list item.
    $content = str_replace(array('<li', '</li'), array('<div', '</div'), $content);

    return $content;
}

/**
 * Get's info for a speaker attached to the message.
 *
 * @since  0.1.3
 *
 * @param  mixed   $message           Post object or ID or (LqdM_Message_Post object).
 * @param  array   $args             Args array
 * @param  array   $get_speaker_args Args for LqdM_Message_Post::get_speaker()
 *
 * @return string Message speaker info output.
 * @throws Exception
 */
function lqdm_get_message_speaker_info($message = 0, $args = array(), $get_speaker_args = array())
{
    if (!($message = lqdm_get_message_post($message))) {
        // If no message, bail.
        return '';
    }

    $args = wp_parse_args($args, array(
        'remove_thumbnail'  => false,
        'thumbnail_size'    => 'medium',
        'wrap_classes'      => '',
    ));

    $get_speaker_args['image_size'] = isset($get_speaker_args['image_size'])
        ? $get_speaker_args['image_size']
        : $args['thumbnail_size'];

    if (!($speaker = $message->get_speaker($get_speaker_args))) {
        // If no speaker, bail.
        return '';
    }

    $message = lqdm_get_message_post($message);

    // If no message or no message speaker, bail.
    if (!$message || !($speaker = $message->get_speaker($get_speaker_args))) {
        return '';
    }

    $speaker->image = ! $args['remove_thumbnail'] ? $speaker->image : '';
    $speaker->classes = $args['wrap_classes'];

    $content = LqdM_Template_Loader::get_template('message-speaker-info', (array)$speaker);

    return $content;
}

/**
 * Get's video player for the message.
 *
 * @since  0.1.3
 *
 * @param  mixed $message Post object or ID or (LqdM_Message_Post object).
 * @param  mixed $args   Arguments passed to LqdM_Message_Post::get_video_player().
 *
 * @return string Message video player output.
 * @throws Exception
 */
function lqdm_get_message_video_player($message = 0, $args = array())
{
    $message = lqdm_get_message_post($message);

    // If no message or no related links, bail.
    if (!$message || !($video_player = $message->get_video_player($args))) {
        return '';
    }

    return $video_player;
}

/**
 * Get's audio player for the message.
 *
 * @since  0.1.3
 *
 * @param  mixed $message Post object or ID or (LqdM_Message_Post object).
 * @param  mixed $args   Arguments passed to LqdM_Message_Post::get_audio_player().
 *
 * @return string Message audio player output.
 * @throws Exception
 */
function lqdm_get_message_audio_player($message = 0, $args = array())
{
    $message = lqdm_get_message_post($message);

    // If no message or no related links, bail.
    if (!$message || !($audio_player = $message->get_audio_player($args))) {
        return '';
    }

    return $audio_player;
}

/**
 * Gets the next search results page link when using the search widget.
 *
 * @since  0.1.5
 *
 * @param  int $total_pages Total number of pages.
 *
 * @return string           Next results page link, if there is a next page.
 */
function lqdm_search_get_next_results_link($total_pages)
{
    $page = absint(lqdm__get_arg('results-page', 1));
    $link = '';

    if (++$page <= $total_pages) {
        $link = sprintf(
            '<a href="%s" %s>%s</a>',
            esc_url(add_query_arg('results-page', $page)),
            apply_filters('lqdm_next_results_page_link_attributes', ''),
            __('Older <span>&rarr;</span>', 'lqdm')
        );
    }

    return $link;
}

/**
 * Gets the previous search results page link when using the search widget.
 *
 * @since  0.1.5
 *
 * @return string           Next results page link, if there is a previous page.
 */
function lqdm_search_get_previous_results_link()
{
    $page = absint(lqdm__get_arg('results-page', 1));
    $link = '';

    if ($page-- > 1) {
        $url = $page > 1 ? add_query_arg('results-page', $page) : remove_query_arg('results-page');
        $link = sprintf(
            '<a href="%s" %s>%s</a>',
            esc_url($url),
            apply_filters('lqdm_previous_results_page_link_attributes', ''),
            __('<span>&larr;</span> Newer', 'lqdm')
        );
    }

    return $link;
}

/**
 * Helper function for getting $_GET values with optional default value.
 *
 * @since  0.1.5
 *
 * @param  string  $arg     Query arg to check
 * @param  mixed  $default  Optional default value. Defaults to null.
 *
 * @return mixed            Result of query var or default.
 */
function lqdm__get_arg($arg, $default = null)
{
    return isset($_GET[$arg]) ? $_GET[$arg] : $default;
}

/**
 * Load our plugin's settings.
 *
 * @param string $arg1
 * @param string $arg2
 * @return array|bool|mixed|void
 */
function lqdm_get_plugin_settings_options($arg1 = '', $arg2 = '')
{
    $plugin_option = Lqd_Messages_Plugin::get_plugin_settings_options($arg1, $arg2);

    if (empty($plugin_option)) {
        return array();
    }

    return $plugin_option;
}
