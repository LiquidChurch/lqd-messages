# Shortcode and Quicktag Buttons in Liquid Messages
Liquid Messages provides eleven shortcodes for users that can be used to display messages within other pages/posts as well as creating entire series/message layout pages.

- Audio Player: `[gc_audio_player sermon_id= ]`
- Video Player: `[gc_video_player sermon_id= ]`
- Play Button: `[sermon_play_button sermon_id= icon_color= icon_size= icon_class= ]`
- Recent Series: `[gc_recent_series sermonid= recent= remove_thumbnail= thumbnail_size= ]`
- Recent Sermons: `[gc_recent_sermon per_page= remove_pagination= thumbnail_size= number_columns= ]`
- Recent Speakers: `[gc_recent_speaker sermon_id= recent= remove_thumbnail= thumbnail_size= ]`
- Message Resources: `[sermon_resources]` 
- Search: `[gc_sermons_search search= per_page= content= remove_thumbnail= thumbnail_size= number_columns= separate_resultrs= ]`
- Series: `[gc_series per_page= remove_dates= remove_thumbnail= thumbnail_size= number_columns= remove_pagination= remove_description= ]`
- Sermons: `[gc_sermons per_page= content= remove_thumbnail= thumbnail_size= number_columns= list_offset= wrap_classes= remove_pagination= related_speaker= related_series= ]`
- Single Sermon: `[gc_sermon sermon_id= show_title= show_content= show_image= show_media= show_series= show_part_of_series= show_speakers= show_others_in_series= show_topics= show_tags= show_date_published= show_additional_resource= show_scripture_references= ]`


## For Developers
All shortcodes are found in `lqd-messages/includes/shortcodes/shortcodes-name`.

Liquid Messages uses:
- [Shortcode Button library](https://github.com/jtsternberg/Shortcode_Button) by Justin Sternberg.
 - Provides a rapid way to output shortcodes via TinyMCE and Quicktag buttons. 
- [WDS-Shortcodes](https://github.com/WebDevStudios/WDS-Shortcodes) by WebDevStudios.
 - Provides a rapid way to create shortcodes.
- [CMB2](https://github.com/CMB2/CMB2) by Justin Sternberg, WebDevStudios, et al.
 - Provides the custom fields, metaboxes, etc. used to enter/save/show data in the shortcodes.
  
We highly recommend reviewing the README.md for each of these libraries when doing any work with files in /shortcodes.

**NOTE:** When we use "shortcode button" this is inclusive of both TinyMCE and Quicktag buttons.

- `$button_slug` = What the shortcode's slug will be, e.g. `[get-single-post]`.
- `$js_button_data` = An array of values that define the button.
    - `qt_button_text` = Appears on the button.
    - `button_tooltip` = Appears over button on mouseover.
    - `icon` = Image shown on button.
    - `l10ncancel` = Define text and text domain for cancel button.
    - `l10ninsert` = Same but for insert button.
- `$fields` = An array of CMB2 fields that populate the modal displayed when one clicks on the shortcode button.
