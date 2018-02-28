# Changelog
All notable changes to this project will be documented in this file.

## 0.9.1 - 2017-07-10
### Added
* Recent sermon shortcode
* Sermon single shortcode

## 0.9.0 - 2017-01-09
### Enhancements
* Removed dependency on xrstf/composer-php52 (now requires PHP greater than 5.2).
* functions.php
  ** Added is_array_empty() function.
  ** Added get_plugin_settings_options() function, allows for integration with LiquidChurch Functionality plugin.
* Added GPLv2 license file.
* gc-sermons-admin.js
  ** Added check to warn of attempts to post duplicate messages based on video.
  ** Configured taxonomy to be auto-expanded on sermon admin page.
* class-sermon-post.php
  ** Added get_speaker function
  ** Added get_scriptures function
* class-template-loader.php
  ** CSS stylesheet moved to /assets/css/
* class-sermons.php
  ** Added check_sermon_duplicate_video() function.
  ** Added thumbnail of message feature to columns.
  ** Added columns_sortable() and columns_sort_func()
* shortcodes-search/class-run.php
  ** Added option to determine whether search results display on same page as search form or separate page.
* shortcodes-search/class-admin.php
  ** Added option for results pagination by year or normal # of results
  ** Added ability to make the first page of pagination by year include multiple years
* Replaced list-item.php with list-item-series.php and list-item-sermon.php to allow more differences in style between series and sermon pages.
* admin-column.css, play-button-shortcode-style.css and list-item-style.css moved to /templates/assets/css/
* Numerous other code changes throughout.
  
### Bug Fixes

## 0.1.6 - 2016-06-08

### Enhancements

* Move loading of plugin's classes to the `'plugins_loaded'` hook for more flexibility.
* Output "No results" string when Sermon/Series search results are empty.
* Update shortcode-button dependency to fix modal displaying before CSS loads.

### Bug Fixes

* Fix required plugins notices. WDS Shortcodes is now bundled and not required for installation.
* Fix php notice caused by looping an empty array.

## 0.1.5 - 2016-06-01

### Enhancements

* Add sermon/series search shortcode.
* Add `GCS_Taxonomies_Base::search()` method for searching for terms in the taxonomies.
* Move some functionality in series shortcode to dedicated methods.
* Add wrapper for `get_terms` to account for changes in WP 4.5 where taxonomy is expected as part of the arguments..
* Update WDS-Shortcodes dependency.

### Bug Fixes

* Fix bug where the no-thumb class may not be added properly when thumbs are disabled in shortcodes.
* Tidy up debug/whitespace stuff.
* Fix bug where last page may not show because of rounding error.
* Update sermons shortcode to account for inception issues.
* Cleanup shortcodes class, fixing bad property names.

### Other

* Move taxonomy-based files to taxonomy includes directory, and post-type-based files to post-type includes directory.
* Pass the series taxonomy object to `GCSS_Series_Run` (dependency injection).

## 0.1.4 - 2016-05-30

### Enhancements

* Shortcodes, shortcodes, shortcodes. Also, this changelog.
