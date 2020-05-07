<?php

/**
 * Gets a LQDM_Sermon_Post object from a post object or ID.
 *
 * @since 0.1.3
 *
 * @param  mixed                  $sermon         Post object or ID or (LQDM_Sermon_Post object).
 * @param  bool                   $throw_on_error Use if you have exception handling in place.
 * @return false|LQDM_Sermon_Post                 LQDM_Sermon_Post object if successful
 * @throws Exception
 */
function gc_get_sermon_post($sermon = 0, $throw_on_error = false)
{
    if ( $sermon instanceof LQDM_Sermon_Post) {
        return $sermon;
    }

    $sermon = $sermon ?: get_the_id();

    try {

        $sermon = $sermon instanceof WP_Post ? $sermon : get_post($sermon);
        $sermon = new LQDM_Sermon_Post($sermon);

    } catch (Exception $e) {
        if ($throw_on_error) {
            throw $e;
        }
        $sermon = false;
    }

    return $sermon;
}

/**
 * Get's info for a series attached to the message.
 *
 * @since  0.1.3
 *
 * @param  mixed  $sermon          Post object or ID or (LQDM_Sermon_Post object).
 * @param  array  $args            Args array
 * @param  array  $get_series_args Args for LQDM_Sermon_Post::get_series()
 *
 * @return string Message series info output.
 * @throws Exception
 */
function gc_get_sermon_series_info($sermon = 0, $args = array(), $get_series_args = array())
{
    if (!($sermon = gc_get_sermon_post($sermon))) {
        // If no message, bail.
        return '';
    }

    $args = wp_parse_args($args, array(
        'remove_thumbnail'   => false,
        'remove_description' => true,
        'thumbnail_size'     => 'medium',
        'wrap_classes'       => '',
    ));

    $get_series_args['image_size'] = $get_series_args['image_size'] ?? $args['thumbnail_size'];

    if (!($series = $sermon->get_series($get_series_args))) {
        // If no series, bail.
        return '';
    }

    $series->classes        = $args['wrap_classes'];
    $series->do_image       = !$args['remove_thumbnail'] && $series->image;
    $series->do_description = !$args['remove_description'] && $series->description;
    $series->url            = $series->term_link;
    $series->plugin_option  = get_plugin_settings_options('series_view');

    $content = '';
    $content .= LQDM_Style_Loader::get_template('list-item-style');
    $content .= LQDM_Template_Loader::get_template('list-item-series', (array)$series);

    // Not a list item.
    $content = str_replace(array('<li', '</li'), array('<div', '</div'), $content);

    return $content;
}

/**
 * Get's info for a speaker attached to the message.
 *
 * @since  0.1.3
 *
 * @param  mixed  $sermon           Post object or ID or (LQDM_Sermon_Post object).
 * @param  array  $args             Args array
 * @param  array  $get_speaker_args Args for LQDM_Sermon_Post::get_speaker()
 *
 * @return string Message speaker info output.
 * @throws Exception
 */
function gc_get_sermon_speaker_info($sermon = 0, $args = array(), $get_speaker_args = array())
{
    if (!($sermon = gc_get_sermon_post($sermon))) {
        // If no message, bail.
        return '';
    }

    $args = wp_parse_args($args, array(
        'remove_thumbnail' => false,
        'thumbnail_size'   => 'medium',
        'wrap_classes'     => '',
    ));

    $get_speaker_args['image_size'] = $get_speaker_args['image_size'] ?? $args['thumbnail_size'];

    if (!($speaker = $sermon->get_speaker($get_speaker_args))) {
        // If no speaker, bail.
        return '';
    }

    $sermon = gc_get_sermon_post($sermon);

    // If no message or no speaker, bail.
    if (!$sermon || !($speaker = $sermon->get_speaker($get_speaker_args))) {
        return '';
    }

    $speaker->image   = !$args['remove_thumbnail'] ? $speaker->image : '';
    $speaker->classes = $args['wrap_classes'];

    return LQDM_Template_Loader::get_template('sermon-speaker-info', (array)$speaker);
}

/**
 * Get's video player for the message.
 *
 * Wraps $sermon->get_video_player
 *
 * @since  0.1.3
 *
 * @param  mixed $sermon Post object or ID or (LQDM_Sermon_Post object).
 * @param  mixed $args   Arguments passed to LQDM_Sermon_Post::get_video_player().
 *
 * @return string Message video player output.
 * @throws Exception
 */
function gc_get_sermon_video_player($sermon = 0, $args = array())
{
    $sermon = gc_get_sermon_post($sermon);

    // If no message or video, bail.
    if (!$sermon || !($video_player = $sermon->get_video_player($args))) {
        return '';
    }

    return $video_player;
}

/**
 * Get's audio player for the message.
 *
 * @since  0.1.3
 *
 * @param  mixed $sermon Post object or ID or (LQDM_Sermon_Post object).
 * @param  mixed $args Arguments passed to LQDM_Sermon_Post::get_audio_player().
 *
 * @return string Message audio player output.
 * @throws Exception
 */
function gc_get_sermon_audio_player($sermon = 0, $args = array())
{
    $sermon = gc_get_sermon_post($sermon);

    // If no message or audio, bail.
    if (!$sermon || !($audio_player = $sermon->get_audio_player($args))) {
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
function gc_search_get_next_results_link($total_pages)
{
    $page = absint(gc__get_arg('results-page', 1));
    $link = '';

    if (++$page <= $total_pages) {
        $link = sprintf(
            '<a href="%s" %s>%s</a>',
            esc_url(add_query_arg('results-page', $page)),
            apply_filters('gc_next_results_page_link_attributes', ''),
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
function gc_search_get_previous_results_link()
{
    $page = absint(gc__get_arg('results-page', 1));
    $link = '';

    if ($page-- > 1) {
        $url = $page > 1 ? add_query_arg('results-page', $page) : remove_query_arg('results-page');
        $link = sprintf(
            '<a href="%s" %s>%s</a>',
            esc_url($url),
            apply_filters('gc_previous_results_page_link_attributes', ''),
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
 * @param  string  $arg      Query arg to check
 * @param  mixed   $default  Optional default value. Defaults to null.
 *
 * @return mixed            Result of query var or default.
 */
function gc__get_arg($arg, $default = null)
{
    return $_GET[ $arg ] ?? $default;
}

/**
 * Get Plugin Settings
 *
 * @param string $arg1
 * @param string $arg2
 *
 * @return array|bool|mixed|void
 */
function get_plugin_settings_options($arg1 = '', $arg2 = '')
{
    $plugin_option = GC_Sermons_Plugin::get_plugin_settings_options($arg1, $arg2);

    if (empty($plugin_option)) {
        return array();
    }

    return $plugin_option;
}
