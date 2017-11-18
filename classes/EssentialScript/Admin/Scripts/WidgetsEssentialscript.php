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
 * Description of WidgetsEssentialscript
 *
 * @author docwho
 */
class WidgetsEssentialscript extends \EssentialScript\Admin\Scripts\Decorator {
	//put your code here
	
	public function __construct( Component $page ) {
		
		$this->slug = $page;
		add_action( 'admin_enqueue_scripts', array ( $this, 'enqueueScript' ) );
	}
	
	public function enqueueScript( $hook ) {
		
		if ( $this->slug->getSlug() !== $hook ) {
			return;
		}
		
		// Essential Script JavaScript script for use with Widgets API.
		wp_register_script(
			'essential-script-widgets',
			plugins_url( 'lib/essential-script-widgets.js',
				ESSENTIAL_SCRIPT1_PLUGIN_FILE ),
			// This will have to depend on the settings in the future.
			array( 'jquery', 'dist-codemirror-script' ),
			self::ESSENTIALSCRIPT_VER,
			false 
		); 
		wp_add_inline_script( 'essential-script-widgets', 
			sprintf( "wp.essentialScriptWidgets.init( %s );", 
					wp_json_encode( $this->getExtradata() ) ) 
		);		 
		wp_enqueue_script( 'essential-script-widgets' );  

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
