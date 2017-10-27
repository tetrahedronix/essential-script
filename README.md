# Essential Script

Essential Script adds client-side script to individual areas of your Web site.

Essential Script plugin offers you the ability to plug and manage your client-side script, which is an essential part of your website, through a versatile text editor.

For example, through Essential Script interface you can add your banner in one location and configure what code is allowed to display on the Web page.

## Features
1. Streamlined Option Panel.
2. Setup in minutes.
3. Uses [Codemirror](http://codemirror.net/) for syntax highlighting.
4. You choose where to append/include the script and where to exclude it.
5. Support JavaScript/XML/HTML
6. With Widgets.
7. Now with support for Shortcodes API!
7. Free as in speech.

## Contributors
* tetravalente

## Installation
This section describes how to install the plugin and get it working:

1. Upload the `essential-script` folder to  the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' screen in Wordpress.
3. Access the 'Tools' menu in Wordpress to configure the plugin.

Or install the plugin through the WordPress plugins screen directly.

## Development

Sources of this plugin are available both in SVN and Git:

* [WordPress SVN repository](https://plugins.svn.wordpress.org/essential-script/)
* [GitHub](https://github.com/tetravalence/essential-script)

### Known issue

* This plugin has known conflit with JetPack Embedded Shortcode. You need to disable Embedded Shortcode if you want to use Essential Script and JetPack together ( See also: [Jetpack Shortcode Embeds](https://jetpack.com/support/shortcode-embeds/) ).

### TODO
- [x] Support for Widgets API.
- [x] Support for Shortcode.
- [x] Move the CodeMirror API in its own namespace.
- [ ] Use CodeMirror addons.
- [ ] Improve the user interface.
- [ ] Support for reusable components.
- [ ] Complete script engine with support for user-genereted content.

## Screenshots
1. Essential Script admin dashboard.
![Main panel](https://ps.w.org/essential-script/assets/screenshot-1.png)
2. Essential Script does use of `wp_enqueue_scripts`
![Widget](https://ps.w.org/essential-script/assets/screenshot-2.png)
3. Essential Script widget.
![Widget](https://ps.w.org/essential-script/assets/screenshot-3.png)