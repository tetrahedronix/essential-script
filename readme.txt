=== Essential Script ===
Contributors: tetravalente
Tags: scripting, javascript, css, adsense, code, embed
Requires at least: 4.0
Tested up to: 4.8.2
Stable tag: 0.3.1
Requires PHP: 5.3
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Essential Script adds client-side script to individual areas of your Web site.

== Description ==
Essential Script plugin offers you the ability to enqueue and manage your client-side script, which is an essential part of your website, through a versatile text editor.

For example, through Essential Script interface you can add your banner in one location and configure what code is allowed to display on the Web page.

== Features ==
1. Streamlined Option Panel.
2. Setup in minutes.
3. Uses [Codemirror](http://codemirror.net/) for syntax highlighting.
4. You choose where to append/include the script and where to exclude it.
5. Support JavaScript/XML/HTML.
6. With Widgets.
7. Free as in speech.

== Installation ==
This section describes how to install the plugin and get it working:

1. Upload the `essential-script` folder to  the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' screen in Wordpress.
3. Access the 'Tools' menu in Wordpress to configure the plugin.

Or install the plugin through the WordPress plugins screen directly.

== Development ==

Sources of this plugin are available both in SVN and Git:

* [WordPress SVN repository](https://plugins.svn.wordpress.org/essential-script/)
* [GitHub](https://github.com/tetravalence/essential-script)

### Known issue

* This plugin has known conflit with JetPack Embedded Shortcode. You need to disable Embedded Shortcode if you want to use Essential Script and JetPack together.

### TODO
- [ ] Allow the use of wp_enqueue_scripts where is possible. It requires a checkbox.
- [ ] Support for Shortcodes
- [ ] Move the CodeEditor in its own namespace.
- [ ] Use CodeMirror addons.
- [ ] Improve the user interface.
- [ ] Support for reusable components.

==Screenshots==
1. Essential Script admin dashboard
2. Essential Script widget

== Changelog ==
= 0.3.1=
* Fix Missing argument in `Page.php` on line 52 which prevented the editor from working
= 0.3 =
* Upgrade CodeMirror from 5.29.0 to 5.30.0
* Introduce separate javascript file in preparation for 0.3 version
* Initial support for Widgets API
* Fix deprecated non-static method called statically
= 0.2 =
* (tag: v0.2) First release of Essential Script
