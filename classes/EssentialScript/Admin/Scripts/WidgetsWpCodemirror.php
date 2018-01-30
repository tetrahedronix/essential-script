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
 * Concrete decorator: wraps the Widgets concrete component with the necessary
 * code to use the Code Editor API introduced in Wordpress 4.9.
 *
 * @author docwho
 */
class WidgetsWPCodemirror extends \EssentialScript\Admin\Scripts\Decorator {
	/**
     * @var object  Object reference of the concrete component.
     */	
	private $script;
	/**
	 * Setup class.
	 * 
	 * @param \EssentialScript\Admin\Scripts\Component $script Wrapped component
	 */
	public function __construct( Component $script ) {

		$this->script = $script;
	}
	
	/**
	 * Registers the Codemirror Javascript file provided by Wordpress to be
	 * enqueued afterwards with wp_enqueue_script.
	 * 
	 * @return object The current object handle
	 */
	public function enqueueScript() {
		/*
		 * New in Wordpress 4.9
		 * Prepare Code Editor settings. 
		 * See https://make.wordpress.org/core/2017/10/22/code-editing-improvements-in-wordpress-4-9/
		 */
/*		$settings = wp_enqueue_code_editor(
			array ( 'codemirror' => array (
					'lineNumbers' => true,
					'mode' => array ( 'name' => 'xml', 'htmlMode' => true ),
					'lineWrapping' => true,
					'viewportMargin' => 'Infinity',
					'autofocus' => true,
					'readOnly' => true,
					'dragDrop' => false,
					'lint' => true
				)
			)
		); */
		$extra_data = $this->script->extra_data;
		/*
		 * Enable an option under certain conditions 
		 */		
		switch ( $extra_data[0] ) {
			case 'javascript':
				$mode = array ( 'name' => "javascript" );
				break;
			case 'xml':
			default:
				$mode = array ( 'name' => 'xml', 'htmlMode' => true );
				break;
		}
		
		$settings = array ( 
					'lineNumbers' => true,
					'mode' => $mode,
					'lineWrapping' => true,
					'autofocus' => true,
					'readOnly' => true,
					'dragDrop' => false,
					'lint' => true
		);
		// Bail if user disabled CodeMirror.
/*		if ( false === $settings ) {
			return;
		} */
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
			sprintf( "wp.essentialScriptWidgets.init( %s, %s );",
				wp_json_encode( $settings ),
				wp_json_encode( $extra_data[1] ) ) 
		);		 
		// Used with admin_enqueue_scripts hook 
		return $this->script->enqueueScript();		
	}
	/**
	 * Getter
	 * 
	 * @return string The current script handle
	 */	
	public function getHandle() {

		return $this->script->getHandle();
	}	

	
}
