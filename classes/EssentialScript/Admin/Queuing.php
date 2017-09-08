<?php
/**
 * @package Essential_Script\Admin
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
namespace EssentialScript\Admin;

/**
 * Enqueue various scripts on the administration page.
 *
 * @author docwho
 */
class Queuing {
    /**
	 * Enqueue scripts.
	 */
	public function init() {
		add_action( 'admin_enqueue_scripts', array ( $this, 'register_scripts' ) );
	}
	
	/**
	 * Load scripts and styles for the administration interface
	 */
	public function register_scripts( $hook ) {
		
		if ( 'tools_page_essentialscript' !== $hook ) {
			return;
		}

		/* Register all core scripts and styles.
		 * Codemirror main script.
		 */
		wp_register_script(
				'codemirror-script', 
				plugins_url( 'lib/codemirror.js', ESSENTIAL_SCRIPT1_PLUGIN_FILE ), 
				array(), 
				'5.23.0', 
				false 
		);
		// Codemirror mode script for javascript language.
		wp_register_script(
				'codemirror-mode-js',
				plugins_url( 'lib/mode/javascript/javascript.js', ESSENTIAL_SCRIPT1_PLUGIN_FILE ),
				array(),
				'5.23.0',
				false
		);
		// Codemirror mode script for XML/HTML language.
		wp_register_script(
				'codemirror-mode-xml',
				plugins_url( 'lib/mode/xml/xml.js', ESSENTIAL_SCRIPT1_PLUGIN_FILE ),
				array(),
				'5.23.0',
				false
		);
		// Codemirror style
		wp_register_style(
				'codemirror-style',
				plugins_url( 'lib/codemirror.css', ESSENTIAL_SCRIPT1_PLUGIN_FILE ),
				array(),
				'5.23.0',
				false 
		);
		wp_register_style(
				'codemirror-style-override',
				plugins_url( 'css/codemirror-override.css', ESSENTIAL_SCRIPT1_PLUGIN_FILE ),
				array(),
				'5.23.0',
				false
		);
		// Plugin style
		wp_register_style(
				'essentialscript-plugin-style',
				plugins_url( 'css/essentialscript-admin.css', ESSENTIAL_SCRIPT1_PLUGIN_FILE ),
				array(),
				'0.1',
				false 
		);
		wp_enqueue_script( 'codemirror-script' );
		wp_enqueue_script( 'codemirror-mode-js' );
		wp_enqueue_script( 'codemirror-mode-xml' );
		wp_enqueue_style( 'codemirror-style' );
		wp_enqueue_style( 'codemirror-style-override' );
		wp_enqueue_style( 'essentialscript-plugin-style' );		
	}
}
