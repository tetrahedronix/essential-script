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

namespace EssentialScript\Admin;

/**
 * Enqueue various scripts and files for the administration page.
 *
 * @author docwho
 */
class Queuing {

	/**
	 * @var object Instance of the concrete component.
	 */
	private $script;
	
	/**
	 * @var mixed $extra_data Extra data used by wp_add_inline_script
	 */
	private $extra_data;
	
	/**
	 * Setup class.
	 * 
	 * @param string $handle Name of the script. Should be unique.
	 * @param array $accessories An array of accessories to wrap.
	 * @param mixed $extra_data Extra data used by wp_add_inline_script
	 * @return null On error
	 */
	public function __construct( $handle, $accessories,
		$extra_data = array () ) {

		if ( !is_string( $handle ) ) {
			return;
		}
		
		$this->extra_data = $extra_data;
		$func = "\\EssentialScript\\Admin\\Scripts\\" .
			str_replace( '-', '', ucwords( $handle, '-') );
		// Select the concrete component by using variable function syntax.
		$this->script = new $func( $extra_data );
		// Remove all accessories which are equal to null, 0, '' or false.
		$test_accessories = array_filter( $accessories );		

	    if ( ! empty( $test_accessories ) ) {
	      array_walk( $test_accessories, array ( $this, 'accessorize' ) );
	    }
	    // Recursively enqueue the script together all his accessories.
	    add_action( 'admin_enqueue_scripts',
	        array ( $this->script, 'enqueueScript' ) );
			
/*		if ( 'tools_page_essentialscript' === $slug ) {
			$this->page = 
				new \EssentialScript\Admin\Scripts\Essentialscript( $slug );
		} elseif ( 'widgets.php' === $slug ) {
			$this->page = 
				new \EssentialScript\Admin\Scripts\Widgets( $slug );
			$this->page->setExtradata( $this->extra_data );
		} else {
			return;
		} 
		
		// Remove all values from $scripts which are equal to null, 0, '' or false.
		$test_array = array_filter( $scripts );
		
		if ( !empty ( $test_array ) ) {
			array_walk( $test_array, array( $this, 'accessorize' ) );
		} */
	}
	
	/**
	 * Make sure the correct wrapper is called based on the requirements of the
	 * concrete component.
	 * 
	 * @param string $key Current requirement
	 */
	public function accessorize( $key ) {

		$func = "\\EssentialScript\\Admin\\Scripts\\" .
			str_replace( '-', '', ucwords( $key, '-' ) );
		$this->script = new $func( $this->script );
	}
}
