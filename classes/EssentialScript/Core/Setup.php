<?php
/**
 * @package Essential_Script\Core
 */
/**
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
namespace EssentialScript\Core;

// Exit if accessed directly
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}
/**
 * Plugin setup
 * 
 * Main class for EssentialScript: activation & deactivation setup
 *
 * @author docwho
 */
class Setup {
	/**
	 * PHP version.
	 * 
	 * @var int Minimum PHP version required.
	 */
	const MIN_PHP_VERSION = '5.3';
	/**
	 * Wordpress version.
	 * 
	 * @var int Minimum Wordpress version required.
	 */
	const MIN_WP_VERSION = '4.0';
	/**
	 * Setup class.
	 */
	function __construct() {
		/*
		 * Using register_activation_hook() is a great way to set some default
		 * options for our plugin. It can also verify that the version of 
		 * Wordpress is compatible with our plugin.
		 */
		register_activation_hook( 
				ESSENTIAL_SCRIPT1_PLUGIN_FILE, 
				array ( $this, 'activation') );
		/*
		 * This function is triggered when your plugin is deactived.
		 */		
		register_deactivation_hook(
				ESSENTIAL_SCRIPT1_PLUGIN_FILE,
				array ( $this, 'deactivation' ) );
		
		add_action( 'plugins_loaded', array ( $this, 'i18n' ) );
	}
	
	/**
	 * Triggered on activation
	 * 
	 * This function is triggered when our plugin is activated in Wordpress. 
	 * It checks WP version and PHP version with the constants MIN_WP_VERSION 
	 * and MIN_PHP_VERSION required by our plugin.
	 */
	public function activation() {
		
		if ( version_compare(
				PHP_VERSION,
				Setup::MIN_PHP_VERSION,
				'<' ) ) {
			/* It is recommended to use the admin_init to call 
			 * deactivate_plugins() */ 
			deactivate_plugins( basename ( ESSENTIAL_SCRIPT1_PLUGIN_FILE ) );
			/*wp_die( __( 'The plugin Essential Script requires PHP' .
					Setup::MIN_PHP_VERSION . ' or later. Contact ' .
				'your system admin about updating your PHP interpreter' ) );  */
			wp_die( sprintf( 
				/* translators: %s: MIN_PHP_VERSION */	
				__( 'The plugin Essential Script requires PHP %s or later. ', 
						'essential-script' ) .
				__( 'Contact your system admin about updating your PHP interpreter', 
						'essential-script' ), 
				Setup::MIN_PHP_VERSION ) 
			);
		}
		
		// If Wordpress version is older than 4.0, we deactive our plugin.
		if ( version_compare(
				get_bloginfo( 'version' ),
				Setup::MIN_WP_VERSION,
				'<' ) ) {
			/* It is recommended to use the admin_init to call 
			 * deactivate_plugins() 
			 */
			deactivate_plugins( basename ( ESSENTIAL_SCRIPT1_PLUGIN_FILE ) );
			wp_die( sprintf(
				/* traslators: %s: MIN_WP_VERSION */
				__( 'The plugin Essential Script requires Wordpress %s or later ',
						'essential-script' ) .
				__( 'Contact your system admin about updating your Wordpress copy',
						'essential-script' ),
				Setup::MIN_WP_VERSION ) 
			);
		}
		
		// Default options go here:
		$options = [
			// Source code
			'script' => '',
			// Where the script is located: head, content or foot section, etc.
			'where'  => 'foot',
			'pages'  => array (
				'index'   => true,
				'single'  => false,
				'page'    => false,
				'archive' => false,	),
			'storage'  => 'file',
			'filename' => '',
			'path'     => '',
		];
		add_option( 'essentialscript_options', $options );
	}

	/**
	 * Deactivate Is Not Uninstall
	 */	
	public function deactivation() {

	}
	
	public function i18n() {
		$plugin_dir = 'essential-script/i18n/languages/';
		load_plugin_textdomain( 'essential-script', false, $plugin_dir );
	}
}
