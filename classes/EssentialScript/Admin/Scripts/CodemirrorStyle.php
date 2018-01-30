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
 * Concrete decorator: wraps the Essential Script concrete component with
 * necessary code to add CSS file for Codemirror supplied by WordPress.
 *
 * @author docwho
 */
class CodemirrorStyle extends \EssentialScript\Admin\Scripts\Decorator {
	/**
     * @var object  Object reference of the concrete component.
     */	
	private $script;
	/**
	 * Setup Class.
	 * 
	 * @param \EssentialScript\Admin\Scripts\Component $script Wrapped component
	 */
	public function __construct( Component $script ) {
		
		$this->script = $script;
	}
	
	/**
	 * Registers the Codemirror CSS file to be enqueued afterwards with 
	 * wp_enqueue_style.
	 * 
	 * @return object The current object handle
	 */
	public function enqueueScript() {
		
		// CodeMirror main style
		wp_enqueue_style( 'wp-codemirror' );
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
