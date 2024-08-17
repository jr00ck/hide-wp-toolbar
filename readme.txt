=== Hide WP Toolbar ===
Contributors: jr00ck
Plugin URI: https://github.com/jr00ck/hide-wp-toolbar/
Tags: hide, toolbar, minimize, toggle, adminbar
License: GPLv3
Requires at least: 3.8
Tested up to: 6.5.5
Stable tag: 2.7

Easily hide or show the front-end WordPress Admin Toolbar with a click of a button.

== Description ==

Easily hide or show the front-end WordPress Admin Toolbar with a click of a button. The plugin adds a special button to the right side of the WordPress Admin Toolbar that only displays when you are outside the admin area of WordPress on the front-end. Clicking it will make the admin bar slide off the page to the top left corner, leaving only the hide/show button visible. Clicking the button again will restore the Toolbar to its original position. The shown/hidden position is remembered between page visits so that it can be kept hidden away until you are ready to bring it back.

There are no options or configuration. Just install and activate the plugin. When you exit the admin area, you will see the button to the far right of the Toolbar.

I actually like the WordPress Toolbar. It's a convenient way to go back and forth from the admin area to the public website. However, when I'm doing design modifications for a theme, the Toolbar can be visually distracting. I wanted a quick way to hide the WordPress Toolbar when needed, but otherwise keep it around. I tried several plugins but they didn't work as I wanted or didn't even work at all in some cases. So I decided to build my own.

= Contributions Welcome =
This plugin is on Github. [Submit a pull request](https://github.com/jr00ck/hide-wp-toolbar) if you'd like to contribute.

== Installation ==

1. Upload entire `hide-wp-toolbar` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navigate to the public area of the site and click the right side button to hide/show the WP Toolbar

== Frequently Asked Questions ==

= Are there any settings for this plugin? =

Nope. No settings page is created. Just activate and start using. No configuration required.

= Why does the toolbar flash briefly between page loads when in a hidden state? =

The toolbar uses CSS to hide and since the toolbar always shows by default, there may be a brief moment where it appears before the CSS is fully loaded to hide it. This is standard behavior for CSS and applies to everything on the page.

== Screenshots ==

1. The WordPress Toolbar shown with the hide/show button on the right.
1. The WordPress Toolbar hidden with only the hide/show button visible.

== Changelog ==

= 2.7 =
* Fix arrow button position in WordPress 6.6+

= 2.6.1 =
* Updated plugin assets (icon/screenshots) for compatibility with plugin repo

= 2.6 =
* Cleaned up outdated CSS prefixes (Github issue #8)
* Removed font size CSS declaration to accept default font size (maintains icon position when rotating)
* Created plugin icon for plugin repository (Github issue #4)
* Created animated gif screenshot to see plugin behavior (Github issue #5)

= 2.5.6 =
* Updated readme details and version number after additional testing

= 2.5.5 =
* Fixed toolbar state not saving between page loads (Github issue #7)

= 2.5.4 =
* Stopped loading CSS/JS for non-logged in users that don't have the toolbar (Github issue #6)

= 2.4.2 =
* Modernized and added better comments to javascript code

= 2.4.1 =
* Added proper text domain loading to support translations

= 2.4 =
* Removed dependency on WP Session Manager. Code included library was outdated and had a security issue. Now using WordPress transients to store state of the toolbar.
* Tested with WordPress 4.7.4

= 2.3 =
* Internationalized plugin for proper text translation handling

= 2.2.1 =
* Fixed: PHP Warning for creating default object from empty value (thanks benhuson!)
* Tested with WordPress 4.4.2
* Updated ReadMe regarding browser support and WP compatibility

= 2.2 =
* Use pretty dashicon from WordPress 3.8+ for button arrow (plugin now requires WordPress 3.8+)

= 2.1 =
* Modified placement of hide/show button for better compatibility with WordPress 3.8+

= 2.0 =
* Added functionality to remember shown/hidden position of toolbar between page loads

= 1.3 =
* Initial public release

== Upgrade Notice ==

= 2.7 =
* All users of WordPress 6.6 or higher must upgrade for plugins to work properly. Version 2.7 fixes arrow button position in WordPress 6.6+.
