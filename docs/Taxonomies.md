# Taxonomies in Liquid Messages
Liquid Messages uses several custom taxonomies for categorizing messages. These taxonomies are associated with the Liquid Messages post type.

## Message Series
- If the message is part of a series you can create a "Message Series" taxonomy entry and add all messages in the series to this term.
- If the message does not have a featured image, the message will fallback to using the associated series' feature image.
- To disable this fallback use the following filter:
`add_filter( 'lqdm_do_message_series_fallback_image', '__return_false' );`

# Speakers
- Speakers can be associated with each individual message.

# Topics
- This is a high-level taxonomy for categorization that can be used hierarchically. We recommend setting a defined list of "topics" that are frequent/important subjects of messages. See Tags below for some place to add all related terms.

# Tags
- This is a free-for-all where one can add as many terms as desired in a non-hierarchical manner to a message. Unlike Topics, Tags do not need any form of restraint.

# Scriptures
- Allows one to associate Scripture references with a specific message.
- Recommended implementation is hierarchical with each book of the bible as top level followed by each chapter of the book. If desired one can add further Scriptures, but this becomes difficult to categorize and can result in an overwhelming number of entries in the hierarchy.
