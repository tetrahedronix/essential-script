=== Essential Script ===
Contributors: tetravalente
Tags: scripting, javascript, css, adsense, code, embed
Requires at least: 4.9
Tested up to: 4.9.2
Stable tag: 0.8.1
Requires PHP: 5.4
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Essential Script adds client-side script to individual areas of your Web site.

== Description ==
Essential Script plugin offers you the ability to plug and manage your client-side script, which is an essential part of your website, through a versatile text editor.

For example, through Essential Script interface you can add your banner in one location and configure what code is allowed to display on the Web page.

== Features ==
1. Streamlined Option Panel.
2. Setup in minutes.
3. Uses [Codemirror](http://codemirror.net/) for syntax highlighting.
4. You choose where to append/include the script and where to exclude it.
5. Support JavaScript/XML/HTML.
6. With Widgets.
7. Now with support for Shortcodes API!
8. New! Include options for async and defer attributes
9. Free as in speech.

== Installation ==
This section describes how to install the plugin and get it working:

1. Upload the `essential-script` folder to  the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' screen in Wordpress.
3. Access the 'Tools' menu in Wordpress to configure the plugin.

Or install the plugin through the WordPress plugins screen directly.

== Frequently Asked Questions ==
= Will I lose all of my custom scripts if I uninstall the plugin? =
No, you won't. If you use the option `File` to store the script then you can find it saved in the upload directory of Wordpress.
= Why does this plugin work for untrusted users? =
Wordpress includes the ability to create a network of sites. If you install a multisite network, then you can allow end users to use Essential Scripts. In this case they are able to post a limited set of HTML markup and even JavaScript code. See `PageEssentialscript.php` for more info and settings.

== Development ==

Sources of this plugin are available both in SVN and Git:

* [WordPress SVN repository](https://plugins.svn.wordpress.org/essential-script/)
* [GitHub](https://github.com/tetravalence/essential-script)

### Known issue

* This plugin has known conflict with JetPack Embedded Shortcode. You need to disable Embedded Shortcode if you want to use Essential Script and JetPack together ( See also: [Jetpack Shortcode Embeds](https://jetpack.com/support/shortcode-embeds/) ).


### TODO
- Find a reliable solution for uploading and managing script files
- Use CodeMirror addons.
- Improve the user interface.
- Support for reusable components.
- Complete script engine with support for user-genereted content.

==Screenshots==
1. Essential Script admin dashboard
2. Essential Script does use of wp_enqueue_scripts
3. Essential Script widget

== Changelog ==
= 0.8.1 =
* Remove incorrect try-catch implementation
* Updated to re-use CodeMirror as bundled with Wordpress core library
* Prevents uncaught error if class name is an invalid string
* Document `Options`, fix some inconsistencies
= 0.8 =
* Save properties with array object instead of array
* Untrusted users are allowed to post only a limited set of HTML markup
* Implement the Decorator pattern for enqueuing scripts to the front page
* Frontend: Refactoring the `Strategy` pattern to remove conditional statements
* Add FAQ section and tested up to Wordpress 4.9.1
* Improve the documentation about the `Template Method` pattern
* Add Context class to separate a request from a concrete strategy
* Rename class name from `footer` to `foot` for using variable functions
* Update minimum PHP version requirement
* Add `async` and `defer` options to Settings page
* Fix improper use of wp_enqueue_scripts with Shortcode
= 0.7.1 =
* Upgrade CodeMirror from 5.31.0 to 5.32.0
* Fix problem with `wp_enqueue_scripts` option was enabled with XML mode
* Fix Syntax highlighter doesn't match Essential Script option when run in Widget
= 0.7 =
* Widgets: start support for Code Editor API
* Move Codemirror code to a more suitable directory
* Introduce decorator for the new Code Editor API with Wordpress 4.9
* Fix if statements causing `Undefined index` error in `Main.php`
* Add option for syntax higlighter
* Improve the `Queuing` code by implementing the Decorator Pattern
= 0.6.1 =
* Update i18n related po files
* Remove files and directories no longer necessary
= 0.6 =
* Upgrade CodeMirror from 5.30.0 to 5.31.0
* Move the CodeMirror API in its own namespace
* Improves the `Settings API` code by implementing the Factory Pattern
= 0.5.1 =
* Fix incorrect variable name `filter` in `essential-script.php`
= 0.5 =
* Add support for Shortcode API
* Introduce `File` class for file management
* Frontend: Restructure the code and implement Strategy pattern
* Add new checkbox to use with Shortcode
= 0.4.1 =
* Add Note for proper use of wp_enqueue_scripts option
* Checkbox switches off when Wordpress DB is selected
= 0.4 =
* Add checkbox to allow the use of wp_enqueue_scripts where is possible
* Use array_key_exists instead of isset
* No longer it does exclude pages but includes
* Rename register_scripts to admin_register_scripts
= 0.3.1 =
* Fix Missing argument in `Page.php` on line 52 which prevented the editor from working
= 0.3 =
* Upgrade CodeMirror from 5.29.0 to 5.30.0
* Introduce separate javascript file in preparation for 0.3 version
* Initial support for Widgets API
* Fix deprecated non-static method called statically
= 0.2 =
* (tag: v0.2) First release of Essential Script

== Upgrade Notice ==

= 0.8 =
0.8 is a major update. Make a script backup and disable Essential Script before upgrading.