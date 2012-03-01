=== Rotating Image Widget ===
Contributors: ericmann
Donate link: http://www.jumping-duck.com/wordpress/
Tags: jQuery, image rotate, gallery, slideshow, widget
Requires at least: 2.8
Tested up to: 3.2
Stable tag: 1.1.3
License: GPLv2+

Create a jQuery-driven rotating image sidebar widget.

== Description ==

Gives you the option of adding a Javascript-powered fading image gallery as a sidebar widget.  The widget pulls its images from previous posts and automatically re-sizes them for display in the appropriate area.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the entire `rotating-image-widget` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add the 'Rotating Image Widget' to your sidebar

== Frequently Asked Questions ==

= How many of these widgets can I have on a page? =

The widget itself will allow for multiple instances in a sidebar, but we recommend you stick to just one.  Each widget will pull images from the same location, so having multiple widgets running at once doesn't give you anthing extra.  However, if you have multiple sidebars, feel free to use a widget in each in different locations.

= I use large images on my site that won't fit in the sidebar ... =

That's fine.  The widget will automatically re-size the images to fit inside your sidebar.  This way the user's browser isn't forced to download multiple large images.

= Why do I see a page with a red crack in it rather than my photo? =

The file handler can only downsample images that are 2MB in size or smaller.  Images larger than this size will be skipped and replaced by a "broken image" placeholder.  By default, we try to use the "large" image size as defined by WordPress.  If you think something has gone wrong, please [contact us](mailto:info@jumping-duck.com) immediately.

= Why does the plug-in not activate when I install it? =

Rotating Image Widget requires a few particular elements on your site.  If you're using an older version of WordPress (less than 2.8) it won't install.  Since the plug-in requires some advanced functions available only in PHP 5 or higher, activation will fail for users running a lower version.

If you feel your system meets all of these requirements, please [contact us](mailto:info@jumping-duck.com) and we'll double check your system and provide a work-around.

== Screenshots ==

1. Options panel in the widget
2. The actual widget functioning on a site

== Changelog ==

= 1.1.2 =
* Minor bug fix to correct a name collision.

= 1.1 =
* Use the WP-HTTP API to make image requests
* Improve documentation

= 1.0.3 =
* Adds functions to handle failure in the case of very large images
* Changes the image grabbing function to select multiple unique images per post ID

= 1.0.2 =
* Centered widget content
* Added compatibility warning - requires WordPress 2.8+ and PHP 5 and fopen() function

= 1.0.1 =
* Fixes typo in plug-in folder structure

= 1.0.0 =
* First release

== Upgrade Notice ==
This plug-in will ONLY work with WordPress 2.8+ running on a server with PHP 5+ with the fopen() function available.  If any of these conditions are not met, plug-in activation will fail!