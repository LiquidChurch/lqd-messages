# Liquid Messages WordPress Plugin #
**Contributors:**      liquid-church, jtsternberg, davidshq, surajgupta  
**Tags:**              church, sermons, messages, library, archives  
**Requires at least:** 4.4  
**Tested up to:**      5.3  
**Stable tag:**        0.9.1  
**License:**           GPLv2  
**License URI:**       http://www.gnu.org/licenses/gpl-2.0.html  

## Description ##
A message/sermon plugin for WordPress.

## Documentation

Documentation for this plugin can be found in the [docs folder](https://github.com/LiquidChurch/lqd-messages/tree/mergefns-012720/docs).

[Check out the GC-Sermons wiki](https://github.com/jtsternberg/GC-Sermons/wiki) for usage till we get ours up and running.



### Dependency Fragility
Unfortunately, some of the dependencies of Liquid Messages have not aged particularly well. Because of this issue we are committing working versions of these dependencies with the plugin and we do not recommend running composer at this time due to the likelihood it will break one or more dependencies.

This is a temporary situation we hope to remedy in the near future.

## History of Liquid Messages Plugin
- Justin Sternberg (@jsternberg) created a robust WP plugin for sermon management - [GC-Sermons](https://github.com/jtsternberg/GC-Sermons/).
- Dave Mackey (@davidshq) on behalf of Liquid Church (@liquidchurch) contracted Justin to provide further enhancements to the plugin.
- Later Dave Mackey (@davidshq), again on the behalf of Liquid Church (@liquidchurch) would contract Suraj Gupta (@surajgupta) to perform additional enhancements and Liquid Church forked the plugin for these improvements.
- Most recently Dave Mackey (@davidshq) has significantly revamped the plugin, including consolidating functionality that required a second plugin into this single Liquid Messages Plugin.

## Utilizes

* Composer
* CMB2 (Justin Sternberg, WebDevStudios, et al.)
  * CMB2 Term Select
  * CMB2 Post Search Field
* [FitVid.js 1.1](http://fitvidsjs.com/) - Ensures that videos are responsive rather than fixed width allowing for proper display on a variety of viewports.
* WordPress Shortcode Button
* WP Asynchronous Tasks (TechCrunch)
* TGMPA
* CPT_Core (WebDevStudios)
* Taxonomy_Core (WebDevStudios)
* WDS Shortcodes (WebDevStudios)
