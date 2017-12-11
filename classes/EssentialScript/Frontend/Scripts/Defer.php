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

namespace EssentialScript\Frontend\Scripts;

/**
 * Concrete decorator: add support for the Defer attribute.
 *
 * @author docwho
 */
class Defer {
	/**
	 * @var object Object reference of the concrete component.
	 */
	private $script;
	
	/**
	 * Setup class.
	 * 
	 * @param \EssentialScript\Frontend\Scripts\Component $script
	 */
	public function __construct( Component $script ) {
		
		$this->script = $script;
	}

	/**
	 * Filters the HTML script tag of an enqueued script.
	 * 
	 * @return object Object reference for wp_enqueue_scripts hook.
	 */	
	public function enqueueScript() {
		
		add_filter( 'script_loader_tag', array( $this, 'feature' ), 10, 3 );		
		
		return $this->script->enqueueScript();
	}

	/**
	 * Callback for the script_loader_tag filter hook.
	 * 
	 * @param string $tag The tag for the enqueued script.
	 * @param type $handle The script's registered handle.
	 * @param type $src The script's source URL.
	 * @return string The modified tag.
	 */	
	public function feature( $tag, $handle, $src ) {
		
		if ( $this->script->getHandle() === $handle ) {
			$tag = '<script type="text/javascript" defer src="' .
				esc_url( $src ) . '"></script>' . PHP_EOL;
		}
		
		return $tag; 
	}

	/**
	 * Getter method.
	 * 
	 * @return string Name of the script. Should be unique.
	 */	
	public function getHandle() {
		return $this->script->getHandle();
	}
	
}
