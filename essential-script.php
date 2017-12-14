<?php
/**
 * Essential Script
 * 
 * @package Essential_Script
 * @author Giulio <giupersu@yahoo.it>
 * @version 0.8
 * 
 * @wordpress-plugin
 * Plugin Name: Essential Script
 * Plugin URI: https://github.com/tetravalence/essential-script
 * Description: Essential Script plugin offers you the ability to plug and manage your client-side script, which is an essential part of your website, through a versatile text editor made with <a href="http://codemirror.net/">CodeMirror</a>.
 * Version: 0.8
 * Requires: 4.0
 * Tested up to: 4.9.1
 * Requires PHP: 5.4
 * Author: Giulio
 * Author URI: https://www.freelancer.com/u/Tetravalente.html
 * License: GPL
 * Text Domain: essential-script
 * Domain Path: /i18n/languages
 */
/* 
 * Copyright (C) 2017 docwho
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
// Make sure we don't expose any info if called directly.
if ( !function_exists( 'add_action' ) ) {
	echo "Hi there! I'm just a plugin, not much I can do when called directly.";
	exit;
}
// Define all named constants here.
define ( 'ESSENTIAL_SCRIPT1_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define ( 'ESSENTIAL_SCRIPT1_PLUGIN_FILE', __FILE__ );
define ( 'ESSENTIAL_SCRIPT1_PLUGIN_PACKAGE', 'EssentialScript' );
define ( 'ESSENTIAL_SCRIPT1_DIST_CODEMIRROR', 'lib/codemirror/' );

// Include or require any necessary files here.
require_once ( ESSENTIAL_SCRIPT1_PLUGIN_DIR . 'classes/EssentialScript/Tools/Autoloader.php' );

// Activation stage
new \EssentialScript\Tools\Autoloader;
new \EssentialScript\Core\Setup;

/*
 *  Generic actions and filters go here using anonymous function from PHP 5.3
 *
 *  Admin action:
 */
if ( is_admin() ) {
	/*
	 * Settings API
	 *
	 * Creating the Essential Script submenu.
	 */
	add_action( 'admin_menu', function() {
		// Essential Script page.
		$page_essentialscript = new \EssentialScript\Admin\PageEssentialscript(
			'essentialscript' 
		);
		// Essential Script Submenu.
		( new \EssentialScript\Admin\Menu() )->
			init( $page_essentialscript )->
			title( 'Essential Script', 'Essential Script' )->
			capability( 'manage_options' )->
			slug( $page_essentialscript )->
			tools();
		new \EssentialScript\Admin\Queuing( 
			\EssentialScript\Admin\Menu::get_suffix(), 
			array ( 'dist-codemirror-script', 
				'dist-codemirror-style', 
				'dist-codemirror-mode-js',
				'dist-codemirror-mode-xml',
				'codemirror-style-override' ) 
		);
	} );
}
/*
 * Widget API
 * 
 * Registering a Wordpress Widget.
 */
add_action( 'widgets_init', function() {
	register_widget( 'EssentialScript\Admin\Widget' );
} );
/*
 * If !admin then it's frontend.
 * 
 * Frontend actions:
 */
$essentialscript_filter = null;
add_action( 'init', function() use ( &$essentialscript_filter ) {
	$presenter = new \EssentialScript\Frontend\Presenter;
	$essentialscript_filter = $presenter->router();
} );
/* The wp action hook runs immediately after the global WP class
 * object is set up. Notice that init hook does not the job here
 * because we need the conditional tags on the weblog frontend
 * Essentialscript\Frontend.
 */
add_action( 'wp', function() use ( &$essentialscript_filter ) {
	if ( !is_null( $essentialscript_filter ) ) {
		$context = new \EssentialScript\Frontend\Main();
		$context->trigger( $essentialscript_filter );
	}
} ); 
