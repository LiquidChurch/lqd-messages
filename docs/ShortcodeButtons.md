# Shortcode and Quicktag Buttons in Liquid Messages

Liquid Messages uses the [Shortcode Button library](https://github.com/jtsternberg/Shortcode_Button) by Justin Sternberg. This provides a rapid way to output shortcodes via TinyMCE and Quicktag buttons. We highly recommend reviewing the README.md for this library when doing any work with files in /shortcodes.

NOTE: When we use "shortcode button" this is inclusive of both TinyMCE and Quicktag buttons.

- `$button_slug` = What the shortcode's slug will be, e.g. `[get-single-post]`.
- `$js_button_data` = An array of values that define the button.
    - `qt_button_text` = Appears on the button.
    - `button_tooltip` = Appears over button on mouseover.
    - `icon`
    - `l10ncancel` = Define text and text domain for cancel button.
    - `l10ninsert` = Same but for insert button.
