# The Messages Post Type in Liquid Messages

## It's Importance
The entire Liquid Messages plugin is centered around the messages post type.

## Wrapper for WP_Post
One can use `LqdM_Message_Post` instead of `WP_Post`, the former wraps the latter.

To get an instance of `LqdM_Message_Post`: `lqdm_get_message_post( $post_id )`.

One can pass in `$message->ID`, `$message->post_name`, `$message->post_date`, and all normal `WP_Post` parameters to `lqdm_get_message_post()`.

## Wrapper for Message Video
`$message->get_video_player( $args = array() )` is a wrapper for `wp_oembed_get` and `wp_video_shortcode`.

## Wrapper for Message Audio
`$message->get_audio_player()` is a wrapper for `wp_audio_shortcode`.

## Wrapper for Message Permalink
`$message->permalink()` is a wrapper for `get_permalink`.

## Wrapper for Message Title
`$message->permalink` is a wrapper for `get_the_title`.

## Wrapper for Message Excerpt
`$message->loop_excerpt()` is a wrapper for `the_excerpt`.

## Wrapper for Message Featured Image
`$message->featured_image( $size = 'full', $attr = '' )` is a wrapper for `get_the_post_thumbnail`.
 - `$size` - optional, can accept any valid image size or an array of width and height values in pixels.
 - `$attr` - optional, query string or array of attributes.
 
## Wrapper for Series Featured Image
`$message->series_image ( $size = 'full', $attr = '' )` is a wrapper for `get_the_post_thumbnail` and can use the same attributes as outlined above regarding the message featured image.

## Wrapper for Single Speaker
`$message->get_speaker( $args = array() )`

## Wrapper for Single Series
`$message->get_series( $args = array() )`

## Wrapper for Other Messages in Same Series
`$message->get_others_in_series( $args = array() )`
- `$args` should be an array of `WP_Query` arguments.

## Wrapper for Other Messages by Same Speaker
`$message->get_others_by_speaker( $args = array() )`
- `$args` should be an array of `WP_Query` arguments.

## Wrapper for Querying Series Taxonomy
`$message->series()` is a wrapper for `get_the_terms`.

## Wrapper for Querying Speaker Taxonomy
`$message->speakers()` is a wrapper for `get_the_terms`.

## Wrapper for Querying Topic Taxonomy
`$message->topics()` is a wrapper for `get_the_terms`.

## Wrapper for Querying Tag Taxonomy
`$message->tags()` is a wrapper for `get_the_terms.

## Getting Message Meta Data
`$message->get_meta( $key )` is a wrapper for `get_post_meta`.
- `$key` is the key of the post meta to be retrieved.
