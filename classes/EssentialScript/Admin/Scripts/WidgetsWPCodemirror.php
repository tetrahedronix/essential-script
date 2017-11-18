<?php

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

namespace EssentialScript\Admin\Scripts;

/**
 * Description of WPCodemirror
 *
 * @author docwho
 */
class WidgetsWPCodemirror extends \EssentialScript\Admin\Scripts\Decorator {
	
	public function __construct( Component $page ) {
		
		$this->slug = $page;
		add_action( 'admin_enqueue_scripts', array ( $this, 'enqueueScript' ) );
	}
	
	public function enqueueScript( $hook ) {
		
		if ( $this->slug->getSlug() !== $hook ) {
			return;
		}
		
		/*
		 * New in Wordpress 4.9
		 * Prepare Code Editor settings. 
		 * See https://make.wordpress.org/core/2017/10/22/code-editing-improvements-in-wordpress-4-9/
		 */
		$settings = wp_enqueue_editor(
			array ( 'codemirror' => array (
					'lineNumbers' => true,
					'mode' => array ( 'name' => 'xml', 'htmlMode' => true ),
					'lineWrapping' => true,
					'viewportMargin' => 'Infinity',
					'autofocus' => true,
					'readOnly' => true,
					'dragDrop' => false,
				)
			)
		);
		
		// Bail if user disabled CodeMirror.
		if ( false === $settings ) {
			return;
		}
		
		wp_register_script(
	'wp-codemirror-widgets',
			plugins_url( 'lib/wp-codemirror-widgets.js',
				ESSENTIAL_SCRIPT1_PLUGIN_FILE ),
			// This will have to depend on the settings in the future.
			array( 'jquery', 'wp-codemirror' ),
			self::ESSENTIALSCRIPT_VER,
			false 
		); 
		wp_enqueue_script( 'wp-codemirror-widgets' );
		wp_add_inline_script( 'wp-codemirror-widgets', 
			sprintf( "wp.essentialScriptWidgets.init( %s );", 
					wp_json_encode( $this->getExtradata() ) ) 
		);		 
		// Javascript Code
/*		$jcode=<<<'JCODE'
node = document.querySelector('[id^="widget-essential_script"]');
jQuery( function() { wp.codeEditor.initialize( node, %s ); } );,
JCODE; */
		// Load Wordpress Code Editor API.
/*		wp_add_inline_script(
			'code-editor',
			sprintf( $jcode, wp_json_encode( $settings ) )
		); */
	}
	
	public function getExtradata() {
		
		return $this->slug->getExtradata();
	}
	
	/**
	 * Getter
	 * 
	 * @return string The page slug
	 */	
	public function getSlug() {

		return $this->slug->getSlug();
	}

	/**
	 * Setter
	 * 
	 * @param mixed $data Extra data
	 */
	public function setExtradata( $data ) {

		$this->extra_data = $data;
	}	
	
}
