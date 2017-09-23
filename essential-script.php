<?php
/**
 * @package Essential_Script
 * @author Giulio <giupersu@yahoo.it>
 * @version 0.3.1
 * 
 * Plugin Name: Essential Script
 * Plugin URI: 
 * Description: Essential Script plugin offers you the ability to enqueue and manage your client-side script, which is an essential part of your website, through a versatile text editor made with <a href="http://codemirror.net/">CodeMirror</a>.
 * Version: 0.3.1
 * Requires: 4.0
 * Tested up to: 4.8.2
 * Requires PHP: 5.3
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

// Include or require any necessary files here.
require_once ( ESSENTIAL_SCRIPT1_PLUGIN_DIR . 'classes/EssentialScript/Tools/Autoloader.php' );

// Activation stage
new \EssentialScript\Tools\Autoloader;
new \EssentialScript\Core\Setup;

// Generic actions and filters go here using anonymous function from PHP 5.3
if ( is_admin() ) {
	// Prepares options for the Page object
	add_action( 'admin_init', function() {
		$opts = new \EssentialScript\Core\Options;
		new \EssentialScript\Admin\Page( $opts );
	} ); 
	// Creating the menu.
	add_action( 'admin_menu', function() {
		\EssentialScript\Admin\Menu::init();
	} ); 
}
// Registering a Wordpress Widget.
add_action( 'widgets_init', function() {
	register_widget( 'EssentialScript\Admin\Widget' );
} );
// If !admin then it's frontend.
add_action( 'wp', function() { 
	/* The wp action hook runs immediately after the global WP class
	 * object is set up. Notice that init hook does not the job here
	 * because we need the conditional tags on the weblog frontend
	 * Essentialscript\Frontend.
	 */
	$opts = new \EssentialScript\Core\Options;
	$presenter = new \EssentialScript\Frontend\Presenter( $opts );
	$presenter->exclusion();
} ); 
