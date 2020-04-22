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

**Please note:** you will need to run `composer install` in order to fetch the dependencies for this plugin/library.

## Documentation

[Check out the GC-Sermons wiki](https://github.com/jtsternberg/GC-Sermons/wiki) for usage till we get ours up and running.

### Dependency Fragility
Unfortunately, some of the dependencies of Liquid Messages have not aged particularly well. Because of this issue we are committing working versions of these dependencies with the plugin and we cannot recommend running composer at this time due to the likelihood it will break one or more dependencies.

This is a temporary situation we hope to remedy in the near future.

## Fork of GC-Sermons
Justin Sternberg (@jsternberg) created the core GC-Sermons WordPress plugin. Liquid Church then contracted Justin to significantly expand the plugin. Since then Liquid Church has contracted Suraj Gupta to continue to expand and refine the plugin. Development of the plugin has occurred under the direction of Dave Mackey (@davidshq).

## Utilizes
* [FitVid.js 1.1](http://fitvidsjs.com/) - Ensures that videos are responsive rather than fixed width allowing for proper display on a variety of viewports.
* Composer
* CMB2
  ** CMB2 Term Select
  ** CMB2 Post Search Field
* WordPress Shortcode Button
* TechCrunch WP Asynchronous Tasks
* CPT_Core
* Taxonomy_Core
* WDS Shortcodes
