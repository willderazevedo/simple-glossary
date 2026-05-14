=== Simple Glossary ===
Contributors: willderazevedo
Tags: glossary, tooltip, popover, dictionary, terms
Requires at least: 5.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.1
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

A lightweight and simple glossary plugin that transforms words into interactive popovers.

== Description ==

Simple Glossary is a minimal WordPress plugin designed to create interactive glossary popovers directly inside your content.

Unlike traditional glossary plugins, it does not create:

- glossary pages
- archives
- indexes
- SEO structures
- automatic internal links
- unnecessary database overhead

It simply searches for configured terms and transforms them into interactive popovers.

Perfect for documentation websites, blogs, tutorials, technical articles, and educational content.

== Features ==

- Lightweight and simple
- Bootstrap popovers
- Custom Post Type for glossary terms
- Categories for organization
- Configurable wrapper class
- Optional automatic content injection
- No archive pages
- No automatic glossary indexes
- No builder dependency

== Installation ==

1. Upload the plugin to the `/wp-content/plugins/simple-glossary` directory.
2. Activate the plugin through the WordPress plugins screen.
3. Go to `Settings -> Simple Glossary`.
4. Configure the wrapper class and auto injection.
5. Create glossary terms from the new `Glossary` menu.

== Frequently Asked Questions ==

= Does this plugin create glossary pages? =

No.

The plugin only transforms words into popovers inside the content.

= Does it automatically scan the entire website? =

No.

The plugin only searches inside the configured wrapper class.

= Can I manually define where the glossary works? =

Yes.

Disable auto injection and manually add your custom wrapper class.

= Does it work with page builders? =

Yes.

As long as the builder outputs standard HTML content.

== Screenshots ==

1. Glossary term popover example
2. Plugin settings page
3. Glossary term editor

== Changelog ==

= 1.1 =

- Added configurable wrapper class
- Added automatic content injection
- Added settings page
- Added security improvements
- Added function prefixes to avoid conflicts

= 1.0 =

- Initial release

== Upgrade Notice ==

= 1.1 =

Includes new settings for wrapper class and automatic content injection.