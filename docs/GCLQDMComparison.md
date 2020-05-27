# Comparison of GC Sermons and Liquid Messages

## Introduction
This is not a competition, GC Sermons is a robust plugin in its own right and Liquid Messages would not exist without it. The goal here is simply to provide potential users as they choose which message plugin will be the best fit for their needs.

## Differences
### Developer Differences
- We've removed a few tooling files from the plugin (bower, travis, yeoman, dockunit) and added a few others (editorconfig, gitattributes, phpcs, stylelint, and a dictionary).
    - The dictionary contains terms which a spell checker might otherwise mark as typos.
- LQDM favors using regular style comparisons over yoda (GCS).
- In LQDM, if a variable is only used to return a value, it is eliminated and the value is returned directly.
- In LQDM multiple assignments are avoided, e.g. `$file = $this->template = "{$template}{$this->extension}";` and instead written as:
  ```
  $this->template = "{$template}{$this->extension}
  $file = $this->template;
  ```
- LQDM explicitly returns null, GCS sometimes implicitly returns null.
- LQDM stores its assets in `/assets/css/` folders.
- GCS has additional utility functions: `gc_get_series_object()`, `gc_get_speaker_object()`, meanwhile LQDM has `get_speakers()`.
- LQDM rewrites permalinks so that they are nested like so: /messages/series/name-of-series/name-of-message
- GCS: Uses Grunt while LQDM does not and is moving towards Gulp. LQDM also uses other popular dev tools: autoprefixer, backstopjs, eslint, postcss, prettier, sass, stylelint, and yuicompressor as opposed to Grunt add-ons.
- LQDM: Enables REST and GraphQL endpoints on messages and taxonomies (including series).
- GCS provides integration with the GC Staff plugin.
- LQDM: Due to requiring PHP 7 it is able to take advantage of the [null coalescing operator (??)](https://www.tutorialspoint.com/php7/php7_coalescing_operator.htm) to decrease code verbosity. Example:
 GCS: 
 ```
if ( isset( $this->args[ $arg ] ) ) {
        return $this->args[ $arg ];
    }
    
    return $default;
 ```

```
return $this->args[ $arg ] ?? $default;
```
- GCS: Has a get_inline_styles() function in class-shortcodes-run-base.php that LQDM does not utilize.
- LQDM: Allows one to choose whether search results should appear on the same page as the search box or on a separate page.
- LQDM: Uses == instead of in_array when possible, for example:
  GCS:
  ```
  $search_sermons = $search_both || in_array( $to_search, array( 'sermons' ), 1 );
  ```
  LQDM:
  ```
  $search_sermons = $search_both || $to_search == 'sermons'
  ```
- LQDM: Where functions did not have explicit access modifiers they have been added.
### Large Differences
- GCS: Supports PHP 5.2+.
- LQDM: Supports PHP 7+.
- GCS: Uses FitVid.js
- LQDM: Uses CSS-only solution.
- LQDM: Includes a settings page which allows significant customization via GUI options of how Liquid Messages operates/is presented. These can be found in `/includes/pages/class-settings-page.php`.
- LQDM: Enables sorting of messages in admin interface.
- GCS: Includes related links.
- LQDM: Includes additional resources (can contain links, images, videos, etc.)
- GCS: Includes a play button shortcode, LQDM does not.
- LQDM: Adds Pagination by year or page and some related options to series shortcode.
- GCS: Uses Composer for adding all dependencies.
- LQDM: Includes most dependencies in /libs folder.
- LQDM: Has templates for list item series and messages pages.
- GCS: Has templates for list item messages pages.
- LQDM: Temporarily uses Bootstrap on search page.


