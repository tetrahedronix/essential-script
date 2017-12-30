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
 * necessary code to add JavaScript Lint to CodeMirror.
 *
 * @author docwho
 */
class CodemirrorModeJS extends \EssentialScript\Admin\Scripts\Decorator {
	
	/**
	 * Setup class.
	 * 
	 * @param \EssentialScript\Admin\Scripts\Component $page Wrapped component
	 */
	public function __construct( Component $page ) {

		$this->slug = $page ;
		add_action( 'admin_enqueue_scripts', array ( $this, 'enqueueScript' ) );
	}
    
	/**
	 * Registers the Codemirror script to be enqueued afterwards with 
	 * wp_enqueue_script.
	 * 
	 * @param string $hook The hook suffix for the current admin page
	 * @return null If current page is not plugin administration.
	 */
	public function enqueueScript( $hook ) {
		
		if ( $this->slug->getSlug() !== $hook ) {
			return;
		}

		// Codemirror mode script for javascript language.
		if ( !wp_script_is( 'jshint', 'enqueued' ) ) {
			wp_enqueue_script( 'jshint' );
		}
	}

	/**
	 * Getter
	 * 
	 * @return mixed Extra data
	 */
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
