# Theming and Templates for Liquid Messages Plugin

## It's All Customizable
Liquid Messages includes some basic templates to lay out the content of messages and series on a WordPress site. Each of these templates can be easily overridden with your own custom design if desired.

## Where Do Templates Live?
The built-in templates can be found in `lqd-messages/templates`. If you want to override these templates you'll add a folder to your WordPress theme called `lqd-messages`.

## Using Filters
The data sent to the template loader can be altered using a filter: `"template_args_for_{$template_file_name}"`.

The output of the template loader can also be filtered: `"template_output_for_{$template_file_name}"`.

## Customizing the Message Post Type and Its Taxonomies
One can also create custom templates for the message post type and its associated taxonomies.

To learn about creating custom templates see:
- Nick Schaferhoff's [A Detailed Guide to Custom WordPress Page Templates](https://www.smashingmagazine.com/2015/06/wordpress-custom-page-templates/).
- The Official [WordPress Theme Handbook on Custom Post Type Template Files](https://developer.wordpress.org/themes/template-files-section/custom-post-type-template-files/) and on [Taxonomy Templates](https://developer.wordpress.org/themes/template-files-section/taxonomy-templates/).

### Templates:
#### Post Types
- `single-gc-sermons.php`  -  For an individual message.
- `archive-gc-sermons.php` - For the archives of messages.
#### Taxonomies
- Sermon Series Templates
 - `taxonomy-gc-sermon-series-{term}.php`     - For a single term archive.
 - `taxonomy-gc-sermon-series.php`            - For all terms archive.
- Scripture Templates
 - `taxonomy-gcs-scripture-{scripture}.php`   - For a single Scripture archive.
 - `taxonomy-gcs-scripture.php`               - For all Scriptures archive.
- Speaker Templates
 - `taxonomy-gcs-speaker-{speaker}.php`       - For a single speaker archive.
 - `taxonomy-gcs-speaker.php`                 - For all speakers archive.
- Tag Templates
 - `taxonomy-gcs-tag-{term}.php`              - For a single tag archive.
 - `taxonomy-gcs-tag.php`                     - For all tags archive.
- Topic Templates
 - `taxonomy-gcs-topic-{term}.php`            - For a single topic archive.
 - `taxonomy-gcs-topic.php`                   - For all topics archive.



