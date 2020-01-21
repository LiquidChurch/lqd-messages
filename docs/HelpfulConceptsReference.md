# Helpful Concepts Reference

## Introduction
This document provides brief information on some concepts which may not be familiar to developers, especially those with a background in other languages rather than PHP.

## Callbacks and Callables
- wordpress.stackexchange.com/questions/267430/add-filter-passing-an-array-instead-of-callback-function
- php.net/manual/en/languages.types.callable.php
"A method of an instantiated object is passed as an array containing an object at index 0 and the method name at index 1."
You are likely to see this when hooks are being added. For example:

`add_filter('get_post_metadata', array($this, 'featured_image_fallback_to_series_image'), 10, 3);`

In this case `$this` is part of the object `GCS_Sermons` and `featured_image_fallback_to_series_image` is the name of one of its methods. This will be read as: `GCS_Sermons->featured_image_fallback_to_series_image`.
