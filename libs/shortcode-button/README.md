WordPress Shortcode Button (1.0.6)
================

Tinymce and Quicktag buttons (and modals) for outputting shortcodes. Built to work with [CMB2](https://github.com/WebDevStudios/CMB2).

Checkout the "[Cool Shortcode](https://github.com/jtsternberg/Cool-Shortcode)" demo plugin which demonstrates how to use [WDS-Shortcodes](https://github.com/WebDevStudios/WDS-Shortcodes), [CMB2](https://github.com/WebDevStudios/CMB2) and this library.

#### Todo:
* Testing with all CMB2 field types

### Screenshots

![button hover](http://dsgnwrks.pro/file-drop/images/button-hover.png)
*Button hover*

![button-click-show-modal](http://dsgnwrks.pro/file-drop/images/button-click-show-modal.png)
*Click button and open modal*

![button-click-show-modal](http://dsgnwrks.pro/file-drop/images/submit-add-shortcode.png)
*Submitted form inserts shortcode with params*

![button-click-show-modal](http://dsgnwrks.pro/file-drop/images/text-tab-quicktag-button.png)
*Text tab quicktag button (operates identically)*


#### Changelog

* 1.0.6
	* Remove the custom recursive QTags button in the shortcode modal wysiwyg editor. Props (@nonsensecreativity)[https://github.com/nonsensecreativity], (#14)[https://github.com/jtsternberg/Shortcode_Button/pull/14].

* 1.0.5
	* Fix incorrect content displaying when editing shortcodes with self-closing tags and content.
	* Fix radio button 'checked' value displays when editing shortcode.
	* Fix multicheck checkboxes 'selected' value displays when editing shortcode.
	* Fix select 'selected' value displays when editing shortcode.

* 1.0.4
	* Make sure "file" field type inputs are populated when using MCE views and editing a shortcode.
	* When editing a snippet with content, normalize the content to address tinymce auto-paragraph issues.

* 1.0.3
	* Hide modal manually to ensure it is hidden before CSS loads. Prevents flash of content.

* 1.0.2
	* Fix broken loader. Needs to hook into a WordPress hook, and uses first available (`'muplugins_loaded'`, `'plugins_loaded'`, `'after_setup_theme'`) to fire the include action.

* 1.0.1
	* Handle repeatable groups for attribute values (or any array value) with a modified JSON string (which will need to be converted in your shortcode).

* 1.0.0
	* Add a conflict-resolution loader (like CMB2), so that only one version of Shortcode_Button is loaded, and it always loads the newest version.
	* Use WordPress core `wp.shortcode()` javascript api.
	* Better handling for populating edit modal with CMB2 defaults, if set.
	* A _bunch_ of fixes for when `'mceView'` is enabled:
		* Add a wysiwyg editor to the edit modal to handle wrapping shortcodes (`'include_close'`)
		* Better handling for populating edit modal with contents of shortcode being edited.
		* Better shortcode rendering in mce view. Your mileage may vary.

* 0.2.3
	* Fix focus issue when modal opens. ([#9](https://github.com/jtsternberg/Shortcode_Button/issues/9))
	* Fix modal height/scroll issues when modal opens.

* 0.2.2
	* Remove hidden image id from CMB2 `file` field type when closing the modal.

* 0.2.1
	* Enables tinymce views, though the implementation needs manual effort per-shortcode. Can use the `"shortcode_button_parse_mce_view_before_send"` and `"shortcode_button_parse_mce_view_before_send_$slug"` to modify the shortcode display before it's returned to the view.
	* Added javascript events, `'shortcode_button:jquery_init_complete'`, `'shortcode_button:buttons_init_complete'`, `'shortcode_button:populate'`, `'shortcode_button:button_init_complete_'+ buttonSlug`.

* 0.2.0
	* Removes jQuery-UI dialog dependency which caused some obscure bugs.
	* Enable non-modal buttons for simply inserting shortcodes via the mce button.
	* Rename to more-sane `Shortcode_Button` classname.
	* Added javascript events, `'shortcode_button:clear'`, `'shortcode_button:open'` and `'shortcode_button:close'`.

* 0.1.2
	* Add 'include_close' parameter for self-closing shortcodes. This also allows wrapping a selection with the shortcode.
	* Added a way that the `"{$button_slug}_shortcode_fields"` filter can pass content to be added inside the shortcode.
	* Add `shortcode_button_js_url` filter in case the JS assets are not enqueued properly.
	* Add the modal to the footer at an earlier priority so that scripts can be enqueued properly.
	* Added ability to register a shortcode button that does NOT open a modal (no fields, or added programatically)
	* Added javascript events, `'shortcode_button:click'` and `'shortcode_button:insert'`.
	* Better handling for nested field keys (i.e. <input name="name[value]" />).
	* New hook, `"shortcode_button_before_modal_{$button_slug}"`, added before the modal markup is output (for things like conditional enqueueing).

* 0.1.1
	* Add override options for dialog modal's class, height, and width.
	* Better styling for CMB2 fields.

* 0.1.0
	* Hello World!
