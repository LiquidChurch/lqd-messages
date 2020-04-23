# Liquid Messages WordPress Plugin #
**Contributors:**      liquid-church, jtsternberg, davidshq, surajgupta  
**Tags:**              church, sermons, messages, library, archives  
**Requires at least:** 4.4  
**Tested up to:**      4.4  
**Stable tag:**        0.9.1  
**License:**           GPLv2  
**License URI:**       http://www.gnu.org/licenses/gpl-2.0.html  

## Description ##
A message/sermon plugin for WordPress.

## Documentation

[Check out the GC-Sermons wiki](https://github.com/jtsternberg/GC-Sermons/wiki) for usage till we get ours up and running.

### Dependency Fragility
Unfortunately, some of the dependencies of Liquid Messages have not aged particularly well. Because of this issue we are committing working versions of these dependencies with the plugin and we cannot recommend running composer at this time due to the likelihood it will break one or more dependencies.

This is a temporary situation we hope to remedy in the near future.

## Fork of GC-Sermons
Justin Sternberg (@jsternberg) created the core GC-Sermons WordPress plugin. Liquid Church then contracted Justin to significantly expand the plugin. Since then Liquid Church has contracted Suraj Gupta to continue to expand and refine the plugin. Development of the plugin has occurred under the direction of Dave Mackey (@davidshq).

## Utilizes
* [FitVid.js 1.1](http://fitvidsjs.com/) - Ensures that videos are responsive rather than fixed width allowing for proper display on a variety of viewports.
* [Composer](https://github.com/composer/composer) - But not really atm see above.
* [CMB2](https://github.com/CMB2/CMB2) - Toolkit for building metaboxes, custom fields, forms.
  ** [CMB2 Term Select](https://github.com/CMB2/cmb2-term-select) - Select terms to associate with content.
  ** [CMB2 Post Search Field](https://github.com/CMB2/CMB2-Post-Search-field) - Adds a post search dialog for searching/attaching other post IDs.
  ** [CMB2 User Select](https://github.com/CMB2/CMB2-User-Select) - Associate users with object.
* [WordPress Shortcode Button](https://github.com/jtsternberg/Shortcode_Button) - Allows for quickly creating TinyMCE and Quicktag buttons for outputting shortcodes.
* [TechCrunch WP Asynchronous Tasks](https://github.com/techcrunch/wp-async-task) - Make tasks asynchronous.
* [CPT_Core](https://github.com/WebDevStudios/CPT_Core) - Helper class for creating CPTs.
* [Taxonomy_Core](https://github.com/WebDevStudios/Taxonomy_Core) - Helper class for registering custom taxonomies.
* [WDS Shortcodes](https://github.com/WebDevStudios/WDS-Shortcodes) - Base class for creating shortcodes including ability to add a corresponding button.
 - This plugin depends upon several other plugins including TGMPA and Shortcode Button. Its reliance on the former has been removed from the version bundled with Liquid Messages.
